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
    <title>About Us</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/index/nav.css">
    <link rel="stylesheet" href="./public/css/index/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/index.php">
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
                    <a href="<?php echo $loginLinkURL; ?>" class="nav-link"><?php echo $loginLinkText; ?></a> <a
                        href="./cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container about-us">
        <section class="about-section">
            <div class="row">
                <div class="col-md-6">
                    <h2>About MedLinkUp</h2>
                    <p>Welcome to MedLinkUp, your one-stop destination for all your pharmaceutical needs. At MedLinkUp,
                        we understand the importance of accessible, reliable, and affordable medication for everyone.
                    </p>
                    <p>Our online platform is designed to provide a seamless experience for purchasing medications,
                        ensuring that you have convenient access to the products you need to maintain your health and
                        well-being.</p>
                </div>
                <div class="col-md-6">
                    <img src="./public/img/about.jpg" alt="About Us Image" class="img-fluid">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4>Our Mission</h4>
                    <p>At MedLinkUp, our mission is to empower individuals to take control of their health by providing
                        them with easy access to a wide range of medications. We believe that everyone deserves access
                        to high-quality pharmaceutical products, and we are committed to making this a reality by
                        offering a convenient online platform where customers can browse, purchase, and receive their
                        medications with ease.</p>
                    <h4>Our Commitment to Quality</h4>
                    <p>We understand the importance of quality when it comes to medication. That's why we partner with
                        reputable pharmaceutical manufacturers and distributors to ensure that all the products
                        available on our platform meet the highest standards of safety and efficacy. Whether you're
                        looking for over-the-counter medications, prescription drugs, or specialty pharmaceuticals, you
                        can trust that the products you find on MedLinkUp are of the highest quality.</p>
                    <h4>Exceptional Customer Service</h4>
                    <p>At MedLinkUp, we prioritize the satisfaction and well-being of our customers above all else. Our
                        team of dedicated customer service representatives is available to assist you with any questions
                        or concerns you may have, ensuring that your experience with MedLinkUp is always positive and
                        hassle-free. Whether you need help finding a specific product, navigating our website, or
                        tracking your order, we're here to help every step of the way.</p>
                    <h4>Your Trusted Partner in Health</h4>
                    <p>Whether you're managing a chronic condition, dealing with a temporary illness, or simply looking
                        to stock up on essentials, MedLinkUp is here to support you on your journey to better health.
                        With our extensive selection of medications, easy-to-use platform, and commitment to customer
                        satisfaction, we're proud to be your trusted partner in health.</p>
                    <p>Thank you for choosing MedLinkUp. We look forward to serving you and helping you live your
                        healthiest life possible.</p>
                </div>
            </div>
        </section>
    </div>

    <!-- About Section -->
    <!-- <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>About MedLinkup</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec dictum nunc. Nullam vitae
                        ligula sed nisi sagittis facilisis vitae nec velit. Integer scelerisque magna sit amet dui
                        suscipit, sed aliquam nunc scelerisque. </p>
                    <p>Mauris vel tortor vel nunc tincidunt tristique. Nullam accumsan neque id suscipit mattis.
                        Quisque ullamcorper euismod velit, eu laoreet turpis faucibus eget. Duis posuere, felis a
                        gravida vulputate, justo ex aliquam justo, nec venenatis orci ex et lorem.</p>
                </div>
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/600x370" alt="About Us Image 1" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/600x300" alt="About Us Image 1" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec dictum nunc. Nullam vitae
                        ligula sed nisi sagittis facilisis vitae nec velit. Integer scelerisque magna sit amet dui
                        suscipit, sed aliquam nunc scelerisque. </p>
                    <p>Mauris vel tortor vel nunc tincidunt tristique. Nullam accumsan neque id suscipit mattis.
                        Quisque ullamcorper euismod velit, eu laoreet turpis faucibus eget. Duis posuere, felis a
                        gravida vulputate, justo ex aliquam justo, nec venenatis orci ex et lorem.</p>
                </div>
            </div>
        </div>
    </section>-->

    <!-- Design Element -->
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
                <a href="./privacypolicy.php">Privacy Policy</a> | <a href="/termsofservice.php">Terms of Service</a>
            </p>
        </div>
    </footer>
    <!-- JavaScript imports -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>