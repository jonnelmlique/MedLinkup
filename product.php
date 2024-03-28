<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="./public/css/index/nav.css">
    <link rel="stylesheet" href="./public/css/index/product.css">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="./index.php">
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
                    <a href="./cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
        </nav>

    <div class="container product-details">
        <div class="row">
            <div class="col-md-6 product-details-img">
                <img src="https://via.placeholder.com/400x300" alt="Product Image">
            </div>
            <div class="col-md-6">
                <h2 class="product-details-title">Example Product</h2>
                <p class="product-details-price">₱19.99</p>
                <p class="product-details-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut
                    risus eget est facilisis laoreet. Quisque bibendum justo nec arcu dictum, eget posuere velit cursus.
                    Nulla fermentum sem et lacus placerat, nec fermentum arcu faucibus. Nam consequat sodales leo, at
                    tempor lectus faucibus ac.</p>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" class="form-control form-control-sm" id="quantity" value="1" min="1"
                        style="width: 100px;">
                </div>
                <button class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                <button class="btn btn-success">Buy Now</button>
            </div>
        </div>

    </div>

    <div class="product-section">
        <div class="container">
            <h3 class="mb-4">Featured Products</h3>
                <div class="row">
                    <!-- Example Product Card -->
                    <div class="col-md-15">
                        <div class="product-card">
                            <a class="product-card-link" href="product.php">
                                <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                                <div class="product-card-body">
                                    <h3 class="product-card-title">Example Product 1</h3>
                                    <p class="product-card-price">₱19.99</p>
                                    <!--<button class="btn btn-primary">Add to Cart</button>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Example Product Card -->
                    <div class="col-md-15">
                        <div class="product-card">
                            <a class="product-card-link" href="product.php">
                                <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                                <div class="product-card-body">
                                    <h3 class="product-card-title">Example Product 2</h3>
                                    <p class="product-card-price">₱29.99</p>
                                    <!--     <button class="btn btn-primary">Add to Cart</button>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Example Product Card -->
                    <div class="col-md-15">
                        <div class="product-card">
                            <a class="product-card-link" href="product.php">
                                <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                                <div class="product-card-body">
                                    <h3 class="product-card-title">Example Product 3</h3>
                                    <p class="product-card-price">₱39.99</p>
                                    <!--     <button class="btn btn-primary">Add to Cart</button>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Example Product Card -->
                    <div class="col-md-15">
                        <div class="product-card">
                            <a class="product-card-link" href="product.php">
                                <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                                <div class="product-card-body">
                                    <h3 class="product-card-title">Example Product 3</h3>
                                    <p class="product-card-price">₱39.99</p>
                                    <!--     <button class="btn btn-primary">Add to Cart</button>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Example Product Card -->
                    <div class="col-md-15">
                        <div class="product-card">
                            <a class="product-card-link" href="product.php">
                                <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                                <div class="product-card-body">
                                    <h3 class="product-card-title">Example Product 3</h3>
                                    <p class="product-card-price">₱39.99</p>
                                    <!--     <button class="btn btn-primary">Add to Cart</button>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Example Product Card -->
                    <div class="col-md-15">
                        <div class="product-card">
                            <a class="product-card-link" href="product.php">
                                <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                                <div class="product-card-body">
                                    <h3 class="product-card-title">Example Product 3</h3>
                                    <p class="product-card-price">₱39.99</p>
                                    <!--     <button class="btn btn-primary">Add to Cart</button>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Example Product Card -->
                    <div class="col-md-15">
                        <div class="product-card">
                            <a class="product-card-link" href="product.php">
                                <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                                <div class="product-card-body">
                                    <h3 class="product-card-title">Example Product 3</h3>
                                    <p class="product-card-price">₱39.99</p>
                                    <!--     <button class="btn btn-primary">Add to Cart</button>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Example Product Card -->
                    <div class="col-md-15">
                        <a class="product-card-link" href="product.php">
                            <div class="product-card">
                                <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                                <div class="product-card-body">
                                    <h3 class="product-card-title">Example Product 3</h3>
                                    <p class="product-card-price">₱39.99</p>
                                    <!--     <button class="btn btn-primary">Add to Cart</button>-->
                                </div>
                        </a>
                    </div>
                </div>
                <!-- Example Product Card -->
                <div class="col-md-15">
                    <div class="product-card">
                        <a class="product-card-link" href="product.php">
                            <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                            <div class="product-card-body">
                                <h3 class="product-card-title">Example Product 3</h3>
                                <p class="product-card-price">₱39.99</p>
                                <!--     <button class="btn btn-primary">Add to Cart</button>-->
                            </div>
                        </a>
                    </div>
                </div>
                <!-- Example Product Card -->
                <div class="col-md-15">
                    <div class="product-card">
                        <a class="product-card-link" href="product.php">
                            <img src="https://via.placeholder.com/200x200" alt="Product Image" />
                            <div class="product-card-body">
                                <h3 class="product-card-title">Example Product 3</h3>
                                <p class="product-card-price">₱39.99</p>
                                <!--     <button class="btn btn-primary">Add to Cart</button>-->
                            </div>
                        </a>
                    </div>
                </div>
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

    <script src="./public/js/index/productcart.js"></script>

    <script>
        function addToCart() {
            var productName = document.querySelector('.product-details-title').textContent;
            var productPrice = document.querySelector('.product-details-price').textContent;
            var quantity = parseInt(document.getElementById('quantity').value);
    
            var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    
            var existingItem = cartItems.find(function(item) {
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
    </script>
    
    

</body>

</html>