<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Database connection

$id = $_GET['id'];

// Delete the offer
$stmt = $conn->prepare("DELETE FROM offers WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin.php");
} else {
    echo "<p>Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>