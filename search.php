<?php
include 'db.php';
$term = $_GET['query'];
echo "<h2>Search Results for '$term'</h2>";
$result = $conn->query("SELECT * FROM products WHERE name LIKE '%$term%'");
while ($row = $result->fetch_assoc()) {
    echo "<div>
        <img src='img/{$row['image']}' width='100'><br>
        {$row['name']} - ₹{$row['price']}<br>
        <a href='cart.php?add={$row['id']}'>Add to Cart</a>
    </div><hr>";
}
echo "<a href='products.php'>← Back</a>";
?>