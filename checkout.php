<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $customer_number = $_POST['customer_number'];
    $payment_method = 'GCash';
    $total_amount = (float) $_POST['total_amount'];
    $order_date = date("Y-m-d H:i:s");
    $cart_data = json_decode($_POST['cart_data'], true);

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_number, payment_method, total_amount, order_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $customer_name, $customer_number, $payment_method, $total_amount, $order_date);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert order items
        foreach ($cart_data as $item) {
            $product_name = $item['name'];
            $price = $item['price'];
            $quantity = $item['qty'];

            $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
            $stmt_item->bind_param("isdd", $order_id, $product_name, $price, $quantity);
            $stmt_item->execute();
        }

        // Redirect to receipt page
        header("Location: receipt.php?order_id=$order_id");
        exit;
    } else {
        echo "Checkout error: " . $stmt->error;
    }
}
?>
