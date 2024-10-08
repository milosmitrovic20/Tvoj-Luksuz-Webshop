document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const searchButton = document.getElementById('searchButton');

    // Function to normalize search input for Serbian Latin characters
    function normalizeSerbianLatin(text) {
        const charMap = {
            'dj': 'đ', // Handle 'dj' before 'd' to avoid interference
            'c': 'č', 
            's': 'š', 
            'z': 'ž', 
            'd': 'đ', 
            'C': 'Č', 
            'S': 'Š', 
            'Z': 'Ž', 
            'D': 'Đ',
            'ć': 'ć' // Keeps 'ć' intact for real 'ć'
        };

        for (const [key, value] of Object.entries(charMap)) {
            const regex = new RegExp(key, 'g');
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
