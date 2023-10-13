<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "CIA3";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the book title from the URL query parameter
$bookTitle = $_GET["title"];

// SQL query to fetch book details
$sql = "SELECT * FROM repository WHERE book_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $bookTitle);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows >= 1) {
    $bookData = $result->fetch_assoc();
    // Retrieve book details
    $bookName = $bookData["book_name"];
    $authorName = $bookData["author_name"];
    $bookPrice = $bookData["book_price"];
    
    $response = array(
        "success" => true,
        "book" => array(
            "book_name" => $bookName,
            "author_name" => $authorName,
            "book_price" => $bookPrice
        )
    );

    echo json_encode($response);
} else {
    $response = array("success" => false, "message" => "Book not found in the repository");
    echo json_encode($response);
}

$conn->close();
?>
