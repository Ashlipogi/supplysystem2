<?php
session_start();
require_once 'db.php';  // Your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirmPassword = md5($_POST['password_confirmation']);

    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Email is already taken.";
        } else {
            // Insert new user into the database
            $role = 'user';  // New user role by default
            $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $name, $email, $password, $role);
            if ($stmt->execute()) {
                echo "Account created successfully.";
                header("Location: auth.php");
            } else {
                echo "Error creating account.";
            }
        }
    }
}
?>
