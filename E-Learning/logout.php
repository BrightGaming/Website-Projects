<?php
session_start();
session_destroy();
echo json_encode(["success" => "Logged out successfully and see you soon!"]);
?>
