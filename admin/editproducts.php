<?php
include '../src/config/config.php';
session_start();

$product_data = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $product_id = $_GET['id'];

    try {
        $sql = "SELECT * FROM products WHERE productid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $product_data = $result->fetch_assoc();

            $supplier_id = $product_data['supplierid'];
            $sql_supplier = "SELECT email FROM users WHERE userid = ?";
            $stmt_supplier = $conn->prepare($sql_supplier);
            $stmt_supplier->bind_param("i", $supplier_id);
            $stmt_supplier->execute();
            $result_supplier = $stmt_supplier->get_result();
            $supplier_data = $result_supplier->fetch_assoc();
            $product_data['supplier_email'] = $supplier_data['email'];

        } else {
            header("Location: products.php");
            exit;
        }

        $stmt->close();
    } catch (PDOException $e) {

        error_log("Error: " . $e->getMessage());
        header("Location: error.php");
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {


        if (isset($_POST["productid"]) && isset($_FILES["image"])) {

            $product_id = $_POST["productid"];
            $sql = "SELECT p.*, u.email as supplier_email FROM products p
                    JOIN users u ON p.supplierid = u.userid
                    WHERE p.productid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $product_data = $result->fetch_assoc();

                $product_name = isset($_POST["productName"]) ? $_POST["productName"] : $product_data['productname'];
                $price = isset($_POST["price"]) ? $_POST["price"] : $product_data['price'];
                $product_details = isset($_POST["details"]) ? $_POST["details"] : $product_data['productdetails'];
                $product_category = isset($_POST["category"]) ? $_POST["category"] : $product_data['productcategory'];
                $stock = isset($_POST["stock"]) ? $_POST["stock"] : $product_data['stock'];
                $supplier_email = $product_data['supplier_email'];

                if (!empty($_FILES["image"]["name"])) {
                    $targetDir = "../productimg/";
                    $fileName = basename($_FILES["image"]["name"]);
                    $targetFilePath = $targetDir . $fileName;
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                    $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');

                    if (in_array($fileType, $allowedTypes)) {

                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                            $image_changed = true;
                        } else {
                            throw new Exception("Sorry, there was an error uploading your file.");
                        }
                    } else {
                        throw new Exception("Sorry, only JPG, JPEG, PNG, GIF files are allowed.");
                    }
                } else {
                    $image_changed = false;
                    $fileName = $product_data['image'];
                }

                if (
                    $product_name != $product_data['productname'] || $price != $product_data['price'] ||
                    $product_details != $product_data['productdetails'] || $product_category != $product_data['productcategory'] ||
                    $stock != $product_data['stock'] || $image_changed
                ) {

                    $sql = "UPDATE products SET productname = ?, image = ?, price = ?, productdetails = ?, productcategory = ?, stock = ? WHERE productid = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssdssii", $product_name, $fileName, $price, $product_details, $product_category, $stock, $product_id);
                    if ($stmt->execute()) {
                        $message = "success";
                    } else {
                        throw new Exception("Error executing SQL statement: " . $stmt->error);
                    }
                    $stmt->close();
                } else {
                    $message = "No changes detected.";
                }
            } else {
                echo "Product not found.";
            }
        } else {
            throw new Exception("Please provide all required fields.");
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Product</title>
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
                <a href="../admin/contact.php">
                    <i class='fas fa-envelope'></i>
                    <span class="text"> Contact</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text">Discounts</span>
                </a>
                <ul class="submenu">
                    <li><a href="../admin/discounttype.php">Add Discount</a></li>
                    <li><a href="../admin/discountverify.php">Verification</a></li>
                </ul>
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
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text"> Supplier</span>
                </a>
                <ul class="submenu">
                    <li><a href="z">Order</a></li>
                    <li><a href="../public/Shared/Layout/error.php">Pending Order</a></li>
                    <li><a href="../public/Shared/Layout/error.php">Completed Order</a></li>
                    <li><a href="../public/Shared/Layout/error.php">Add Supplier</a></li>
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
                        <a href="../logout.php" class="logout">
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
                                    <img src="../productimg/<?php echo $product_data['image'] ?? ''; ?>"
                                        alt="Product Image">
                                </div>
                            </div>
                            <div id="form-container">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="productid"
                                        value="<?php echo $product_data['productid']; ?> ">


                                    <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                        onchange="previewImage(event)">
                                    <div class="mb-3">
                                        <label for="productName">Product Name</label>
                                        <input type="text" class="form-control" id="productName" name="productName"
                                            placeholder="Product Name"
                                            value="<?php echo htmlspecialchars($product_data['productname']); ?>"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            placeholder="Price" min="0" step="0.01"
                                            value="<?php echo htmlspecialchars($product_data['price']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="details">Product Details</label>
                                        <textarea class="form-control" id="details" name="details" rows="4"
                                            placeholder="Product Details"
                                            required><?php echo htmlspecialchars($product_data['productdetails']); ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category">Select Category</label>
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="" disabled>Select Category</option>
                                            <?php
                                            $sql = "SELECT categoryname FROM categories";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = ($row['categoryname'] == $product_data['productcategory']) ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($row['categoryname']) . "' $selected>" . htmlspecialchars($row['categoryname']) . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">

                                        <label for="supplier">Supplier</label>
                                        <input type="text" class="form-control" id="supplier" name="supplier"
                                            placeholder="Supplier Email"
                                            value="<?php echo htmlspecialchars($product_data['supplier_email']); ?>"
                                            required disabled>

                                    </div>


                                    <div class="mb-3">
                                        <label for="stock">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock"
                                            placeholder="Stock"
                                            value="<?php echo htmlspecialchars($product_data['stock']); ?>" required>
                                    </div>

                                    <button type="submit" class="btn btn-submit">Update Product</button>
                                    <a href="./products.php" class="cancel-btn"
                                        style="display: inline-block; padding: 13px 16px; background-color: #f44336; color: #fff; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;"
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
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
            Swal.fire({
                title: 'Product Edited Successfully!',
                text: 'You have successfully edidted the product.',
                icon: 'success',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
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

        reader.onloadend = function() {
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