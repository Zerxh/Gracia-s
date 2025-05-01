<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = $_POST['otp'];



    // Check the OTP
    $sql = "SELECT * FROM register WHERE  otp = '$otp'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Mark as verified and clear OTP
        $update = "UPDATE register SET is_verified = 1, otp = NULL WHERE otp = '$otp'";
        mysqli_query($conn, $update);

        echo "<script>alert('OTP Verified. Redirecting to login...'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Incorrect OTP. Please try again.'); window.location.href='verify.php';</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gracia's Restaurant</title>
    <link rel="stylesheet" href="verify.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="img/logo.jpg" alt="Gracia's Logo">
            <p>GRACIA'S</p>
        </div>
        <nav>
            <ul>
                <li class="lia"><a href="homepage.php">Home</a></li>
                <li class="lia"><a href="menu.html">Menu</a></li>
                <li class="lia"><a href="#about" class="scroll-link">About Us</a></li>
                <li id="login"><a href="login.php">Log In</a></li>
                <li id="signup"><a href="User_Reg.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="text-center">
            <h1>Verify OTP</h1>


        </div>

        <form action="verify.php" method="POST" id="VerifyForm">

            <div class="form-group">
            <label for="otp">Enter OTP:</label>
            <div class="input-container">
            <input type="text" name="otp" required>
            </div>
                
            </div>


            <button type="submit" class="button">Verify OTP</button>
        </form>

    </div>

    <footer id ="about">
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
                    <li><a href="homepage.html">Home</a></li>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="promo.html">Promotions</a></li>
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