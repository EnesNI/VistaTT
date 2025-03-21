<?php 
session_start();
include 'config.php'; 

$offers = [];
$result = $conn->query("SELECT * FROM offers ORDER BY created_at DESC");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }
}



$conn->close();
?>

<div class="dashboard-container">
    <button id="open-filters" style="margin-top: 200px; position: fixed; top: 20px; left: 20px; width: 50px; height: 50px; border-radius: 50%; background: #007bff; color: #fff; border: none; cursor: pointer; box-shadow: 0 0 10px #007bff;">☰</button>
    <div class="filters-container" id="filters" style="display: none;">
        <button id="close-filters" style="  font-size: 18px; position: absolute; top: 10px; right: 10px; width: 30px; height: 30px; border-radius: 50%; background: transparent; color: black; border: none; cursor: pointer;"><b>X</b></button>
        <h2>Filter Offers</h2>

        <!-- Budget Filter -->
        <div class="filter-section">
            <h3>Budget (per night)</h3>
            <input type="number" id="min-price" placeholder="Min price" min="0">
            <input type="number" id="max-price" placeholder="Max price" min="0">
        </div>

        <!-- Popular Filters -->
        <div class="filter-section">
            <h3>Popular Filters</h3>
            <label><input type="checkbox" id="no-credit-card"> Book without credit card</label>
            <label><input type="checkbox" id="beachfront"> Beachfront</label>
            <label><input type="checkbox" id="five-stars"> 5 stars</label>
            <label><input type="checkbox" id="rating-8plus"> Very Good: 8+</label>
            <label><input type="checkbox" id="vacation-homes"> Vacation Homes</label>
            <label><input type="checkbox" id="pet-friendly"> Pet friendly</label>
            <label><input type="checkbox" id="apartments"> Apartments</label>
            <label><input type="checkbox" id="breakfast-dinner"> Breakfast & dinner included</label>
        </div>

        <!-- Fun Things To Do -->
        <div class="filter-section">
            <h3>Fun Things To Do</h3>
            <label><input type="checkbox" id="horseback-riding"> Horseback riding</label>
            <label><input type="checkbox" id="cycling"> Cycling</label>
            <label><input type="checkbox" id="beach"> Beach</label>
            <label><input type="checkbox" id="fishing"> Fishing</label>
            <label><input type="checkbox" id="hiking"> Hiking</label>
        </div>

        <!-- Bedrooms and Bathrooms -->
        <div class="filter-section">
            <h3>Bedrooms and Bathrooms</h3>
            <input type="number" id="bedrooms" placeholder="Bedrooms needed" min="0">
            <input type="number" id="bathrooms" placeholder="Bathrooms needed" min="0">
        </div>

        <!-- Facilities -->
        <div class="filter-section">
            <h3>Facilities</h3>
            <label><input type="checkbox" id="parking"> Parking</label>
            <label><input type="checkbox" id="restaurant"> Restaurant</label>
            <label><input type="checkbox" id="room-service"> Room service</label>
            <label><input type="checkbox" id="front-desk"> 24-hour front desk</label>
            <label><input type="checkbox" id="fitness-center"> Fitness center</label>
            <label><input type="checkbox" id="non-smoking"> Non-smoking rooms</label>
            <label><input type="checkbox" id="airport-shuttle"> Airport shuttle</label>
            <label><input type="checkbox" id="family-rooms"> Family rooms</label>
            <label><input type="checkbox" id="spa"> Spa</label>
            <label><input type="checkbox" id="free-wifi"> Free Wifi</label>
            <label><input type="checkbox" id="charging-station"> EV charging station</label>
            <label><input type="checkbox" id="wheelchair-access"> Wheelchair accessible</label>
            <label><input type="checkbox" id="swimming-pool"> Swimming pool</label>
        </div>

        <button id="apply-filters">Apply Filters</button>
    </div>
</div>

<script>
    const openFiltersBtn = document.getElementById('open-filters');
    const closeFiltersBtn = document.getElementById('close-filters');
    const filters = document.getElementById('filters');

    openFiltersBtn.addEventListener('click', () => {
        filters.style.display = 'block';
    });

    closeFiltersBtn.addEventListener('click', () => {
        filters.style.display = 'none';
    });
</script>



<!-- Add this to your CSS file -->
<style>
.filters-container {
    width: 300px;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: fixed;
    left: 20px;
    top: 100px;
    overflow-y: auto;
    max-height: 80vh;
    margin-right: 30px;
}

.filter-section {
    margin-bottom: 20px;
}

.filter-section h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.filter-section label {
    display: block;
    margin: 5px 0;
    font-size: 14px;
}

#apply-filters {
    display: block;
    width: 100%;
    padding: 10px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#apply-filters:hover {
    background: #0056b3;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Vista Travel</title>
    <link rel="stylesheet" href="dashboardd.css">
</head>
<body>
    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <div class="admin-button">
            <a href="admin.php"  style="float: right; color: blue; text-decoration: none; margin-top: 20px; margin-right: 10px; font-size: ;">Admin</a>
        </div>
    <?php endif; ?>

    <div class="dashboard-container">
        <h1>Find Your Perfect Stay</h1>

        <div class="search-bar">
    <input type="text" id="destination" placeholder="Destination">
    <input type="date" id="check-in" placeholder="Check-In Date">
    <input type="date" id="check-out" placeholder="Check-Out Date">
    <input type="number" id="persons" placeholder="Number of Persons" min="1">
    <button id="search-button">Search</button>
         </div>

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


