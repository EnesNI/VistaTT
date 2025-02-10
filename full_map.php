<?php
// Connect to your database to retrieve saved offers
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";  // Replace with your database password
$dbname = "vista_travel";  // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all saved offers from the database
$sql = "SELECT id, location, latitude, longitude, description, price_per_person, photos 
        FROM offers";
$result = $conn->query($sql);

$offers = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }
} else {
    echo "No offers found";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full Map</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        /* Transparent Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            position: absolute; /* Position it on top of the map */
            width: 100%;
            z-index: 1000; /* Ensure it stays above the map */
            pointer-events: all; /* Allow clicking on navbar */
        }

        #map {
            width: 100%;
            height: 100vh;
            z-index: 1; /* Lower the map's z-index so it's below the navbar */
            pointer-events: auto; /* Make the map interactive */
        }

        .navbar .logo {
            height: 130px; /* Adjusted logo size */
            margin-left: 50px;
            margin-top: 10px;
            width: auto;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.3); /* Lower transparency for links */
            transition: background 0.3s ease-in-out, transform 0.2s ease;
        }

        .nav-links a:hover {
            background-color: #00d4ff; /* Lighter blue background on hover */
            color: #003366;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .nav-links .active {
            background-color: #00d4ff;
            color: #003366;
        }

        /* Map Styles */
        #map {
            width: 100%;
            height: 100vh; /* Fullscreen map */
        }

        .info-window {
            font-size: 14px;
            color: #333;
            max-width: 250px;
        }

        .info-window img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .info-window h2 {
            color: #0077ff;
            font-size: 16px;
            margin: 0 0 5px;
        }

        .info-window p {
            margin: 5px 0;
            line-height: 1.4;
        }

        .info-window button {
            display: block;
            width: 100%;
            padding: 10px;
            background: linear-gradient(90deg, #0077ff, #00c6ff);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }

        .info-window button:hover {
            background: linear-gradient(90deg, #005bbb, #0077ff);
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsf6zTNX-iDmWmX0GBzmZupExTeHPVc1Q&callback=initMap" async defer></script>
    <script>
        let map;
        function initMap() {
            // Initialize map with a default center
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 40.7128, lng: -74.0060 }, // Default center (New York City)
                zoom: 10
            });

            // Fetch saved offers from PHP (retrieved from the database)
            const offers = <?php echo json_encode($offers); ?>;

            // Add a marker for each saved offer
            offers.forEach(offer => {
                let latLng = new google.maps.LatLng(offer.latitude, offer.longitude);
                let marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: offer.location  // Set the place name as the title of the marker
                });

                // Get the first photo (using the same method as dashboard.php)
                let photos = offer.photos.split(','); // Assume the photos are stored as comma-separated values
                let firstPhoto = photos[0]; // Get the first photo URL

                // Add info window with offer details
                let content = `
                    <div class="info-window">
                        <h2>${offer.location}</h2>
                        <img src="uploads/${firstPhoto}" alt="${offer.location}" class="offer-photo">
                        <p><strong>Description:</strong> ${offer.description}</p>
                        <p class="price">Price per Person: $${offer.price_per_person}</p>
                        <button onclick="window.location.href='offer_details.php?id=${offer.id}'">View Details</button>
                    </div>
                `;
                
                let infoWindow = new google.maps.InfoWindow({
                    content: content
                });

                // Open the info window when the marker is clicked
                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });
            });
        }

        // Initialize map after the DOM is loaded
        window.onload = initMap;
    </script>
</head>
<body>
    <div class="navbar">
        <img src="VTA logo3.png" alt="Logo" class="logo"> <!-- Replace with your actual logo -->
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">Offers</a>
            <a href="#">Contact</a>
            <a href="#">About</a>
        </div>
    </div>
  
    <div id="map"></div>
</body>
</html>
        