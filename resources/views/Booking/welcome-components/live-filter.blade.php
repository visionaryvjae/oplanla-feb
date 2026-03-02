<script>
    // This script for live filtering on the other dropdowns remains the same.
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('room-filter-form');
        const bedNumSelect = document.getElementById('num_beds');
        
        const locationInput = document.getElementById('location');
        const propertyTypeSelect = document.getElementById('property_type');
        const minPriceSelect = document.getElementById('min_price');
        const maxPriceSelect = document.getElementById('max_price');
        const resultsContainer = document.getElementById('room-results-container');
        const loadingIndicator = document.getElementById('loading-indicator');
    
        const filterInputs = [locationInput, propertyTypeSelect, minPriceSelect, maxPriceSelect, bedNumSelect];
    
        const fetchRooms = () => {
            loadingIndicator.style.display = 'block';
            resultsContainer.style.display = 'none';
    
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();
    
            fetch(`{{ route('rooms.live-filter') }}?${params}`)
                .then(response => response.text())
                .then(html => {
                    loadingIndicator.style.display = 'none';
                    resultsContainer.innerHTML = html;
                    resultsContainer.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching rooms:', error);
                    loadingIndicator.style.display = 'none';
                    resultsContainer.innerHTML = '<p class="text-center text-red-500">Could not load rooms. Please try again.</p>';
                    resultsContainer.style.display = 'block';
                });
        };
    
        filterInputs.forEach(input => {
            let debounceTimer;
            const eventType = input.tagName === 'SELECT' ? 'change' : 'keyup';
    
            input.addEventListener(eventType, () => {
                if (input.id === 'location') return; // Location input is handled by the other script
                if (eventType === 'keyup') {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(fetchRooms, 500);
                } else {
                    fetchRooms();
                }
            });
        });
        
        // Add event listener for form submission
        form.addEventListener('submit', (e) => {
            e.preventDefault(); // Prevent default form submission
            fetchRooms(); // Manually trigger the fetch
        });
    });
</script>