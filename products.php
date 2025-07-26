<?php 
include 'db.php'; 
session_start();
$page_title = "Products - Medico";
include 'header.php';

$category = $_GET['category'] ?? '';
$sql = "SELECT * FROM products";
if ($category) {
    $sql .= " WHERE category='$category'";
}
$res = $conn->query($sql);
?>

<div class="products-page">
    <div class="page-header">
        <h1>Our Products</h1>
        <p>Browse our wide range of medicines and healthcare products</p>
    </div>

    <div class="filters-section">
        <form action="search.php" method="GET" class="search-form">
            <div class="search-input">
                <i class="fas fa-search"></i>
                <input type="text" name="query" placeholder="Search medicine..." required>
            </div>
            <button type="submit">Search</button>
        </form>
        
        <form method="GET" class="filter-form">
            <select name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <option value="Tablets" <?php echo $category == 'Tablets' ? 'selected' : ''; ?>>Tablets</option>
                <option value="Syrups" <?php echo $category == 'Syrups' ? 'selected' : ''; ?>>Syrups</option>
                <option value="Supplements" <?php echo $category == 'Supplements' ? 'selected' : ''; ?>>Supplements</option>
                <option value="Creams" <?php echo $category == 'Creams' ? 'selected' : ''; ?>>Creams</option>
            </select>
        </form>
    </div>

    <div class="products-grid">
        <?php while($row = $res->fetch_assoc()): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="img/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                </div>
                <div class="product-info">
                    <h3><?php echo $row['name']; ?></h3>
                    <p class="product-category"><?php echo $row['category']; ?></p>
                    <p class="product-price">₹<?php echo $row['price']; ?></p>
                    <p class="product-stock">Stock: <?php echo $row['stock']; ?> units</p>
                    <a href="cart.php?add=<?php echo $row['id']; ?>" class="add-to-cart-btn">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="prescription-upload-section">
        <div class="prescription-upload-container">
            <h2><i class="fas fa-prescription-bottle-alt"></i> Upload Prescription</h2>
            <p>Upload your prescription and we'll get back to you with the medicines</p>
            <form action="prescription_upload.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="prescription_file">Choose Prescription (PDF/JPG/PNG):</label>
                    <input type="file" name="prescription_file" id="prescription_file" accept=".pdf,image/*" required>
                </div>
                <div class="form-group">
                    <label for="user_email">Your Email:</label>
                    <input type="email" name="user_email" id="user_email" required>
                </div>
                <button type="submit" class="upload-btn">
                    <i class="fas fa-upload"></i> Upload Prescription
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.products-page {
    padding: 2rem 0;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-header h1 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.page-header p {
    color: #666;
    font-size: 1.1rem;
}

.filters-section {
    display: flex;
    gap: 2rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
}

.search-form {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.search-input {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input i {
    position: absolute;
    left: 1rem;
    color: #666;
}

.search-input input {
    padding: 0.8rem 1rem 0.8rem 2.5rem;
    border: 2px solid #ddd;
    border-radius: 25px;
    font-size: 1rem;
    width: 300px;
}

.search-input input:focus {
    outline: none;
    border-color: #667eea;
}

.search-form button {
    padding: 0.8rem 2rem;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s ease;
}

.search-form button:hover {
    background: #5a6fd8;
}

.filter-form select {
    padding: 0.8rem 2rem;
    border: 2px solid #ddd;
    border-radius: 25px;
    font-size: 1rem;
    background: white;
    cursor: pointer;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.product-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.product-image {
    height: 200px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info {
    padding: 1.5rem;
}

.product-info h3 {
    margin-bottom: 0.5rem;
    color: #333;
    font-size: 1.2rem;
}

.product-category {
    color: #667eea;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.product-price {
    font-size: 1.3rem;
    font-weight: 700;
    color: #28a745;
    margin-bottom: 0.5rem;
}

.product-stock {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.add-to-cart-btn {
    display: inline-block;
    width: 100%;
    padding: 0.8rem;
    background: #28a745;
    color: white;
    text-decoration: none;
    text-align: center;
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.3s ease;
}

.add-to-cart-btn:hover {
    background: #218838;
}

.prescription-upload-section {
    background: #f8f9fa;
    padding: 3rem 0;
    margin-top: 3rem;
}

.prescription-upload-container {
    max-width: 500px;
    margin: 0 auto;
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.prescription-upload-container h2 {
    text-align: center;
    color: #333;
    margin-bottom: 0.5rem;
}

.prescription-upload-container p {
    text-align: center;
    color: #666;
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 0.8rem;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}

.form-group input:focus {
    outline: none;
    border-color: #667eea;
}

.upload-btn {
    width: 100%;
    padding: 1rem;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

.upload-btn:hover {
    background: #5a6fd8;
}

@media (max-width: 768px) {
    .filters-section {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-input input {
        width: 100%;
    }
    
    .products-grid {
        grid-template-columns: 1fr;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
}
</style>

<?php include 'footer.php'; ?>