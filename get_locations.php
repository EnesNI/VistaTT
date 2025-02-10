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

// Fetch all locations from the database
$sql = "SELECT latitude, longitude FROM offers";
$result = $conn->query($sql);

$locations = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
} else {
    echo "No locations found";
}

$conn->close();

// Return the locations as a JSON response
echo json_encode($locations);
?>
