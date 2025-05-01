<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Notice</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            color: #333;
            text-align: center;
            padding: 50px;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 90%;
        }
        h2 {
            color: #dc3545;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        h3 {
            font-size: 1.2em;
            margin: 20px 0;
            color: #555;
        }
        .social-links a {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            background-color: #0076c0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 1em;
        }
        .social-links a:hover {
            background-color: #005fa3;
            transform: scale(1.05);
        }
        .social-links i {
            margin-right: 10px;
        }
        .footer {
            margin-top: 40px;
            font-size: 1em;
            color: #777;
        }
        .reserved-rights {
            margin-top: 20px;
            font-size: 0.9em;
            color: black;
            background-color: lightgray;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Maintenance Notice</h2>
    <h3>We apologize for the inconvenience, but our system is currently undergoing maintenance.</h3>
    <p>Please refer to our social media pages for updates and to place your orders:</p>
    <div class="social-links">
        <a href="https://www.instagram.com/sorbetesbygracias/" target="_blank">
            <i class="fab fa-instagram"></i> Instagram
        </a>
        <a href="https://web.facebook.com/ggraciass.2020" target="_blank">
            <i class="fab fa-facebook-f"></i> Facebook
        </a>
    </div>
    <p class="footer">Thank you for your understanding and patience.</p>
    <div class="reserved-rights">
        &copy; <?php echo date("Y"); ?> Gracia's Cafe. All rights reserved.
    </div>
</div>

</body>
</html>
