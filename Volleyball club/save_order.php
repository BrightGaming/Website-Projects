<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "orders";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data from the request body or form
$data = json_decode(file_get_contents('php://input'), true);

// You can also retrieve form data using $_POST if it's sent via POST
$name = $_POST['name'] ?? null;
$phone = $_POST['phone'] ?? null;
$address = $_POST['address'] ?? null;
$cart = isset($_POST['cart']) ? json_decode($_POST['cart'], true) : null;

// Check if cart exists
if ($cart === null) {
    error_log("Cart is not set or is null.");
    echo "Cart is not set.";
    exit();
} else {
    error_log("Cart received: " . print_r($cart, true));
}

// Prepare and bind - Insert customer info and order details into the `orders` table
$stmt = $conn->prepare("INSERT INTO orders (name, phone, address, cart) VALUES (?, ?, ?, ?)");
$cart_json = json_encode($cart);
$stmt->bind_param("ssss", $name, $phone, $address, $cart_json);

// Execute the statement and handle errors
if ($stmt->execute()) {
    // Redirect to thank you page after successful order
    header("Location: thank_you.php");
    exit();
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
