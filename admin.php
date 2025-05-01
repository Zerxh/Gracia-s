<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$fullName = $_SESSION['fullName'];

// Database connection
require_once 'connect.php';

// Handle CRUD operations for users
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        switch ($action) {
            case 'create':
                $fullName = $conn->real_escape_string($_POST['fullName']);
                $email = $conn->real_escape_string($_POST['email']);
                $phone = $conn->real_escape_string($_POST['phone']);
                $role = $conn->real_escape_string($_POST['role']);
                $is_verified = isset($_POST['is_verified']) ? 1 : 0;
                
                // Generate temporary password
                $temp_password = 'temp123';
                $hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO register (fullName, email, phone, password, role, is_verified) 
                        VALUES ('$fullName', '$email', '$phone', '$hashed_password', '$role', $is_verified)";
                
                if ($conn->query($sql)) {
                    $_SESSION['message'] = "User created successfully! Temporary password: $temp_password";
                } else {
                    $_SESSION['error'] = "Error creating user: " . $conn->error;
                }
                break;
                
            case 'update':
                $id = intval($_POST['id']);
                $fullName = $conn->real_escape_string($_POST['fullName']);
                $email = $conn->real_escape_string($_POST['email']);
                $phone = $conn->real_escape_string($_POST['phone']);
                $role = $conn->real_escape_string($_POST['role']);
                $is_verified = isset($_POST['is_verified']) ? 1 : 0;
                
                $sql = "UPDATE register SET 
                        fullName='$fullName', 
                        email='$email', 
                        phone='$phone', 
                        role='$role', 
                        is_verified=$is_verified 
                        WHERE id=$id";
                
                if ($conn->query($sql)) {
                    $_SESSION['message'] = "User updated successfully!";
                } else {
                    $_SESSION['error'] = "Error updating user: " . $conn->error;
                }
                break;
                
            case 'delete':
                $id = intval($_POST['id']);
                
                if ($id == $_SESSION['user_id']) {
                    $_SESSION['error'] = "You cannot delete your own account!";
                } else {
                    $sql = "DELETE FROM register WHERE id=$id";
                    
                    if ($conn->query($sql)) {
                        $_SESSION['message'] = "User deleted successfully!";
                    } else {
                        $_SESSION['error'] = "Error deleting user: " . $conn->error;
                    }
                }
                break;
        }
        
        header("Location: admin.php#users");
        exit();
    }
}

// Fetch data from database
$orders = [];
$order_items = [];
$users = [];

