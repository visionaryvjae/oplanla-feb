<script>
    // MODIFIED: This script now targets any element with data-tenant-id, making it work for mobile and desktop.
    document.addEventListener("DOMContentLoaded", function () {
        const clickableElements = document.querySelectorAll("[data-tenant-id]");
        clickableElements.forEach(function (elem) {
            elem.addEventListener("click", function () {
                const tenantId = this.getAttribute("data-tenant-id");
                window.location.href = `/provider/tenants/${tenantId}`;
            });
        });
    });
</script>