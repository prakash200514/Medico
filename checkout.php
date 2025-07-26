<?php
session_start();
include 'db.php';

$orderPlaced = false;
$invoice = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["user"])) {
        // Optionally, you can show a message or allow guest checkout
        $user_email = "Guest";
    } else {
        $user_email = $_SESSION["user"];
    }
    $payment = $_POST['payment'];
    $total = 0;
    $products = [];

    foreach ($_SESSION['cart'] as $id => $qty) {
        $res = $conn->query("SELECT * FROM products WHERE id=$id");
        if ($row = $res->fetch_assoc()) {
            $subtotal = $row['price'] * $qty;
            $total += $subtotal;
            $products[] = [
                'name' => $row['name'],
                'price' => $row['price'],
                'qty' => $qty,
                'subtotal' => $subtotal
            ];
            // Save order to DB if you want
            $conn->query("INSERT INTO orders (user_email, product_id, quantity, total_price, payment_method) VALUES ('$user_email', $id, $qty, $subtotal, '$payment')");
        }
    }
    $invoice = [
        'user_email' => $user_email,
        'payment' => $payment,
        'products' => $products,
        'total' => $total
    ];
    $_SESSION["cart"] = [];
    $orderPlaced = true;
}

include 'header.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
body, .auth-page {
    font-family: 'Poppins', sans-serif;
}
.auth-page {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.auth-container {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
}
.auth-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    text-align: center;
}
.auth-header {
    margin-bottom: 2rem;
}
.auth-header i {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}
.auth-header h2 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 0.5rem;
    font-weight: 700;
}
.auth-header p {
    color: #666;
    font-size: 1rem;
}
.auth-form {
    text-align: left;
}
.form-group {
    margin-bottom: 1.5rem;
}
.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.form-group label i {
    color: #667eea;
}
.form-group input[type="radio"] {
    margin-right: 8px;
}
.auth-btn {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
}
.auth-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}
.auth-footer {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}
.auth-footer a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}
.auth-footer a:hover {
    color: #5a6fd8;
}
.back-home {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #666 !important;
    font-size: 0.9rem;
}
.back-home:hover {
    color: #333 !important;
}
@media (max-width: 480px) {
    .auth-card {
        padding: 2rem;
        margin: 1rem;
    }
    .auth-header h2 {
        font-size: 1.5rem;
    }
}
.invoice-container {
    max-width: 500px;
    margin: 50px auto;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 2.5rem;
    text-align: center;
    font-family: 'Poppins', sans-serif;
}
.invoice-header {
    color: #1e90ff;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
}
.invoice-table {
    width: 100%;
    margin: 1.5rem 0;
    border-collapse: collapse;
}
.invoice-table th, .invoice-table td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    text-align: center;
}
.invoice-table th {
    background: #f7f9fb;
    color: #333;
}
.invoice-total {
    font-size: 1.2rem;
    font-weight: bold;
    color: #28a745;
    margin-top: 1rem;
}
.invoice-info {
    margin-bottom: 1.5rem;
    color: #555;
}
.invoice-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    margin-top: 2rem;
    text-decoration: none;
    display: inline-block;
    transition: background 0.3s;
}
.invoice-btn:hover {
    background: #5a6fd8;
}
</style>

<?php if ($orderPlaced): ?>
    <div class="invoice-container">
        <div class="invoice-header"><i class="fas fa-receipt"></i> Invoice</div>
        <div class="invoice-info">
            <strong>Email:</strong> <?php echo htmlspecialchars($invoice['user_email']); ?><br>
            <strong>Payment Method:</strong> <?php echo htmlspecialchars($invoice['payment']); ?>
        </div>
        <table class="invoice-table">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach ($invoice['products'] as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td>₹<?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['qty']; ?></td>
                <td>₹<?php echo number_format($item['subtotal'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="invoice-total">Total: ₹<?php echo number_format($invoice['total'], 2); ?></div>
        <a href="products.php" class="invoice-btn"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
    </div>
<?php else: ?>
    <!-- Your checkout form here (as before) -->
<?php endif; ?>

<?php include 'footer.php'; ?>