<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "capstone";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === "fetch") {
    $result = $conn->query("SELECT id, name, email, user_role FROM users ORDER BY id ASC");
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);
}

// Add a new user
if ($action === "add") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';
    $password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);

    if (empty($name) || empty($email) || empty($role)) {
        echo json_encode(["error" => "All fields are required."]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, user_role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        echo json_encode(["success" => "User added successfully!"]);
    } else {
        echo json_encode(["error" => "Failed to add user."]);
    }

    $stmt->close();
}

// Edit an existing user
if ($action === "edit") {
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($id) || empty($name) || empty($email) || empty($role)) {
        echo json_encode(["error" => "All fields are required."]);
        exit();
    }

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, password=?, user_role=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $email, $password, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, user_role=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => "User updated successfully!"]);
    } else {
        echo json_encode(["error" => "Failed to update user."]);
    }

    $stmt->close();
}

// Delete a user
if ($action === "delete") {
    $id = $_POST['id'] ?? 0;
    if (empty($id)) {
        echo json_encode(["error" => "User ID is required."]);
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => "User deleted successfully!"]);
    } else {
        echo json_encode(["error" => "Failed to delete user."]);
    }

    $stmt->close();
}

$conn->close();
?>
