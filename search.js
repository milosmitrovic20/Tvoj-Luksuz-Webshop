document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const productContainer = document.querySelector('.col-50'); // Container for products
    const productCountSpan = document.querySelector('.center-content span'); // Span for displaying the number of products found

    let products = [];

    // Fetch all products from the server once
    fetch('get_products.php')
        .then(response => response.json())
        .then(data => {
            products = data;
            displayProducts(products); // Display all products initially
        })
        .catch(error => console.error('Error fetching products:', error));

    // Event listener for search button click
    document.querySelector('.search-btn').addEventListener('click', () => {
        const query = searchInput.value.toLowerCase();
        const filteredProducts = products.filter(product =>
            product.naziv.toLowerCase().includes(query)
        );
        displayProducts(filteredProducts);
        productCountSpan.textContent = `Pronašli smo ${filteredProducts.length} proizvoda za tebe!`;
    });

    // Function to display products
    const displayProducts = (productList) => {
        productContainer.innerHTML = ''; // Clear current products
        productList.forEach(product => {
            const productHTML = `
                <div class="min-[992px]:w-[25%] w-[50%] max-[480px]:w-full px-[12px] cr-product-box mb-[24px]">
                    <div class="cr-product-card h-full p-[12px] border-[1px] border-solid border-[#e9e9e9] bg-[#fff] rounded-[5px] overflow-hidden flex-col max-[480px]:w-full">
                        <div class="cr-product-image rounded-[5px] flex items-center justify-center relative">
                            <div class="cr-image-inner zoom-image-hover w-full h-full flex items-center justify-center relative overflow-hidden max-[991px]:pointer-events-none">
                                <img src="${product.url_slike}" alt="${product.naziv}" class="w-full rounded-[5px]">
                            </div>
                        </div>
                        <div class="cr-product-details pt-[24px] text-center overflow-hidden max-[1199px]:pt-[20px]">
                            <a href="product-full-width.php?id=${product.id_proizvoda}" class="title transition-all duration-[0.3s] ease-in-out mb-[12px] font-Poppins text-[15px] font-medium leading-[24px] text-[#2b2b2d] hover:text-[#64b496] flex justify-center">${product.naziv}</a>
                            <p class="cr-price font-Poppins text-[16px] text-[#7a7a7a] leading-[1.75] max-[1199px]:text-[14px]">
                                <span class="new-price font-Poppins text-[16px] leading-[1.75] max-[1199px]:text-[14px] font-bold text-[#64b496]">${product.cena_sa_popustom} RSD</span> 
                                <span class="old-price font-Poppins ml-[5px] leading-[1.75] text-[13px] line-through text-[#7a7a7a] max-[1199px]:text-[12px]">${product.cena_bez_popusta} RSD</span>
                            </p>
                        </div>
                    </div>
                </div>
            `;
            productContainer.insertAdjacentHTML('beforeend', productHTML);
        });
    };
});