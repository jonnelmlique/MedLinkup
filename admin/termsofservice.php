<?php
include '../src/config/config.php';

$message = "";

$sql = "SELECT sectiontitle, sectioncontent FROM termsofservice WHERE tosid = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $terms_title = $row["sectiontitle"];
    $terms_content = $row["sectioncontent"];
} else {
    $terms_title = "";
    $terms_content = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (isset($_POST["termsname"])) {
            $terms_name = $_POST["termsname"];

            if ($_POST["termsname"] !== $terms_title || $_POST["editorcontent"] !== $terms_content) {

                $sql = "UPDATE termsofservice SET sectiontitle = ?, sectioncontent = ?";
                $params = array($terms_name, $_POST["editorcontent"]);

                $sql .= " WHERE tosid = 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $terms_name, $_POST["editorcontent"]);
                if ($stmt->execute()) {
                    $message = "success";
                } else {
                    throw new Exception("Error executing SQL statement: " . $stmt->error);
                }
                $stmt->close();
            } else {
                $message = "No changes made to the terms of service section.";
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
    <title>Terms of Service | System Maintenance</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/termsofservice.css">
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
                        <li class="active"><a href="../admin/termsofservice.php">Terms of Service</a></li>
                    </ul>
                </li>
                <ul class="side-menu">
                    <li>
                        <a href="#">
                            <i class='fa fa-cogs'></i>
                            <span class="text">Settings</span>
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
                    <h1 class="lefth">Terms of Service</h1>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="add-category-section">


                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                enctype="multipart/form-data" class="needs-validation">
                                <div id="form-container">
                                    <div class="input">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="termsname" name="termsname"
                                                placeholder="Terms of Service" value="<?php echo $terms_title; ?>"
                                                required>
                                        </div>
                                        <div class="editor-content">
                                            <textarea class="editor-textarea" id="editorcontent" name="editorcontent"
                                                placeholder="Start typing..."><?php echo $terms_content; ?></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-submit">Update</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
            Swal.fire({
                title: 'Terms of Service Updated Successfully!',
                text: 'You have successfully Updated the Terms of Service.',
                icon: 'success',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../admin/termsofservice.php';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
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


</body>

</html>