<?php
session_start();
include 'config.php'; // Database connection

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
    <title>Offers Locations - Vista Travel</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AlzaSyU2HKh9DpmVvC4BPUgT5l8CKiuCEWTjx5f&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var mapOptions = {
                zoom: 8,
                center: { lat: 40.7128, lng: -74.0060 }, // Default to New York City
            };

            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

            // Mark each offer on the map
            <?php foreach ($offers as $offer): ?>
                var marker = new google.maps.Marker({
                    position: { lat: <?php echo $offer['latitude']; ?>, lng: <?php echo $offer['longitude']; ?> },
                    map: map,
                    title: "<?php echo $offer['location']; ?>"
                });

                var infoWindow = new google.maps.InfoWindow({
                    content: "<h3><?php echo $offer['location']; ?></h3><p><?php echo $offer['description']; ?></p>"
                });

                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
            <?php endforeach; ?>
        }
    </script>
</head>
<body>
    <div id="map" style="height: 100vh;"></div>
</body>
</html>
