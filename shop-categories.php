<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shop</title>

    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/index/shopcategories.css">
    <link rel="stylesheet" href="./public/css/index/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>
<?php
include './src/config/config.php';

session_start();

$message = '';

$loginLinkText = '<i class="fas fa-user"></i> Login';
$loginLinkURL = './auth/login.php';

if (isset($_SESSION['userid']) && isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
    $loginLinkText = '<i class="fas fa-user"></i> ' . $loggedInUsername;
    $loginLinkURL = './customer/dashboard.php';
}


?>

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
                    <a href="<?php echo $loginLinkURL; ?>" class="nav-link">
                        <?php echo $loginLinkText; ?>
                    </a>
                    <a href="./cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="product-section">
        <div class="container">
            <h3 class="mb-4"> Products <a href="./shop.php" class="btn btn-success">View All Products</a></h3>
            <div id="productContainer" class="row">
                <?php
                try {
                    if (isset($_GET['category'])) {
                        $category = $_GET['category'];
                        $sql = "SELECT productid, productname, price, image FROM products WHERE productcategory = '$category'";
                    } else {
                        $sql = "SELECT productid, productname, price, image FROM products";
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $productName = strlen($row["productname"]) > 35 ? substr($row["productname"], 0, 35) . '...' : $row["productname"];
                            ?>
                <div class="col-md-15">
                    <a href="./product.php?id=<?php echo $row["productid"]; ?>" class="product-card-link"
                        style="text-decoration: none;">
                        <div class="product-card">
                            <img src="./productimg/<?php echo $row["image"]; ?>" alt="Product Image" />
                            <div class="product-card-body">
                                <h3 class="product-card-title"><?php echo $productName; ?></h3>
                                <p class="product-card-price">₱<?php echo $row["price"]; ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                        }
                    } else {
                        echo "No products available.";
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
    </div>
    <section class="design-element">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Our Mission</h3>
                    <p>Empowering health through easy access to medications. Your trusted online platform for quality
                        pharmaceuticals.</p>
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
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>