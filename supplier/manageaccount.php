<?php
session_start();

include '../src/config/config.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    $sql = "SELECT * FROM users WHERE (email = ? OR username = ?) AND userid != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $email, $username, $_SESSION['userid']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Email or Username is already taken.";
    } else {

        $sql = "SELECT * FROM users WHERE userid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['userid']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user['firstname'] == $firstname && $user['lastname'] == $lastname && $user['email'] == $email && $user['username'] == $username) {
            $message = "No changes have been made.";
        } else {
            $sql = "UPDATE users SET firstname=?, lastname=?, email=?, username=? WHERE userid=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $firstname, $lastname, $email, $username, $_SESSION['userid']);

            if ($stmt->execute()) {
                $message = "success";
            } else {
                $message = "Error updating profile: " . $conn->error;
            }
        }
    }
}

$userid = $_SESSION['userid'];
$sql = "SELECT firstname, lastname, username, email FROM users WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $message = "No user found with the given ID.";
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Account</title>
    <!-- <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../public/css/supplier/sidebar.css">
    <link rel="stylesheet" href="../public/css/supplier/manageaccount.css">
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
                    <li class="active"><a href="../supplier/manageaccount.php">Manage Account</a></li>
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
                    <div class="myprofile-section">

                        <div class="head-title">
                            <div class="left">
                                <h1 class="lefth">Manage Account</h1>
                            </div>

                        </div>
                        <form action="#" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="profile">First Name:</labl>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        placeholder="First Name" value="<?php echo $user['firstname']; ?>" required>

                            </div>
                            <div class="mb-3">
                                <label for="profile">Last Name:</labl>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="Last Name" value="<?php echo $user['lastname']; ?>" required>

                            </div>
                            <div class="mb-3">
                                <label for="profile">Email:</labl>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                        value="<?php echo $user['email']; ?>" required>

                            </div>
                            <div class="mb-3">
                                <label for="profile">Username:</labl>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Username" value="<?php echo $user['username']; ?>" required>

                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
                Swal.fire({
                    title: 'Profile Updated Successfully!',
                    text: 'Your profile has been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: '$message',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    }
    ?>
</body>

</html>