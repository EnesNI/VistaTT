<?php

$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "vista_travel";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

       
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            position: absolute; 
            width: 100%;
            z-index: 1000; 
            pointer-events: all; 
        }

        #map {
            width: 100%;
            height: 100vh;
            z-index: 1; 
            pointer-events: auto; 
        }

        .navbar .logo {
            height: 130px; 
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
            background: rgba(255, 255, 255, 0.3); 
            transition: background 0.3s ease-in-out, transform 0.2s ease;
        }

        .nav-links a:hover {
            background-color: #00d4ff; 
            color: #003366;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .nav-links .active {
            background-color: #00d4ff;
            color: #003366;
        }

        #map {
            width: 100%;
            height: 100vh;
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
            
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 40.7128, lng: -74.0060 }, 
                zoom: 10
            });

          
            const offers = <?php echo json_encode($offers); ?>;

           
            offers.forEach(offer => {
                let latLng = new google.maps.LatLng(offer.latitude, offer.longitude);
                let marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: offer.location  
                });

                
                let photos = offer.photos.split(',');
                let firstPhoto = photos[0]; 

              
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

             
                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });
            });
        }

       
        window.onload = initMap;
    </script>
</head>
<body>
    <div class="navbar">
        <img src="VTA logo3.png" alt="Logo" class="logo"> 
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
        