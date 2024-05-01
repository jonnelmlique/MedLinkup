<?php
include './src/config/config.php';

session_start();

$message = '';

$loginLinkText = '<i class="fas fa-user"></i> Login';
$loginLinkURL = './auth/login.php';

if (isset($_SESSION['userid']) && isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
    $loginLinkText = '<i class="fas fa-user"></i> ' . $loggedInUsername;
    $loginLinkURL = './customer/dashboard.php';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/index/contact.css">
    <link rel="stylesheet" href="./public/css/index/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="./index.php">
                <img src="./public/img/logo.png" alt="MedLinkup Logo" class="logo"> MedLinkup
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./shop.php">Shop</a>
                    </li>
                </ul>
                <div class="navbar-icons d-flex align-items-center">
                    <a href="<?php echo $loginLinkURL; ?>" class="nav-link"><?php echo $loginLinkText; ?></a>
                    <a href="./cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container contact-form">
        <h2>Contact Us</h2>

        <div class="alert alert-success" role="alert">
            You can also send a direct email to <a href="medlinkupcontact@gmail.com"
                class="alert-link">medlinkupcontact@gmail.com</a>
        </div>

        <?php

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'src/contact/Exception.php';
        require 'src/contact/PHPMailer.php';
        require 'src/contact/SMTP.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $messageToInsert = $_POST['message'];


            date_default_timezone_set('Asia/Manila');

            $currentTimestamp = date("Y-m-d H:i:s");
            $mail = new PHPMailer(true);

            try {

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'medlinkupcontact@gmail.com';
                $mail->Password = 'suxcgpyfagvcluxi';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('medlinkupcontact@gmail.com', 'MedLinkup Contact');
                $mail->addAddress('medLinkupofficial@gmail.com');
                $mail->addReplyTo($email);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $message = "<p><strong>Sender Email:</strong> $email</p><br>" . $message;
                $mail->Body = $message;

                $mail->send();

                $stmt = $conn->prepare("INSERT INTO contact (email, subject, messagecontent, received) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $email, $subject, $messageToInsert, $currentTimestamp);

                $stmt->execute();

                $message = "success";
            } catch (Exception $e) {
                $message = "Message could not be sent. Mailer Error:";
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="needs-validation">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Send</button>
        </form>
    </div>
    <section class="design-element">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Our Mission</h3>
                    <p>Empowering health through easy access to medications. Your trusted online platform for quality
                        pharmaceuticals.</p>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>
                &copy; 2024 MedLinkup. All rights reserved. |
                <a href="./privacypolicy.php">Privacy Policy</a> | <a href="./termsofservice.php">Terms of Service</a>
            </p>
        </div>
    </footer>
    <!-- node -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
            Swal.fire({
                title: 'Message has been sent Successfully!',
                text: 'You have successfully sent your message.',
                icon: 'success',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'contact.php';

                } else if (result.dismiss === Swal.DismissReason.cancel) {
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