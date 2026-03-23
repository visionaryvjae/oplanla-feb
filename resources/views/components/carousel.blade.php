<script>
    const carouselContainer = document.getElementById('carousel-container');
    const prevBtnConference = document.getElementById('prevBtnConference');
    const nextBtnConference = document.getElementById('nextBtnConference');


    // The width of one carousel item including its margin-right (w-64 + space-x-6 -> 16rem + 1.5rem = 17.5rem).
    // A more robust way is to get it dynamically.
    const itemWidthConference = carouselContainer.children[0] ? carouselContainer.children[0].offsetWidth + 24 : 280; // 256px + 24px

    nextBtnConference.addEventListener('click', () => {
        carouselContainer.scrollBy({ left: itemWidthConference, behavior: 'smooth' });
    });

    prevBtnConference.addEventListener('click', () => {
        carouselContainer.scrollBy({ left: -itemWidthConference, behavior: 'smooth' });
    });

    // Optional: Hide/show buttons based on scroll position
    function updateButtonStateConference() {
        const maxScrollLeftConference = carouselContainer.scrollWidth - carouselContainer.clientWidth;
        prevBtnConference.style.display = carouselContainer.scrollLeft <= 0 ? 'none' : 'block';
        nextBtnConference.style.display = carouselContainer.scrollLeft >= maxScrollLeftConference -1 ? 'none' : 'block'; // -1 for precision issues
    }

    carouselContainer.addEventListener('scroll', updateButtonStateConference);
    window.addEventListener('resize', updateButtonStateConference); // Update on resize
    updateButtonStateConference(); // Initial check
</script>