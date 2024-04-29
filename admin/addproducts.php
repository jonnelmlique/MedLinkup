<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/addproducts.css">
    <!-- <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>

    <section id="sidebar">
        <a href="../admin/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="MedLinkup Logo" class="logo">
            <span class="text"> MedLinkup</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="../admin/dashboard.php">
                    <i class='fas fa-clone'></i>
                    <span class="text"> Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-capsules'></i>
                    <span class="text">Inventory</span>
                </a>
                <ul class="submenu">
                    <li><a href="../admin/products.php">Products</a></li>
                    <li><a href="../admin/lowstock.php">Low Stock</a></li>
                    <li><a href="../admin/categories.php">Categories</a></li>

                </ul>
            </li>
            <li>
                <a href="../admin/order.php">
                    <i class='fas fa-shopping-bag'></i>
                    <span class="text"> Orders</span>
                </a>
            </li>
            <li>
                <a href="../admin/sales.php">
                    <i class='fas fa-chart-bar'></i>
                    <span class="text"> Sales</span>
                </a>
            </li>
            <li>
                <a href="../admin/customer.php">
                    <i class='fas fa-portrait'></i>
                    <span class="text"> Customers</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text">Shipping Settings</span>
                </a>
                <ul class="submenu">
                    <li><a href="../admin/location.php">Location</a></li>
                    <li><a href="../admin/shippingfee.php">Shipping Fee</a></li>
                </ul>
            </li>
            <li>
                <a href="supplier.php">
                    <i class='fas fa-clone'></i>
                    <span class="text"> Supplier</span>
                </a>
                <ul class="submenu">
                    <li><a href="../supplier/suppliershop.php">Order</a></li>
                    <li><a href="../admin/orderstatus.php">Order Status</a></li>
                    <li><a href="../admin/history.php">History</a></li>
                </ul>
            </li>
            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='fa fa-user-cog'></i>
                        <span class="text">System Maintenane</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../admin/about.php">About</a></li>
                        <li><a href="../admin/privacypolicy.php">Privacy Policy</a></li>
                        <li><a href="../admin/termsofservice.php">Terms of Service</a></li>
                        <li><a href="../admin/home.php">Home</a></li>
                        <li><a href="../admin/header.php">Header</a></li>
                        <li><a href="../admin/footer.php">Footer</a></li>
                    </ul>
                </li>
                <ul class="side-menu">
                    <li>
                        <a href="#">
                            <i class='fa fa-cogs'></i>
                            <span class="text"> Settings</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="../admin/delivery.php">Delivery Address</a></li>


                        </ul>
                    </li>
                    <li>
                        <a href="#" class="logout">
                            <i class='fas fa-user'></i>
                            <span class="text"> Logout</span>
                        </a>
                    </li>
                </ul>
    </section>

    <section id="content">
        <nav>
            <i class='fa-pills'></i>
            <a href="#" class="profile">
                <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg">
            </a>
        </nav>
    </section>


    <main>
        <div class="box-section">
            <div class="head-title">
                <div class="left">
                    <h1>Add Product</h1>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="add-product-section">
                            <div id="image-container">
                                <div id="preview-image">
                                    <img src="https://via.placeholder.com/350x350" alt="Preview Image">
                                </div>
                            </div>
                            <div id="form-container">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                        onchange="previewImage(event)" required>
                                    <div class="mb-3">
                                        <label for="categoryname">Product Name</label>

                                        <input type="text" class="form-control" id="productName" name="productName"
                                            placeholder="Product Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoryname">Price</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            placeholder="Price" min="0" step="0.01" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoryname">Product Details</label>
                                        <textarea class="form-control" id="details" name="details" rows="4"
                                            placeholder="Product Details" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoryname">Select Category</label>
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="" disabled selected>Select Category</option>
                                            <?php
                                            include '../src/config/config.php';

                                            $sql = "SELECT categoryname FROM categories";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['categoryname'] . "'>" . $row['categoryname'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoryname">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock"
                                            placeholder="Stock" required>
                                    </div>

                                    <button type="submit" class="btn btn-submit">Add Product</button>
                                    <a href="./products.php" class="cancel-btn" style="display: inline-block; padding: 13px 16px; 
                                        background-color: #f44336; color: #fff; text-decoration: 
                                        none; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='#d32f2f';"
                                        onmouseout="this.style.backgroundColor='#f44336';">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    try {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productName = $_POST['productName'];
            $price = $_POST['price'];
            $details = $_POST['details'];
            $category = $_POST['category'];
            $stock = $_POST['stock'];

            $targetDir = "../productimg/";
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowedTypes)) {

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {

                    $sql = "INSERT INTO products (productname, image, price, productdetails, productcategory, stock, supplierid) 
                    VALUES ('$productName', '$fileName', '$price', '$details', '$category', '$stock', '2')";
                    if ($conn->query($sql) === TRUE) {
                        $message = "success";
                    } else {
                        throw new Exception("Error executing SQL statement: " . $stmt->error);
                    }
                } else {
                    throw new Exception("Sorry, there was an error uploading your file.");
                }
            } else {
                throw new Exception("Sorry, only JPG, JPEG, PNG, GIF files are allowed.");
            }
        }
    } catch (Exception $e) {

        $message = $e->getMessage();

    }
    ?>
    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
            Swal.fire({
                title: 'Product Added Successfully!',
                text: 'You have successfully added the Product.',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'View Products'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Do something if user clicks OK
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = '../admin/products.php';
                }
            });
        </script>";
        } else {
            echo "<script>
            Swal.fire({
                title: 'Error',
                text: '" . $message . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
        }
    }
    ?>
    <script>
        function previewImage(event) {
            var preview = document.getElementById('preview-image');
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.style.display = 'block';
                preview.querySelector('img').src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

</body>

</html>