<script>
    // MODIFIED: This script now targets any element with data-room-id, making it work for mobile and desktop.
    document.addEventListener("DOMContentLoaded", function () {
        const clickableElements = document.querySelectorAll("[data-room-id]");
        clickableElements.forEach(function (elem) {
            elem.addEventListener("click", function () {
                const roomId = this.getAttribute("data-room-id");
                window.location.href = `/provider/room/${roomId}`;
            });
        });
    });
</script>