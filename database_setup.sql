-- Create the database
CREATE DATABASE IF NOT EXISTS PABSBDEC;
USE PABSBDEC;

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_title VARCHAR(255) NOT NULL,
    product_description TEXT,
    product_price DECIMAL(10,2) NOT NULL,
    product_image VARCHAR(255),
    product_quantity INT NOT NULL DEFAULT 0,
    product_featured BOOLEAN DEFAULT FALSE,
    product_category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_category_id) REFERENCES categories(category_id) ON DELETE SET NULL
);

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(20),
    phone VARCHAR(20),
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create orders table
CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_amount DECIMAL(10,2) NOT NULL,
    order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    shipping_address TEXT,
    shipping_city VARCHAR(50),
    shipping_state VARCHAR(50),
    shipping_zip VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- Create order_items table
CREATE TABLE IF NOT EXISTS order_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    product_price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE SET NULL
);

-- Create cart table
CREATE TABLE IF NOT EXISTS cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

-- Insert sample categories
INSERT INTO categories (category_title) VALUES 
('Personal Starships'),
('Commercial Vessels'),
('Space Parts'),
('Navigation Systems'),
('Life Support Equipment');

-- Insert sample products
INSERT INTO products (product_title, product_description, product_price, product_image, product_quantity, product_featured, product_category_id) VALUES 
('Nova Explorer', 'Compact personal starship perfect for solo space exploration. Features advanced navigation and comfortable living quarters.', 2500000.00, 'nova_explorer.jpg', 5, TRUE, 1),
('Quantum Hauler', 'Medium-sized cargo vessel with enhanced storage capacity. Ideal for small businesses and independent traders.', 4500000.00, 'quantum_hauler.jpg', 3, TRUE, 2),
('Fusion Drive Core', 'High-efficiency propulsion system that reduces fuel consumption by 40%. Compatible with most modern starships.', 750000.00, 'fusion_core.jpg', 15, FALSE, 3),
('Stellar Navigator Pro', 'Advanced navigation system with real-time star mapping and automated course correction.', 120000.00, 'stellar_nav.jpg', 20, TRUE, 4),
('Atmospheric Recycler', 'State-of-the-art life support system that maintains optimal air quality for up to 6 passengers.', 85000.00, 'atmo_recycler.jpg', 30, FALSE, 5),
('Solar Sail Kit', 'Eco-friendly propulsion enhancement that harnesses solar energy for auxiliary power.', 45000.00, 'solar_sail.jpg', 50, FALSE, 3),
('Galaxy Class Suite', 'Luxury personal starship with premium amenities and extended range capabilities.', 3500000.00, 'galaxy_suite.jpg', 2, TRUE, 1),
('Quantum Shield Generator', 'Advanced defensive system that provides protection against space debris and radiation.', 180000.00, 'quantum_shield.jpg', 25, FALSE, 3);

-- Insert sample admin user (password: admin123)
INSERT INTO users (username, password, email, first_name, last_name, is_admin) VALUES 
('admin', 'admin123', 'admin@starshipdealer.com', 'Admin', 'User', TRUE);