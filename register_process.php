<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    
    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $conn = new mysqli('localhost', 'root', '', 'online_restaurant');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO users (username, email, phone_number, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $phone_number, $hashed_password);

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
                    <h1>Registration successful...</h1>
                    <p>You will be redirected to the login page shortly.</p>
                </div>
            </body>
            </html>
            ';
            header("refresh:3;login.html");
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
    } else {
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
                    <h1>Password does not match</h1>
                    <p>You will be redirected to the registration page shortly.</p>
                </div>
            </body>
            </html>
            ';
            header("refresh:3;register.html");

    }
}
?>
