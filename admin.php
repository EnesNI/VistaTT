<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $description = $_POST['description'];
    $room_capacity = $_POST['room_capacity'];
    $available_rooms = $_POST['available_rooms'];
    $price_per_person = $_POST['price_per_person'];
    $room_details = $_POST['room_details'];
    $includes = $_POST['includes'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];


    $photos = [];
    if (!empty($_FILES['photos']['name'][0])) {
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                $file_name = basename($_FILES['photos']['name'][$key]);
                $upload_dir = 'uploads/';
                $target_file = $upload_dir . $file_name;
                move_uploaded_file($tmp_name, $target_file);
                $photos[] = $target_file;
            }
        }
    }

    $photos_str = implode(',', $photos); 

 
    $stmt = $conn->prepare("INSERT INTO offers (location, description, room_capacity, available_rooms, price_per_person, room_details, latitude, longitude, includes, photos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiissddss", $location, $description, $room_capacity, $available_rooms, $price_per_person, $room_details, $latitude, $longitude, $includes, $photos_str);

    if ($stmt->execute()) {
        echo "<p>Offer posted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}


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
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsf6zTNX-iDmWmX0GBzmZupExTeHPVc1Q&callback=initMap" async defer></script>
    <script>
        let map, marker;

        function initMap() {
           
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 40.7128, lng: -74.0060 },
                zoom: 10
            });

           
            map.addListener('click', function(event) {
                placeMarker(event.latLng);
            });
        }

        function placeMarker(latLng) {
      
            if (marker) {
                marker.setMap(null);
            }


            marker = new google.maps.Marker({
                position: latLng,
                map: map
            });

    
            document.getElementById('latitude').value = latLng.lat();
            document.getElementById('longitude').value = latLng.lng();
        }
    </script>
</head>
<body onload="initMap()">
<div class="admin-container">
    <h1>Admin Panel</h1>
    <a href="logout.php" style="float: right; color: red; text-decoration: none;">Logout</a> <!-- Logout button -->


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

        <label for="includes">What's Included:</label>
        <input type="text" id="includes" name="includes" required> <!-- e.g., "Breakfast", "All Inclusive" -->

        <label for="map_location">Select Location on Map:</label>
        <input type="text" id="latitude" name="latitude" placeholder="Latitude" required>
        <input type="text" id="longitude" name="longitude" placeholder="Longitude" required>

     
        <div id="map"></div>

        <label for="photos">Upload Photos:</label>
        <input type="file" id="photos" name="photos[]" multiple accept="image/*">

        <button type="submit">Post Offer</button>
    </form>

   
    <h2>Posted Offers</h2>
    <div class="offers-list">
        <?php foreach ($offers as $offer): ?>
            <div class="offer">
                <h3><?php echo htmlspecialchars($offer['location']); ?></h3>
                <p><?php echo htmlspecialchars($offer['description']); ?></p>
                <p><strong>Room Capacity:</strong> <?php echo $offer['room_capacity']; ?></p>
                <p><strong>Available Rooms:</strong> <?php echo $offer['available_rooms']; ?></p>
                <p><strong>Price Per Person:</strong> $<?php echo number_format($offer['price_per_person'], 2); ?></p>
                <p><strong>Room Details:</strong> <?php echo htmlspecialchars($offer['room_details']); ?></p>
                <p><strong>Includes:</strong> <?php echo htmlspecialchars($offer['includes']); ?></p>

                <div class="photos">
                    <?php
                    $photos = explode(',', $offer['photos']);
                    foreach ($photos as $photo):
                        if (!empty($photo)):
                    ?>
                        <img src="<?php echo htmlspecialchars($photo); ?>" alt="Offer Photo" width="100">
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
