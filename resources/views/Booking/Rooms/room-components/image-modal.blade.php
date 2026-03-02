{{-- Image Modal JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const images = @json($images); // Convert PHP array to JavaScript array
        const modal = document.getElementById('myModal');
        const carouselImage = document.getElementById('carouselImage');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        const miniImageCarousel = document.getElementById('miniImageCarousel');
        const closeButton = document.getElementById('btn_close');
        const closeModal = document.getElementById('close_modal');
        let currentIndex = 0;

        // Variables for swipe/drag functionality
        let startX = 0;
        let isDragging = false;
        let dragThreshold = 50; // Minimum pixels to drag for a swipe

        // --- ADDED: Variables for Zoom & Pan ---
        let isZoomed = false;
        let startPan = { x: 0, y: 0 };
        let currentTranslate = { x: 0, y: 0 };
        let startY = 0; // We also need to track Y for panning

        // Open modal when an image is clicked from the gallery
        document.querySelectorAll('.gallery-image').forEach((image, index) => {
            image.addEventListener('click', () => {
                modal.style.display = 'flex'; // Use flex to center the modal
                currentIndex = index;
                updateCarouselImage();
            });
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
                resetZoom(); // ADDED: Reset zoom on modal close
            }
        };
        
        // --- ADDED: Function to reset zoom state ---
        function resetZoom() {
            isZoomed = false;
            carouselImage.classList.remove('zoomed');
            carouselImage.style.transform = '';
            currentTranslate = { x: 0, y: 0 };
            startPan = { x: 0, y: 0 };
        }

        // Update the carousel image and mini-image focus
        function updateCarouselImage() {
            resetZoom(); // ADDED: Reset zoom every time the image changes
            carouselImage.src = "{{ asset('storage/images') }}" + '/' + images[currentIndex];
            updateMiniImageFocus();
            scrollMiniImageCarousel();
        }

        // Update focus on mini-images
        function updateMiniImageFocus() {
            document.querySelectorAll('.mini-image-wrapper').forEach((wrapper, index) => {
                if (index === currentIndex) {
                    wrapper.classList.add('active');
                } else {
                    wrapper.classList.remove('active');
                }
            });
        }

        // Scroll mini-image carousel to focus on the current image
        function scrollMiniImageCarousel() {
            const activeMiniImage = miniImageCarousel.querySelector('.mini-image-wrapper.active');
            if (activeMiniImage) {
                const containerWidth = miniImageCarousel.offsetWidth;
                const imageWidth = activeMiniImage.offsetWidth;
                const scrollLeft = activeMiniImage.offsetLeft - (containerWidth / 2) + (imageWidth / 2);
                miniImageCarousel.scrollTo({
                    left: scrollLeft,
                    behavior: 'smooth'
                });
            }
        }
        
        // Close modal when clicking close button
        closeButton.addEventListener('click', () => {
            modal.style.display = 'none'; // Hide the modal
            resetZoom(); // ADDED: Reset zoom on modal close
        });
        
        // Close modal when clicking close modal button
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none'; // Hide the modal
            resetZoom(); // ADDED: Reset zoom on modal close
        });

        // Previous button click event
        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateCarouselImage();
        });

        // Next button click event
        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % images.length;
            updateCarouselImage();
        });

        // Click on mini-images to change main image
        miniImageCarousel.addEventListener('click', (event) => {
            const clickedWrapper = event.target.closest('.mini-image-wrapper');
            if (clickedWrapper) {
                const index = parseInt(clickedWrapper.dataset.index);
                if (!isNaN(index) && index >= 0 && index < images.length) {
                    currentIndex = index;
                    updateCarouselImage();
                }
            }
        });

        // --- ADDED: Double-click to Zoom ---
        carouselImage.addEventListener('dblclick', (e) => {
            e.preventDefault(); // Prevent default double-click behavior (like full-screen)
            isZoomed = !isZoomed;
            if (isZoomed) {
                // Zoom In
                carouselImage.classList.add('zoomed');
                
                // --- Optional: Zoom to cursor position (more advanced) ---
                // const rect = carouselImage.getBoundingClientRect();
                // const x = (e.clientX - rect.left) / rect.width;
                // const y = (e.clientY - rect.top) / rect.height;
                // carouselImage.style.transformOrigin = `${x * 100}% ${y * 100}%`;
                // For simplicity, we'll just zoom to center.
            } else {
                // Zoom Out
                resetZoom();
            }
        });


        // --- Swipe/Drag functionality for the main image ---

        // Mouse events for dragging
        carouselImage.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY; // ADDED: track Y
            
            // ADDED: Set start position for panning
            startPan.x = e.clientX - currentTranslate.x;
            startPan.y = e.clientY - currentTranslate.y;
            
            carouselImage.style.cursor = isZoomed ? 'grabbing' : 'grab'; // MODIFIED: cursor
        });

        carouselImage.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault(); // MODIFIED: Always preventDefault when dragging
            
            // ADDED: Panning logic
            if (isZoomed) {
                currentTranslate.x = e.clientX - startPan.x;
                currentTranslate.y = e.clientY - startPan.y;
                
                // Apply the pan
                carouselImage.style.transform = `scale(2.5) translate(${currentTranslate.x}px, ${currentTranslate.y}px)`;
            }
        });

        carouselImage.addEventListener('mouseup', (e) => {
            if (!isDragging) return;
            isDragging = false;
            carouselImage.style.cursor = isZoomed ? 'move' : 'grab'; // MODIFIED: cursor

            // ADDED: If zoomed, we were panning, so don't swipe
            if (isZoomed) return; 

            // --- ORIGINAL SWIPE LOGIC (now conditional) ---
            const endX = e.clientX;
            const diffX = startX - endX; 

            if (Math.abs(diffX) > dragThreshold) {
                if (diffX > 0) { // Swiped left
                    currentIndex = (currentIndex + 1) % images.length;
                } else { // Swiped right
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                }
                updateCarouselImage();
            }
        });

        carouselImage.addEventListener('mouseleave', () => {
            isDragging = false; // Reset dragging if mouse leaves the image area
            carouselImage.style.cursor = isZoomed ? 'move' : 'grab'; // MODIFIED: cursor
        });

        // Touch events for swiping
        carouselImage.addEventListener('touchstart', (e) => {
            isDragging = true;
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY; // ADDED: track Y
            
            // ADDED: Set start position for panning
            startPan.x = e.touches[0].clientX - currentTranslate.x;
            startPan.y = e.touches[0].clientY - currentTranslate.y;
            
        }, { passive: true }); 

        carouselImage.addEventListener('touchmove', (e) => {
            if (!isDragging) return;

            // MODIFIED: Pan logic for touch
            if (isZoomed) {
                e.preventDefault(); // Only preventDefault when panning
                currentTranslate.x = e.touches[0].clientX - startPan.x;
                currentTranslate.y = e.touches[0].clientY - startPan.y;
                
                // Apply the pan
                carouselImage.style.transform = `scale(2.5) translate(${currentTranslate.x}px, ${currentTranslate.y}px)`;
            
            } else {
                // Original logic to prevent vertical scroll while swiping horizontally
                const currentX = e.touches[0].clientX;
                const diffX = startX - currentX;
                if (Math.abs(diffX) > 10) { 
                    e.preventDefault();
                }
            }
        }, { passive: false }); 

        carouselImage.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;
            
            // ADDED: If zoomed, we were panning, so don't swipe
            if (isZoomed) return;

            // --- ORIGINAL SWIPE LOGIC (now conditional) ---
            const endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;

            if (Math.abs(diffX) > dragThreshold) {
                if (diffX > 0) { // Swiped left
                    currentIndex = (currentIndex + 1) % images.length;
                } else { // Swiped right
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                }
                updateCarouselImage();
            }
        });

    });
</script>