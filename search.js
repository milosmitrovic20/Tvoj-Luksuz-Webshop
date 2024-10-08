document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const searchButton = document.getElementById('searchButton');

    // Function to generate all possible variations of a word with Serbian Latin replacements
    function generateVariations(text) {
        const charMap = {
            'c': ['c', 'č', 'ć'],
            's': ['s', 'š'],
            'z': ['z', 'ž'],
            'dj': ['dj', 'đ'],
            'd': ['d', 'đ'],
            'C': ['C', 'Č', 'Ć'],
            'S': ['S', 'Š'],
            'Z': ['Z', 'Ž'],
            'D': ['D', 'Đ']
        };

        let variations = ['']; // Start with an empty array

        for (let i = 0; i < text.length; i++) {
            const char = text[i];
            const nextTwoChars = text.slice(i, i + 2);

            // Handle 'dj' as a special case
            if (nextTwoChars === 'dj' || nextTwoChars === 'DJ') {
                const newVariations = [];
                charMap['dj'].forEach(replacement => {
                    variations.forEach(variation => {
                        newVariations.push(variation + replacement);
                    });
                });
                variations = newVariations;
                i++; // Skip the next character since 'dj' is two characters
                continue;
            }

            // Handle single character replacements
            const replacements = charMap[char] || [char]; // If no replacement, use the original char
            const newVariations = [];

            replacements.forEach(replacement => {
                variations.forEach(variation => {
                    newVariations.push(variation + replacement);
                });
            });

            variations = newVariations;
        }

        return variations;
    }

    searchButton.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default link behavior
        let query = searchInput.value.trim();

        if (query) {
            // Generate all possible variations of the search query
            const queryVariations = generateVariations(query);

            // Now you have an array of all possible variations, for example:
            // ['sofersajbna', 'šoferšajbna', 'šoferšajbna', 'soferšajbna', ...]

            // Redirect to the shop page with one of the variations
            // For example, sending the first variation:
            window.location.href = `shop-full-width.php?query=${encodeURIComponent(queryVariations[0])}`;

            // If you need to use multiple variations, you can handle it based on your backend logic.
        }
    });
});
