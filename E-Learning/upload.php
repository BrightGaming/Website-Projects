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

$targetDir = 'uploads/';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_name = $POST['UploadFile'];
    $file_path = $targetDir . $file_name;
    $folder = $POST[''];
    $uploaded_by = 
    $uploaded_to = 
}
?>

