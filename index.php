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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/index/home.css">
    <link rel="stylesheet" href="./public/css/index/nav.css">
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
                    <a href="<?php echo $loginLinkURL; ?>" class="nav-link"><?php echo $loginLinkText; ?></a>
                    <a href="./cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>

    <a href="./shop.php" class="hero-section">
        <div class="container">
            <span class="btn btn-success btn-lg" style="font-size: 24px; margin-top: 200px;">Shop Now</span>
        </div>
    </a>

    <section class="category-section">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-6">
                    <h3 class="mb-0">Featured Categories</h3>
                </div>
            </div>
            <div id="categoryCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $query = "SELECT * FROM categories";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $count = 0;
                        $first = true;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $categoryName = $row['categoryname'];
                            $imagePath = $row['imagepath'];

                            if ($count % 6 == 0) {
                                if (!$first) {
                                    echo '</div></div>';
                                }
                                echo '<div class="carousel-item' . ($first ? ' active' : '') . '"><div class="row">';
                                $first = false;
                            }
                            echo '<div class="col-sm-2">
                        <a href="./shop-categories.php?category=' . urlencode($categoryName) . '" class="text-decoration-none text-inherit">
                            <div class="card card-product mb-lg-4">
                                <div class="card-body text-center py-4">
                                    <img src="./productimg/' . $imagePath . '" alt="' . $categoryName . '" class="mb-2 img-fluid" />
                                    <div class="text-truncate">' . $categoryName . '</div>
                                </div>
                            </div>
                        </a>
                    </div>';

                            $count++;
                        }
                        echo '</div></div>';
                    } else {
                        echo "No categories found";
                    }
                    ?>
                </div>
                <!-- <a class="carousel-control-prev" href="#categoryCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#categoryCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a> -->
            </div>
        </div>
    </section>


    <div class="product-section">
        <div class="container">
            <h3 class="mb-4">Recent Products <a href="./shop.php" class="btn btn-primary">View All Products</a></h3>


            <div class="row">
                <?php
                try {
                    $sql = "SELECT productid, productname, price, image FROM products LIMIT 10";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            $productName = strlen($row["productname"]) > 35 ? substr($row["productname"], 0, 35) . '...' : $row["productname"];
                            ?>
                <div class="col-md-15">
                    <a href="./product.php?id=<?php echo $row["productid"]; ?>" class="product-card-link">

                        <div class="product-card">
                            <img src="./productimg/<?php echo $row["image"]; ?>" alt="Product Image" />
                            <div class="product-card-body">
                                <h3 class="product-card-title"><?php echo $productName; ?></h3>
                                <p class="product-card-price">₱<?php echo $row["price"]; ?></p>
                            </div>
                    </a>
                </div>
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var heroSection = document.querySelector(".hero-section");
        var imageUrl = "hero.jpg";

        heroSection.style.backgroundImage = "url('" + imageUrl + "')";
    });
    </script>
</body>

</html>