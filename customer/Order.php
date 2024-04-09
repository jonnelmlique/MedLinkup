<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order</title>
    <link rel="stylesheet" href="../public/css/customer/sidebar.css">
    <link rel="stylesheet" href="../public/css/customer/pendingorder.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <section id="sidebar">
        <a href="../customer/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="MedLinkup Logo" class="logo">
            <span class="text"> MedLinkup</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="../customer/dashboard.php">
                    <i class='fas fa-clone'></i>
                    <span class="text"> Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-portrait'></i>
                    <span class="text"> Profile</span>
                </a>
                <ul class="submenu">
                    <li><a href="../customer/myprofile.php">My Profile</a></li>
                    <li><a href="../customer/delivery.php">Delivery Address</a></li>

                </ul>
            </li>

            <li>
                <a href="../cart.php">
                    <i class='fas fa-cart-plus'></i>
                    <span class="text"> Cart</span>
                </a>
            </li>
            <li class="active">
                <a href="../customer/order.php">
                    <i class='fas fa-cart-arrow-down'></i>
                    <span class="text">Order</spvan>
                </a>
            </li>
            <li>
                <a href="../customer/history.php">
                    <i class='fas fa-shopping-basket'></i>
                    <span class="text"> History</span>
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
                    <li><a href="../customer/changepassword.php">Change Password</a></li>
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
                            <a class="buttona" href="../customer/order.php">To Ship</a>
                            <a class="buttonb" href="../customer/toreceived.php">To Received</a>
                            <a class="buttonc" href="../customer/Completed.php">Completed</a>
                        </div>

                        <?php
include '../src/config/config.php';
session_start(); 

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

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
            orderprocess o
        JOIN 
            users u ON o.userid = u.userid
        JOIN 
            products p ON o.productid = p.productid
        JOIN 
            shippingaddresses s ON o.addressid = s.addressid
        WHERE 
            o.userid = $userid AND 
            o.status = 'Processing' OR o.status = 'Pending'
        GROUP BY 
            o.transactionid
        ORDER BY 
            orderdate DESC"; 

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    ?>
                        <?php
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
                        <a href="orderdetails.php?transactionid=<?php echo $row['transactionid']; ?>"
                            style="text-decoration: none; color: inherit;">
                            <div class="product-box">
                                <div class="product-details">
                                    <img src="../productimg/<?php echo $row['image']; ?>"
                                        alt="<?php echo $row['productname']; ?>" class="product-image">
                                    <div class="product-info">
                                        <div class="product-name"><?php echo $row['productname']; ?></div>
                                        <div class="product-status"><span
                                                class="s <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span>
                                        </div>
                                        <div class="product-price price">₱<?php echo $row['totalprice']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php
    }
} else {
    echo '<p class="orderdisplay">No orders</p>';
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

</body>

</html>