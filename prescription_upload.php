<?php
session_start();
include "db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filename = $_FILES['prescription']['name'];
    $tempname = $_FILES['prescription']['tmp_name'];
    $folder = "uploads/" . $filename;
    if (move_uploaded_file($tempname, $folder)) {
        echo "<p>Prescription uploaded successfully.</p>";
    } else {
        echo "<p>Failed to upload prescription.</p>";
    }
}
?>
<h2>Upload Prescription</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="prescription" accept=".jpg,.png,.pdf" required>
    <button type="submit">Upload</button>
</form>
<a href="products.php">← Back to Products</a>