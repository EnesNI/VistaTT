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

document.addEventListener("DOMContentLoaded", function () {
    const offers = document.querySelectorAll(".offer");
    const expandedView = document.createElement("div");
    expandedView.classList.add("offer-expanded");
    document.body.appendChild(expandedView);

    offers.forEach(offer => {
        offer.addEventListener("click", function () {
            const imgSrc = this.querySelector("img").src;
            const title = this.querySelector(".offer-title").innerText;
            const details = this.querySelector(".room-details").innerText;
            const price = this.querySelector(".price").innerText;
            const rating = this.dataset.rating;
            const description = this.dataset.description;

            expandedView.innerHTML = `
                <img src="${imgSrc}" alt="Offer Image">
                <div class="offer-info">
                    <div class="rating">⭐ ${rating}</div>
                    <h2>${title}</h2>
                    <p class="room-details">${details}</p>
                    <p class="price">${price}</p>
                    <button class="reserve-button">Reserve</button>
                    <p class="offer-description">${description}</p>
                </div>
            `;

            expandedView.style.display = "flex";

            // Clicking anywhere inside expands to fullscreen and shows description
            expandedView.addEventListener("click", function () {
                expandedView.classList.toggle("fullscreen");
            });
        });
    });
});
