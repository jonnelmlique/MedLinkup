<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>My Profile</title>
        <!-- <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
        <link rel="stylesheet" href="../public/css/customer/sidebar.css">
        <link rel="stylesheet" href="../public/css/customer/myprofile.css">
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
                        <li class="active"><a href="../customer/myprofile.php">My Profile</a></li>
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
                <a href="../customer/order.php">
                    <i class="fas fa-cart-arrow-down"></i>
                    <span class="text">Order</span>
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
                    <a href="../logout.php" class="logout">
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
                
        
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="myprofile-section">

                                <div class="head-title">
                                    <div class="left">
                                        <h1 class="lefth">My Profile</h1>
                                    </div>
                                    
                                </div>
                                <form action="#" method="POST" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="fullName" name="fullName"
                                            placeholder="Full Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Username" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="fullName" name="address"
                                        placeholder="Address" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="contactno" name="contactno"
                                        placeholder="Contact No" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../node_modules/bootstrap/js/src/sidebar.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        
    </body>
    </html>