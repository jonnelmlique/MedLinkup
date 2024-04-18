<?php
include '../src/config/config.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST['oldpassword'];
    $newPassword = $_POST['newpassword'];
    $confirmPassword = $_POST['confirmpassword'];

    if ($newPassword !== $confirmPassword) {
        $message = "Password and Confirm Password do not match.";
    } else {

        $userId = $_SESSION['userid'];
        $sql = "SELECT password FROM users WHERE userid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($oldPassword, $row['password'])) {

                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $updateSql = "UPDATE users SET password = ? WHERE userid = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("si", $hashedPassword, $userId);
                $updateStmt->execute();

                $message = "success";
            } else {
                $message = "Old password is incorrect.";
            }
        } else {
            $message = "User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Change Password</title>
    <!-- <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../public/css/supplier/sidebar.css">
    <link rel="stylesheet" href="../public/css/supplier/changepassword.css">
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
                    <li class="active"><a href="../supplier/changepassword.php">Change Password</a></li>

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
                    <div class="manage-account-section">


                        <h1 class="lefth">Change Password</h1>

                        <form action="#" method="POST" class="needs-validation">
                            <div class="mb-3">
                                <input type="password" class="form-control" id="oldpassword" name="oldpassword"
                                    placeholder="Old Password" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="newpassword" name="newpassword"
                                    placeholder="New Password" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword"
                                    placeholder="Confirm Password" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        </div>
        </div>
        </div>
        </div>

    </main>

    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
            Swal.fire({
                title: 'Password Updated Successfully!',
                text: 'You have successfully updated your password.',
                icon: 'success',
                showCancelButton: false,
                confirmButtonText: 'OK'
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