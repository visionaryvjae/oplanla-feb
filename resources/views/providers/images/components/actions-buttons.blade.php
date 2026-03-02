<script>
    document.addEventListener('DOMContentLoaded', function() {
        const url = window.location.href;
        const photoidMatch = url.match(/\/provider\/\d+\/images\/(\d+)/);
        if (photoidMatch && photoidMatch[1]) {
            let photoId = parseInt(photoidMatch[1], 10);
            let providerId = {{ $providerId }};

            const editButtonLink = document.querySelector('.btn-edit');
            if (editButtonLink) {
                editButtonLink.href = `/provider/${providerId}/images/edit/${photoId}`;
            }

            const deleteForm = document.querySelector('.form-delete');
            if (deleteForm) {
                deleteForm.action = `/provider/${providerId}/images/delete/${photoId}`;
            }
        }
    });
</script>