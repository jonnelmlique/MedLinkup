<?php
include '../src/config/config.php';

session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $message = "Email and password are required.";
    } else {

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $message = "Error preparing statement: " . $conn->error;
        } else {

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $storedPassword = $row['password'];

                if (password_verify($password, $storedPassword)) {

                    $_SESSION['userid'] = $row['userid'];
                    $_SESSION['usertype'] = $row['usertype'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['username'] = $row['username'];


                    if ($row['usertype'] == 'admin') {
                        header("Location: ../admin/dashboard.php");
                        exit();
                    } else {
                        header("Location: ../index.php");
                        exit();
                    }
                } else {
                    $message = "Incorrect password.";
                }
            } else {
                $message = "Email not found.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/index/nav.css">
    <link rel="stylesheet" href="../public/css/auth/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/index.php">
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
                    <a href="../public/auth/login.html" class="nav-link"><i class="fas fa-user"></i> Login </a>
                    <a href="../cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="login-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="logologin text-center">
                            <img src="../public/img/auth/CoverLogin.png" alt="Logo" class="img-fluid custom-image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h1>Login to MedLinkup</h1>
                        <p>Welcome back to MedLinkup! Enter your email and password to Login.</p>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                            class="needs-validation">
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    required>
                                <div class="invalid-feedback">Please enter your email.</div>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                                <div class="invalid-feedback">Please enter your password.</div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Login</button>
                        </form>

                        <div class="forgot-password text-center">
                            <a href="../auth/forgot.php">Forgot password?</a>
                        </div>

                        <div class="signup-link text-center">
                            Don’t have an account? <a href="../auth/register.php">Register</a>
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
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: '" . $message . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }
    ?>
</body>

</html>