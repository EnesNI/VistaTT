<?php
session_start();


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; 

$id = $_GET['id'];


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