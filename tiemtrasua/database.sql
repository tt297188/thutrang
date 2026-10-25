CREATE DATABASE IF NOT EXISTS trasua
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE trasua;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(30) DEFAULT 'Chờ xác nhận',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO products (name, description, price, image)
SELECT 'Trà sữa trân châu', 'Trà sữa thơm ngon, trân châu dai', 30000, 'images/tranchau.jpg'
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE name = 'Trà sữa trân châu'
);

INSERT INTO products (name, description, price, image)
SELECT 'Trà đào', 'Trà đào thanh mát', 25000, 'images/tradao.jpg'
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE name = 'Trà đào'
);

INSERT INTO products (name, description, price, image)
SELECT 'Matcha latte', 'Matcha thơm béo', 35000, 'images/matcha.jpg'
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE name = 'Matcha latte'
);

INSERT INTO products (name, description, price, image)
SELECT 'Trà sữa truyền thống', 'Vị trà sữa truyền thống', 28000, 'images/trasua.jpg'
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE name = 'Trà sữa truyền thống'
);