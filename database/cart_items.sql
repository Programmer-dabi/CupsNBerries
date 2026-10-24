-- Apply once to the configured application database before using the cart model.
-- cart_key is derived on the server: user:<id> or guest:<random session token>.
-- addons stores the selected add-on IDs, names and price snapshots as JSON.
CREATE TABLE IF NOT EXISTS cart_items (
    cart_key VARCHAR(70) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    line_key CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    product_id INT(11) NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    variant_id INT(11) DEFAULT NULL,
    variant_label VARCHAR(60) DEFAULT NULL,
    addons JSON NOT NULL,
    milk_preference VARCHAR(10) DEFAULT NULL,
    sugar_level TINYINT UNSIGNED DEFAULT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    quantity TINYINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (cart_key, line_key),
    CONSTRAINT fk_cart_item_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
    CONSTRAINT fk_cart_item_variant FOREIGN KEY (variant_id) REFERENCES product_variants (id) ON DELETE SET NULL,
    CONSTRAINT chk_cart_quantity CHECK (quantity BETWEEN 1 AND 99),
    CONSTRAINT chk_cart_price CHECK (unit_price >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
