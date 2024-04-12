<?php
include '../src/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $suppliername = $_POST['suppliername'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password']; 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO suppliers (suppliername, contact, email, address) VALUES ('$suppliername', '$contact', '$email', '$address')";
    if (mysqli_query($conn, $sql)) {
        $sql_user = "INSERT INTO users (firstname, lastname, username, email, password, usertype) VALUES ('$suppliername', '$suppliername', '$email', '$email', '$hashedPassword', 'Supplier')";
        mysqli_query($conn, $sql_user);
        $message = "success";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Supplier</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/addsupplier.css">
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
                <a href="supplier.php">
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
                <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg">
            </a>
        </nav>
    </section>


    <main>
        <div class="box-section">
            <div class="head-title">
                <div class="left">
                    <h1>Add Supplier</h1>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="add-product-section">

                            <div id="form-container">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                    enctype="multipart/form-data" class="needs-validation">


                                    <div class="mb-3">
                                        <label for="suppliername">Supplier Name</label>
                                        <input type="text" class="form-control" id="suppliername" name="suppliername"
                                            placeholder="Supplier Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="contact">Contact</label>
                                        <input type="number" class="form-control" id="contact" name="contact"
                                            placeholder="Contact" min="0" step="0.01" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Address" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Password" required>
                                    </div>

                                    <button type="submit" class="btn btn-submit">Add Supplier</button>
                                    <a href="./products.php" class="cancel-btn" style="display: inline-block; padding: 13px 16px; 
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

    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
            Swal.fire({
                title: 'Supplier Added Successfully!',
                text: 'You have successfully added the Supplier.',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'View Supplier'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Do something if user clicks OK
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = '../admin/supplier.php';
                }
            });
        </script>";
        } else {
            echo "<script>
            Swal.fire({
                title: 'Error',
                text: '" . $message . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
        }
    }
    ?>


</body>

</html>