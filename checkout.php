<?php
session_start(); include 'db.php';
if (!isset($_SESSION["user"])) { header("Location: login.php"); exit; }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment = $_POST['payment'];
    foreach ($_SESSION['cart'] as $id) {
        $conn->query("INSERT INTO orders (user_email, product_id, quantity, total_price, payment_method) VALUES ('{$_SESSION['user']}', $id, 1, (SELECT price FROM products WHERE id=$id), '$payment')");
    }
    $_SESSION["cart"] = [];
    header("Location: order_success.php");
}
?>
<h2>Checkout</h2>
<form method="post">
  <label>Select Payment Method:</label><br>
  <input type="radio" name="payment" value="COD" required> Cash on Delivery<br>
  <input type="radio" name="payment" value="Online"> Online Payment<br><br>
  <button type="submit">Place Order</button>
</form>