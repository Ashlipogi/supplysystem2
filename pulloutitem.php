<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pullout'])) {
    $serialNumber = $_POST['serialNumber'];

    $updateQuery = "UPDATE supply SET status = 'pulled out' WHERE serialNumber = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("s", $serialNumber);

    if ($stmt->execute()) {
        header("Location: dashboard.php?message=Item successfully marked as pulled out");
    } else {
        header("Location: dashboard.php?message=Failed to mark item as pulled out");
    }
    exit();
}
?>
