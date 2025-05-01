<?php
session_start();
include 'connect.php'; // database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer autoload

function sendOTP($email, $conn) {
    $otp = rand(100000, 999999);
    $otp_expiry = date("Y-m-d H:i:s", strtotime("+5 minutes")); // still 5 minutes expiry but hidden

    $stmt = $conn->prepare("UPDATE register SET otp=?  WHERE email=?");
    $stmt->bind_param("ss", $otp, $email);
    $stmt->execute();

    if ($stmt) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'braelly024@gmail.com'; // your Gmail
        $mail->Password = 'otvk xprt jvba pgdi'; // app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        $mail->setFrom('braelly024@gmail.com', 'Gracia\'s Restaurant');
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Code';
        $mail->Body = "Your OTP code is: $otp";

        if ($mail->send()) {
            return true;
        }
    }
    return false;
}

// Step 1: Confirm Email
if (isset($_POST['confirm_email'])) {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM register WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $_SESSION['email'] = $email;
        $_SESSION['step'] = 'send_otp';
        $message = "Please confirm your email to proceed.";
    } else {
        $error = "Email not found.";
    }
}

// Step 2: Send OTP
if (isset($_POST['send_otp'])) {
    $email = $_SESSION['email'];

    if (sendOTP($email, $conn)) {
        $_SESSION['step'] = 'verify_otp';
        $message = "OTP has been sent to your email!";
    } else {
        $error = "Failed to send OTP.";
    }
}

// Step 3: Verify OTP
if (isset($_POST['verify_otp'])) {
    $email = $_SESSION['email'];
    $otp_entered = $_POST['otp'];

    $stmt = $conn->prepare("SELECT otp FROM register WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        if ($result['otp'] == $otp_entered) {
            $_SESSION['step'] = 'reset_password';
            $message = "OTP verified! Please reset your password.";
        } else {
            $error = "Invalid OTP.";
        }
    } else {
        $error = "Invalid session.";
    }
}

// Step 4: Reset Password
if (isset($_POST['reset_password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $email = $_SESSION['email'];

        $stmt = $conn->prepare("UPDATE register SET password=?, otp=NULL  WHERE email=?");
        $stmt->bind_param("ss", $password, $email);

        if ($stmt->execute()) {
            session_destroy();
            echo "<script>alert('Password reset successful! Please login.'); window.location.href='login.php';</script>";
            exit();
        } else {
            $error = "Password reset failed.";
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
    <link rel="stylesheet" href="forgot.css">
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
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>
<body>


<div class="container">
<div class="text-center">

    <h2>Forgot Password</h2>

    <?php if (isset($error)): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <?php if (isset($message)): ?>
        <div class="message success"><?= $message ?></div>
    <?php endif; ?>

    <?php if (!isset($_SESSION['step'])): ?>
        <!-- Step 1: Confirm Email Form -->
        <form method="POST" action="">
        <div class="form-group">
        <div class="input-container">
            <input type="email" name="email" placeholder="Enter your email" required>
    </div>
    </div>
            <button type="submit" class="button" name="confirm_email">Confirm Email</button>
        </form>
        </div>

    <?php elseif ($_SESSION['step'] == 'send_otp'): ?>
        <!-- Step 2: Send OTP Form -->
        <form method="POST" action="">
        <div class="form-group">
        <div class="input-container">
            <input type="hidden" name="email" value="<?= $_SESSION['email'] ?>">
        </div>
        </div>
            <button type="submit" class="button" name="send_otp">Send OTP</button>
        </form>

    <?php elseif ($_SESSION['step'] == 'verify_otp'): ?>
        <!-- Step 3: Verify OTP Form -->
        <form method="POST" action="">
        <div class="form-group">
        <div class="input-container">
            <input type="text" name="otp" placeholder="Enter OTP" required>
        </div>
        </div>
            <button type="submit" class="button" name="verify_otp">Verify OTP</button>
        </form>
        </div>
        
    <?php elseif ($_SESSION['step'] == 'reset_password'): ?>
        <!-- Step 4: Reset Password Form -->
        <form method="POST" action="">
        <div class="form-group">
        <div class="input-container">
            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            </div>
            <button type="submit" class="button" name="reset_password">Reset Password</button>
        </form>
        </div>
    <?php endif; ?>

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
