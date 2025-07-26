
<?php
$conn = new mysqli("localhost", "root", "password", "medicine_store");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
