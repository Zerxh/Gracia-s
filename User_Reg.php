<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'vendor/autoload.php';

 $message = "";

  if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $otp = $_POST['otp'];

    $sql= "SELECT * FROM  register WHERE email = '$email'";
         
    // Check if email already exists
$result = mysqli_query($conn, $sql);
if ($result) {
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        echo "<script>alert('Email already exists.'); window.location.href='User_Reg.php';</script>";
        exit();
    } else {
        $verification_token = bin2hex(random_bytes(16));
        $insert_sql = "INSERT INTO register (fullName, email, password, phone, otp, verification_token)
                       VALUES ('$fullName', '$email', '$password', '$phone', '$otp', '$verification_token')";
        $insert_result = mysqli_query($conn, $insert_sql);

        if ($insert_result) {
            $mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'braelly024@gmail.com';
    $mail->Password = 'otvk xprt jvba pgdi'; // App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // 👇 Fix for SSL certificate verify failed
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->setFrom('braelly024@gmail.com', 'Gracia\'s Cafe');
    $mail->addAddress($email);
    $mail->Subject = 'Your Verification Code';
    $mail->Body = "Your verification code is: $otp";

    $mail->send();

    echo "<script>
            alert('Verification code has been sent to your email.');
            window.location.href='verify.php';
          </script>";
    exit();
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

        }
    }
}
  }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Gracia's Restaurant</title>
    <link rel="stylesheet" href="User_Reg.css">
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
                <li class="lia"><a href="#about">About Us</a></li>
                <li id="login"><a href="login.php">Log In</a></li>
                <li id="signup"><a href="User_Reg.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>
    <style>
  .modal-overlay {
    position: fixed;
    top: 80px; left: 0; right: 0; bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
  }
  .modal-box {
    background: #fff;
    width: 600px;
    max-height: 90vh;
    padding: 20px;
    border-radius: 10px;
    overflow-y: auto;
    position: relative;
  }
  .close-btn {
    position: absolute;
    right: 16px;
    top: 10px;
    font-size: 20px;
    cursor: pointer;
  }
  .tabs {
    display: flex;
    margin-bottom: 10px;
  }
  .tab {
    flex: 1;
    padding: 10px;
    cursor: pointer;
    border: none;
    background: #f2f2f2;
    font-weight: bold;
  }
  .tab.active {
    background: #ddd;
  }
  .content {
    max-height: 60vh;
    overflow-y: auto;
  }
</style>

    
    <div class="container">
        <div class="text-center">
            <h1>Create Account</h1>
            <p>Welcome to Gracia's Restaurant</p>
        

        </div>

        <form action = "User_Reg.php" method="post"  id="registrationForm">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <div class="input-container">
                    <span class="icon">👤</span>
                    <input type="text" id="fullName" name="fullName" placeholder=" Juan Dela Cruz" required>
                </div>
                <p class="error-message">Error message</p>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-container">
                    <span class="icon">📧</span>
                    <input type="email" id="email" name="email" placeholder="juan@gmail.com" required>
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

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <div class="input-container">
                    <span class="icon">📞</span>
                    <input type="tel" id="phone" name="phone" placeholder="+63 9123 456 789" required>
                </div>
                <p class="error-message">Error message</p>
            </div>

            <div class="form-group">
                <div class="input-container">
                    <input type="hidden"  name="otp" id ="otp" class = "form-control">
                    <input type="hidden"  name="subject" id ="subject" class = "form-control" value="Received OTP">
                </div>
                <p class="error-message">Error message</p>
            </div>

            <label for="terms">
                <input type="checkbox" id="terms" name="terms" required>
                I agree to the <a href="#" class="terms-link">Terms of Service and Privacy Policy</a>
            </label>
            <br>
            <br>
            <button type="submit" class="button">Create Account</button>
           
            <div id="successMessage" class="success-message">
                ✅ Registration successful!
            </div>
        </form>

        <div id="termsModal" class="modal-overlay" style="display:none;">
  <div class="modal-box">
    <span class="close-btn" onclick="closeModal()">×</span>

    <div class="tabs">
      <button class="tab active" onclick="showTab('termsTab')">Terms of Service</button>
      <button class="tab" onclick="showTab('privacyTab')">Privacy Policy</button>
    </div>

    <div class="content" id="termsTab">
      <p><strong>1. Account Creation:</strong> You must be at least 18 years old to create an account. Provide accurate and up-to-date information.</p>
      <p><strong>2. Ordering and Payment:</strong> You agree to pay for all orders placed through the service. Payment terms and methods are specified during checkout.</p>
      <p><strong>3. Delivery and Pickup:</strong> Provide accurate delivery information for delivery orders. For pickup orders, collect your order at the designated time and location.</p>
      <p><strong>4. Intellectual Property:</strong> All content on the service is the property of Gracia's Café or its licensors.</p>
      <p><strong>5. Limitation of Liability:</strong> The service is provided "as is." We are not liable for any indirect or consequential damages.</p>
      <p><strong>6. Termination:</strong> We may terminate your access to the service anytime.</p>
    </div>

    <div class="content" id="privacyTab" style="display:none;">
      <p><strong>1. Information We Collect:</strong> Name, contact info, and order details.</p>
      <p><strong>2. Use of Information:</strong> We use it to provide and improve our services.</p>
      <p><strong>3. Disclosure:</strong> We only share data with trusted service providers.</p>
      <p><strong>4. Security:</strong> We use reasonable protections for your data.</p>
      <p><strong>5. Your Rights:</strong> You can view or delete your data anytime.</p>
      <p><strong>6. Updates:</strong> Any changes to this policy will be posted here.</p>
    </div>
  </div>
</div>

        <div class="login-text">
            <span>Already have an account?</span>
            <a href="login.php">Log in</a>
        </div>
    </div>

    <footer id = "about">
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
<script>
document.querySelector('.terms-link').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('termsModal').style.display = 'flex';
  });

  function closeModal() {
    document.getElementById('termsModal').style.display = 'none';
  }

  function showTab(tabId) {
    document.querySelectorAll('.content').forEach(c => c.style.display = 'none');
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.getElementById(tabId).style.display = 'block';
    event.target.classList.add('active');
  }

    function generateRandomNumber(){
        
        let min = 100000;
        let max = 999999;
        let randomNumber = Math.floor(Math.random() * (max - min +1 )) +min ;

        let lastGeneratedNumber = localStorage.getItem ('lastGeneratedNumber ');
        while (randomNumber === parseInt(lastGeneratedNumber)) {

            randomNumber = Math.floor(Math.random() * ma(max - min +1 )) +min ;
        }
    localStorage.setItem('lastGeneratedNumber', randomNumber);
    return randomNumber;
    }
         document.getElementById('otp') . value = generateRandomNumber();

</script>
</body>
</html>