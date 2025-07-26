<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

// Initialize cart as associative array: id => qty
if (!isset($_SESSION["cart"])) $_SESSION["cart"] = [];

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array();
    
    if (isset($_POST['product_id'])) {
        $id = (int)$_POST['product_id'];
        
        // Add to cart (increase quantity)
        if (isset($_SESSION["cart"][$id])) {
            $_SESSION["cart"][$id]++;
        } else {
            $_SESSION["cart"][$id] = 1;
        }
        
        // Calculate total items in cart
        $total_items = array_sum($_SESSION["cart"]);
        
        $response = array(
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $total_items
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Product ID is required'
        );
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// If not POST request, return error
header('Content-Type: application/json');
echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
?> 