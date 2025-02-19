document.addEventListener('DOMContentLoaded', function () {
    const offerWindows = document.querySelectorAll('.offer-window');
    const modal = document.getElementById('offer-modal');
    const closeModal = document.querySelector('.close');
    const modalPhoto = document.getElementById('modal-photo');
    const modalReviews = document.getElementById('modal-reviews');
    const modalRoomDetails = document.getElementById('modal-room-details');
    const modalIncludes = document.getElementById('modal-includes');
    const modalAvailableRooms = document.getElementById('modal-available-rooms');
    const modalTotalPrice = document.getElementById('modal-total-price');
    const prevPhotoButton = document.getElementById('prev-photo');
    const nextPhotoButton = document.getElementById('next-photo');

    let currentOffer = null;
    let currentPhotoIndex = 0;
    let photos = [];

    // Open modal when an offer is clicked
    offerWindows.forEach(offer => {
        offer.addEventListener('click', () => {
            const offerId = offer.getAttribute('data-id');
            fetch(`get_offer.php?id=${offerId}`)
                .then(response => response.json())
                .then(data => {
                    currentOffer = data;
                    currentPhotoIndex = 0;
                    photos = currentOffer.photos.split(',');
                    updateModal();
                    modal.style.display = 'flex';
                });
        });
    });

    // Close modal
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Navigate photos
    prevPhotoButton.addEventListener('click', () => {
        currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
        updateModalPhoto();
    });

    nextPhotoButton.addEventListener('click', () => {
        currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
        updateModalPhoto();
    });

    // Update modal content
    function updateModal() {
        updateModalPhoto();
        modalReviews.textContent = currentOffer.reviews || 'No reviews yet.';
        modalRoomDetails.textContent = currentOffer.room_details;
        modalIncludes.textContent = `Includes: ${currentOffer.includes}`;
        modalAvailableRooms.textContent = `Available Rooms: ${currentOffer.available_rooms}`;
        modalTotalPrice.textContent = `Total Price: $${currentOffer.price_per_person}`;

        // Initialize Google Map
        initMap(currentOffer.latitude, currentOffer.longitude);
    }

    function updateModalPhoto() {
        if (photos.length > 0) {
            modalPhoto.src = photos[currentPhotoIndex];
        }
    }

    // Initialize Google Map with offer location
    function initMap(lat, lng) {
        const mapContainer = document.getElementById("map-container");
        if (!mapContainer) return;

        const map = new google.maps.Map(mapContainer, {
            center: { lat: parseFloat(lat), lng: parseFloat(lng) },
            zoom: 14,
        });

        new google.maps.Marker({
            position: { lat: parseFloat(lat), lng: parseFloat(lng) },
            map: map,
            title: "Offer Location",
        });
    }
});
