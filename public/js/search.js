document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[placeholder="search project"]');

    if (searchInput) {
        searchInput.addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                const form = searchInput.closest("form");
                if (form) {
                    form.submit();
                }
            }
        });
    }
});

