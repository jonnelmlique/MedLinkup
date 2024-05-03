<?php
include '../src/config/config.php';

$verificationid = "";

if (isset($_GET['verificationid'])) {
    $verificationid = $_GET['verificationid'];

    $user_query = "SELECT * FROM discountverification WHERE verificationid = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("i", $verificationid);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if (!$user_result) {
        die("<script>Swal.fire('Error', 'Database error. Please try again later.', 'error');</script>");
    }

    if ($user_result->num_rows > 0) {
        $userInfo = $user_result->fetch_assoc();
    } else {
        die("<script>Swal.fire('Error', 'No user information found.', 'error');</script>");
    }

    // Close the statement
    $stmt->close();

}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/discountverify.css">
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
            <li>
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
                <a href="../admin/contact.php">
                    <i class='fas fa-envelope'></i>
                    <span class="text"> Contact</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text">Discounts</span>
                </a>
                <ul class="submenu">
                    <li><a href="../admin/discounttype.php">Add Discount</a></li>
                    <li class="active"><a href="../admin/discountverify.php">Verification</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text">Shipping Settings</span>
                </a>
                <ul class="submenu">
                    <li><a href="../admin/location.php">Location</a></li>
                    <li><a href="../admin/shippingfee.php">Shipping Fee</a></li>
                </ul>
            </li>

            <li>
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text"> Supplier</span>
                </a>
                <ul class="submenu">
                    <li><a href="../supplier/suppliershop.php">Order</a></li>
                    <li><a href="../admin/orderstatus.php">Order Status</a></li>
                    <li><a href="../admin/history.php">History</a></li>
                </ul>
            </li>
            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='fa fa-user-cog'></i>
                        <span class="text">System Maintenane</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../admin/about.php">About</a></li>
                        <li><a href="../admin/privacypolicy.php">Privacy Policy</a></li>
                        <li><a href="../admin/termsofservice.php">Terms of Service</a></li>

                    </ul>
                </li>
                <ul class="side-menu">
                    <li>
                        <a href="#">
                            <i class='fa fa-cogs'></i>
                            <span class="text">Settings</span>
                        </a>
                        <ul class="submenu">
                            <li class="active"><a href="../admin/delivery.php">Delivery Address</a></li>

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
        <div class="box-section">
            <div class="head-title">
                <div class="left">
                    <h1>Add Product</h1>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="add-product-section">
                            <div id="image-container">
                                <div id="preview-image">
                                    <img src="../idpictures/<?php echo isset($userInfo['idpicture']) ? htmlspecialchars($userInfo['idpicture']) : ''; ?>"
                                        alt="ID Image">

                                </div>
                            </div>
                            <div id="form-container">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                    enctype="multipart/form-data">

                                    <input type="hidden" name="verificationid"
                                        value="<?php echo isset($userInfo['verificationid']) ? htmlspecialchars($userInfo['verificationid']) : ''; ?>">
                                    <div class="mb-3">
                                        <label for="firstname">First Name</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            placeholder="First Name"
                                            value="<?php echo isset($userInfo['firstname']) ? htmlspecialchars($userInfo['firstname']) : ''; ?>"
                                            disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="middlename">Middle Name</label>
                                        <input type="text" class="form-control" id="middlename" name="middlename"
                                            placeholder="Middle Name"
                                            value="<?php echo isset($userInfo['middlename']) ? htmlspecialchars($userInfo['middlename']) : ''; ?>"
                                            disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            placeholder="Last Name"
                                            value="<?php echo isset($userInfo['lastname']) ? htmlspecialchars($userInfo['lastname']) : ''; ?>"
                                            disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dob">Date of Birth</label>
                                        <input type="text" class="form-control" id="dob" name="dob"
                                            value="<?php echo isset($userInfo['birthday']) ? htmlspecialchars($userInfo['birthday']) : ''; ?>"
                                            disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="contact">Contact</label>
                                        <input type="text" class="form-control" id="contact" name="contact"
                                            placeholder="Contact"
                                            value="<?php echo isset($userInfo['contact']) ? htmlspecialchars($userInfo['contact']) : ''; ?>"
                                            disabled
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email"
                                            value="<?php echo isset($userInfo['email']) ? htmlspecialchars($userInfo['email']) : ''; ?>"
                                            disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="distype">Discount Type</label>
                                        <input type="text" class="form-control" id="distype" name="distype"
                                            placeholder="Discount Type"
                                            value="<?php echo isset($userInfo['type']) ? htmlspecialchars($userInfo['type']) : ''; ?>"
                                            disabled>
                                    </div>

                                    <a href="#" class="btn btn-submit accept-btn"
                                        data-verificationid="<?php echo htmlspecialchars($verificationid); ?>">Accept</a>
                                    <a href="#" class="btn btn-submit1 reject-btn"
                                        data-verificationid="<?php echo htmlspecialchars($verificationid); ?>">Reject</a>


                                    <a href="./discountverify.php" class="cancel-btn" style="display: inline-block; padding: 13px 16px; 
            background-color: #f44336; color: #fff; text-decoration: 
            none; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='#d32f2f';"
                                        onmouseout="this.style.backgroundColor='#f44336';">Cancel</a>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function previewImage(event) {
        var preview = document.getElementById('preview-image');
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.style.display = 'block';
            preview.querySelector('img').src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
    </script>
    <script>
    $(document).ready(function() {
        $(".accept-btn").click(function(e) {
            e.preventDefault();
            var verificationid = $(this).attr("data-verificationid");
            $.ajax({
                url: "accept.php",
                method: "POST",
                data: {
                    verificationid: verificationid
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Status updated',
                        text: 'The status has been successfully updated to Accepted.',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = '../admin/discountverify.php';
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error updating the status. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $(".reject-btn").click(function(e) {
            e.preventDefault();
            var verificationid = $(this).attr("data-verificationid");
            $.ajax({
                url: "reject.php",
                method: "POST",
                data: {
                    verificationid: verificationid
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Status updated',
                        text: 'The status has been successfully updated to Rejected.',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = '../admin/discountverify.php';
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error updating the status. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
    </script>

</body>

</html>