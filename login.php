<?php 

// Check if the system is under maintenance
$isMaintenanceMode = false; // Set this to true during maintenance

if ($isMaintenanceMode) {
    include 'maintenance.php';
    exit;
}

session_start();

// Check if the user is logging out
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();

    // Redirect to the login page or homepage
    header("Location: login.php");
    exit();
}
  if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql= "SELECT * FROM  register
     WHERE email = '$email' AND password = '$password'";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            session_unset();    
            session_destroy();
            $row = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['fullName'] = $row['fullName'];
            $_SESSION['role'] = $row['role'];

            if ($_SESSION['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: homepage.php");
            } 
             exit();
        } else {
            $message = "Invalid email or password!";
      
        }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gracia's Restaurant</title>
    <link rel="stylesheet" href="login.css">
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
                <li class="lia"><a href="menu.php">Menu</a></li>
                <li class="lia"><a href="#about" class="scroll-link">About Us</a></li>
                <li id="login"><a href="login.php">Log In</a></li>
                <li id="signup"><a href="User_Reg.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="text-center">
            <h1>Welcome Back!</h1>
            <p>Log in to continue</p>
    </div>

        <form action="login.php" method="POST" id="loginForm">
            <div class="form-group">
                <label for="email">Email </label>
                <div class="input-container">
                    <span class="icon">👤</span>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <p class="error-message">Error message</p>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-container">
                    <span class="icon">🔒</span>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <p class="error-message">Error message</p>
            </div>

            <div class="forgot-password">
                <a href="forgot.php">Forgot password?</a>
            </div>

            <button type="submit" class="button">Log In</button>

            <div id="successMessage" class="success-message">
                ✅ Login successful!
            </div>
        </form>

        <div class="login-text">
            <span>Don't have an account?</span>
            <a href="User_Reg.php">Create an account</a>
        </div>
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