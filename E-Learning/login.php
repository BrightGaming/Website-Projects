<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "capstone";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get user input
$email = $_POST['email'] ?? '';
$password = $_POST['pass'] ?? '';

// Check if user exists
$stmt = $conn->prepare("SELECT id, name, email, password, user_role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['user_role'];

        // Determine redirect URL based on user role
        $redirect_url = "";
        switch ($user['user_role']) {
            case "admin":
                $redirect_url = "home(admin).html";
                break;
            case "lecturer":
                $redirect_url = "home(lecturer).html";
                break;
            case "student":
                $redirect_url = "home.html";
                break;
        }

        echo json_encode([
            "success" => "Login Successful!",
            "user" => $user,
            "redirect" => $redirect_url
        ]);
    } else {
        echo json_encode(["error" => "Invalid password"]);
    }
} else {
    echo json_encode(["error" => "Email not found"]);
}

$stmt->close();
$conn->close();
?>





