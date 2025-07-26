<?php
session_start();
include 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

$message = '';
$product = null;

// Get product data
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    $product = $result->fetch_assoc();
    
    if (!$product) {
        header('Location: admin_dashboard.php');
        exit();
    }
} else {
    header('Location: admin_dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    
    // Handle image upload
    $image_name = $product['image']; // Keep existing image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $image_name = time() . '_' . $filename;
            $upload_path = 'img/' . $image_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Delete old image if it exists and is different
                if ($product['image'] && $product['image'] != $image_name && file_exists('img/' . $product['image'])) {
                    unlink('img/' . $product['image']);
                }
            } else {
                $message = "Error uploading image!";
            }
        } else {
            $message = "Invalid image format! Only JPG, JPEG, PNG, GIF allowed.";
        }
    }
    
    if (empty($message)) {
        $sql = "UPDATE products SET name=?, price=?, category=?, stock=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdssi", $name, $price, $category, $stock, $image_name, $id);
        
        if ($stmt->execute()) {
            $message = "Product updated successfully!";
            // Update product data for display
            $product['name'] = $name;
            $product['price'] = $price;
            $product['category'] = $category;
            $product['stock'] = $stock;
            $product['image'] = $image_name;
        } else {
            $message = "Error updating product!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
    <style>
        .admin-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .admin-header {
            background: #007bff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-nav {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .admin-nav a {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .admin-nav a:hover {
            background: #0056b3;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .current-image {
            margin: 10px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .current-image img {
            max-width: 200px;
            max-height: 150px;
            border-radius: 5px;
        }
        .submit-btn {
            background: #28a745;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background: #218838;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Edit Product</h1>
            <a href="admin_dashboard.php" style="color: white; text-decoration: none;">Back to Dashboard</a>
        </div>

        <div class="admin-nav">
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_add_product.php">Add Product</a>
            <a href="products.php">View Store</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name *</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="price">Price (₹) *</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo $product['price']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="category">Category *</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Tablets" <?php echo ($product['category'] == 'Tablets') ? 'selected' : ''; ?>>Tablets</option>
                        <option value="Syrups" <?php echo ($product['category'] == 'Syrups') ? 'selected' : ''; ?>>Syrups</option>
                        <option value="Supplements" <?php echo ($product['category'] == 'Supplements') ? 'selected' : ''; ?>>Supplements</option>
                        <option value="Creams" <?php echo ($product['category'] == 'Creams') ? 'selected' : ''; ?>>Creams</option>
                        <option value="Drops" <?php echo ($product['category'] == 'Drops') ? 'selected' : ''; ?>>Drops</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stock">Stock Quantity *</label>
                    <input type="number" id="stock" name="stock" min="0" value="<?php echo $product['stock']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="image">Product Image</label>
                    <?php if ($product['image']): ?>
                        <div class="current-image">
                            <strong>Current Image:</strong><br>
                            <img src="img/<?php echo $product['image']; ?>" alt="Current product image">
                        </div>
                    <?php endif; ?>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small style="color: #666;">Leave empty to keep current image. Supported formats: JPG, JPEG, PNG, GIF. Max size: 5MB</small>
                </div>

                <button type="submit" class="submit-btn">Update Product</button>
            </form>
        </div>
    </div>
</body>
</html> 