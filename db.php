<?php
$servername = "localhost";
$username = "root";
$password = "";  // Your database password
$dbname = "csucc_supply_office";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
