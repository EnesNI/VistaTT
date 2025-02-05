<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Handle form submission for posting offers
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $description = $_POST['description'];
    $room_capacity = $_POST['room_capacity'];
    $available_rooms = $_POST['available_rooms'];

    // Handle file uploads
    $photos = [];
    if (!empty($_FILES['photos']['name'][0])) {
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['photos']['name'][$key];
            $file_tmp = $_FILES['photos']['tmp_name'][$key];
            $upload_dir = 'uploads/';
            move_uploaded_file($file_tmp, $upload_dir . $file_name);
            $photos[] = $upload_dir . $file_name;
        }
    }

    $photos_str = implode(',', $photos); // Convert array to comma-separated string

    // Insert offer into the database
    $stmt = $conn->prepare("INSERT INTO offers (location, description, room_capacity, available_rooms, photos) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiis", $location, $description, $room_capacity, $available_rooms, $photos_str);

    if ($stmt->execute()) {
        echo "<p>Offer posted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch all offers from the database
$offers = [];
$result = $conn->query("SELECT * FROM offers ORDER BY created_at DESC");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Vista Travel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-container">
        <h1>Admin Panel</h1>
        <a href="logout.php" style="float: right; color: red; text-decoration: none;">Logout</a> <!-- Logout button -->
        <!-- Form to post new offers -->
        <form action="admin.php" method="POST" enctype="multipart/form-data">
    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="room_capacity">Room Capacity:</label>
    <input type="number" id="room_capacity" name="room_capacity" required>

    <label for="available_rooms">Available Rooms:</label>
    <input type="number" id="available_rooms" name="available_rooms" required>

    <label for="price_per_person">Price Per Person:</label>
    <input type="number" id="price_per_person" name="price_per_person" step="0.01" required>

    <label for="room_details">Room Details:</label>
    <textarea id="room_details" name="room_details" required></textarea>

    <label for="map_location">Map Location (Google Maps URL):</label>
    <input type="text" id="map_location" name="map_location" required>

    <label for="includes">What's Included:</label>
    <input type="text" id="includes" name="includes" required> <!-- e.g., "Breakfast", "All Inclusive" -->

    <label for="photos">Upload Photos:</label>
    <input type="file" id="photos" name="photos[]" multiple accept="image/*">

    

    <button type="submit">Post Offer</button>
</form>

        <!-- Display all offers -->
        <h2>Posted Offers</h2>
        <div class="offers-list">
            <?php foreach ($offers as $offer): ?>
                <div class="offer">
                    <h3><?php echo $offer['location']; ?></h3>
                    <p><?php echo $offer['description']; ?></p>
                    <p><strong>Room Capacity:</strong> <?php echo $offer['room_capacity']; ?></p>
                    <p><strong>Available Rooms:</strong> <?php echo $offer['available_rooms']; ?></p>
                    <div class="photos">
                        <?php
                        $photos = explode(',', $offer['photos']);
                        foreach ($photos as $photo):
                            if (!empty($photo)):
                        ?>
                            <img src="<?php echo $photo; ?>" alt="Offer Photo" width="100">
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                    <a href="edit_offer.php?id=<?php echo $offer['id']; ?>">Edit</a>
                    <a href="delete_offer.php?id=<?php echo $offer['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>