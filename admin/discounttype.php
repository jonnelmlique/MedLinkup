<?php
include '../src/config/config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $required_fields = ['discounttype', 'percentage'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field])) {
                throw new Exception("Required field '$field' is missing.");
            }
        }

        $discounttype = htmlspecialchars($_POST["discounttype"]);
        $percentage = floatval($_POST["percentage"]);

        $check_stmt = $conn->prepare("SELECT discountid FROM discounts WHERE discounttype = ?");
        if (!$check_stmt) {
            throw new Exception("Error in preparing statement: " . $conn->error);
        }
        $check_stmt->bind_param("s", $discounttype);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            throw new Exception("Discount type '$discounttype' already exists.");
        }
        $check_stmt->close();

        $insert_stmt = $conn->prepare("INSERT INTO discounts (discounttype, discountpercentage) VALUES (?, ?)");
        if (!$insert_stmt) {
            throw new Exception("Error in preparing statement: " . $conn->error);
        }
        $insert_stmt->bind_param("sd", $discounttype, $percentage);
        if (!$insert_stmt->execute()) {
            throw new Exception("Error in executing statement: " . $insert_stmt->error);
        }

        $message = "success";

        $insert_stmt->close();
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
    <title>Add Disocunt</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/discounttype.css">
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
                    <li class="active"><a href="../admin/discounttype.php">Add Discount</a></li>
                    <li><a href="../admin/discountverify.php">Verification</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text">Shipping Settings</span>
                </a>
                <ul class="submenu">
                    <li class="active"><a href="../admin/location.php">Location</a></li>
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
                    <h1>Add Discount</h1>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="add-location-section">

                            <div id="form-container">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="country">Discount Type</label>
                                        <input type="text" class="form-control" id="discounttype" name="discounttype"
                                            placeholder="Discount Type" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="region">Percentage</label>
                                        <input type="number" class="form-control" id="percentage" name="percentage"
                                            placeholder="percentage" required>
                                    </div>

                                    <button type="submit" class="btn btn-submit">Add</button>
                                </form>
                            </div>

                            <?php

                            $message = "";

                            try {

                                if ($conn->connect_error) {
                                    throw new Exception("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT discounttype, discountpercentage FROM discounts";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo '<table class="table">';
                                    echo '<thead><tr><th>Type</th><th>Percent</th></tr></thead>';
                                    echo '<tbody>';

                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row['discounttype'] . '</td>';
                                        echo '<td>' . $row['discountpercentage'] . '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody></table>';
                                } else {
                                    echo "No shipping fees found";
                                }

                                $conn->close();
                            } catch (Exception $e) {
                                $message = $e->getMessage();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src=zznode_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
                Swal.fire({
                    title: 'Discount Added Successfully!',
                    text: 'You have successfully added the discount.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../admin/discounttype.php';
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