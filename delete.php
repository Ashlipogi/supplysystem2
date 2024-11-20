<?php
session_start();
require_once 'db.php'; // Include database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in or not admin
    exit();
}

// Check if the serial number is provided via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['serialNumber'])) {
    // Sanitize and validate the serial number
    $serialNumber = $conn->real_escape_string($_POST['serialNumber']);

    // Prepare the delete query
    $deleteQuery = "DELETE FROM supply WHERE serialNumber = ?";
    $stmt = $conn->prepare($deleteQuery);
    if ($stmt) {
        $stmt->bind_param("s", $serialNumber);

        if ($stmt->execute()) {
            // Success - Redirect back to the list page
            header("Location: pullout.php?message=Record deleted successfully");
            exit();
        } else {
            // Error in execution
            echo "<script>alert('Error: Unable to delete the record.'); window.location.href = 'pullout.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error: Failed to prepare the delete statement.'); window.location.href = 'pullout.php';</script>";
    }
} else {
    echo "<script>alert('Error: Invalid request.'); window.location.href = 'pullout.php';</script>";
}

$conn->close();
?>