<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyFiltersBtn = document.getElementById('apply-filters');
    const offersGrid = document.querySelector('.offers-grid');

    applyFiltersBtn.addEventListener('click', function() {
        const filters = {
            minPrice: document.getElementById('min-price').value,
            maxPrice: document.getElementById('max-price').value,
            noCreditCard: document.getElementById('no-credit-card').checked,
            beachfront: document.getElementById('beachfront').checked,
            fiveStars: document.getElementById('five-stars').checked,
            rating8Plus: document.getElementById('rating-8plus').checked,
            vacationHomes: document.getElementById('vacation-homes').checked,
            petFriendly: document.getElementById('pet-friendly').checked,
            apartments: document.getElementById('apartments').checked,
            breakfastDinner: document.getElementById('breakfast-dinner').checked,
            horsebackRiding: document.getElementById('horseback-riding').checked,
            cycling: document.getElementById('cycling').checked,
            beach: document.getElementById('beach').checked,
            fishing: document.getElementById('fishing').checked,
            hiking: document.getElementById('hiking').checked,
            bedrooms: document.getElementById('bedrooms').value,
            bathrooms: document.getElementById('bathrooms').value,
            parking: document.getElementById('parking').checked,
            restaurant: document.getElementById('restaurant').checked,
            roomService: document.getElementById('room-service').checked,
            frontDesk: document.getElementById('front-desk').checked,
            fitnessCenter: document.getElementById('fitness-center').checked,
            nonSmoking: document.getElementById('non-smoking').checked,
            airportShuttle: document.getElementById('airport-shuttle').checked,
            familyRooms: document.getElementById('family-rooms').checked,
            spa: document.getElementById('spa').checked,
            freeWifi: document.getElementById('free-wifi').checked,
            chargingStation: document.getElementById('charging-station').checked,
            wheelchairAccess: document.getElementById('wheelchair-access').checked,
            swimmingPool: document.getElementById('swimming-pool').checked
        };

        fetch('filter_offers.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(filters)
        })
        .then(response => response.json())
        .then(data => {
            offersGrid.innerHTML = '';
            data.forEach(offer => {
                const offerHtml = `
                    <div class="offer-window" data-id="${offer.id}" onclick="showOfferDetails(${offer.id})">
                        <img class="offer-image" src="${offer.photos.split(',')[0]}" alt="Offer Photo">
                        <div class="offer-info">
                            <h3 class="offer-title">${offer.location}</h3>
                            <p class="offer-room-details">${offer.room_details}</p>
                            <div class="offer-bottom">
                                <p class="offer-price"><strong>Price:</strong> $${offer.price_per_person} per person</p>
                                <button class="reserve-button">Reserve</button>
                            </div>
                        </div>
                    </div>
                `;
                offersGrid.innerHTML += offerHtml;
            });
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchButton = document.getElementById('search-button');
    const offersGrid = document.querySelector('.offers-grid');

    searchButton.addEventListener('click', function() {
        // Collect search criteria
        const destination = document.getElementById('destination').value;
        const checkIn = document.getElementById('check-in').value;
        const checkOut = document.getElementById('check-out').value;
        const persons = document.getElementById('persons').value;

        // Validate inputs
        if (!destination || !checkIn || !checkOut || !persons) {
            alert("Please fill in all fields.");
            return;
        }

        // Calculate the number of nights
        const checkInDate = new Date(checkIn);
        const checkOutDate = new Date(checkOut);
        const timeDifference = checkOutDate - checkInDate;
        const nights = Math.ceil(timeDifference / (1000 * 60 * 60 * 24)); // Convert milliseconds to days

        console.log("Search Criteria:", { destination, checkIn, checkOut, persons, nights }); // Debugging: Log search criteria

        // Send search criteria to the server
        fetch('search_offers.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                destination: destination,
                checkIn: checkIn,
                checkOut: checkOut,
                persons: persons,
                nights: nights // Add nights to the request
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log("Search Results:", data); // Debugging: Log search results

            // Check if the response contains an error
            if (data.error) {
                console.error("Error from server:", data.error);
                offersGrid.innerHTML = '<p>An error occurred while searching. Please try again.</p>';
                return;
            }

            offersGrid.innerHTML = ''; // Clear the current offers grid

            // Check if data is empty
            if (data.length === 0) {
                offersGrid.innerHTML = '<p>No offers found matching your criteria.</p>';
                return;
            }

            // Populate the offers grid with the new data
            data.forEach(offer => {
                // Calculate total price
                const totalPrice = (offer.price_per_person * persons * nights).toFixed(2);

                const offerHtml = `
                    <div class="offer-window" data-id="${offer.id}" onclick="showOfferDetails(${offer.id})">
                        <img class="offer-image" src="${offer.photos.split(',')[0]}" alt="Offer Photo">
                        <div class="offer-info">
                            <h3 class="offer-title">${offer.location}</h3>
                            <p class="offer-room-details">${offer.room_details}</p>
                            <div class="offer-bottom">
                                <p class="offer-price"><strong>Total Price:</strong> $${totalPrice} (${nights} nights for ${persons} persons)</p>
                                <button class="reserve-button">Reserve</button>
                            </div>
                        </div>
                    </div>
                `;
                offersGrid.innerHTML += offerHtml;
            });
        })
        .catch(error => {
            console.error('Error:', error); // Debugging: Log any errors
            offersGrid.innerHTML = '<p>An error occurred while searching. Please try again.</p>';
        });
    });
});
</script>