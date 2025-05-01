<?php
include 'connect.php';

// Include TCPDF library
require_once('tcpdf/tcpdf.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order main details
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    // Fetch ordered items
    $stmt_items = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");
    $stmt_items->bind_param("i", $order_id);
    $stmt_items->execute();
    $items = $stmt_items->get_result();

    // Calculate total from items (as a backup in case order total is wrong)
    $calculated_total = 0;
    $items_for_total = $items->fetch_all(MYSQLI_ASSOC);
    foreach ($items_for_total as $item) {
        $calculated_total += $item['price'] * $item['quantity'];
    }

    // Check if PDF download was requested
    if (isset($_GET['download']) && $_GET['download'] == 'pdf') {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('Your Store');
        $pdf->SetAuthor('Your Store');
        $pdf->SetTitle('Order Receipt #' . $order_id);
        $pdf->SetSubject('Order Receipt');

        // Add a page
        $pdf->AddPage();

        // Set some content
        $html = '<h1 style="text-align:center;">Order Receipt</h1>';
        $html .= '<p><strong>Order ID:</strong> ' . htmlspecialchars($order['id']) . '</p>';
        $html .= '<p><strong>Name:</strong> ' . htmlspecialchars($order['customer_name']) . '</p>';
        $html .= '<p><strong>GCash Number:</strong> ' . htmlspecialchars($order['customer_number']) . '</p>';
        $html .= '<p><strong>Payment Method:</strong> ' . htmlspecialchars($order['payment_method']) . '</p>';
        $html .= '<p><strong>Order Date:</strong> ' . htmlspecialchars(date('Y-m-d H:i:s', strtotime($order['order_date']))) . '</p>';

        $html .= '<h3>Items Ordered:</h3>';
        $html .= '<table border="1" cellpadding="4">
                    <thead>
                        <tr>
                            <th><strong>Product Name</strong></th>
                            <th><strong>Qty</strong></th>
                            <th><strong>Price (₱)</strong></th>
                            <th><strong>Subtotal (₱)</strong></th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($items_for_total as $item) {
            $html .= '<tr>
                        <td>' . htmlspecialchars($item['product_name']) . '</td>
                        <td>' . $item['quantity'] . '</td>
                        <td>₱' . number_format($item['price'], 2) . '</td>
                        <td>₱' . number_format($item['price'] * $item['quantity'], 2) . '</td>
                    </tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<p style="text-align:right; font-size:14pt; font-weight:bold;">
                    Total Paid: ₱' . number_format($calculated_total, 2) . '</p>';

        // Output HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        $pdf->Output('receipt_order_' . $order_id . '.pdf', 'D');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f8f9fa;
            position: relative;
        }
        .receipt {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .download-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .download-btn:hover {
            background: #45a049;
        }
        .back-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            padding: 10px 20px;
            background: #0076c0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover {
            background: #005fa3;
        }
    </style>
</head>
<body>

<div class="receipt">
    <h2 style="text-align:center;">Order Receipt</h2>

    <?php if ($order): ?>
        <p><strong>Order ID:</strong> <?= htmlspecialchars($order['id']) ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
        <p><strong>GCash Number:</strong> <?= htmlspecialchars($order['customer_number']) ?></p>
        <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
        <p><strong>Order Date:</strong> <?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($order['order_date']))) ?></p>

        <h3>Items Ordered:</h3>

        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price (₱)</th>
                    <th>Subtotal (₱)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items_for_total as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>₱<?= number_format($item['price'], 2) ?></td>
                    <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            Total Paid: ₱<?= number_format($calculated_total, 2) ?>
        </div>

        <a href="receipt.php?order_id=<?= $order_id ?>&download=pdf" class="download-btn">Download as PDF</a>
    <?php else: ?>
        <p>No order found.</p>
    <?php endif; ?>
</div>

<!-- Back to Menu Button -->
<button class="back-btn" onclick="window.location.href='menu.php'">Back to Menu</button>

</body>
</html>
