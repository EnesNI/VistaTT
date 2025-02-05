<?php
session_start();
include 'config.php'; // Database connection

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM offers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$offer = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($offer);

$stmt->close();
$conn->close();
?>