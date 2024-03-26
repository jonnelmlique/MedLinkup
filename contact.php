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
            <a class="navbar-brand" href="./index.html">
                <img src="./public/img/logo.png" alt="Pharmawell Logo" class="logo"> Pharmawell
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact.html">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/shop.html">Shop</a>
                    </li>
                </ul>
                <div class="navbar-icons d-flex align-items-center">
                    <a href="./auth/login.php" class="nav-link"><i class="fas fa-user"></i> Login </a>
                    <a href="/cart.html" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container contact-form">
        <h2>Contact Us</h2>

        <div class="alert alert-success" role="alert">
            You can also send a direct email to <a href="pharmawell@gmail.com" class="alert-link">pharmawell@gmail.com</a>
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
            $mail = new PHPMailer(true);

            try {
               
                $mail->isSMTP(); 
                $mail->Host = 'smtp.example.com'; 
                $mail->SMTPAuth = true; 
                $mail->Username = 'your_smtp_username'; 
                $mail->Password = 'your_smtp_password'; 
                $mail->SMTPSecure = 'tls'; 
                $mail->Port = 587; 

                $mail->setFrom('your_email@example.com', 'Your Name');
                $mail->addAddress('pharmawell@gmail.com'); 
                $mail->addReplyTo($email); 

                $mail->isHTML(true); 
                $mail->Subject = $subject;
                $message .= "<p>Sender's Email: $email</p>";
                $mail->Body = $message;

                $mail->send();
                echo '<div class="alert alert-success" role="alert">Message has been sent</div>';
            } catch (Exception $e) {
                echo '<div class="alert alert-danger" role="alert">Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</div>';
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec dictum nunc. Nullam vitae ligula sed nisi sagittis facilisis vitae nec velit. Integer scelerisque magna sit amet dui suscipit, sed aliquam nunc scelerisque.</p>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>
                &copy; 2024 Pharmawell. All rights reserved. |
                <a href="/privacypolicy.html">Privacy Policy</a> | <a href="/termsofservice.html">Terms of Service</a>
            </p>
        </div>
    </footer> 
    <!-- node -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>
