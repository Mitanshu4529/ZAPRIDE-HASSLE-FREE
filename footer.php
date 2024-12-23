<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <div class="footer-logo">
                <span class="logo">⚡ ZapRide</span>
            </div>
            <div class="social-links">
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-section">
            <h3>Services</h3>
            <ul>
                <li><a href="book-ride.php">Book a Ride</a></li>
                <li><a href="driver-signup.php">Drive with us</a></li>
                <li><a href="intercity.php">Intercity</a></li>
                <li><a href="rental.php">Rental</a></li>
                <li><a href="corporate.php">Corporate</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Company</h3>
            <ul>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="support.php">Support</a></li>
                <li><a href="careers.php">Careers</a></li>
                <li><a href="news.php">News Room</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Legal</h3>
            <ul>
                <li><a href="privacy.php">Privacy Policy</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
                <li><a href="safety.php">Safety</a></li>
                <li><a href="compliance.php">Compliance</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> ZapRide. All Rights Reserved.</p>
        <div class="footer-bottom-links">
            <a href="notices.php">Notices</a>
            <a href="privacy.php">Privacy Policy</a>
            <a href="terms.php">Terms of Service</a>
        </div>
    </div>

    <style>
        .footer {
            background-color: #000;
            color: #fff;
            padding: 40px 20px 20px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            padding-bottom: 40px;
        }

        .footer-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .footer-logo .logo {
            font-size: 24px;
            font-weight: bold;
            color: #FFD700;
        }

        .social-links {
            display: flex;
            gap: 20px;
        }

        .social-links a {
            color: #fff;
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: #FFD700;
        }

        .footer-section h3 {
            color: #FFD700;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 14px;
        }

        .footer-section ul li a:hover {
            color: #FFD700;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 20px;
            border-top: 1px solid #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-bottom p {
            color: #666;
            font-size: 14px;
        }

        .footer-bottom-links {
            display: flex;
            gap: 20px;
        }

        .footer-bottom-links a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: #FFD700;
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 30px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .footer-bottom-links {
                justify-content: center;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</footer>