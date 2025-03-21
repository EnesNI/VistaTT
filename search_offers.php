<?php
include 'config.php';

// Get the raw POST data
$data = file_get_contents('php://input');
$searchCriteria = json_decode($data, true);

// Debugging: Log the received search criteria
error_log("Received Search Criteria: " . print_r($searchCriteria, true));

// Extract search criteria
$destination = isset($searchCriteria['destination']) ? $searchCriteria['destination'] : '';
$checkIn = isset($searchCriteria['checkIn']) ? $searchCriteria['checkIn'] : '';
$checkOut = isset($searchCriteria['checkOut']) ? $searchCriteria['checkOut'] : '';
$persons = isset($searchCriteria['persons']) ? intval($searchCriteria['persons']) : 1;

// Build the SQL query
$sql = "SELECT * FROM offers WHERE location LIKE ? AND room_capacity >= ?";

// Debugging: Log the SQL query
error_log("SQL Query: " . $sql);

// Prepare the SQL statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    $error = $conn->error; // Get the error message
    error_log("Error preparing statement: " . $error);
    die(json_encode(['error' => 'Database error: ' . $error])); // Return detailed error
}

// Bind parameters
$destinationParam = "%$destination%";
$stmt->bind_param("si", $destinationParam, $persons);

// Execute the query
if (!$stmt->execute()) {
    $error = $stmt->error; // Get the error message
    error_log("Error executing statement: " . $error);
    die(json_encode(['error' => 'Database error: ' . $error])); // Return detailed error
}

$result = $stmt->get_result();
$offers = [];

// Fetch results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }
}

// Debugging: Log the results
error_log("Search Results: " . print_r($offers, true));

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($offers);

// Close the statement and connection
$stmt->close();
$conn->close();
?>