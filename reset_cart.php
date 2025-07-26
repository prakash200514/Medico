<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Reset cart
$_SESSION["cart"] = array();

echo "Cart has been reset successfully!";
echo "<br><a href='products.php'>Go to Products</a>";
?> 