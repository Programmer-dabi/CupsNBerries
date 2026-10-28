<?php
namespace App\Models;

use App\Database\Database;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use mysqli;
use Throwable;

class Admin
{
    public const CATEGORIES = ['Coffee', 'Iced-Coffee', 'Tea', 'Pastries', 'Desserts'];
    public const STATUSES = ['Placed order', 'Confirmed', 'Preparing', 'Ready for pickup', 'Completed', 'Cancelled'];

    public static function statusesForPayment(string $method): array
    {
        return match ($method) {
            'gcash' => ['Placed order', 'Confirmed', 'Payed', 'Preparing', 'On delivery', 'Completed', 'Cancelled'],
            'cash_on_delivery' => ['Placed order', 'Confirmed', 'Preparing', 'Delivery', 'Completed', 'Cancelled'],
            default => self::STATUSES,
        };
    }

    public static function availableOrderStatuses(string $method, string $currentStatus): array
    {
        $normalized = strtolower(trim(preg_replace('/[\s_-]+/', ' ', $currentStatus)));
        $normalized = str_replace('pick up', 'pickup', $normalized);
        $current = match ($normalized) {
            'pending', 'placed order' => 'Placed order',
            'paid', 'payed' => 'Payed',
            'ready', 'ready for pickup', 'ready to pickup' => match ($method) {
                'gcash' => 'Preparing',
                'cash_on_delivery' => 'Delivery',
                default => 'Ready for pickup',
            },
            'delivery', 'on delivery', 'out for delivery' => $method === 'gcash' ? 'On delivery' : 'Delivery',
            'complete', 'completed', 'picked up', 'collected' => 'Completed',
            'cancelled', 'canceled' => 'Cancelled',
            default => ucfirst($normalized),
        };
        if (in_array($current, ['Completed', 'Cancelled'], true)) {
            return [$current];
        }
        $statuses = self::statusesForPayment($method);
        $position = array_search($current, $statuses, true);
        // Unrecognized historical statuses cannot safely be ranked.
        return $position === false ? [$currentStatus] : array_slice($statuses, $position);
    }

    private mysqli $db;

    public function __construct(?mysqli $db = null)
    {
        $this->db = $db ?? (new Database())->getConnection();
        $this->db->query("SET time_zone = '+08:00'");
    }

