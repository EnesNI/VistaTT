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

    // Collect checkbox filter values
    $filters = [
        'no_credit_card' => isset($_POST['no_credit_card']) ? 1 : 0,
        'beachfront' => isset($_POST['beachfront']) ? 1 : 0,
        'five_stars' => isset($_POST['five_stars']) ? 1 : 0,
        'rating_8plus' => isset($_POST['rating_8plus']) ? 1 : 0,
        'vacation_homes' => isset($_POST['vacation_homes']) ? 1 : 0,
        'pet_friendly' => isset($_POST['pet_friendly']) ? 1 : 0,
        'apartments' => isset($_POST['apartments']) ? 1 : 0,
        'breakfast_dinner' => isset($_POST['breakfast_dinner']) ? 1 : 0,
        'horseback_riding' => isset($_POST['horseback_riding']) ? 1 : 0,
        'cycling' => isset($_POST['cycling']) ? 1 : 0,
        'beach' => isset($_POST['beach']) ? 1 : 0,
        'fishing' => isset($_POST['fishing']) ? 1 : 0,
        'hiking' => isset($_POST['hiking']) ? 1 : 0,
        'parking' => isset($_POST['parking']) ? 1 : 0,
        'restaurant' => isset($_POST['restaurant']) ? 1 : 0,
        'room_service' => isset($_POST['room_service']) ? 1 : 0,
        'front_desk' => isset($_POST['front_desk']) ? 1 : 0,
        'fitness_center' => isset($_POST['fitness_center']) ? 1 : 0,
        'non_smoking' => isset($_POST['non_smoking']) ? 1 : 0,
        'airport_shuttle' => isset($_POST['airport_shuttle']) ? 1 : 0,
        'family_rooms' => isset($_POST['family_rooms']) ? 1 : 0,
        'spa' => isset($_POST['spa']) ? 1 : 0,
        'free_wifi' => isset($_POST['free_wifi']) ? 1 : 0,
        'charging_station' => isset($_POST['charging_station']) ? 1 : 0,
        'wheelchair_access' => isset($_POST['wheelchair_access']) ? 1 : 0,
        'swimming_pool' => isset($_POST['swimming_pool']) ? 1 : 0
    ];

    // Store filter values as a serialized string or JSON
    $filters_str = json_encode($filters);

    // Handle uploaded photos
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

// Insert data into the database
$stmt = $conn->prepare("INSERT INTO offers (location, description, room_capacity, available_rooms, price_per_person, room_details, latitude, longitude, includes, photos, filters) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiissddsss", $location, $description, $room_capacity, $available_rooms, $price_per_person, $room_details, $latitude, $longitude, $includes, $photos_str, $filters_str);

if ($stmt->execute()) {
    echo "<p>Offer posted successfully!</p>";
} else {
    echo "<p>Error: " . $stmt->error . "</p>";
}

$stmt->close();

echo "Location: $location<br>";
echo "Description: $description<br>";
echo "Room Capacity: $room_capacity<br>";
echo "Available Rooms: $available_rooms<br>";
echo "Price Per Person: $price_per_person<br>";
echo "Room Details: $room_details<br>";
echo "Latitude: $latitude<br>";
echo "Longitude: $longitude<br>";
echo "Includes: $includes<br>";
echo "Photos: $photos_str<br>";
echo "Filters: $filters_str<br>";
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
    <link rel="stylesheet" href="adminn.css">
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsf6zTNX-iDmWmX0GBzmZupExTeHPVc1Q&callback=initMap" async defer></script>

    
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
<a href="logout.php" style="float: right; color: red; text-decoration: none;">Logout</a> <!-- Logout button -->

<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
    <a href="users.admin.php" style="float: right; color: blue; text-decoration: none;">Users</a>
<?php endif; ?>

<a href="dashboard.php" style="float: right; color: blue; text-decoration: none;">Dashboard</a>

<div class="admin-container">
    <h1>Admin Panel</h1>                 
   

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
        <br>
 <br>  
      

    <!-- Popular Filters -->
    <div class="checkbox-section">
        <h3>Popular Filters</h3>
        <label><input type="checkbox" name="no_credit_card"> Book without credit card</label>
        <label><input type="checkbox" name="beachfront"> Beachfront</label>
        <label><input type="checkbox" name="five_stars"> 5 stars</label>
        <label><input type="checkbox" name="rating_8plus"> Very Good: 8+</label>
        <label><input type="checkbox" name="vacation_homes"> Vacation Homes</label>
        <label><input type="checkbox" name="pet_friendly"> Pet friendly</label>
        <label><input type="checkbox" name="apartments"> Apartments</label>
        <label><input type="checkbox" name="breakfast_dinner"> Breakfast & dinner included</label>
    </div>

    <!-- Fun Things To Do -->
    <div class="checkbox-section">
        <h3>Fun Things To Do</h3>
        <label><input type="checkbox" name="horseback_riding"> Horseback riding</label>
        <label><input type="checkbox" name="cycling"> Cycling</label>
        <label><input type="checkbox" name="beach"> Beach</label>
        <label><input type="checkbox" name="fishing"> Fishing</label>
        <label><input type="checkbox" name="hiking"> Hiking</label>
    </div>

    <!-- Bedrooms and Bathrooms -->
    <div class="checkbox-section">
        <h3>Bedrooms and Bathrooms</h3>
        <input type="number" name="bedrooms" placeholder="Bedrooms" min="0">
        <input type="number" name="bathrooms" placeholder="Bathrooms" min="0">
    </div>

    <!-- Facilities -->
    <div class="checkbox-section">
        <h3>Facilities</h3>
        <label><input type="checkbox" name="parking"> Parking</label>
        <label><input type="checkbox" name="restaurant"> Restaurant</label>
        <label><input type="checkbox" name="room_service"> Room service</label>
        <label><input type="checkbox" name="front_desk"> 24-hour front desk</label>
        <label><input type="checkbox" name="fitness_center"> Fitness center</label>
        <label><input type="checkbox" name="non_smoking"> Non-smoking rooms</label>
        <label><input type="checkbox" name="airport_shuttle"> Airport shuttle</label>
        <label><input type="checkbox" name="family_rooms"> Family rooms</label>
        <label><input type="checkbox" name="spa"> Spa</label>
        <label><input type="checkbox" name="free_wifi"> Free Wifi</label>
        <label><input type="checkbox" name="charging_station"> EV charging station</label>
        <label><input type="checkbox" name="wheelchair_access"> Wheelchair accessible</label>
        <label><input type="checkbox" name="swimming_pool"> Swimming pool</label>
    </div>
<br>
 <br>  

        <label for="map_location">Select Location on Map:</label>
        <input type="text" id="latitude" name="latitude" placeholder="Latitude" required>
        <input type="text" id="longitude" name="longitude" placeholder="Longitude" required>
        <div id="map"></div>
        <br>
        <label for="photos">Upload Photos:</label>
        <input type="file" id="photos" name="photos[]" multiple accept="image/*">
        <br>
        <button type="submit">Post Offer</button>
    </form>
    </div> 
   
    
    <div class="offers-list">
    <h2>Posted Offers</h2>
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

</body>
</html>
