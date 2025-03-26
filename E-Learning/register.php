<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "capstone";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['pass'] ?? '';
$c_password = $_POST['c_pass'] ?? '';
$user_role = $_POST['user_role'] ?? '';

// Check if passwords match
if ($password !== $c_password) {
    echo json_encode(["error" => "Passwords do not match"]);
    exit();
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["error" => "The email has been registered, pleaseuse another Email to register account."]);
    exit();
}

$stmt->close();

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (name, email, password, user_role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashed_password, $user_role);

if ($stmt->execute()) {
    echo json_encode(["success" => "Account Register Success"]);
} else {
    echo json_encode(["error" => "Registration failed. Please try again."]);
}

$stmt->close();
$conn->close();
?>
