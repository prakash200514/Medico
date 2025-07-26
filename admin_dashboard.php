<?php
session_start();
include 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id");
    header('Location: admin_dashboard.php');
    exit();
}

// Get all products
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
    <style>
        .admin-container {
            max-width: 1200px;
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
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .product-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .product-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn-edit {
            background: #28a745;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-edit:hover, .btn-delete:hover {
            opacity: 0.8;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <a href="admin_logout.php" style="color: white; text-decoration: none;">Logout</a>
        </div>

        <div class="admin-nav">
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_add_product.php">Add Product</a>
            <a href="products.php">View Store</a>
        </div>

        <?php
        // Get statistics
        $total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
        $total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
        $total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
        ?>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_products; ?></div>
                <div>Total Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_orders; ?></div>
                <div>Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_users; ?></div>
                <div>Total Users</div>
            </div>
        </div>

        <h2>Manage Products</h2>
        <div class="products-grid">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="img/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <h3><?php echo $row['name']; ?></h3>
                    <p><strong>Price:</strong> ₹<?php echo $row['price']; ?></p>
                    <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
                    <p><strong>Stock:</strong> <?php echo $row['stock']; ?></p>
                    <div class="product-actions">
                        <a href="admin_edit_product.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                        <a href="admin_dashboard.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html> 