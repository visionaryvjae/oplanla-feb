<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('room-filter-form');
        const bedNumSelect = document.getElementById('num_beds');
        const toggleButton = document.getElementById('toggle-filters-button');
        const filtersContainer = document.getElementById('filters-container');
        if (toggleButton && filtersContainer) {
            toggleButton.addEventListener('click', () => {
                filtersContainer.classList.toggle('hidden');
            });
        }
    });
    
</script>