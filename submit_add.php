<?php
// Database connection
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password
$dbname = "csucc_supply_office"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate form data
    $fundCluster = $conn->real_escape_string($_POST['fundCluster']);
    $serialNumber = $conn->real_escape_string($_POST['serialNumber']);
    $supplierName = $conn->real_escape_string($_POST['supplierName']);
    $description = $conn->real_escape_string($_POST['description']);
    $amount = $_POST['amount'];
    $targetDeliveryDate = $_POST['targetDeliveryDate'];
    $poNumber = $conn->real_escape_string($_POST['PoNumber']); // Ensure this is treated as a string
    $office = $conn->real_escape_string($_POST['office']);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO Supply (fundCluster, serialNumber, supplierName, description, amount, targetDeliveryDate, poNumber, office) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $fundCluster, $serialNumber, $supplierName, $description, $amount, $targetDeliveryDate, $poNumber, $office);

    // Execute the statement
    if ($stmt->execute()) {
        // If successful, return a success response
        echo json_encode(['success' => true]);
    } else {
        // If an error occurs, return an error response
        echo json_encode(['success' => false, 'error' => 'Error: ' . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
