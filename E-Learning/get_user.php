<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$response = [
    "name" => $_SESSION['name'],
    "role" => $_SESSION['role'],
    "profile_image" => $_SESSION['profile_image']
];

echo json_encode($response);
?>
