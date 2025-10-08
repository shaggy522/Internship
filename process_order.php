<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $customer_number = $_POST['customer_number'];
    $order_details = $_POST['order_details'];
    $order_quantity = $_POST['order_quantity'];
    $customer_message = $_POST['customer_message'];
    $order_time = $_POST['order_time'];
    $customer_address = $_POST['customer_address'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'restaurant_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_number, order_details, order_quantity, customer_message, order_time, customer_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisisss", $customer_name, $customer_number, $order_details, $order_quantity, $customer_message, $order_time, $customer_address);

    if ($stmt->execute()) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
