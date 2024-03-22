<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "mysql";
$dbName = "login_register";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName, 4306);

if ($conn->connect_error) {
    die("Could not connect to database");
}

$fullName = $_POST["fullname"];
$email = $_POST["email"];
$password = $_POST["password"];
$passwordRepeat = $_POST["repeat_password"];

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$errors = array();

if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
    array_push($errors, "All fields are required");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Email is not valid");
}
if (strlen($password) < 8) {
    array_push($errors, "Password must be at least 8 characters long");
}
if ($password !== $passwordRepeat) {
    array_push($errors, "Password does not match");
}

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
        array_push($errors, "Email already exists!");
    }
} else {
    array_push($errors, "Database error");
}

if (count($errors) > 0) {
    $response = array("status" => "error", "errors" => $errors);
} else {
    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
        mysqli_stmt_execute($stmt);
        $response = array("status" => "success", "message" => "You are registered successfully.");
    } else {
        $response = array("status" => "error", "errors" => array("Something went wrong"));
    }
}

echo json_encode($response);
?>
