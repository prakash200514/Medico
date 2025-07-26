CREATE DATABASE IF NOT EXISTS medicine_store;
USE medicine_store;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  email VARCHAR(100),
  password VARCHAR(100)
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  price DECIMAL(10,2),
  category VARCHAR(50),
  stock INT,
  image VARCHAR(100)
);

CREATE TABLE prescriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_email VARCHAR(100),
  file_path VARCHAR(255),
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_email VARCHAR(100),
  product_id INT,
  quantity INT,
  total_price DECIMAL(10,2),
  payment_method VARCHAR(50),
  order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, price, category, stock, image) VALUES
('Paracetamol 500mg', 25, 'Tablets', 100, 'C:\xampp\htdocs\medicine_store\p500.jpg'),
('Cough Syrup', 120, 'Syrups', 50, 'med2.jpg'),
('Vitamin D3 Capsules', 150, 'Supplements', 75, 'med3.jpg');