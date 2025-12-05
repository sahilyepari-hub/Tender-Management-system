<?php
session_start();
require_once 'db.php';

// If not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php?msg=Invalid request");
    exit;
}

// Get all inputs
$first = trim($_POST['first_name']);
$middle = trim($_POST['middle_name']);
$last = trim($_POST['last_name']);
$mobile = trim($_POST['mobile']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$confirm_password = trim($_POST['confirm_password']);

// Validate fields
if ($first == '' || $middle == '' || $last == '' || $mobile == '' || $email == '' || $password == '') {
    header("Location: register.php?msg=All fields required");
    exit;
}

if ($password !== $confirm_password) {
    header("Location: register.php?msg=Passwords do not match");
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Handle photo upload
if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {

    $tmp = $_FILES['photo']['tmp_name'];
    $name = $_FILES['photo']['name'];
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    // allowed image formats
    $allowed = ['jpg', 'jpeg', 'png'];
    if (!in_array($ext, $allowed)) {
        header("Location: register.php?msg=Only JPG, JPEG, PNG allowed");
        exit;
    }

    // New filename
    $newName = uniqid() . "." . $ext;
    $uploadPath = "uploads/" . $newName;

    // move file
    move_uploaded_file($tmp, $uploadPath);

} else {
    header("Location: register.php?msg=Photo upload failed");
    exit;
}

// Insert user into database
$stmt = $mysqli->prepare("INSERT INTO users 
    (first_name, middle_name, last_name, mobile, email, password, photo)
    VALUES (?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssss", 
    $first, $middle, $last, $mobile, $email, $hashedPassword, $uploadPath);

if ($stmt->execute()) {
    header("Location: login.php?msg=Registration successful!");
    exit;
} else {
    header("Location: register.php?msg=Email already exists");
    exit;
}
?>