// Get orders
$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
if ($result) {
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Get order items
$result = $conn->query("SELECT * FROM order_items");
if ($result) {
    $order_items = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Get users
$result = $conn->query("SELECT id, fullName, email, phone, role, is_verified FROM register");
if ($result) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Handle PDF generation requests
if (isset($_GET['download'])) {
    require_once 'tcpdf/tcpdf.php';

    $table = $conn->real_escape_string($_GET['download']);
    $filename = $table . '_report_' . date('Y-m-d') . '.pdf';

    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('Gracia\'s Restaurant');
    $pdf->SetAuthor('Admin');
    $pdf->SetTitle(ucfirst($table) . ' Report');
    $pdf->SetSubject(ucfirst($table) . ' Data');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Gracia\'s Restaurant - ' . ucfirst(str_replace('_', ' ', $table)) . ' Report', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'C');
    $pdf->Ln(10);

    // Fetch data for the specific table
    $result = $conn->query("SELECT * FROM $table");
    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();

        if (count($data)) {
            // Get column names
            $columns = array_keys($data[0]);

            // Create table header
            $html = '<table border="1" cellpadding="4">';
            $html .= '<tr style="background-color:#f2f2f2;">';
            foreach ($columns as $col) {
                $html .= '<th>' . htmlspecialchars($col) . '</th>';
            }
            $html .= '</tr>';

            // Add table rows
            foreach ($data as $row) {
                $html .= '<tr>';
                foreach ($columns as $col) {
                    $html .= '<td>' . htmlspecialchars($row[$col]) . '</td>';
                }
                $html .= '</tr>';
            }

            $html .= '</table>';

            $pdf->writeHTML($html, true, false, false, false, '');
        } else {
            $pdf->Cell(0, 10, 'No data found in ' . $table, 0, 1);
        }
    } else {
        $pdf->Cell(0, 10, 'Error: ' . $conn->error, 0, 1);
    }

    // Close and output PDF document
    $pdf->Output($filename, 'D');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gracia's Restaurant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #e89c62;
            padding: 10px 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo p{
            font-size: 40px;
            font-weight: bold;
            margin: 10px;
            margin-top: 20px;
            float: right;
            font-family: Times New Roman;
            color: #fff;
        } 
        .logo img {
            height: 80px;
            width: 80px;
            border-radius: 100px;
            margin-left: 30px;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            gap: 30px;
            padding: 0;
            margin: 0;
        }
        .navbar ul li {
            position: relative;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 600;
            transition: color 0.25s;
            padding: 10px;
            display: block;
        }
        .lia a:hover {
            color: black;
        }
        .lia a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 100%;
            height: 3px;
            background: white;
            transform: scaleX(0);
            transition: transform 0.3s ease-in-out;
        }
        .lia a:hover::after {
            transform: scaleX(1);
        }
        #login a {
            color: black;
            text-align: center;
        }
        #login {
            background-color: white;
            border-radius: 10px;
            width:90px;
            margin-right: -25px;
        }
        #login a:hover {
            color: white;
            transition: 0s;
        }
        #login :hover {
            background-color: black;
            border-radius: 10px;
            width: 70px;
        }
        #signup a {
            color: rgb(255, 255, 255);
            text-align: center;
        }
        #signup  {
            background-color: rgb(255, 0, 0);
            border-radius: 10px;
            width:88px;
        }
        #signup a:hover {
            color: rgb(255, 255, 255);
        }
        #signup :hover {
            background-color: rgb(0, 0, 0);
            border-radius: 10px;
            width: 68px;
        }
        #admin {
            background-color: #4CAF50;
            border-radius: 10px;
            width: 100px;
        }
        #admin a {
            color: white;
            text-align: center;
        }
        #admin:hover {
            background-color: #3e8e41;
        }
        .admin-container {
            display: flex;
            min-height: calc(100vh - 100px);
        }
        .admin-sidebar {
            width: 250px;
            background: #333;
            color: white;
            padding: 20px 0;
        }
        .admin-sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #e89c62;
        }
        .admin-sidebar ul {
            list-style: none;
            padding: 0;
        }
        .admin-sidebar li {
            padding: 15px 20px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .admin-sidebar li:hover {
            background: #444;
        }
        .admin-sidebar li.active {
            background: #e89c62;
        }
        .admin-main {
            flex: 1;
            padding: 20px;
        }
        .admin-section {
            display: none;
        }
        .admin-section.active {
            display: block;
        }
        .admin-card {
            background: white;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .admin-card h3 {
            margin-top: 0;
            color: #e89c62;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }
        .btn-edit {
            background-color: #2196F3;
            color: white;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        .btn-add {
            background-color: #4CAF50;
            color: white;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin-top: 0;
            color: #333;
        }
        .stat-value {
            font-size: 36px;
            font-weight: bold;
            color: #e89c62;
            margin: 10px 0;
        }
        .download-btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
            text-decoration: none;
            display: inline-block;
        }
        .download-btn:hover {
            background-color: #45a049;
        }
        .download-btn i {
            margin-right: 5px;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: black;
        }
        /* Form styles */
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        /* Message styles */
        .alert {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        /* Footer styles */
        footer {
            background-color: #2c2c2c;
            color: #ffffff;
            padding: 40px 0 20px;
            font-family: 'Arial', sans-serif;
        }
        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .footer-column {
            margin-bottom: 20px;
        }
        #logo-footer {
            font-size: 28px;
            font-weight: bold;
            color: #e89c62;
            margin-bottom: 15px;
            font-family: 'Times New Roman', serif;
        }
        .footer-location {
            display: flex;
            align-items: flex-start;
            margin-top: 15px;
        }
        .footer-location i {
            color: #e89c62;
            margin-right: 10px;
            margin-top: 3px;
        }
        .footer-location p {
            margin: 0;
            line-height: 1.5;
        }
        .footer-column h3 {
            color: #e89c62;
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        .footer-column h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background: #e89c62;
        }
        .footer-links li, .footer-contact li {
            margin-bottom: 12px;
            list-style: none;
            display: flex;
            align-items: center;
        }
        .footer-links a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            color: #e89c62;
        }
        .footer-contact i {
            color: #e89c62;
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .social-media {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .social-media a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: #3a3a3a;
            border-radius: 50%;
            color: #ffffff;
            transition: all 0.3s;
        }
        .social-media a:hover {
            background: #e89c62;
            transform: translateY(-3px);
        }
        .business-hours h4 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #e89c62;
        }
        .business-hours p {
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
        }
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 30px;
            border-top: 1px solid #3a3a3a;
        }
        .copyright {
            margin: 0;
            font-size: 14px;
            color: #aaaaaa;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-content {
                width: 80%;
            }
            .form-row {
                flex-direction: column;
                gap: 10px;
            }
            .footer-container {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 480px) {
            .footer-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="img/logo.jpg" alt="Gracia's Logo">
            <p>GRACIA'S</p>
        </div>
        <nav>
            <ul>
                <li id="login"><a href="login.php?logout=true">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <div class="admin-container">
        <div class="admin-sidebar">
            <h2>Admin Dashboard</h2>
            <ul>
                <li class="active" data-section="dashboard">Dashboard</li>
                <li data-section="orders">Orders</li>
                <li data-section="users">User Management</li>
                <li data-section="reports">Reports</li>
            </ul>
        </div>
        <div class="admin-main">
            <!-- Dashboard Section -->
            <div class="admin-section active" id="dashboard">
                <h1>Dashboard Overview</h1>
                <div class="stats-container">
                    <div class="stat-card">
                        <h3>Total Orders</h3>
                        <div class="stat-value"><?php echo count($orders); ?></div>
                        <p>All time orders</p>
                    </div>
                    <div class="stat-card">
                        <h3>Total Revenue</h3>
                        <div class="stat-value">₱<?php 
                            $totalRevenue = 0;
                            foreach ($orders as $order) {
                                $totalRevenue += $order['total_amount'];
                            }
                            echo number_format($totalRevenue, 2);
                        ?></div>
                        <p>All time revenue</p>
                    </div>
                    <div class="stat-card">
                        <h3>Registered Users</h3>
                        <div class="stat-value"><?php echo count($users); ?></div>
                        <p>Total users</p>
                    </div>
                </div>

                <div class="admin-card">
                    <h3>Recent Orders</h3>
                    <table>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                        <?php foreach(array_slice($orders, 0, 5) as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_number']); ?></td>
                            <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo date('M j, Y g:i A', strtotime($order['order_date'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="admin-section" id="orders">
                <h1>Order Management</h1>
                <a href="?download=orders" class="download-btn"><i class="fas fa-file-pdf"></i> Download Orders</a>
                <div class="admin-card">
                    <table>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Payment Method</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                        <?php foreach($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_number']); ?></td>
                            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                            <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo date('M j, Y g:i A', strtotime($order['order_date'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                
                <h2>Order Items</h2>
                <a href="?download=order_items" class="download-btn"><i class="fas fa-file-pdf"></i> Download Order Items</a>
                <div class="admin-card">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                        <?php foreach($order_items as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td>#<?php echo $item['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>₱<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>

            <!-- User Management Section -->
            <div class="admin-section" id="users">
                <h1>User Management</h1>
                <a href="?download=register" class="download-btn"><i class="fas fa-file-pdf"></i> Download Users</a>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                
                <button class="btn btn-add" onclick="openModal('create')"><i class="fas fa-plus"></i> Add New User</button>
                
                <div class="admin-card">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Verified</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['fullName']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td><?php echo htmlspecialchars($user['role'] ?: 'customer'); ?></td>
                            <td><?php echo $user['is_verified'] ? 'Yes' : 'No'; ?></td>
                            <td>
                                <button class="btn btn-edit" onclick="openModal('update', <?php echo $user['id']; ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>

            <!-- Reports Section -->
            <div class="admin-section" id="reports">
                <h1>Reports</h1>
                <div class="admin-card">
                    <h3>Sales Report</h3>
                    <div class="form-group">
                        <label for="report-period">Select Period:</label>
                        <select id="report-period">
                            <option>Today</option>
                            <option>This Week</option>
                            <option selected>This Month</option>
                            <option>This Year</option>
                            <option>Custom Range</option>
                        </select>
                    </div>
                    <table>
                        <tr>
                            <th>Period</th>
                            <th>Orders</th>
                            <th>Revenue</th>
                            <th>Avg. Order Value</th>
                        </tr>
                        <?php
                        $monthlyData = [];
                        foreach ($orders as $order) {
                            $month = date('F Y', strtotime($order['order_date']));
                            if (!isset($monthlyData[$month])) {
                                $monthlyData[$month] = [
                                    'orders' => 0,
                                    'revenue' => 0
                                ];
                            }
                            $monthlyData[$month]['orders']++;
                            $monthlyData[$month]['revenue'] += $order['total_amount'];
                        }
                        
                        foreach ($monthlyData as $month => $data):
                            $avgOrder = $data['revenue'] / $data['orders'];
                        ?>
                        <tr>
                            <td><?php echo $month; ?></td>
                            <td><?php echo $data['orders']; ?></td>
                            <td>₱<?php echo number_format($data['revenue'], 2); ?></td>
                            <td>₱<?php echo number_format($avgOrder, 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User CRUD Modal -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add New User</h2>
            <form id="userForm" method="POST">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="id" id="userId" value="">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="customer">Customer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="is_verified" name="is_verified" value="1">
                        Verified Account
                    </label>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-add">Update</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
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
        // Sidebar navigation
        document.querySelectorAll('.admin-sidebar li').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.admin-sidebar li').forEach(li => {
                    li.classList.remove('active');
                });
                this.classList.add('active');
                
                document.querySelectorAll('.admin-section').forEach(section => {
                    section.classList.remove('active');
                });
                
                const sectionId = this.getAttribute('data-section');
                document.getElementById(sectionId).classList.add('active');
            });
        });

        // Delete button handlers
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this item?')) {
                    const row = this.closest('tr');
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                    }, 300);
                }
            });
        });

        // Modal functions
        function openModal(action, userId = null) {
            const modal = document.getElementById('userModal');
            const form = document.getElementById('userForm');
            const title = document.getElementById('modalTitle');
            
            form.reset();
            document.getElementById('formAction').value = action;
            
            if (action === 'create') {
                title.textContent = 'Add New User';
                document.getElementById('userId').value = '';
            } else if (action === 'update' && userId) {
                title.textContent = 'Edit User';
                document.getElementById('userId').value = userId;
                
                const user = <?php echo json_encode($users); ?>.find(u => u.id == userId);
                if (user) {
                    document.getElementById('fullName').value = user.fullName;
                    document.getElementById('email').value = user.email;
                    document.getElementById('phone').value = user.phone;
                    document.getElementById('role').value = user.role || 'customer';
                    document.getElementById('is_verified').checked = user.is_verified == 1;
                }
            }
            
            modal.style.display = 'block';
        }

        function closeModal() {
            document.getElementById('userModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('userModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>