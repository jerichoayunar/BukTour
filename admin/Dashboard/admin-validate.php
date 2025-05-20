<?php
session_start();
include('../../includes/db.php'); // Ensure this path is correct for your setup

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: login-admin.php");
        exit();
    }

    // Prepare and execute SQL
    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: login-admin.php");
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // If user found
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $username;
            $_SESSION['success'] = "Welcome, $username!";
            header("Location: dashboard.php"); 
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['error'] = "Admin user not found.";
    }

    $stmt->close();
    $conn->close();

    header("Location: login-admin.php");
    exit();
} else {
    // If someone tries to access it directly
    $_SESSION['error'] = "Invalid request.";
    header("Location: login-admin.php");
    exit();
}
