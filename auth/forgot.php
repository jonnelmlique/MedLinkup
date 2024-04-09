<?php
include '../src/config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/contact/Exception.php';
require '../src/contact/PHPMailer.php';
require '../src/contact/SMTP.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateToken()
{
    return bin2hex(random_bytes(32));
}

date_default_timezone_set('Asia/Manila');

function generateExpiration()
{
    return date('Y-m-d H:i:s', strtotime('+1 hour'));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $token = generateToken();
        $expiration = generateExpiration();

        $sql = "UPDATE users SET reset_token='$token', reset_token_expiration='$expiration' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'medlinkupcontact@gmail.com';
                $mail->Password = 'suxcgpyfagvcluxi';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('medlinkupcontact@gmail.com', 'MedLinkup   ');
                $mail->addAddress($email);
                $mail->isHTML(true);

                $mail->Subject = 'Password Reset Link';
                $mail->Body = 'Click <a href="http://localhost/MedLinkup/auth/reset.php?token=' . $token . '">here</a> to reset your password. This link is valid for 1 hour.';

                $mail->send();

                $message = "success";
            } catch (Exception $e) {
                $message = "Error sending email: " . $mail->ErrorInfo;
            }
        } else {
            $message = "Error updating record: " . $conn->error;
        }
    } else {
        $message = "Email not found.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/index/nav.css">
    <link rel="stylesheet" href="../public/css/auth/forgotpassword.css">
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
        <section class="forgot-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="logoforgot text-center">
                            <img src="../public/img/auth/CoverRegistration.png" alt="Logo"
                                class="img-fluid custom-image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h1>Forgot Password</h1>
                        <p>Enter your email to receive the reset link.</p>

                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="row">

                            </div>

                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    required>
                                <div class="invalid-feedback">Please enter your email.</div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                        </form>
                        <?php
                        if (!empty($message)) {
                            echo "<script>
        Swal.fire({
            title: '" . ($message === "success" ? "Email sent" : "Error") . "',
            text: '" . ($message === "success" ? "Password reset link sent to your email." : $message) . "',
            icon: '" . ($message === "success" ? "success" : "error") . "',
            confirmButtonText: 'OK'
        });
    </script>";
                        }
                        ?>
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
                title: 'Reset Link Sent Successfully',
                text: 'You have successfully sent the reset link to your email.',
                icon: 'success',
                confirmButtonText: 'OK',
               
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