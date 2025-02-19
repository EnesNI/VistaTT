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
    <title>Dashboard - Vista Travel</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Find Your Perfect Stay</h1>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="destination" placeholder="Destination">
            <input type="date" id="check-in" placeholder="Check-In Date">
            <input type="date" id="check-out" placeholder="Check-Out Date">
            <input type="number" id="persons" placeholder="Number of Persons" min="1">
            <button id="search-button">Search</button>
        </div>

        <!-- Offers Grid -->
        <div class="offers-grid">
            <?php foreach ($offers as $offer): ?>
                <div class="offer-window" data-id="<?php echo $offer['id']; ?>" onclick="showOfferDetails(<?php echo $offer['id']; ?>)">
                    <img class="offer-image" src="<?php echo explode(',', $offer['photos'])[0]; ?>" alt="Offer Photo">
                    <div class="offer-info">
                        <h3 class="offer-title"><?php echo $offer['location']; ?></h3>
                        <p class="offer-room-details"><?php echo $offer['room_details']; ?></p>
                        <div class="offer-bottom">
                            <p class="offer-price"><strong>Price:</strong> $<?php echo $offer['price_per_person']; ?> per person</p>
                            <button class="reserve-button">Reserve</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Detailed Offer Modal -->
    <div id="offer-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-left">
                <img id="modal-photo" src="" alt="Offer Photo">
                <div class="photo-navigation">
                    <button id="prev-photo">❮ Prev</button>
                    <button id="next-photo">Next ❯</button>
                </div>
            </div>
            <div class="modal-right">
                <div class="reviews">
                    <h3>Reviews</h3>
                    <p id="modal-reviews">No reviews yet.</p>
                </div>
                <div class="map">
                    <h3>Location</h3>
                    <div id="map-container" style="width: 100%; height: 200px; border-radius: 10px;"></div>
                </div>
                <div class="details">
                    <h3>Details</h3>
                    <p id="modal-room-details"></p>
                    <p id="modal-includes"></p>
                    <p id="modal-available-rooms"></p>
                </div>
                <div class="price">
                    <h3>Total Price</h3>
                    <p id="modal-total-price"></p>
                    <button id="reserve-button">Reserve Now</button>
                </div>
            </div>
        </div>
    </div>

    <script src="dashboardd.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsf6zTNX-iDmWmX0GBzmZupExTeHPVc1Q&callback=initMap"></script>
</body>
</html>
