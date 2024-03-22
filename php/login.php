<?php
session_start();

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "mysql";
$dbName = "login_register";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName, 4306);

if ($conn->connect_error) {
    die("Could not connect to database");
}

$email = $_POST["email"];
$password = $_POST["password"];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    if (password_verify($password, $user["password"])) {
        $_SESSION["user"] = "yes";
        header("Location: php/profile.php");
        exit();
    } else {
        echo 'Password does not match';
    }
} else {
    echo 'Email does not match';
}
?>
