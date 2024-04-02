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
                <img src="./public/img/logo.png" alt="MedLinkup Logo" class="logo"> MedLinkup
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

        <?php
include './src/config/config.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = $_GET['id'];
    try {
        $sql = "SELECT productname, price, productdetails, image, stock FROM products WHERE productid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <div class="container product-details">
                <div class="row">
                    <div class="col-md-6 product-details-img">
                        <img src="./productimg/<?php echo $row["image"]; ?>" alt="Product Image">
                    </div>
                    <div class="col-md-6">
                        <h2 class="product-details-title"><?php echo $row["productname"]; ?></h2>
                        <p class="product-details-price">₱<?php echo $row["price"]; ?></p>
                        <p class="product-details-description"><?php echo $row["productdetails"]; ?></p>
                        <p class="product-stock">Available Stock: <?php echo $row["stock"]; ?></p>

                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" class="form-control form-control-sm" id="quantity" value="1" min="1" style="width: 100px;">
                        </div>
                        <button class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                        <!-- <button class="btn btn-success">Buy Now</button> -->
                        <div id="paypal-button"></div>

                    </div>
                </div>
            </div>
            <?php
        } else {
            echo "Product not found.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    $stmt->close();
} else {
    echo "Invalid product ID.";
}

$conn->close();
?>


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
                &copy; 2024 MedLinkup. All rights reserved. |
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
    <script src="https://www.paypal.com/sdk/js?client-id=Ac6-DA_lDGiu6FsHZRddA0716cAvXTq2FIRXyy9x_OGpL4_h_ACJOpMXgBCnL0XXJ89jNDAtG9Dr7PEH&currency=PHP" data-sdk-integration-source="button-factory"></script>

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
    
    
    <script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $row["price"]; ?>'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Transaction completed by ' + details.payer.name.given_name + '!');
            });
        }
    }).render('#paypal-button');
</script>

</body>

</html>