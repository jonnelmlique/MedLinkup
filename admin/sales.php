<?php
include '../src/config/config.php';

try {
    // Daily Sales
    $sql_daily_sales = "SELECT IFNULL(SUM(totalprice), 0) AS daily_sales 
    FROM (SELECT DISTINCT transactionid, totalprice 
          FROM orderprocess 
          WHERE DATE(ordercompleted) = CURDATE() AND status = 'Completed') AS daily_orders";
    $result_daily_sales = $conn->query($sql_daily_sales);
    $row_daily_sales = $result_daily_sales->fetch_assoc();
    $daily_sales = $row_daily_sales['daily_sales'];

    // Monthly Sales
    $sql_monthly_sales = "SELECT IFNULL(SUM(totalprice), 0) AS monthly_sales 
                          FROM (SELECT DISTINCT transactionid, totalprice 
                                FROM orderprocess 
                                WHERE YEAR(orderdate) = YEAR(CURDATE()) AND MONTH(orderdate) = MONTH(CURDATE()) AND status = 'Completed') AS monthly_orders";
    $result_monthly_sales = $conn->query($sql_monthly_sales);
    $row_monthly_sales = $result_monthly_sales->fetch_assoc();
    $monthly_sales = $row_monthly_sales['monthly_sales'];

    // Total Sales
    $sql_total_sales = "SELECT IFNULL(SUM(totalprice), 0) AS total_sales 
                        FROM (SELECT DISTINCT transactionid, totalprice 
                              FROM orderprocess 
                              WHERE status = 'Completed') AS total_orders";
    $result_total_sales = $conn->query($sql_total_sales);
    $row_total_sales = $result_total_sales->fetch_assoc();
    $total_sales = $row_total_sales['total_sales'];
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/sales.css">
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
            <li class="active">
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
                <h1>Sales</h1>
            </div>
        </div>

        <ul class="box-info">
            <li>
                <a href="#">
                    <i class='fas fa-chart-line'></i>
                    <span class="text">
                        <h3>&#8369;<?php echo number_format($daily_sales, 2); ?></h3>
                        <p>Daily Sales</p>
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-chart-area'></i>
                    <span class="text">
                        <h3>&#8369;<?php echo number_format($monthly_sales, 2); ?></h3>
                        <p>Monthly Sales</p>
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-chart-bar'></i>
                    <span class="text">
                        <h3>&#8369;<?php echo number_format($total_sales, 2); ?></h3>
                        <p>Total Sales</p>
                    </span>
                </a>
            </li>
        </ul>
        <?php
        try {
            $sql_orders = "SELECT op.*, p.productname, u.username, op.totalprice
    FROM orderprocess op
    JOIN products p ON op.productid = p.productid
    JOIN users u ON op.userid = u.userid
    WHERE op.status IN ('Completed') 
    GROUP BY op.transactionid 
    ORDER BY op.ordercompleted DESC
    LIMIT 5";
            $result_orders = $conn->query($sql_orders);
            $num_orders = $result_orders->num_rows;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
        <div class="table-data">
            <div class="sales">
                <div class="head">
                    <h3>Sales History</h3>
                </div>
                <?php if ($num_orders > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Ordered By</th>
                            <th>Product</th>
                            <th>Total</th>
                            <th>Date Completed</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_orders->fetch_assoc()): ?>
                        <tr onclick="window.location='orderdetails.php?transactionid=<?php echo $row['transactionid']; ?>';"
                            style="cursor: pointer;">
                            <td>
                                <p><?php echo $row['username']; ?></p>
                            </td>
                            <td>
                                <p><?php echo $row['productname']; ?></p>
                            </td>
                            <td>
                                <p><?php echo number_format($row['totalprice'], 2, '.', ','); ?></p>
                            </td>

                            <td><?php echo date("d-m-Y", strtotime($row['ordercompleted'])); ?></td>
                            <td><span class="status completed"><?php echo $row['status']; ?></span></td>
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


    <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>