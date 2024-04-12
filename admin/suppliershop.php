<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shop</title>

    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/index/shop.css">
    <link rel="stylesheet" href="../public/css/index/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<?php
include '../src/config/config.php';

session_start();

$message = '';

$loginLinkText = '<i class="fas fa-user"></i> Login';
$loginLinkURL = '../auth/login.php';

if (isset($_SESSION['userid']) && isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
    $loginLinkText = '<i class="fas fa-user"></i> ' . $loggedInUsername;
    $loginLinkURL = './dashboard.php';
}

?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="./index.php">
                <img src="../public/img/logo.png" alt="MedLinkup Logo" class="logo"> MedLinkup
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">

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
    <div class="row">
        <div class="col-md-3">
            <div class="filter-section">
                <h4>Filters</h4>
                <?php
                $query = "SELECT * FROM categories";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input category-checkbox" type="checkbox" value="' . $row['categoryid'] . '" id="category' . $row['categoryid'] . '">';
                        echo '<label class="form-check-label" for="category' . $row['categoryid'] . '">';
                        echo $row['categoryname'];
                        echo '</label>';
                        echo '</div>';
                    }
                } else {
                    echo "No categories found.";
                }
                ?>


            </div>
        </div>

        <div class="product-section">
            <div class="container">

                <div class="search-bar">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search Products"
                        aria-label="Search Products" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondarys" type="button" id="button-addon2" disabled><i
                            class="fas fa-search"></i></button>
                </div>
                <h4 class="mb-4">Products</h4>

                <div id="productContainer" class="row">

                    <?php

                    try {
                        $sql = "SELECT productid, productname, supplierprice, image FROM products WHERE supplierstock IS NOT NULL AND supplierprice IS NOT NULL";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {
                                $productName = strlen($row["productname"]) > 35 ? substr($row["productname"], 0, 35) . '...' : $row["productname"];

                                ?>
                    <div class="col-md-15">
                        <a href="../product.php?id=<?php echo $row["productid"]; ?>" class="product-card-link">

                            <div class="product-card">
                                <img src="../productimg/<?php echo $row["image"]; ?>" alt="Product Image" />
                                <div class="product-card-body">
                                    <h3 class="product-card-title">
                                        <?php echo $productName; ?>
                                    </h3>

                                    <p class="product-card-price">₱
                                        <?php echo $row["supplierprice"]; ?>
                                    </p>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
    document.getElementById('searchInput').addEventListener('input', function() {
        var searchText = this.value.trim();

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                document.getElementById('productContainer').innerHTML = response;
            }
        };
        xhr.open('POST', 'shopsearch.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('search=' + searchText);
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function handleCategoryFilter() {
            var selectedCategories = document.querySelectorAll('.category-checkbox:checked');
            var categoryIds = Array.from(selectedCategories).map(function(checkbox) {
                return checkbox.value;
            }).join(',');

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('productContainer').innerHTML = xhr.responseText;
                }
            };
            xhr.open('POST', 'filter_products.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('categoryIds=' + categoryIds);
        }
        var categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        categoryCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', handleCategoryFilter);
        });
    });
    </script>
</body>

</html>