<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard</title>
        <!-- <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
        <link rel="stylesheet" href="../public/css/customer/sidebar.css">
        <link rel="stylesheet" href="../public/css/customer/dashboard.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    </head>

    <body>
        <section id="sidebar">
            <a href="../supplier/dashboard.php" class="brand">
                <img src="../public/img/logo.png" alt="Pharmawell Logo" class="logo">
                <span class="text"> Pharmawell</span>
            </a>
            <ul class="side-menu top">
                <li class="active">
                    <a href="../customer/dashboard.php">
                        <i class='fas fa-clone' ></i>
                        <span class="text"> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class='fas fa-portrait' ></i>
                        <span class="text"> Profile</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../customer/myprofile.php">My Profile</a></li>
                        <li><a href="../customer/delivery.php">Delivery Address</a></li>

                    </ul>
                </li>
             
                <li>
                    <a href="../cart.php">
                        <i class='fas fa-cart-plus' ></i>
                        <span class="text"> Cart</span>
                    </a>
                </li>
                <li>
                    <a href="../customer/pendingorder.php">
                        <i class='fas fa-cart-arrow-down' ></i>
                        <span class="text"> Pending Order</spvan>
                    </a>
                </li>
                <li>
                    <a href="history.php">
                        <i class='fas fa-shopping-basket' ></i>
                        <span class="text"> History</span>
                    </a>
                </li>
            </ul>
            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='fa fa-cogs' ></i>
                        <span class="text"> Settings</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../customer/changepassword.php">Change Password</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="logout">
                        <i class='fas fa-user' ></i>
                        <span class="text"> Logout</span>
                    </a>
                </li>
            </ul>
        </section>

        <section id="content">
		<nav>
            <i class='fa-pills' ></i>
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
                        <a href="#">
                        <i class='fas fa-cart-plus' ></i>
                        <span class="text">
                            <h3>20</h3>
                            <p>Pending Order</p>
                        </span>
                    </a>
                    </li>
                    <li>
                        <a href="#">
                        <i class='fas fa-capsules' ></i>
                        <span class="text">
                            <h3>34</h3>
                            <p>History</p>
                        </span>
                    </a>
                    </li>
                    <li>
                        <a href="#">
                        <i class='fas fa-chart-bar'></i>
                        <span class="text">
                            <h3>&#8369;4,300</h3>
                            <p>Total Spend</p>
                        </span>
                    </a>
                    </li>
                    
                </ul>
    
    
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Pending Orders</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Date Order</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                   
                                    <td>
                                        <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg">
                                        <p>Sample</p>
                                    </td>
                                    <td>02-10-2024</td>
                                    <td><span class="status pending">Pending</span></td>
                                </tr>
                                <tr>
                                   
                                    <td>
                                        <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg">
                                        <p>Sample</p>
                                    </td>
                                    <td>02-10-2024</td>
                                    <td><span class="status pending">Pending</span></td>
                                </tr>
                                <tr>
                                   
                                    <td>
                                        <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg">
                                        <p>Sample</p>
                                    </td>
                                    <td>02-10-2024</td>
                                    <td><span class="status pending">Pending</span></td>
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