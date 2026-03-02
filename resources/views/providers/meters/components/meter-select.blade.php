<script>
    // MODIFIED: This script now targets any element with data-room-id, making it work for mobile and desktop.
    document.addEventListener("DOMContentLoaded", function () {
        const clickableElements = document.querySelectorAll("[data-meter-id]");
        clickableElements.forEach(function (elem) {
            elem.addEventListener("click", function () {
                const meterId = this.getAttribute("data-meter-id");
                window.location.href = `/provider/meters/${meterId}`;
            });
        });
    });
</script>