    private function rows(string $sql, array $values = []): array
    {
        $stmt = $this->db->prepare($sql);
        if ($values !== []) {
            $types = implode('', array_map(static fn($value) => is_int($value) ? 'i' : 's', $values));
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    public function products(): array
    {
        $products = (new Product($this->db))->getProductAll();
        foreach ($products as &$product) {
            $product['variants'] = [];
            $product['addons'] = [];
        }
        unset($product);
        foreach ($this->rows('SELECT * FROM product_variants ORDER BY id') as $variant) {
            $products[$variant['product_id']]['variants'][] = $variant;
        }
        foreach ($this->rows('SELECT * FROM product_addons ORDER BY id') as $addon) {
            $products[$addon['product_id']]['addons'][] = $addon;
        }
        return $products;
    }

    public function dashboard(): array
    {
        $now = new DateTimeImmutable('now', new DateTimeZone('Asia/Manila'));
        $today = $now->setTime(0, 0);
        $tomorrow = $today->modify('+1 day')->format('Y-m-d H:i:s');
        $month = $today->modify('first day of this month')->format('Y-m-d H:i:s');
        $products = $this->products();
        $inventory = [];
        foreach ($products as $product) {
            foreach ($product['variants'] as $variant) {
                $inventory[] = array_merge($variant, [
                    'product_name' => $product['product_name'],
                    'image_path' => $product['images'][0]['image_path'] ?? null,
                ]);
            }
        }
        $lowStock = array_values(array_filter($inventory, static fn($variant) => (int) $variant['stock_quantity'] <= 10));
        usort($lowStock, static fn($a, $b) => (int) $a['stock_quantity'] <=> (int) $b['stock_quantity']);
        $reports = [];
        foreach (['daily' => $today->format('Y-m-d H:i:s'), 'weekly' => $today->modify('-6 days')->format('Y-m-d H:i:s'), 'monthly' => $month] as $period => $start) {
            $reports[$period] = $this->rows("SELECT COALESCE(SUM(total), 0) AS sales FROM orders WHERE status = 'Completed' AND created_at >= ? AND created_at < ?", [$start, $tomorrow])[0]['sales'];
        }
        $sales = $this->rows("SELECT DATE(created_at) AS day, SUM(total) AS sales FROM orders WHERE status = 'Completed' AND created_at >= ? AND created_at < ? GROUP BY DATE(created_at)", [$today->modify('-6 days')->format('Y-m-d H:i:s'), $tomorrow]);
        $byDay = array_column($sales, 'sales', 'day');
        $chart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->modify("-$i days");
            $chart[] = ['label' => $date->format('D'), 'date' => $date->format('M j'), 'sales' => (float) ($byDay[$date->format('Y-m-d')] ?? 0)];
        }
        $maximum = max(1, ...array_column($chart, 'sales'));
        foreach ($chart as &$bar) {
            $bar['height'] = round($bar['sales'] / $maximum * 100);
        }
        unset($bar);
        $categoryCounts = array_column($this->rows('SELECT category, COUNT(*) AS product_count FROM products GROUP BY category'), 'product_count', 'category');
        $categories = [];
        foreach (array_unique(array_merge(self::CATEGORIES, array_keys($categoryCounts))) as $category) {
            $categories[] = ['name' => $category, 'product_count' => (int) ($categoryCounts[$category] ?? 0)];
        }
        return [
            'products' => $products,
            'inventory' => $inventory,
            'low_stock' => $lowStock,
            'reports' => $reports,
            'sales_chart' => $chart,
            'categories' => $categories,
            'stats' => [
                'orders_today' => $this->rows('SELECT COUNT(*) AS count FROM orders WHERE created_at >= ? AND created_at < ?', [$today->format('Y-m-d H:i:s'), $tomorrow])[0]['count'],
                'orders_month' => $this->rows('SELECT COUNT(*) AS count FROM orders WHERE created_at >= ? AND created_at < ?', [$month, $tomorrow])[0]['count'],
                'customers' => $this->rows('SELECT COUNT(*) AS count FROM users')[0]['count'],
                'products' => count($products),
            ],
            'recent_orders' => $this->rows('SELECT o.*, (SELECT COALESCE(SUM(quantity), 0) FROM order_items WHERE order_id = o.id) AS item_count FROM orders o ORDER BY o.created_at DESC, o.id DESC LIMIT 20'),
            'status_counts' => $this->rows('SELECT status, COUNT(*) AS count FROM orders WHERE created_at >= ? AND created_at < ? GROUP BY status ORDER BY status', [$today->format('Y-m-d H:i:s'), $tomorrow]),
            'best_sellers' => $this->rows("SELECT i.product_name, MAX(i.image_path) AS image_path, SUM(i.quantity) AS sold, SUM(i.line_total) AS sales FROM order_items i JOIN orders o ON o.id = i.order_id WHERE o.status = 'Completed' AND o.created_at >= ? AND o.created_at < ? GROUP BY i.product_id, i.product_name ORDER BY sold DESC, sales DESC LIMIT 5", [$month, $tomorrow]),
            'customers' => $this->rows('SELECT u.id, u.name, u.email, u.phone_number, u.created_at, (SELECT COUNT(*) FROM orders WHERE user_id = u.id) AS order_count FROM users u ORDER BY u.created_at DESC, u.id DESC LIMIT 50'),
            'today' => $now,
        ];
    }

    public function order(int $id): ?array
    {
        $order = $this->rows('SELECT * FROM orders WHERE id = ?', [$id])[0] ?? null;
        if ($order === null) { return null; }
        $order['pickup_time'] = $order['pickup_at'] !== null ? new DateTimeImmutable($order['pickup_at'], new DateTimeZone('Asia/Manila')) : null;
        $order['payment_label'] = Order::paymentLabel($order['payment_method']);
        $order['items'] = $this->rows('SELECT * FROM order_items WHERE order_id = ? ORDER BY id', [$id]);
        foreach ($order['items'] as &$item) {
            $item['addons'] = json_decode($item['addons'], true, 512, JSON_THROW_ON_ERROR);
        }
        unset($item);
        return $order;
    }

    public function customer(int $id): ?array
    {
        $customer = $this->rows("SELECT u.id, u.name, u.email, u.phone_number, u.created_at, (SELECT COUNT(*) FROM orders WHERE user_id = u.id) AS order_count, (SELECT COALESCE(SUM(total), 0) FROM orders WHERE user_id = u.id AND status = 'Completed') AS amount_spent FROM users u WHERE u.id = ?", [$id])[0] ?? null;
        if ($customer === null) { return null; }
        $customer['orders'] = $this->rows('SELECT id, order_number, total, status, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC, id DESC LIMIT 10', [$id]);
        return $customer;
    }

    public function updateOrderStatus(int $id, string $status): void
    {
        $this->db->begin_transaction();
        try {
            // Lock the latest status so simultaneous or stale forms cannot move it backward.
            $order = $this->rows('SELECT status, payment_method FROM orders WHERE id = ? FOR UPDATE', [$id])[0] ?? null;
            if ($order === null) {
                throw new InvalidArgumentException('Order not found.');
            }
            if (!in_array($status, self::statusesForPayment($order['payment_method']), true)) {
                throw new InvalidArgumentException('Choose a valid status for this order\'s mode of payment.');
            }
            if (!in_array($status, self::availableOrderStatuses($order['payment_method'], $order['status']), true)) {
                throw new InvalidArgumentException('Order status cannot move backward. Completed or cancelled orders cannot be changed. Reload the order to see its current status.');
            }
            if ($status === 'Cancelled') {
                Order::cancelLockedOrder($this->db, $id);
            } else {
                $stmt = $this->db->prepare('UPDATE orders SET status = ? WHERE id = ?');
                $stmt->bind_param('si', $status, $id);
                $stmt->execute();
                $stmt->close();
            }
            $this->db->commit();
        } catch (Throwable $error) {
            $this->db->rollback();
            throw $error;
        }
    }
}
