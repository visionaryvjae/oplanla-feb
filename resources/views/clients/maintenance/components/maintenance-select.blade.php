<script>
    // MODIFIED: This script now targets any element with data-job-id, making it work for mobile and desktop.
    document.addEventListener("DOMContentLoaded", function () {
        const clickableElements = document.querySelectorAll("[data-job-id]");
        clickableElements.forEach(function (elem) {
            elem.addEventListener("click", function () {
                const jobId = this.getAttribute("data-job-id");
                window.location.href = `/tenant/maintenance/${jobId}`;
            });
        });
    });
</script>