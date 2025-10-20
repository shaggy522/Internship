<?php
// Database configuration
$host = 'localhost';
$dbname = 'intern';
$username = 'root';
$password = '1234'; // Replace with your actual DB password

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and collect form data
        $fullname = htmlspecialchars(trim($_POST['fullname']));
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars(trim($_POST['phone']));
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO users (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$fullname, $email, $phone, $password]);

        echo "Registration successful!";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
