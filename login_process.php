<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'online_restaurant');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user exists
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start a session
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: homepage.php"); // Redirect to home page
            exit();
        } else {
            echo "Incorrect password!";
            header("Location: index.html"); // Redirect to home page

        }
    } else {
        echo "No user found with this email!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h3 {
            text-align: center;
            color: #333;
        }
        .box {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .remember {
            display: flex;
            align-items: center;
        }
        .remember label {
            margin-left: 5px;
            color: #666;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            box-sizing: border-box;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #4cae4c;
        }
        p {
            text-align: center;
            color: #666;
        }
        p a {
            color: #5cb85c;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body background="image/Food - Restaurant Website Design Using HTML - CSS - SASS - JAVASCRIPT - freewebsitecode.jpg">
    <div class="container" id="login-form-container">
        <form action="login_process.php" method="POST">
            
            <h3>Login Form</h3>
            <input type="email" name="email" placeholder="Enter Your Email" class="box" required>
            <input type="password" name="password" placeholder="Enter Your Password" class="box" required>
            <div class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
            </div>
            <input type="submit" value="Login Now" class="btn">
            <p>Forgot your password? <a href="#">Press the button</a></p>
            <p>Don't have an account? <a href="register.html">Create an account</a></p>
            <div><P><a href="index.html">Back To Home</a></P></div>
        </form>
    </div>
</body>
</html>
