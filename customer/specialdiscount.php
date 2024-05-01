<?php
include '../src/config/config.php';
session_start();

try {
    // Check if userid is set in session
    if (isset($_SESSION['userid'])) {
        $userid = $_SESSION['userid'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $firstname = $_POST['firstname'];
            $middlename = $_POST['middlename'];
            $lastname = $_POST['lastname'];
            $dob = $_POST['dob'];
            $email = $_POST['email'];
            $contact = $_POST['contact'];
            $type = $_POST['distype'];
            $status = "Pending";

            $idpicture = basename($_FILES["idpicture"]["name"]);
            $targetDir = "../idpictures/";
            $targetFilePath = $targetDir . $idpicture;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES["idpicture"]["tmp_name"], $targetFilePath)) {
                    $checkUserQuery = "SELECT userid FROM users WHERE userid = $userid";
                    $result = $conn->query($checkUserQuery);
                    if ($result && $result->num_rows > 0) {
                        $sql = "INSERT INTO discountverification (userid, idpicture, firstname, middlename, lastname, birthday, email, contact, type, status) 
                            VALUES ('$userid', '$idpicture', '$firstname', '$middlename', '$lastname', '$dob', '$email', '$contact', '$type', '$status')";
                        if ($conn->query($sql) === TRUE) {
                            $message = "success";
                        } else {
                            throw new Exception("Error executing SQL statement: " . $conn->error);
                        }
                    } else {
                        throw new Exception("User does not exist.");
                    }
                } else {
                    throw new Exception("Sorry, there was an error uploading your ID picture.");
                }
            } else {
                throw new Exception("Sorry, only JPG, JPEG, PNG, GIF files are allowed for ID picture.");
            }
        }
    } else {
        throw new Exception("User ID is not set in session.");
    }
} catch (Exception $e) {
    $message = $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product</title>
    <link rel="stylesheet" href="../public/css/customer/sidebar.css">
    <link rel="stylesheet" href="../public/css/customer/specialdiscount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

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
                    <i class='fas fa-clone'></i>
                    <span class="text"> Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-portrait'></i>
                    <span class="text"> Profile</span>
                </a>
                <ul class="submenu">
                    <li><a href="../customer/myprofile.php">My Profile</a></li>
                    <li><a href="../customer/delivery.php">Delivery Address</a></li>


                </ul>
            </li>

            <li>
                <a href="../cart.php">
                    <i class='fas fa-cart-plus'></i>
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
                    <i class='fas fa-shopping-basket'></i>
                    <span class="text"> History</span>
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
                    <li class="active"><a href="../customer/changepassword.php">Change Password</a></li>
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
                                    <img src="https://via.placeholder.com/350x350" alt="Preview Image">
                                </div>
                            </div>
                            <div id="form-container">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <label for="id">ID</label>
                                    <input type="file" class="form-control" id="idpicture" name="idpicture"
                                        accept="image/*" onchange="previewImage(event)" required>


                                    <div class="mb-3">
                                        <label for="firstname">First Name</label>

                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            placeholder="First Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="middlename">Middle Name</label>

                                        <input type="text" class="form-control" id="middlename" name="middlename"
                                            placeholder="Middle Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname">Last Name</label>

                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            placeholder="Last Name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="distype">Discount Type</label>
                                        <select class="form-control" id="distype" name="distype" required>
                                            <option value="" disabled selected>Select Type</option>
                                            <?php
                                            include '../src/config/config.php';

                                            $sql = "SELECT discounttype FROM discounts";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['discounttype'] . "'>" . $row['discounttype'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <div class="mb-3">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="contact">Contact</label>
                                        <input type="text" class="form-control" id="contact" name="contact"
                                            placeholder="Contact" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);">

                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" required>
                                    </div>

                                    <button type="submit" class="btn btn-submit">Add Product</button>
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
            title: 'Verification Request Sent!',
            text: 'Your verification request has been sent successfully.',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'View Products'
        }).then((result) => {
            if (result.isConfirmed) {
                // Do something if user clicks OK
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = '../admin/products.php';
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

</body>

</html>