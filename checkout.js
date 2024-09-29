// Function to display products in the cart
const displayCartItems = () => {
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    const cartContainer = document.querySelector('#cr-checkout-pro'); // Assuming this is your container

    // Clear the current contents of the cart
    cartContainer.innerHTML = '';

    // Loop through the cart items and generate HTML for each
    cartItems.forEach((item) => {
        const productHTML = `
            <div class="w-full mb-[15px]">
                <div class="cr-product-inner flex flex-row items-center">
                    <div class="cr-pro-image-outer w-[80px] mr-[15px]">
                        <div class="cr-pro-image overflow-hidden">
                            <a href="product-left-sidebar.html" class="image">
                                <img class="main-image" src="${item.image}" alt="${item.name}" class="w-full">
                            </a>
                        </div>
                    </div>
                    <div class="cr-pro-content cr-product-details justify-start w-[calc(100%-143px)] p-[0] flex flex-col border-[0]">
                        <h5 class="cr-pro-title text-left mb-[.5rem] pr-[15px] text-[15px] leading-[1.2] max-[1199px]:mb-[0]">
                            <a href="product-left-sidebar.html" class="text-[15px] text-[#000] font-medium leading-[1.2]">${item.name}</a>
                        </h5>
                        <p class="cr-price font-Poppins text-[16px] leading-[1.75] text-[#7a7a7a] text-left max-[1199px]:text-[14px]">
                            <span class="new-price text-[#64b496] font-bold">$${item.price.toFixed(2)}</span>
                        </p>
                        <p class="quantity text-[14px] text-[#555]">Quantity: ${item.quantity}</p>
                    </div>
                </div>
            </div>
        `;

        // Append the product HTML to the cart container
        cartContainer.insertAdjacentHTML('beforeend', productHTML);
    });
};

// Call the function to display cart items
displayCartItems();