document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const searchButton = document.getElementById('searchButton');

    searchButton.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default link behavior
        const query = searchInput.value.trim();

        if (query) {
            // Redirect to the shop page with the query parameter
            window.location.href = `shop-full-width.php?query=${encodeURIComponent(query)}`;
        }
    });
});
