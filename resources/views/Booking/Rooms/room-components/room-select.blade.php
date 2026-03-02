 <script>
    const rental = {{ $rental }};
    console.log('Rental value:', rental);
    document.addEventListener("DOMContentLoaded", function () {
        // Select all table rows
        const rows = document.querySelectorAll(" div[data-room-id]");

        // Add click event listener to each row
        rows.forEach(function (row) {
            row.addEventListener("click", function () {
                const roomId = this.getAttribute("data-room-id");
                window.location.href = rental ? `/booking/rental/${roomId}` : `/booking/room/${roomId}`;
            });
        });
    });
</script>