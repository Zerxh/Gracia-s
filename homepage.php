<?php
session_start();
if (!isset($_SESSION['fullName'])) {
    header("Location: login.php"); // redirect if not logged in
    exit();
}
$fullName = $_SESSION['fullName'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracia's Restaurant</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <div class="logo"><img src="img/logo.jpg" alt="Gracia's Logo"><p>GRACIA'S</p></div>

        <nav>
            <ul>
                <li class="lia"><a href="homepage.php">Home</a></li>
                <li class="lia"><a href="menu.php">Menu</a></li>
                <li class="lia"><a href="#about">About Us</a></li>
                <li id="login"><a href="login.php?logout=true">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <section class="welcome-section">
        <div class="content-sections">
        <h1>WELCOME <span style="
              text-transform: uppercase;
              font-size: 3.5rem;
              font-weight: bold;
              background: linear-gradient(to right, #ff6a00, #ee0979);
              text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
             <?php echo htmlspecialchars($_SESSION['fullName']); ?></span> TO GRACIA'S RESTAURANT</h1>
            <p>Experience the culinary delights of Gracia’s, from classic favorites to innovative creations.</p>
          
        </div>
        <img class="wel" src="img/welcome.jpg">
    </section>

    <div class="menu">
        <div class="overlay">
            <h1>OUR BEST SELLERS</h1>
            <p>Discover flavors that excite your taste buds and make every meal memorable.</p>
            <div class="image-container">
                <img class="image-box" src="img/unliw.jpg">
                <img class="image-box" src="img/sorbetes.jpg">
                <img class="image-box" src="img/pares.jpeg">
            </div>
            <p id="menu-a">UNLI WINGS</p> 
            <p id="menu-b">SORBETES</p>
            <p id="menu-c">PARES</p>
            <button class="ex-btn"><a href="menu.html">Explore Menu</a></button>
        </div>
    </div>

    <section class="homepage-layout">
        <div class="left-section">
            <img class="pickup" src="img/pick-up.png">
            <div class="order-pickup">ORDER & PICK UP</div>
            <p>Quickly place your orders and pick them up at your convenience.</p>
        </div>
        <div class="right-section">
            <img class="pickup" src="img/sisig.jpg">
            <div class="order-pickup">PRODUCT</div>
            <p>Discover our latest featured product and promotions.</p>
        </div>
    </section>
    
    <section class="content-section">
        <h2>ABOUT GRACIA'S</h2>
        <p>Gracia’s Restaurant is a hidden gem, offering a cozy and inviting atmosphere.</p>
        <div class="buttons">
            <button>Appetizers</button>
            <button>Soups</button>
            <button>Salads</button>
        </div>
    </section>

    <section class="content-section">
        <h2>GET IN TOUCH</h2>
        <p>We are dedicated to providing exceptional service.</p>
        <button class="con-btn">Book a Table</button>
    </section>
    
    <footer id="about">
    <div class="footer-container">
        <div class="footer-column">
            <div id="logo-footer">GRACIA'S</div>
            <div class="footer-location">
                <i class="fas fa-map-marker-alt"></i>
                <p>14B Divina St. North Poblacion,<br>Masinloc, Philippines</p>
            </div>
        </div>
        <div class="footer-column">
            <h3>Quick Links</h3>
            <ul class="footer-links">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="#about">About Us</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Contact Us</h3>
            <ul class="footer-contact">
                <li><i class="fas fa-phone"></i> +63 912 345 6789</li>
                <li><i class="fas fa-envelope"></i> info@gracias.com</li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Follow Us</h3>
            <div class="social-media">
                <a href="https://web.facebook.com/ggraciass.2020" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/sorbetesbygracias/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
            </div>
            <div class="business-hours">
                <h4>Business Hours</h4>
                <p>Monday-Sunday: 8:00 AM - 10:00 PM</p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p class="copyright">&copy; 2025 Gracia's Restaurant. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
