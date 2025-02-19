<?php

$servername = "localhost";
$username = "root"; 
$password = "";  
$dbname = "vista_travel";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


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


echo json_encode($locations);
?>
