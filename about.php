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
                    <a href="<?php echo $loginLinkURL; ?>" class="nav-link"><?php echo $loginLinkText; ?></a> <a
                        href="./cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>



    <?php
    $sql = "SELECT * FROM medlinkupabout";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="container about-us">';
        echo '    <section class="about-section">';
        echo '        <div class="row">';

        $aboutMedLinkUpDisplayed = false;

        while ($row = $result->fetch_assoc()) {
            if (!$aboutMedLinkUpDisplayed && $row["sectiontitle"] == "About MedLinkUp") {

                echo '            <div class="col-md-12">';
                echo '                <h2>' . $row["sectiontitle"] . '</h2>';
                echo '                <img src="./maintenance/' . $row["aboutimage"] . '" alt="About Us Image" class="img-fluid" style="max-width: 500px; height: 400px; margin-left: 320px;">';

                echo '                <p>' . nl2br($row["sectioncontent"]) . '</p>';
                echo '            </div>';
                echo '            <div class="col-md-5">';
                if ($row["aboutimage"]) {
                }
                echo '            </div>';
                $aboutMedLinkUpDisplayed = true;
            } else {
                echo '            <div class="col-md-12">';
                echo '                <h4>' . $row["sectiontitle"] . '</h4>';
                echo '                <p>' . nl2br($row["sectioncontent"]) . '</p>';
                echo '            </div>';
            }
        }

        echo '        </div>';
        echo '    </section>';
        echo '</div>';
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>


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
    <!-- JavaScript imports -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>