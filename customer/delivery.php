<?php
include '../src/config/config.php';

session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit;
}
$userID = $_SESSION['userid'];

$sql = "SELECT * FROM shippingaddresses WHERE userid = $userID";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $shippingAddress = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Address</title>
    <link rel="stylesheet" href="../public/css/customer/sidebar.css">
    <link rel="stylesheet" href="../public/css/customer/delivery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>

    </style>

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
                    <li><a href="../customer/delivery.php">Delivery Address</a></li>

                </ul>
            </li>
            <li>
                <a href="../cart.php">
                    <i class="fas fa-cart-plus"></i>
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
                <a href="../index.php">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="text"> Continue Shopping</span>
                </a>
            </li>
            <li>
                <a href="../logout.php" class="logout">
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
                <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg"
                    alt="Profile Picture">
            </a>
        </nav>
    </section>
    <main>

        <div class="box-section">

            <div class="head-title">
                <div class="left">

                    <h1>Delivery Address</h1>

                </div>

            </div>
            <hr>
            <div class="add-button">
                <a href="../customer/adddelivery.php" class="btn-link">
                    <button>Add</button>
                    <a href="../customer/updatedelivery.php" class="btn-link">
                        <button>Update</button>
                    </a>

            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="add-location-section">

                            <div id="form-container">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                    enctype="multipart/form-data">

                                    <div class="mb-3">
                                        <label for="country">First Name:</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            value="<?php echo isset($shippingAddress['firstname']) ? $shippingAddress['firstname'] : ''; ?>"
                                            placeholder="First Name" required disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Last Name:</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            value="<?php echo isset($shippingAddress['lastname']) ? $shippingAddress['lastname'] : ''; ?>"
                                            placeholder="Last Name" required disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo isset($shippingAddress['email']) ? $shippingAddress['email'] : ''; ?>"
                                            placeholder="Email" required disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country">Contact:</label>
                                        <input type="number" class="form-control" id="contact" name="contact"
                                            value="<?php echo isset($shippingAddress['contact']) ? $shippingAddress['contact'] : ''; ?>"
                                            placeholder="Contact" required disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Country:</label>
                                        <input type="text" class="form-control" id="country" name="country"
                                            value="<?php echo isset($shippingAddress['country']) ? $shippingAddress['country'] : ''; ?>"
                                            placeholder="Country" required disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Region:</label>
                                        <input type="text" class="form-control" id="region" name="region"
                                            value="<?php echo isset($shippingAddress['region']) ? $shippingAddress['region'] : ''; ?>"
                                            placeholder="Region" required disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Province:</label>
                                        <input type="text" class="form-control" id="province" name="province"
                                            value="<?php echo isset($shippingAddress['province']) ? $shippingAddress['province'] : ''; ?>"
                                            placeholder="Province" required disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">City:</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            value="<?php echo isset($shippingAddress['city']) ? $shippingAddress['city'] : ''; ?>"
                                            placeholder="City" required disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Barangay:</label>
                                        <input type="text" class="form-control" id="barangay" name="barangay"
                                            value="<?php echo isset($shippingAddress['barangay']) ? $shippingAddress['barangay'] : ''; ?>"
                                            placeholder="Barangay" required disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Zip Code:</label>
                                        <input type="number" class="form-control" id="zipcode" name="zipcode"
                                            value="<?php echo isset($shippingAddress['zipcode']) ? $shippingAddress['zipcode'] : ''; ?>"
                                            placeholder="Zip Code" required disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country">Address:</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="<?php echo isset($shippingAddress['addressline1']) ? $shippingAddress['addressline1'] : ''; ?>"
                                            placeholder="Address" required disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country">Address 2:</label>
                                        <input type="text" class="form-control" id="address2" name="address2"
                                            value="<?php echo isset($shippingAddress['addressline2']) ? $shippingAddress['addressline2'] : ''; ?>"
                                            placeholder="Address 2" required disabled>
                                    </div>



                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- JavaScript -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>