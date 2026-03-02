{{-- This script is preserved to maintain functionality --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const url = window.location.href;
        const roomidMatch = url.match(/provider\/meters\/(\d+)/);
        if (roomidMatch && roomidMatch[1]) {
            let roomId = parseInt(roomidMatch[1], 10);
            const editButtonLink = document.querySelector('.btn-edit');
            if (editButtonLink) {
                editButtonLink.href = "{{ route('provider.meters.edit', '__ROOM_ID__') }}".replace('__ROOM_ID__', roomId);
            }
            const deleteForm = document.querySelector('.form-delete');
            if (deleteForm) {
                deleteForm.action = "{{ route('provider.meters.destroy', '__ROOM_ID__') }}".replace('__ROOM_ID__', roomId);
            }
        }
    });
</script>