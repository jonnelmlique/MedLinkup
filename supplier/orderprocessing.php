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
    <title>Order - Processing</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/orderprocessing.css">
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
            <li class="active">
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

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="pending-section">
                        <h1 class="lefth">Order - Processing</h1>
                        <hr>
                        <div class="buttonabc">
                            <a class="buttona" href="../supplier/order.php">Pending</a>
                            <a class="buttonb" href="../supplier/orderprocessing.php">Processing</a>
                            <a class="buttonc" href="../supplier/ordershipped.php">Shipped</a>
                            <a class="buttond" href="../supplier/ordercompleted.php">Completed</a>
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
            CONCAT(s.firstname, ' ', s.lastname) AS flname,
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
            o.status = 'Processing' 
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
                                        <p><strong>Order by:</strong> <?php echo $row['flname']; ?></p>
                                        <div class="product-status"><span
                                                class="s <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span>
                                        </div>
                                        <div class="product-price price">₱<?php echo $row['totalprice']; ?></div>
                                    </div>
                                </div>
                                <a class="orderapprove" href="#"
                                    data-transactionid="<?php echo $row['transactionid']; ?>">Mark as Shipped</a>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        $('.orderapprove').click(function(e) {
            e.preventDefault();
            var transactionid = $(this).data('transactionid');

            $.ajax({
                url: 'updates_order_status_shipped.php',
                method: 'POST',
                data: {
                    transactionid: transactionid,
                    status: 'Shipped'
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Shipped!',
                        text: 'The order status has been updated successfully.',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
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