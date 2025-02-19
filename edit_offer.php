<?php
session_start();


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; 

$id = $_GET['id'];


$stmt = $conn->prepare("SELECT * FROM offers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$offer = $result->fetch_assoc();
$stmt->close();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $description = $_POST['description'];
    $room_capacity = $_POST['room_capacity'];
    $available_rooms = $_POST['available_rooms'];

    $stmt = $conn->prepare("UPDATE offers SET location = ?, description = ?, room_capacity = ?, available_rooms = ? WHERE id = ?");
    $stmt->bind_param("ssiii", $location, $description, $room_capacity, $available_rooms, $id);

    if ($stmt->execute()) {
        echo "<p>Offer updated successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Offer - Vista Travel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit Offer</h1>

        <form action="edit_offer.php?id=<?php echo $id; ?>" method="POST">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo $offer['location']; ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $offer['description']; ?></textarea>

            <label for="room_capacity">Room Capacity:</label>
            <input type="number" id="room_capacity" name="room_capacity" value="<?php echo $offer['room_capacity']; ?>" required>

            <label for="available_rooms">Available Rooms:</label>
            <input type="number" id="available_rooms" name="available_rooms" value="<?php echo $offer['available_rooms']; ?>" required>

            <button type="submit">Update Offer</button>
        </form>
    </div>
</body>
</html>