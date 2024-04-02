<?php
include '../src/config/config.php';
// Send email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/contact/Exception.php';
require '../src/contact/PHPMailer.php';
require '../src/contact/SMTP.php';
// end Send email
$defaultUserType = 'customer';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = trim(mysqli_real_escape_string($conn, $_POST['firstName']));
    $lastname = trim(mysqli_real_escape_string($conn, $_POST['lastName']));
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    $confirmPassword = trim(mysqli_real_escape_string($conn, $_POST['confirmPassword']));

    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $message = "All fields are required.";
    } else {

        $checkEmailQuery = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $emailResult = $stmt->get_result();

        if ($emailResult->num_rows > 0) {
            $message = "Email already exists.";
        } else {

            $checkUsernameQuery = "SELECT * FROM users WHERE username=?";
            $stmt = $conn->prepare($checkUsernameQuery);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $usernameResult = $stmt->get_result();

            if ($usernameResult->num_rows > 0) {
                $message = "Username already exists.";
            } else {

                if ($password !== $confirmPassword) {
                    $message = "Password and Confirm Password do not match.";
                } else {

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $insertUserQuery = "INSERT INTO users (username, firstname, lastname, email, password, usertype) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($insertUserQuery);
                    $stmt->bind_param("ssssss", $username, $firstname, $lastname, $email, $hashedPassword, $defaultUserType);
                    if ($stmt->execute()) {
                        $message = "success";

                        // Send email
                        try {
                            $mail = new PHPMailer(true);

                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'medlinkupcontact@gmail.com';
                            $mail->Password = 'ynlaogsvvbmlrsob';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            $mail->setFrom('medlinkupcontact@gmail.com', 'MedLinkup');
                            $mail->addAddress($email);
                            $mail->isHTML(true);

                            $mail->Subject = 'Account Created Successfully';
                            $mail->Body = 'Welcome to MedLinkup. Your account has been successfully created.';

                            $mail->send();
                        } catch (Exception $e) {

                            $message = "Error sending email: " . $mail->ErrorInfo;
                        }
                        // end Send email


                    } else {
                        $message = "Error: " . $stmt->error;
                    }
                }
            }
        }
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/index/nav.css">
    <link rel="stylesheet" href="../public/css/auth/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/index.html">
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
                    <a href="../cart.html" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="register-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="logoregister text-center">
                            <img src="../public/img/Auth/CoverRegistration.png" alt="Logo"
                                class="img-fluid custom-image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h1>Register to MedLinkup</h1>
                        <p>Create your account to get started with MedLinkup.</p>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                            class="needs-validation">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="firstname" name="firstName"
                                            placeholder="First Name" required>
                                        <div class="invalid-feedback">Please enter your first name.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="lastname" name="lastName"
                                            placeholder="Last Name" required>
                                        <div class="invalid-feedback">Please enter your last name.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username" required>
                                <div class="invalid-feedback">Please enter your Username.</div>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                                <div class="invalid-feedback">Please enter your password.</div>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                    placeholder="Confirm Password" required>
                                <div class="invalid-feedback">Please confirm your password.</div>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="agreeCheckbox" required>
                                <label class="form-check-label" for="agreeCheckbox">I accept the <a
                                        href="/privacypolicy.html" target="_blank">Privacy Policy</a> and <a
                                        href="/termsofservice.html" target="_blank">Terms of Service</a></label>
                                <div class="invalid-feedback">You must agree to the privacy policy and terms.</div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Register</button>
                        </form>

                        <div class="signup-link text-center">
                            Already have an account? <a href="../auth/login.php">Login</a>
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
                <a href="/privacypolicy.html">Privacy Policy</a> | <a href="/termsofservice.html">Terms of Service</a>
            </p>
        </div>
    </footer>

    <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
            Swal.fire({
                title: 'Registration successful',
                text: 'You have successfully registered.',
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