<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/index/nav.css">
    <link rel="stylesheet" href="./public/css/index/cart.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/index.php">
                <img src="./public/img/logo.png" alt="Pharmawell Logo" class="logo"> Pharmawell
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./shop.php">Shop</a>
                    </li>
                </ul>
                <div class="navbar-icons d-flex align-items-center">
                    <a href="./auth/login.php" class="nav-link"><i class="fas fa-user"></i> Login </a>
                    <a href="#" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
        </nav>

        <div class="main-container">
            <div class="container">
                <h2 class="mt-5 mb-4">Cart</h2>
                <div id="cart-items">
               </div>
                <div id="total-price" class="text-right mt-4">
                    Total: <span id="total-amount"></span>
                    <button class="btn btn-success btn-lg ml-2" onclick="buyItems()">Check Out</button>
                </div>
            </div>
        </div>

        <section class="design-element">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3>Our Mission</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec dictum nunc. Nullam vitae
                            ligula sed nisi sagittis facilisis vitae nec velit. Integer scelerisque magna sit amet dui
                            suscipit, sed aliquam nunc scelerisque.</p>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <div class="container">
                <p>
                    &copy; 2024 Pharmawell. All rights reserved. |
                    <a href="./privacypolicy.php">Privacy Policy</a> | <a href="./termsofservice.php">Terms of Service</a>
                </p>
            </div>
        </footer> 
    
    <!-- node -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>

<script>
    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    function renderCart() {
        var cartContainer = document.getElementById('cart-items');
        var totalPrice = 0;
        var parsedCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

        parsedCartItems.forEach(function(item) {
            totalPrice += parseFloat(item.price.substring(1)) * item.quantity;
        });

        cartContainer.innerHTML = '';

        parsedCartItems.forEach(function(item) {
            var cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.setAttribute('data-name', item.name);
            cartItem.innerHTML = `
            <div class="row">
    <div class="col-md-2">
        <img src="https://via.placeholder.com/100" alt="Product Image">
    </div>
    <div class="col-md-7 cart-item-details">
        <h3 class="cart-item-title">${item.name}</h3>
        <p class="cart-item-price">${item.price} x ${item.quantity}</p>
    </div>
    <div class="col-md-3 text-right">
        <hr> <!-- Line added here -->
        <button class="btn btn-sm btn-primary mr-2" onclick="decreaseQuantity('${item.name}')">-</button>
        <span class="cart-item-quantity">${item.quantity}</span> 
        <button class="btn btn-sm btn-primary ml-2" onclick="increaseQuantity('${item.name}')">+</button>
        <button class="btn btn-sm btn-danger ml-2" onclick="removeItem('${item.name}')">Remove</button>
    </div>
</div>

            `;
            cartContainer.appendChild(cartItem);
        });

        document.getElementById('total-amount').textContent = '₱' + totalPrice.toFixed(2);
    }

    function increaseQuantity(name) {
        var parsedCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        parsedCartItems.forEach(function(item) {
            if (item.name === name) {
                item.quantity += 1;
            }
        });
        localStorage.setItem('cartItems', JSON.stringify(parsedCartItems));
        renderCart();
    }

    function decreaseQuantity(name) {
        var parsedCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        parsedCartItems.forEach(function(item) {
            if (item.name === name && item.quantity > 1) {
                item.quantity -= 1;
            }
        });
        localStorage.setItem('cartItems', JSON.stringify(parsedCartItems));
        renderCart();
    }

    function removeItem(name) {
        var parsedCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        parsedCartItems = parsedCartItems.filter(function(item) {
            return item.name !== name;
        });
        localStorage.setItem('cartItems', JSON.stringify(parsedCartItems));
        renderCart();
    }

    renderCart();
</script>

