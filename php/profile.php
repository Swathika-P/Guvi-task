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

if(isset($_POST['new_email']) && isset($_POST['new_name']) && isset($_POST['new_dob'])) {
    $newEmail = $_POST['new_email'];
    $newName = $_POST['new_name'];
    $newDob = $_POST['new_dob'];


    $stmt = $conn->prepare("UPDATE userprofile SET email = ?, full_name = ?, dob = ? WHERE id = 1");
    $stmt->bind_param("sssi", $newEmail, $newName, $newDob, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Profile updated successfully";
    } else {
        echo "Failed to update profile";
    }
} else {
    echo "Invalid request";
}
?>
