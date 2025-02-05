document.addEventListener('DOMContentLoaded', function () {
    const offerWindows = document.querySelectorAll('.offer-window');
    const modal = document.getElementById('offer-modal');
    const closeModal = document.querySelector('.close');
    const modalPhoto = document.getElementById('modal-photo');
    const modalReviews = document.getElementById('modal-reviews');
    const modalMap = document.getElementById('modal-map');
    const modalRoomDetails = document.getElementById('modal-room-details');
    const modalIncludes = document.getElementById('modal-includes');
    const modalAvailableRooms = document.getElementById('modal-available-rooms');
    const modalTotalPrice = document.getElementById('modal-total-price');
    const prevPhotoButton = document.getElementById('prev-photo');
    const nextPhotoButton = document.getElementById('next-photo');

    let currentOffer = null;
    let currentPhotoIndex = 0;

    // Open modal when an offer is clicked
    offerWindows.forEach(offer => {
        offer.addEventListener('click', () => {
            const offerId = offer.getAttribute('data-id');
            fetch(`get_offer.php?id=${offerId}`)
                .then(response => response.json())
                .then(data => {
                    currentOffer = data;
                    currentPhotoIndex = 0;
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
        if (currentPhotoIndex > 0) {
            currentPhotoIndex--;
            updateModalPhoto();
        }
    });

    nextPhotoButton.addEventListener('click', () => {
        if (currentPhotoIndex < currentOffer.photos.length - 1) {
            currentPhotoIndex++;
            updateModalPhoto();
        }
    });

    // Update modal content
    function updateModal() {
        const photos = currentOffer.photos.split(',');
        modalPhoto.src = photos[currentPhotoIndex];
        modalReviews.textContent = currentOffer.reviews || 'No reviews yet.';
        modalMap.src = currentOffer.map_location;
        modalRoomDetails.textContent = currentOffer.room_details;
        modalIncludes.textContent = `Includes: ${currentOffer.includes}`;
        modalAvailableRooms.textContent = `Available Rooms: ${currentOffer.available_rooms}`;
        modalTotalPrice.textContent = `Total Price: $${currentOffer.price_per_person}`;
    }

    function updateModalPhoto() {
        const photos = currentOffer.photos.split(',');
        modalPhoto.src = photos[currentPhotoIndex];
    }
});

