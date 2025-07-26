        </div>
    </div>
    
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><i class="fas fa-pills"></i> Medico</h3>
                    <p>Your trusted online pharmacy for quality medicines and healthcare products. We provide safe, reliable, and affordable healthcare solutions.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="checkout.php">Checkout</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="products.php?category=Tablets">Tablets</a></li>
                        <li><a href="products.php?category=Syrups">Syrups</a></li>
                        <li><a href="products.php?category=Supplements">Supplements</a></li>
                        <li><a href="products.php?category=Creams">Creams</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <div class="contact-info">
                        <p><i class="fas fa-phone"></i> +91 98765 43210</p>
                        <p><i class="fas fa-envelope"></i> info@medico.com</p>
                        <p><i class="fas fa-map-marker-alt"></i> 123 Medical Street, Health City, HC 12345</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Medico. All rights reserved. | Designed with <i class="fas fa-heart" style="color: #e74c3c;"></i> for better healthcare</p>
            </div>
        </div>
    </footer>
    
    <style>
        .footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 3rem 0 1rem 0;
            margin-top: auto;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            color: #ffd700;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .footer-section h4 {
            color: #ffd700;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        
        .footer-section p {
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-section ul li a {
            color: #ecf0f1;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-section ul li a:hover {
            color: #ffd700;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .social-links a {
            color: white;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        
        .social-links a:hover {
            color: #ffd700;
        }
        
        .contact-info p {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .contact-info i {
            color: #ffd700;
            width: 20px;
        }
        
        .footer-bottom {
            border-top: 1px solid #34495e;
            padding-top: 1rem;
            text-align: center;
        }
        
        .footer-bottom p {
            margin: 0;
            color: #bdc3c7;
        }
        
        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .social-links {
                justify-content: center;
            }
        }
    </style>
</body>
</html> 