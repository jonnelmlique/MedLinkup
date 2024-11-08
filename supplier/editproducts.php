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
        if (isset($_POST["productid"])) {
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
                $supplier_price = isset($_POST["supplierprice"]) ? $_POST["supplierprice"] : $product_data['supplierprice'];
                $supplier_stock = isset($_POST["supplierstock"]) ? $_POST["supplierstock"] : $product_data['supplierstock'];
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
                    $product_name != $product_data['productname'] || $supplier_price != $product_data['supplierprice'] ||
                    $supplier_stock != $product_data['supplierstock'] 
                ) {
                    $sql = "UPDATE products SET productname = ?, supplierprice = ?, supplierstock = ?, image = ? WHERE productid = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sddsi", $product_name, $supplier_price, $supplier_stock, $fileName, $product_id);
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
                throw new Exception("Product not found.");
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
        <a href="../supplier/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="MedLinkup Logo" class="logo">
            <span class="text"> MedLinkup</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="../supplier/dashboard.php">
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
                    <li><a href="../supplier/products.php">Products</a></li>
                    <li><a href="../supplier/lowstock.php">Low Stock</a></li>
                    <li><a href="../supplier/unavailableproducts.php">Unavailable Products</a></li>
                </ul>
            </li>
            <li>
                <a href="./order.php">
                    <i class='fas fa-shopping-bag'></i>
                    <span class="text"> Orders</span>
                </a>

            </li>
            <li>
                <a href="sales.php">
                    <i class='fas fa-chart-bar'></i>
                    <span class="text"> Sales</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class='fa fa-cogs'></i>
                    <span class="text"> Settings</span>
                </a>
                <ul class="submenu">
                    <li><a href="../supplier/manageaccount.php">Manage Account</a></li>
                    <li><a href="../supplier/changepassword.php">Change Password</a></li>
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
                <img src="../public/img/logo.png">
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
                                <div id="form-container">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="productid"
                                            value="<?php echo $product_data['productid']; ?> ">


                                        <div class="mb-3">
                                            <label for="productName">Product Name</label>
                                            <input type="text" class="form-control" id="productName" name="productName"
                                                placeholder="Product Name"
                                                value="<?php echo htmlspecialchars($product_data['productname']); ?>"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price">Supplier Price</label>
                                            <input type="number" class="form-control" id="supplierprice"
                                                name="supplierprice" placeholder="Supplier Price" min="0" step="0.01"
                                                value="<?php echo htmlspecialchars($product_data['supplierprice']); ?>"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="stock">Supplier Stock</label>
                                            <input type="number" class="form-control" id="supplierstock"
                                                name="supplierstock" placeholder="Supplier Stock"
                                                value="<?php echo htmlspecialchars($product_data['supplierstock']); ?>"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="supplier">Supplier</label>
                                            <input type="text" class="form-control" id="supplier" name="supplier"
                                                placeholder="Supplier Email"
                                                value="<?php echo $product_data['supplier_email']; ?>" required
                                                disabled>
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
                    window.location.href = '../supplier/products.php';
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