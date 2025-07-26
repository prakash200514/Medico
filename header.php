<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Medicine Store'; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }
        
        .logo i {
            margin-right: 10px;
            color: #ffd700;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }
        
        .nav-menu a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        
        .nav-menu a.active {
            background: rgba(255,255,255,0.3);
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .user-menu a:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .admin-link {
            background: #ffd700;
            color: #333 !important;
            font-weight: 600;
        }
        
        .admin-link:hover {
            background: #ffed4e !important;
        }
        
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #667eea;
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }
            
            .nav-menu.active {
                display: flex;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .header-container {
                position: relative;
            }
        }
        
        .main-content {
            flex: 1;
            padding: 2rem 0;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <a href="index.php" class="logo">
                <i class="fas fa-pills"></i>Medico
            </a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>
                        <i class="fas fa-home"></i> Home
                    </a></li>
                    <li><a href="products.php" <?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'class="active"' : ''; ?>>
                        <i class="fas fa-shopping-bag"></i> Products
                    </a></li>
                    <li><a href="cart.php" <?php echo basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'class="active"' : ''; ?>>
                        <i class="fas fa-shopping-cart"></i> Cart
                    </a></li>
                    <li><a href="checkout.php" <?php echo basename($_SERVER['PHP_SELF']) == 'checkout.php' ? 'class="active"' : ''; ?>>
                        <i class="fas fa-credit-card"></i> Checkout
                    </a></li>
                </ul>
            </nav>
            
            <div class="user-menu">
                <?php if(isset($_SESSION['user_email'])): ?>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                <?php else: ?>
                    <a href="login.php">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="signup.php">
                        <i class="fas fa-user-plus"></i> Signup
                    </a>
                <?php endif; ?>
                <a href="admin_login.php" class="admin-link">
                    <i class="fas fa-user-shield"></i> Admin
                </a>
            </div>
            
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>
    
    <div class="main-content">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            
            <script>
                function toggleMobileMenu() {
                    const navMenu = document.querySelector('.nav-menu');
                    navMenu.classList.toggle('active');
                }
            </script> 