<?php session_start(); include 'db.php';
if (!isset($_SESSION["cart"])) $_SESSION["cart"] = [];

if (isset($_GET["add"])) $_SESSION["cart"][] = $_GET["add"];

$total = 0;
echo "<h2>Your Cart</h2>";
foreach ($_SESSION["cart"] as $id) {
    $res = $conn->query("SELECT * FROM products WHERE id=$id");
    if ($row = $res->fetch_assoc()) {
        $total += $row['price'];
        echo "{$row['name']} - ₹{$row['price']}<br>";
    }
}
echo "<h3>Total: ₹$total</h3>";
echo "<a href='checkout.php'>Checkout</a>";
?>