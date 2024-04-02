<?php
include '../src/config/config.php';
session_start();

$category_data = [];

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    try {
        $sql = "SELECT * FROM categories WHERE categoryid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $category_data = $result->fetch_assoc();
            $_SESSION['category_id'] = $category_id;

        } else {
            
            header("Location: categories.php");
            exit;            
        }

        $stmt->close();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: categories.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        if (isset($_POST["categoryid"]) && isset($_FILES["image"])) {

            $category_id = $_POST["categoryid"];
            $sql = "SELECT * FROM categories WHERE categoryid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $category_data = $result->fetch_assoc();

                $categoryname = isset($_POST["categoryname"]) ? $_POST["categoryname"] : $category_data['categoryname'];
                if ($categoryname != $category_data['categoryname']) {
                    $category_data['categoryname'] = $categoryname;
                    $category_name_changed = true;
                } else {
                    $category_name_changed = false;
                }

                $targetDir = "../uploads/";
                $targetFilePath = $targetDir . basename($_FILES["image"]["name"]);
                $image_changed = ($_FILES["image"]["name"] != '') ? true : false;

                if ($category_name_changed || $image_changed) {

                    if ($image_changed) {
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
                        if (!in_array($fileType, $allowedTypes)) {
                            throw new Exception("Sorry, only JPG, JPEG, PNG, GIF files are allowed.");
                        }
                        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                            throw new Exception("Sorry, there was an error uploading your file.");
                        }
                    } else {
                        $targetFilePath = $category_data['imagepath'];
                    }

                    $sql = "UPDATE categories SET categoryname = ?, imagepath = ? WHERE categoryid = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssi", $categoryname, $targetFilePath, $category_id);
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
                echo "Category not found.";
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
    <title>Edit Categories</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/addcategories.css">
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
                <a href="#">
                    <i class='fas fa-shopping-bag'></i>
                    <span class="text"> Orders</span>
                </a>
                <ul class="submenu">
                    <li><a href="../admin/pending.php">Pending</a></li>
                    <li><a href="../admin/completed.php">Completed</a></li>
                </ul>
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
                    <span class="text"> Supplier</span>
                </a>
                <ul class="submenu">
                    <li><a href="../public/Shared/Layout/error.php">Order</a></li>
                    <li><a href="../public/Shared/Layout/error.php">Pending Order</a></li>
                    <li><a href="../public/Shared/Layout/error.php">Completed Order</a></li>
                    <li><a href="../public/Shared/Layout/error.php">Add Supplier</a></li>
                </ul>
            </li>

            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='fa fa-cogs'></i>
                        <span class="text"> Settings</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../admin/location.php">Location</a></li>
                        <li><a href="../admin/shippingfee.php">Shipping Fee</a></li>

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
                    <h1 class="lefth">Edit Category</h1>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="add-category-section">
                            <div class="image-container">
                                <div class="preview-image" id="preview-image">
                                    <img src="<?php echo $category_data['imagepath'] ?? ''; ?>" alt="Category Image">
                                </div>
                                <form
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $category_data['categoryid']; ?>"
                                    method="POST" enctype="multipart/form-data" class="needs-validation">
                                    <input type="hidden" name="categoryid"
                                        value="<?php echo $category_data['categoryid'] ?? ''; ?>">
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                        onchange="previewImage(event)">
                                    <div id="form-container">
                                        <div class="mb-3">
                                            <label for="categoryname">Category Name</label>
                                            <input type="text" class="form-control" id="categoryname"
                                                name="categoryname" placeholder="Category Name"
                                                value="<?php echo $category_data['categoryname'] ?? ''; ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-submit">Update</button>

                                        <a href="./categories.php" class="cancel-btn" 
                                        style="display: inline-block; padding: 13px 16px; 
                                        background-color: #f44336; color: #fff; text-decoration: 
                                        none; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='#d32f2f';"
                                         onmouseout="this.style.backgroundColor='#f44336';">Cancel</a>

                                    </div>
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
                title: 'Category Edited Successfully!',
                text: 'You have successfully edidted the category.',
                icon: 'success',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../admin/categories.php';
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