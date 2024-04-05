<?php
include './src/config/config.php';

session_start();

$message = '';

$loginLinkText = '<i class="fas fa-user"></i> Login';
$loginLinkURL = './auth/login.php';

if(isset($_SESSION['userid']) && isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username']; 
    $loginLinkText = '<i class="fas fa-user"></i> ' . $loggedInUsername; 
    $loginLinkURL = './customer/dashboard.php';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Terms of Service</title>
    <link rel="stylesheet" href="./public/css/index/nav.css">
    <link rel="stylesheet" href="./public/css/index/termsofservice.css">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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
    <main>
        <section class="terms-of-service-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Terms of Service</h1>
                       
                        <h5>User Agreement:</h5>

<p>Welcome to MedLinkUp! By accessing and using our online pharmacy platform, you agree to abide by the following terms and conditions. Please read this agreement carefully before accessing or using our services.</p>

<h5>Product and Service Offerings:</h5>

<p>MedLinkUp offers a wide range of products and services, including prescription drugs, over-the-counter medications, supplements, and other health-related products. Our platform aims to provide users with convenient access to quality healthcare products.</p>

<h5>Ordering Process:</h5>

<p>To place an order on MedLinkUp, users can navigate through our website, select desired products, and proceed to checkout. We accept various payment methods, including PayPal and Cash on Delivery (COD). Upon successful payment, users will receive confirmation of their order along with shipping details.</p>

<h5>Privacy Policy:</h5>

<p>Please refer to our Privacy Policy for detailed information on how we collect, use, and protect your personal data. Your privacy and security are of utmost importance to us, and we are committed to safeguarding your information.</p>

<h5>Security Measures:</h5>

<p>At MedLinkUp, we prioritize the security of our users' data and employ industry-standard measures to protect against unauthorized access or misuse. Our secure payment gateway ensures the confidentiality of your payment information during transactions.</p>

<h5>Legal Disclaimers:</h5>

<p>While we strive to provide accurate and up-to-date information, MedLinkUp cannot guarantee the accuracy or completeness of all content on our platform. We disclaim any liability for errors or omissions in product descriptions, pricing, or other information provided.</p>

<h5>Refund and Return Policy:</h5>

<p>Please note that MedLinkUp does not offer refunds for purchases. We encourage users to review their orders carefully before completing the transaction. Once an order is confirmed and processed, it cannot be canceled or refunded. We apologize for any inconvenience this may cause and appreciate your understanding.</p>

<h5>Compliance with Laws:</h5>

<p>MedLinkUp operates in compliance with all relevant laws, regulations, and industry standards governing the sale of medications and healthcare products online. We are committed to upholding the highest standards of ethics and integrity in all our business practices.</p>

<h5>Contact Information:</h5>

<p>For any inquiries, concerns, or feedback regarding our services, please feel free to contact us:</p>
<ul>
    <li>Email: medlinkupcontact@gmail.com</li>
    <li>Phone: [insert phone number]</li>
    <li>Address: [insert mailing address]</li>
</ul>

<p>By accessing or using MedLinkUp, you agree to be bound by these terms and conditions. If you do not agree with any part of this agreement, please refrain from using our services. We reserve the right to update or modify these terms at any time without prior notice. Continued use of our platform after any such changes constitutes your acceptance of the revised terms.</p>

<p>Thank you for choosing MedLinkUp for your healthcare needs!</p>
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
                    <p>Empowering health through easy access to medications. Your trusted online platform for quality pharmaceuticals.</p>
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
</body>

</html>