<?php

include '../src/config/config.php';

session_start();

if (!isset($_SESSION['userid'])) {

    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['usertype'] != 'admin') {

    if ($_SESSION['usertype'] == 'customer') {
        header("Location: ../customer/dashboard.php");
        exit();
    } elseif ($_SESSION['usertype'] == 'supplier') {
        header("Location: ../supplier/dashboard.php");
        exit();
    }
}

try {
    if ($_SESSION['usertype'] == 'admin') {
        $query = "SELECT firstname, lastname, username, email FROM users WHERE usertype = 'customer'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Query failed: " . mysqli_error($conn));
        }
        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer</title>
    <!-- <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/customer.css">
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
            <li class="active">
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
    <section id="content">
        <main>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Customers</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    try {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['email'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } catch (Exception $e) {
                                        echo "<tr><td colspan='3'>No customers found</td></tr>";
                                    }
                                    ?>
                        </tbody>
                    </table>


                </div>
            </div>
        </main>
    </section>
    <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <?php
    }
    mysqli_free_result($result);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
mysqli_close($conn);
?>
</body>

</html>