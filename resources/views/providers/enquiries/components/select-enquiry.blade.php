<script>
    // MODIFIED: This script now targets any element with data-enquiry-id, making it work for mobile and desktop.
    document.addEventListener("DOMContentLoaded", function () {
        const clickableElements = document.querySelectorAll("[data-enquiry-id]");
        clickableElements.forEach(function (elem) {
            elem.addEventListener("click", function () {
                const enquiryId = this.getAttribute("data-enquiry-id");
                window.location.href = `/provider/enquiry/${enquiryId}`;
            });
        });
    });
</script>