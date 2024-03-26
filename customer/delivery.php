<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Address</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/customer/sidebar.css">
    <link rel="stylesheet" href="../public/css/customer/delivery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        
    </style>
   
</head>
<body>
    <section id="sidebar">
        <a href="../supplier/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="Pharmawell Logo" class="logo">
            <span class="text"> Pharmawell</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="../customer/dashboard.php">
                    <i class="fas fa-clone"></i>
                    <span class="text"> Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-portrait"></i>
                    <span class="text"> Profile</span>
                </a>
                <ul class="submenu">
                    <li><a href="../customer/myprofile.php">My Profile</a></li>
                    <li class="active"><a href="../admin/categories.php">Delivery Address</a></li>
                </ul>
            </li>
            <li>
                <a href="../cart.php">
                    <i class="fas fa-cart-plus"></i>
                    <span class="text"> Cart</span>
                </a>
            </li>
            <li>
                <a href="../customer/pendingorder.php">
                    <i class="fas fa-cart-arrow-down"></i>
                    <span class="text"> Pending Order</span>
                </a>
            </li>
            <li >
                <a href="../customer/history.php">
                    <i class="fas fa-shopping-basket"></i>
                    <span class="text"> History</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span class="text"> Settings</span>
                </a>
                <ul class="submenu">
                    <li><a href="../customer/changepassword.php">Change Password</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="logout">
                    <i class="fas fa-user"></i>
                    <span class="text"> Logout</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <i class="fa-pills"></i>
            <a href="#" class="profile">
                <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg" alt="Profile Picture">
            </a>
        </nav>
    </section>
   
    <main>
        <section id="delivery-address">
                <h1>Delivery Address</h1>
                <div id="existing-address">
                    <h3>Existing Address</h3>
                    <p><strong>Recipient Name:</strong> John Doe</p>
                    <p><strong>Delivery Address:</strong> 123 Main Street</p>
                    <p><strong>City:</strong> Anytown</p>
                    <p><strong>Country:</strong> Countryland</p>
                </div>
                <div class="edit-container">
                    <button class="edit" onclick="showEditForm()">Edit</button>
                    
                </div>
            </section>
            </main>
        
            <main>
                <section id="edit-address" style="display: none;">

                <h1>Edit Delivery Address</h1>
                <form id="edit-address-form">
                    <div class="form-group">
                        <label for="recipient-name">Recipient Name:</label>
                        <input type="text" id="recipient-name" name="recipient-name" value="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="delivery-address">Delivery Address:</label>
                        <textarea id="delivery-address" name="delivery-address" rows="4" required>123 Main Street</textarea>
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" value="Anytown" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" id="country" name="country" value="Countryland" required>
                    </div>
                    <button type="submit">Submit</button>
                    <button type="button" onclick="hideEditForm()">Cancel</button>
                </form>
        </section>
    </main>

    <!-- JavaScript includes -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./node_modules/bootstrap/js/src/sidebar.js"></script>
    <script src="../customer1/editform.js"></script>


    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    
</body>
</html>