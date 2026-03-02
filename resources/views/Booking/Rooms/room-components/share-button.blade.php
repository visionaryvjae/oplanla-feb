<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shareButton = document.getElementById('shareButton');
        const feedbackMessage = document.getElementById('feedback');
        
        // The shareable URL and room name are passed from your controller
        const shareData = {
            title: 'Check out this room!',
            text: 'I found this amazing room: "{{ $room->name }}"', // Using the room name from the controller
            url: '{{ $shareUrl }}' // The URL generated in the controller
        };
    
        shareButton.addEventListener('click', async () => {
            // Use Web Share API if available
            if (navigator.share) {
                try {
                    await navigator.share(shareData);
                    console.log('Room shared successfully');
                } catch (err) {
                    console.error('Share failed:', err.message);
                }
            } else {
                // Fallback: Copy to clipboard for desktop/unsupported browsers
                try {
                    await navigator.clipboard.writeText(shareData.url);
                    feedbackMessage.style.display = 'block';
                    // Hide the message after a few seconds
                    setTimeout(() => {
                        feedbackMessage.style.display = 'none';
                    }, 2000);
                } catch (err) {
                    console.error('Failed to copy: ', err);
                    alert('Oops, unable to copy the link.');
                }
            }
        });
    });
</script>