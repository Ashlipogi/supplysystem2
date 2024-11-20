<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $serialNumber = $_POST['serialNumber'];

    $deleteQuery = "DELETE FROM supply WHERE serialNumber = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $serialNumber);

    if ($stmt->execute()) {
        header("Location: dashboard.php?message=Item successfully deleted");
    } else {
        header("Location: dashboard.php?message=Failed to delete item");
    }
    exit();
}
?>
