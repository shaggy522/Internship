<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $customer_number = $_POST['customer_number'];
    $order_details = $_POST['order_details'];
    $order_quantity = $_POST['order_quantity']; // Updated to match form
    $customer_message = $_POST['customer_message'];
    $order_time = $_POST['order_time'];
    $customer_address = $_POST['customer_address'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'online_restaurant');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_number, order_details, order_quantity, customer_message, order_time, customer_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisisss", $customer_name, $customer_number, $order_details, $order_quantity, $customer_message, $order_time, $customer_address);

    if ($stmt->execute()) {
                // Display the success message and redirect
                echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Registration Success</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                        }
                        .message-container {
                            background-color: white;
                            padding: 20px;
                            border-radius: 10px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        .message-container h1 {
                            color: #28a745;
                        }
                    </style>
                </head>
                <body>
                    <div class="message-container">
                        <h1>Order Placed Successfully...</h1>
                        <p>You will be redirected to the login page shortly.</p>
                    </div>
                </body>
                </html>
                ';
                header("refresh:3;index.html");
        
        
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
