<?php

$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "vista_travel";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];


$sql = "INSERT INTO offers (latitude, longitude) VALUES ('$latitude', '$longitude')";
if ($conn->query($sql) === TRUE) {
    echo "New location saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
