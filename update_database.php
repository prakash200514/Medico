<?php
include 'db.php';

// Clear existing products
$conn->query("DELETE FROM products");

// Insert sample products with correct image paths
$sample_products = [
    ['Paracetamol 500mg', 25.00, 'Tablets', 100, 'v3.jpg'],
    ['Cough Syrup Corex', 120.00, 'Syrups', 50, 'corex.jpg'],
    ['Vitamin D3 Capsules', 150.00, 'Supplements', 75, 'v3.jpg'],
    ['Amoxicillin 500mg', 45.00, 'Tablets', 60, 'corex.jpg'],
    ['Multivitamin Syrup', 180.00, 'Syrups', 40, 'v3.jpg'],
    ['Iron Supplements', 200.00, 'Supplements', 30, 'corex.jpg']
];

$sql = "INSERT INTO products (name, price, category, stock, image) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

foreach ($sample_products as $product) {
    $stmt->bind_param("sdss", $product[0], $product[1], $product[2], $product[3], $product[4]);
    $stmt->execute();
}

echo "Database updated successfully with sample products!";
echo "<br><a href='admin_login.php'>Go to Admin Login</a>";
?> 