<?php
include '../src/config/config.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order - To Received</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/customer/toreceived.css">
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
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text"> Supplier</span>
                </a>
                <ul class="submenu">
                    <li><a href="../supplier/suppliershop.php">Order</a></li>
                    <li class="active"><a href="../admin/orderstatus.php">Order Status</a></li>
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

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="pending-section">
                        <h1 class="lefth">Order - To Ship</h1>
                        <hr>
                        <div class="buttonabc">
                            <a class="buttona" href="../admin/orderstatus.php">To Ship</a>
                            <a class="buttonb" href="../admin/toreceived.php">To Received</a>
                            <a class="buttonc" href="../admin/completedorder.php">Completed</a>
                        </div>

                        <?php


                        $userid = $_SESSION['userid'];
                        $query = "SELECT 
            o.transactionid,
            MIN(o.orderid) AS orderid,
            u.username, 
            p.productname, 
            p.price, 
            p.image,
            o.quantity, 
            o.totalprice, 
            MIN(o.orderdate) AS orderdate, 
            o.status, 
            o.paymentmethod,
            CONCAT(s.addressline1, ', ', s.addressline2, ', ', s.city, ', ', s.province, ', ', s.country) AS address 
        FROM 
            adminorderprocess o
        JOIN 
            users u ON o.userid = u.userid
        JOIN 
            products p ON o.productid = p.productid
        JOIN 
            shippingaddresses s ON o.addressid = s.addressid
        WHERE 
            o.userid = $userid
        GROUP BY 
            o.transactionid
        ORDER BY 
            orderdate DESC";

                        $result = mysqli_query($conn, $query);

                        $ordersToReceiveExist = false;
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['status'] == 'Shipped') {
                                $ordersToReceiveExist = true;
                                ?>
                                <a href="supplierorderdetails.php?transactionid=<?php echo $row['transactionid']; ?>"
                                    style="text-decoration: none; color: inherit;">
                                    <div class="product-box">
                                        <div class="product-details">
                                            <img src="../productimg/<?php echo $row['image']; ?>"
                                                alt="<?php echo $row['productname']; ?>" class="product-image">
                                            <div class="product-info">
                                                <div class="product-name"><?php echo $row['productname']; ?></div>
                                                <div class="product-status"><span
                                                        class="status <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span>
                                                </div>
                                                <div class="product-price price">₱<?php echo $row['totalprice']; ?></div>
                                            </div>
                                        </div>
                                        <a class="orderreceived" href="#"
                                            data-transactionid="<?php echo $row['transactionid']; ?>">Order Received</a>
                                    </div>
                                </a>
                                <?php
                            }
                        }

                        if (!$ordersToReceiveExist) {
                            ?>
                            <p class="toceived">No orders are currently ready to be received.</p>
                            <?php
                        }
                        ?>
                        <p class="margin"></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../node_modules/bootstrap/js/src/sidebar.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $(".orderreceived").click(function (e) {
                e.preventDefault();
                var transactionid = $(this).data("transactionid");
                $.ajax({
                    url: "order_received.php",
                    method: "POST",
                    data: {
                        transactionid: transactionid
                    },
                    success: function (response) {
                        console.log(response);

                        Swal.fire({
                            icon: 'success',
                            title: 'Order status updated',
                            text: 'The order status has been successfully updated to Completed.',
                            confirmButtonText: 'OK'
                        }).then(function () {
                            location.reload();
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error updating the order status. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>



</body>

</html>