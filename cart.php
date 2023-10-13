<?php
// Database configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "CIA3";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardholder = $_POST["cardholder"];
    $cardnumber = $_POST["cardnumber"];
    $expiry = $_POST["expiry"];
    $cvv = $_POST["cvv"];

    // Validate and ensure cardholder name is not empty
    if (empty($cardholder)) {
        die("Cardholder name cannot be empty.");
    }

    // SQL query to insert payment details into the table
    $sql = "INSERT INTO payment (cardholder_name, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $cardholder, $cardnumber, $expiry, $cvv);

    if ($stmt->execute()) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "message" => "Error storing payment details."));
    }
}

$conn->close();
?>
