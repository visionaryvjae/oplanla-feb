<script>
function toggleDescription() {
    const content = document.getElementById('property-description');
    const button = document.querySelector('.toggle-btn');

    if (content.classList.contains('expanded')) {
        content.classList.remove('expanded');
        button.textContent = 'Show more';
    } else {
        content.classList.add('expanded');
        button.textContent = 'Show less';
    }
}

// Optional: Hide button if description is short
document.addEventListener('DOMContentLoaded', function() {
    const content = document.getElementById('property-description');
    const btn = document.querySelector('.toggle-btn');

    // Temporarily ensure it's visible to measure
    content.style.display = 'block';

    if (content.scrollHeight <= content.clientHeight) {
        btn.style.display = 'none';
    }
});
</script>