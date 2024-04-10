<?php
include '../src/config/config.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userid = $_SESSION['userid'];

try {
    $sql_pending_processing = "SELECT DISTINCT(transactionid) FROM orderprocess WHERE userid = ? AND status IN ('Pending', 'Processing', 'Shipped')";
    $stmt_pending_processing = $conn->prepare($sql_pending_processing);
    $stmt_pending_processing->bind_param("i", $userid);
    $stmt_pending_processing->execute();
    $result_pending_processing = $stmt_pending_processing->get_result();
    $num_orders_pending_processing = $result_pending_processing->num_rows;

    $sql_completed = "SELECT COUNT(DISTINCT(transactionid)) AS num_completed_orders FROM orderprocess WHERE userid = ? AND status = 'Completed'";
    $stmt_completed = $conn->prepare($sql_completed);
    $stmt_completed->bind_param("i", $userid);
    $stmt_completed->execute();
    $result_completed = $stmt_completed->get_result();
    $row_completed = $result_completed->fetch_assoc();
    $num_completed_orders = $row_completed['num_completed_orders'];

    $sql_total_spend = "SELECT IFNULL(SUM(totalprice), 0) AS total_spend FROM (SELECT DISTINCT(transactionid), totalprice FROM orderprocess WHERE userid = ? AND ((status = 'Completed' != 'PayPal') OR (status = 'Processing' AND paymentmethod = 'PayPal'))) AS total_orders";
    // $sql_total_spend = "SELECT IFNULL(SUM(totalprice), 0) AS total_spend FROM (SELECT DISTINCT(transactionid), totalprice FROM orderprocess WHERE userid = ? AND status = 'Completed') AS completed_orders";
    $stmt_total_spend = $conn->prepare($sql_total_spend);
    $stmt_total_spend->bind_param("i", $userid);
    $stmt_total_spend->execute();
    $result_total_spend = $stmt_total_spend->get_result();
    $row_total_spend = $result_total_spend->fetch_assoc();
    $total_spend = $row_total_spend['total_spend'];

    $num_orders_pending_processing = $num_orders_pending_processing ? $num_orders_pending_processing : 0;
    $num_completed_orders = $num_completed_orders ? $num_completed_orders : 0;
    $total_spend = $total_spend ? $total_spend : 0;
} catch (Exception $e) {

    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../public/css/customer/sidebar.css">
    <link rel="stylesheet" href="../public/css/customer/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <section id="sidebar">
        <a href="../customer/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="MedLinkup Logo" class="logo">
            <span class="text"> MedLinkup</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
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
            <li>
                <a href="../customer/order.php">
                    <i class="fas fa-cart-arrow-down"></i>
                    <span class="text">Order</span>
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
                <a href="../index.php">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="text"> Continue Shopping</span>
                </a>
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
        <div class="head-title">
            <div class="left">
                <h1>Dashboard</h1>
            </div>
        </div>

        <ul class="box-info">
            <li>
                <a href="../customer/order.php">
                    <i class='fas fa-cart-plus'></i>
                    <span class="text">
                        <h3><?php echo $num_orders_pending_processing; ?></h3>
                        <p>New Order</p>
                    </span>
                </a>
            </li>
            <li>
                <a href="../customer/history.php">
                    <i class='fas fa-capsules'></i>
                    <span class="text">
                        <h3><?php echo $num_completed_orders; ?></h3>
                        <p>Completed Order</p>
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-chart-bar'></i>
                    <span class="text">
                        <h3>&#8369;<?php echo number_format($total_spend, 2); ?></h3>
                        <p>Total Spend</p>
                    </span>
                </a>
            </li>
        </ul>

        <?php

        try {
            $sql_recent_orders = "SELECT op.*, p.productname
                          FROM orderprocess op
                          JOIN products p ON op.productid = p.productid
                          WHERE op.userid = ? 
                          AND op.status IN ('Pending', 'Processing') 
                          GROUP BY op.transactionid 
                          ORDER BY op.orderdate DESC
                          LIMIT 5";
            $stmt_recent_orders = $conn->prepare($sql_recent_orders);
            $stmt_recent_orders->bind_param("i", $userid);
            $stmt_recent_orders->execute();
            $result_recent_orders = $stmt_recent_orders->get_result();
            $num_recent_orders = $result_recent_orders->num_rows;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Recent Orders</h3>
                </div>
                <?php if ($num_recent_orders > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Date Order</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_recent_orders->fetch_assoc()): ?>
                        <tr onclick="window.location='orderdetails.php?transactionid=<?php echo $row['transactionid']; ?>';"
                            style="cursor: pointer;">
                            <td>
                                <p><?php echo $row['productname']; ?></p>
                            </td>
                            <td><?php echo date("d-m-Y", strtotime($row['orderdate'])); ?></td>
                            <td><span class="status"><?php echo $row['status']; ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
                <?php else: ?>
                <p>No recent orders</p>
                <?php endif; ?>
            </div>
        </div>



    </main>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>