{{-- Facilities updating script --}}
<script>
    // This script for the facilities selector is preserved and slightly adapted
    document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('facility-input')) {
        const inputField = document.getElementById('facility-input');
        const suggestionsList = document.getElementById('suggestions');
        const selectedContainer = document.getElementById('selected-facilities');
        const facilitiesHiddenInput = document.getElementById('room_facilities');
        const submitButton = document.getElementById('submit-button');
        
        // MODIFIED: Added references for new elements
        const mainForm = document.getElementById('main_form');
        const applyToProviderCheckbox = document.getElementById('apply_to_provider');
        const providerFacilitiesInput = document.getElementById('provider_facilities');

        const allFacilities = ['Flat Screen Tv', 'Private Bathroom', 'Terrace', 'Hot Tub', 'View', 'Balcony', 'Washing Machine', 'Air Conditioning', 'Private Pool', 'fireplace', 'Pool Cover', 'Mountain View', 'Infinity Pool', 'Sauna', 'Salt Water Pool', 'Computer', 'Game Console', 'Yukata', 'Lake View', 'Complimentary Snacks', 'Reading Light', 'Sea View', 'Pet Friendly', 'Kitchen', 'Electric Blanket', 'Toaster', 'Fridge', 'Microwave', 'Shower', 'Bath', 'Electric Kettle', 'Wifi'];
        let selectedFacilities = facilitiesHiddenInput.value ? facilitiesHiddenInput.value.split(',') : [];

        const renderSelected = () => {
            selectedContainer.innerHTML = '';
            selectedFacilities.forEach(facility => {
                const badge = document.createElement('span');
                badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800';
                badge.style = 'display: inline-flex; align-items:center; padding:0.325rem 0.825rem; border-radius: 1rem; background-color: rgb(224 231 255); color: rgb(55 48 163);'
                badge.textContent = facility;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'flex-shrink-0 ml-1.5 -mr-0.5 p-0.5 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:bg-indigo-500 focus:text-white';
                removeBtn.style = "display: inline-flex;flex-shrink: 0; align-items: center; justify-content: center; margin-left: 0.375rem; margin-right: -0.125rem; padding: 0.125rem; border-radius: 9999px; color: #818cf8;"
                removeBtn.innerHTML = '<span class="sr-only">Remove</span><img width="10" height="10" src="https://img.icons8.com/ios-glyphs/30/6366f1/delete-sign.png" alt="delete-sign"/>';
                removeBtn.onclick = () => {
                    selectedFacilities = selectedFacilities.filter(f => f !== facility);
                    facilitiesHiddenInput.value = selectedFacilities.join(',');
                    renderSelected();
                };
                badge.appendChild(removeBtn);
                selectedContainer.appendChild(badge);
            });
        };

        const updateSuggestions = () => {
            const query = inputField.value.trim().toLowerCase();
            suggestionsList.innerHTML = '';
            if (query === '') {
                suggestionsList.classList.add('hidden');
                return;
            }
            const filtered = allFacilities.filter(f => f.toLowerCase().includes(query) && !selectedFacilities.includes(f));
            if (filtered.length > 0) {
                suggestionsList.classList.remove('hidden');
                filtered.forEach(facility => {
                    const li = document.createElement('li');
                    li.className = 'cursor-default select-none relative py-2 px-4 text-gray-900 hover:bg-indigo-100';
                    li.textContent = facility;
                    li.onclick = () => {
                        selectedFacilities.push(facility);
                        facilitiesHiddenInput.value = selectedFacilities.join(',');
                        renderSelected();
                        inputField.value = '';
                        suggestionsList.classList.add('hidden');
                    };
                    suggestionsList.appendChild(li);
                });
            } else {
                suggestionsList.classList.add('hidden');
            }
        };

        inputField.addEventListener('input', updateSuggestions);
        document.addEventListener('click', (e) => {
            if (!suggestionsList.contains(e.target) && e.target !== inputField) {
                suggestionsList.classList.add('hidden');
            }
        });
        
        // Prevent form submission on Enter key in facility input
        inputField.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const firstSuggestion = suggestionsList.querySelector('li');
                if (firstSuggestion) {
                    firstSuggestion.click();
                }
            }
        });
        
        if (mainForm) {
            mainForm.addEventListener('submit', () => {
                // Check if the checkbox exists and is checked
                if (applyToProviderCheckbox && applyToProviderCheckbox.checked) {
                    // If so, copy the facilities to the provider facilities hidden input
                    providerFacilitiesInput.value = facilitiesHiddenInput.value;
                } else if (providerFacilitiesInput) {
                    // Otherwise, ensure the value is empty
                    providerFacilitiesInput.value = '';
                }
            });
        }

        // The original save button logic is now handled by the main form submit
        // so we remove the standalone save button's event listener to avoid conflicts.
        // We also hide the original save button if it exists.
        const oldSaveButton = document.getElementById('save-button');
        if(oldSaveButton) oldSaveButton.style.display = 'none';

        renderSelected();
    }
});
</script>