<?php
include 'config.php';

$filters = json_decode(file_get_contents('php://input'), true);

$sql = "SELECT * FROM offers WHERE 1=1";

if (!empty($filters['minPrice'])) {
    $sql .= " AND price_per_person >= " . floatval($filters['minPrice']);
}
if (!empty($filters['maxPrice'])) {
    $sql .= " AND price_per_person <= " . floatval($filters['maxPrice']);
}
if ($filters['noCreditCard']) {
    $sql .= " AND no_credit_card = 1";
}
if ($filters['beachfront']) {
    $sql .= " AND beachfront = 1";
}
if ($filters['fiveStars']) {
    $sql .= " AND five_stars = 1";
}
if ($filters['rating8Plus']) {
    $sql .= " AND rating_8plus = 1";
}
if ($filters['vacationHomes']) {
    $sql .= " AND vacation_homes = 1";
}
if ($filters['petFriendly']) {
    $sql .= " AND pet_friendly = 1";
}
if ($filters['apartments']) {
    $sql .= " AND apartments = 1";
}
if ($filters['breakfastDinner']) {
    $sql .= " AND breakfast_dinner = 1";
}
if ($filters['horsebackRiding']) {
    $sql .= " AND horseback_riding = 1";
}
if ($filters['cycling']) {
    $sql .= " AND cycling = 1";
}
if ($filters['beach']) {
    $sql .= " AND beach = 1";
}
if ($filters['fishing']) {
    $sql .= " AND fishing = 1";
}
if ($filters['hiking']) {
    $sql .= " AND hiking = 1";
}
if (!empty($filters['bedrooms'])) {
    $sql .= " AND bedrooms = " . intval($filters['bedrooms']);
}
if (!empty($filters['bathrooms'])) {
    $sql .= " AND bathrooms = " . intval($filters['bathrooms']);
}
if ($filters['parking']) {
    $sql .= " AND parking = 1";
}
if ($filters['restaurant']) {
    $sql .= " AND restaurant = 1";
}
if ($filters['roomService']) {
    $sql .= " AND room_service = 1";
}
if ($filters['frontDesk']) {
    $sql .= " AND front_desk = 1";
}
if ($filters['fitnessCenter']) {
    $sql .= " AND fitness_center = 1";
}
if ($filters['nonSmoking']) {
    $sql .= " AND non_smoking = 1";
}
if ($filters['airportShuttle']) {
    $sql .= " AND airport_shuttle = 1";
}
if ($filters['familyRooms']) {
    $sql .= " AND family_rooms = 1";
}
if ($filters['spa']) {
    $sql .= " AND spa = 1";
}
if ($filters['freeWifi']) {
    $sql .= " AND free_wifi = 1";
}
if ($filters['chargingStation']) {
    $sql .= " AND charging_station = 1";
}
if ($filters['wheelchairAccess']) {
    $sql .= " AND wheelchair_access = 1";
}
if ($filters['swimmingPool']) {
    $sql .= " AND swimming_pool = 1";
}

$result = $conn->query($sql);
$offers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }
}

echo json_encode($offers);

$conn->close();
?>