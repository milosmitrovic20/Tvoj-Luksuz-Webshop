// Function to remove a product from the cart
const removeFromCart = (productId) => {
    let cartItems = JSON.parse(localStorage.getItem('cart')) || []; // Retrieve cart from localStorage

    // Filter out the product with the given ID
    cartItems = cartItems.filter(item => item.id !== productId);

    // Update localStorage with the new cart array
    localStorage.setItem('cart', JSON.stringify(cartItems));

    // Re-render the cart
    displayCartProducts();
};

// Event listener for remove buttons
const setupRemoveButtons = () => {
    const removeButtons = document.querySelectorAll('.cr-cart-remove a'); // Select all remove buttons

    // Add event listeners to each remove button
    removeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-id'); // Get the product ID from data-id
            removeFromCart(productId); // Call removeFromCart with the product ID
        });
    });
};

// Function to display products in the cart (same as before but adding the setupRemoveButtons call)
const displayCartProducts = () => {
    const cartItems = JSON.parse(localStorage.getItem('cart')) || []; // Retrieve cart from localStorage
    const cartTableBody = document.querySelector('#cart-table-body'); // Assuming there's a <tbody> with this ID

    // Clear the current contents of the cart
    cartTableBody.innerHTML = '';

    // Loop through the cart items and generate HTML for each
    cartItems.forEach((item) => {
        const productHTML = `
            <tr class="border-b-[1px] border-solid border-[#e9e9e9]">
                <td class="cr-cart-name w-[40%] py-[25px] px-[14px] text-[#444] text-[16px] text-left bg-[#f7f7f8]">
                    <a href="javascript:void(0)" class="text-[#444] font-medium text-[14px] flex leading-[1.5] tracking-[0.6px] items-center">
                        <img src="${item.image}" alt="${item.name}" class="cr-cart-img mr-[20px] w-[60px] border-[1px] border-solid border-[#e9e9e9] rounded-[5px]">
                        ${item.name}
                    </a>
                </td>
                <td class="cr-cart-price py-[25px] px-[14px] text-[#555] text-[15px] font-medium text-left bg-[#f7f7f8]">
                    <span class="amount text-[#555] text-[15px] font-medium text-left">$${item.price}</span>
                </td>
                <td class="cr-cart-qty py-[25px] px-[14px] text-[#444] text-[16px] text-left bg-[#f7f7f8]">
                    <div class="cart-qty-plus-minus w-[80px] h-[30px] my-[0] mx-auto relative overflow-hidden flex bg-[#fff] border-[1px] border-solid border-[#e9e9e9] rounded-[5px] items-center justify-between">
                        <button type="button" class="plus h-[25px] w-[25px] mt-[-2px] border-[0] bg-transparent flex justify-center items-center" data-id="${item.id}">+</button>
                        <input type="text" placeholder="." value="${item.quantity}" minlength="1" maxlength="20" class="quantity w-[30px] m-[0] p-[0] text-[#444] float-left text-[14px] font-semibold leading-[38px] h-auto text-center outline-[0]">
                        <button type="button" class="minus h-[25px] w-[25px] mt-[-2px] border-[0] bg-transparent flex justify-center items-center" data-id="${item.id}">-</button>
                    </div>
                </td>
                <td class="cr-cart-subtotal py-[25px] px-[14px] text-[#555] font-medium text-[15px] text-left bg-[#f7f7f8]">$${item.price * item.quantity}</td>
                <td class="cr-cart-remove py-[25px] px-[14px] w-[90px] text-[#555] font-medium text-[15px] text-right bg-[#f7f7f8]">
                    <a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out my-[0] mx-auto text-[#555] hover:text-[#fb5555]" data-id="${item.id}">
                        <i class="ri-delete-bin-line text-[22px]"></i>
                    </a>
                </td>
            </tr>
        `;

        // Append the product HTML to the cart table body
        cartTableBody.insertAdjacentHTML('beforeend', productHTML);
    });

    // Setup remove button functionality after rendering
    setupRemoveButtons();
};

// Call the function to display the cart products
displayCartProducts();