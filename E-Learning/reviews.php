<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";  // Change if needed
$user = "root";       // Change to your MySQL username
$pass = "";           // Change if your MySQL has a password
$dbname = "capstone";

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';  // Capture email from request
    $rating = $_POST['rating'] ?? 5;
    $comment = $_POST['comment'] ?? '';

    if (empty($name) || empty($comment) || empty($email)) {
        echo json_encode(["error" => "Please fill in all fields."]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO reviews (name, email, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $email, $rating, $comment);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Review submitted successfully!"]);
    } else {
        echo json_encode(["error" => "Failed to submit review."]);
    }

    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");
    $reviews = [];

    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    echo json_encode($reviews);
}

$conn->close();
?>
