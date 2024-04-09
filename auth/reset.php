<?php
include '../src/config/config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_GET['token'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $sql = "SELECT * FROM users WHERE reset_token='$token' AND reset_token_expiration > NOW()";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password='$hashed_password', reset_token=NULL, reset_token_expiration=NULL WHERE email='$email'";
            if ($conn->query($update_sql) === TRUE) {
                $message = "success";
            } else {
                $message = "Error updating password: " . $conn->error;
            }
        } else {
            $message = "Invalid or expired token.";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/index/nav.css">
    <link rel="stylesheet" href="../public/css/auth/resetpassword.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../public/img/logo.png" alt="MedLinkup Logo" class="logo"> MedLinkup
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../shop.php">Shop</a>
                    </li>
                </ul>
                <div class="navbar-icons d-flex align-items-center">
                    <a href="../auth/login.php" class="nav-link"><i class="fas fa-user"></i> Login </a>
                    <a href="../cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="reset-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="logoreset text-center">
                            <img src="../public/img/auth/CoverLogin.png" alt="Logo" class="img-fluid custom-image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h1>Reset Password</h1>
                        <p>Enter your New Password.</p>

                        <form action="#" method="POST" class="needs-validation">
                            <div class="row">

                            </div>

                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="New Password" required>
                                <div class="invalid-feedback">Please your New Password.</div>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" placeholder="Confirm Password" required>
                                <div class="invalid-feedback">Please Confirm your Password.</div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>

                        <div class="signup-link text-center">
                            Remember you're password? <a href="../auth/login.php">Login</a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <section class="design-element">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Our Mission</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec dictum nunc. Nullam vitae
                        ligula sed nisi sagittis facilisis vitae nec velit. Integer scelerisque magna sit amet dui
                        suscipit, sed aliquam nunc scelerisque.</p>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>
                &copy; 2024 MedLinkup. All rights reserved. |
                <a href="../privacypolicy.php">Privacy Policy</a> | <a href="../termsofservice.php">Terms of Service</a>
            </p>
        </div>
    </footer>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
            Swal.fire({
                title: 'Reset successful',
                text: 'Your password has been successfully reset.',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Login'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Do something if user clicks OK
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = '../auth/login.php';
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