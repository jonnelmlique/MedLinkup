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
    <title>Privacy Policy</title>
    <link rel="stylesheet" href="./public/css/index/nav.css">
    <link rel="stylesheet" href="./public/css/index/privacypolicy.css">
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
        <section class="privacy-policy-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Privacy Policy</h1>
                        <p>At MedLinkUp, we are committed to protecting your privacy and ensuring the security of your
                            personal data. This Privacy Policy outlines how we collect, use, and safeguard your
                            information when you access or use our online pharmacy platform. By using MedLinkUp, you
                            consent to the practices described in this Privacy Policy.</p>

                        <h5>Information Collection and Use</h5>

                        <p>We may collect personal information from you when you access or use our platform, including
                            but not limited to:</p>
                        <ul>
                            <li>Name</li>
                            <li>Contact information (such as email address, phone number, mailing address)</li>
                            <li>Payment information (if applicable)</li>
                            <li>Demographic information</li>
                            <li>User preferences and behavior data</li>
                        </ul>

                        <p>We use this information to provide and improve our services, process transactions, respond to
                            inquiries or requests, personalize user experience, and comply with legal obligations.</p>

                        <h5>Security Measures</h5>

                        <p>We employ industry-standard security measures to protect your personal information from
                            unauthorized access, alteration, disclosure, or destruction. These measures include secure
                            server infrastructure, encryption techniques, and regular security audits.</p>

                        <h5>Information Sharing</h5>

                        <p>We do not sell, trade, or otherwise transfer your personal information to third parties
                            without your consent, except as required by law or to facilitate services provided by our
                            trusted partners (such as payment processors or shipping companies).</p>

                        <h5>Cookies and Tracking Technologies</h5>

                        <p>We may use cookies and similar tracking technologies to enhance your browsing experience and
                            analyze usage patterns on our platform. You can configure your browser settings to reject
                            cookies, but this may affect the functionality of certain features.</p>

                        <h5>Third-party Links</h5>

                        <p>Our platform may contain links to third-party websites or services that are not operated or
                            controlled by MedLinkUp. We are not responsible for the privacy practices or content of
                            these third-party sites. We encourage you to review the privacy policies of those sites
                            before providing any personal information.</p>

                        <h5>Updates to Privacy Policy</h5>

                        <p>We reserve the right to update or modify this Privacy Policy at any time without prior
                            notice. Changes will be effective immediately upon posting on this page. It is your
                            responsibility to review this Privacy Policy periodically for updates.</p>

                        <h5>Contact Us</h5>

                        <p>If you have any questions, concerns, or feedback regarding our Privacy Policy or data
                            practices, please contact us at:</p>
                        <ul>
                            <li>Email: medlinkupcontact@gmail.com</li>
                        </ul>

                        <p>By accessing or using MedLinkUp, you agree to the terms and conditions outlined in this
                            Privacy Policy. If you do not agree with any part of this Policy, please refrain from using
                            our services.</p>

                        <p>Thank you for choosing MedLinkUp for your healthcare needs!</p>
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