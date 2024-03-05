function addToCart() {
    var productName = document.querySelector('.product-details-title').textContent;
    var productPrice = document.querySelector('.product-details-price').textContent;
    var quantity = parseInt(document.getElementById('quantity').value);

    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    var existingItem = cartItems.find(function (item) {
        return item.name === productName;
    });

    if (existingItem) {

        existingItem.quantity += quantity;
    } else {

        var newItem = { name: productName, price: productPrice, quantity: quantity };
        cartItems.push(newItem);
    }

    localStorage.setItem('cartItems', JSON.stringify(cartItems));
}