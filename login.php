<?php
session_start();
require_once 'db.php';  // Your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve user inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Query to check if the email exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Check password (support both md5 and password_hash)
        $isPasswordValid = false;

        // Check if the password matches the bcrypt hash
        if (password_verify($password, $user['password'])) {
            $isPasswordValid = true;
        }
        // Fallback to md5 for older passwords
        elseif ($user['password'] === md5($password)) {
            $isPasswordValid = true;

            // Re-hash the password with bcrypt for future logins
            $newHash = password_hash($password, PASSWORD_BCRYPT);
            $updateSql = "UPDATE users SET password = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("si", $newHash, $user['id']);
            $updateStmt->execute();
        }

        if ($isPasswordValid) {
            // Successful login
            session_regenerate_id(true);  // Secure session handling
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin.php");  // Redirect to admin dashboard
            } else {
                header("Location: user.php");   // Redirect to user dashboard
            }
            exit();
        }
    }

    // Invalid credentials
    header("Location: auth.php?error=invalid");
    exit();
}
?>
