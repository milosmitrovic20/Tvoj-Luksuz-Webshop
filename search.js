document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const searchButton = document.getElementById('searchButton');

    // Function to normalize search input for Serbian Latin characters
    function normalizeSerbianLatin(text) {
        const charMap = {
            'c': 'č', 's': 'š', 'z': 'ž', 'dj': 'đ', 'd': 'đ', 'c': 'ć'
        };

        for (const [key, value] of Object.entries(charMap)) {
            const regex = new RegExp(key, 'gi');
            text = text.replace(regex, value);
        }

        return text;
    }

    searchButton.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default link behavior
        let query = searchInput.value.trim();

        if (query) {
            // Normalize the query before sending
            query = normalizeSerbianLatin(query);

            // Redirect to the shop page with the normalized query parameter
            window.location.href = `shop-full-width.php?query=${encodeURIComponent(query)}`;
        }
    });
});