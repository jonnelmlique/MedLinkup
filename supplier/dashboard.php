<?php
include '../src/config/config.php';

try {
    $sql_pending_orders = "SELECT COUNT(DISTINCT transactionid) AS pending_orders_count FROM adminorderprocess WHERE status IN ('Pending', 'Processing')";
    $result_pending_orders = $conn->query($sql_pending_orders);
    $row_pending_orders = $result_pending_orders->fetch_assoc();
    $pending_orders_count = $row_pending_orders['pending_orders_count'] ?? 0;

    $sql_products_count = "SELECT COUNT(*) AS products_count FROM products WHERE supplierprice IS NOT NULL AND supplierstock IS NOT NULL";
    $result_products_count = $conn->query($sql_products_count);
    $row_products_count = $result_products_count->fetch_assoc();
    $products_count = $row_products_count['products_count'] ?? 0;

    $sql_total_sale = "SELECT IFNULL(SUM(totalprice), 0) AS total_sale FROM (SELECT DISTINCT transactionid, totalprice FROM adminorderprocess WHERE status = 'Completed') AS completed_orders";
    $result_total_sale = $conn->query($sql_total_sale);
    $row_total_sale = $result_total_sale->fetch_assoc();
    $total_sale = $row_total_sale['total_sale'] ?? 0;
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
    <link rel="stylesheet" href="../public/css/supplier/sidebar.css">
    <link rel="stylesheet" href="../public/css/supplier/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>

    <section id="sidebar">
        <a href="../supplier/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="MedLinkup Logo" class="logo">
            <span class="text"> MedLinkup</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
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
        <div class="head-title">
            <div class="left">
                <h1>Dashboard</h1>
            </div>
        </div>

        <ul class="box-info">
            <li>
                <a href="../admin/order.php">
                    <i class='fas fa-cart-plus'></i>
                    <span class="text">
                        <h3><?php echo $pending_orders_count; ?></h3>
                        <p>New Order</p>
                    </span>
                </a>
            </li>
            <li>
                <a href='../admin/products.php'>
                    <i class='fas fa-capsules'></i>
                    <span class='text'>
                        <h3>
                            <h3><?php echo $products_count; ?></h3>
                            <p>Products</p>
                    </span>
                </a>
            </li>
            <li>
                <a href="../admin/sales.php">
                    <i class='fas fa-chart-bar'></i>
                    <span class="text">
                        <h3>&#8369;<?php echo number_format($total_sale, 2); ?></h3>
                        <p>Total Sales</p>
                    </span>
                </a>
                </a>
            </li>
        </ul>

        <?php
        try {
            $sql_orders = "SELECT op.*, p.productname, u.username
    FROM adminorderprocess op
    JOIN products p ON op.productid = p.productid
    JOIN users u ON op.userid = u.userid
    WHERE op.status IN ('Pending', 'Processing') 
    GROUP BY op.transactionid 
    ORDER BY op.orderdate DESC
    LIMIT 5";
            $result_orders = $conn->query($sql_orders);
            $num_orders = $result_orders->num_rows;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Orders</h3>
                </div>
                <?php if ($num_orders > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Ordered By</th>
                                <th>Product</th>
                                <th>Date Order</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_orders->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <p><?php echo $row['username']; ?></p>
                                    </td>
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

    <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>