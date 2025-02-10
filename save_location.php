<?php
// Database connection
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";  // Replace with your database password
$dbname = "vista_travel";  // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get latitude and longitude from the AJAX request
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Save the location in the database
$sql = "INSERT INTO offers (latitude, longitude) VALUES ('$latitude', '$longitude')";
if ($conn->query($sql) === TRUE) {
    echo "New location saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
