<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sales</title>
    <!-- <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../public/css/supplier/sidebar.css">
    <link rel="stylesheet" href="../public/css/supplier/sales.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    
    <section id="sidebar">
        <a href="../supplier/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="Pharmawell Logo" class="logo">
            <span class="text"> Pharmawell</span>
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
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-shopping-bag'></i>
                    <span class="text"> Orders</span>
                </a>
                <ul class="submenu">
                    <li><a href="../supplier/pending.php">Pending</a></li>
                    <li><a href="../supplier/completed.php">Completed</a></li>
                </ul>
            </li>
            <li class="active">
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
                <img src="../public/img/logo.png">
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
                        <h3>&#8369;1,000</h3>
                        <p>Daily Sales</p>
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-chart-area'></i>
                    <span class="text">
                        <h3>&#8369;11,234</h3>
                        <p>Monthly Sales</p>
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-chart-bar'></i>
                    <span class="text">
                        <h3>&#8369;12,234</h3>
                        <p>Total Sales</p>
                    </span>
                </a>
            </li>
        </ul>


        <div class="table-data">
            <div class="sales">
                <div class="head">
                    <h3>Sales History</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Date Order</th>
                            <th>Total</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            <p>Pharmawell</p>
                            </td>
                            <td>Test</td>
                            <td>10</td>
                            <td>01-10-2021</td>
                            <td>&#8369;1,000</td>
                            <td><span class="status completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <p>Pharmawell</p>
                                </td>
                                <td>Test</td>
                                <td>100</td>
                                <td>01-10-2021</td>
                                <td>&#8369;11,234</td>
                                <td><span class="status completed">Completed</span></td>
                        </tr>

                    </tbody>
                </table>
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