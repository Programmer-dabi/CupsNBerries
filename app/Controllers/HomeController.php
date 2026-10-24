<?php
namespace App\Controllers;
use App\Models\Product;
use App\Models\Cart;
use Flight;
use InvalidArgumentException;
use Throwable;


class HomeController{
    public function index(){
            try {
            $product = new Product();
            $products = $product->getProductAll();

            Flight::render('home.twig', [
                'products' => $products,
                'cart_count' => (new Cart())->getCount(),
            ]);

            }catch (InvalidArgumentException $error) {
                Flight::halt(400, $error->getMessage());
                return;
            }catch (Throwable $error) {
                error_log('Home display failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
                Flight::halt(500, 'Could not load the menu. Please try again.');
                return;
            }
    
    }

    public function testing(){
        Flight::render('test.twig');
    }
}
?>
