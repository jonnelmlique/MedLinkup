<?php
include './src/config/config.php';

session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ./auth/login.php");
    exit;
}

$message = '';

$loginLinkText = '<i class="fas fa-user"></i> Login';
$loginLinkURL = './auth/login.php';

if (isset($_SESSION['userid']) && isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
    $loginLinkText = '<i class="fas fa-user"></i> ' . $loggedInUsername;
    $loginLinkURL = './customer/dashboard.php';
}



$userID = $_SESSION['userid'];

$sql = "SELECT * FROM shippingaddresses WHERE userid = $userID";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $shippingAddress = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/index/nav.css">
    <link rel="stylesheet" href="./public/css/index/checkout.css">
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
                    <a href="<?php echo $loginLinkURL; ?>" class="nav-link"><?php echo $loginLinkText; ?></a>
                    <a href="./cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>


    <div class="container">
        <div class="py-5 text-center">
            <h2>Checkout form</h2>
        </div>
        <?php
        $userID = $_SESSION['userid'];

        $sqlShippingAddress = "SELECT * FROM shippingaddresses WHERE userid = $userID";
        $resultShippingAddress = mysqli_query($conn, $sqlShippingAddress);

        if (mysqli_num_rows($resultShippingAddress) > 0) {
            $shippingAddress = mysqli_fetch_assoc($resultShippingAddress);
            $region = $shippingAddress['region'];

            $sqlShippingFee = "SELECT fee FROM shippingfees WHERE region = '$region'";
            $resultShippingFee = mysqli_query($conn, $sqlShippingFee);

            if (mysqli_num_rows($resultShippingFee) > 0) {
                $shippingFeeRow = mysqli_fetch_assoc($resultShippingFee);
                $shippingFee = $shippingFeeRow['fee'];
            } else {
                $shippingFee = 0;
            }
        } else {
            $shippingFee = 0;
        }


        $sql = "SELECT * FROM cart WHERE userid = $userID";
        $result = mysqli_query($conn, $sql);
        $totalPrice = 0;
        ?>
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill"><?php echo mysqli_num_rows($result); ?></span>
                </h4>

                <ul class="list-group mb-3">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $totalPrice += $row['price'] * $row['quantity'];
                        $productID = $row['productid'];
                        $quantity = $row['quantity'];


                        ?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0"><?php echo $row['productname']; ?></h6>
                            <small class="text-muted">Quantity: <?php echo $row['quantity']; ?></small>
                        </div>
                        <span class="text-muted">₱<?php echo $row['price']; ?></span>
                    </li>


                    <?php
                    }
                    ?>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Shipping Fee</h6>
                        </div>
                        <span class="text-success">₱<?php echo $shippingFee; ?></span>
                    </li>
                    <?php
                    // Initialize discount amount to 0
                    $discount_amount = 0;

                    // Check if the user ID is set in the session
                    if (isset($_SESSION['userid'])) {
                        // Get the user ID from the session
                        $user_id = $_SESSION['userid'];

                        // Query to check the user's status and get the discount type
                        $verification_query = "SELECT status, type FROM discountverification WHERE userid = ?";
                        $stmt = $conn->prepare($verification_query);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $verification_result = $stmt->get_result();

                        // Check if the query executed successfully
                        if ($verification_result) {
                            // Fetching user's verification information
                            $verification_info = $verification_result->fetch_assoc();
                            $status = $verification_info['status'];
                            $discount_type = $verification_info['type'];

                            if ($status === 'Accepted' && $discount_type !== 'None') {
                                // User is eligible for a discount, retrieve the discount percentage
                                $discount_query = "SELECT discountpercentage FROM discounts WHERE discounttype = ?";
                                $stmt = $conn->prepare($discount_query);
                                $stmt->bind_param("s", $discount_type);
                                $stmt->execute();
                                $discount_result = $stmt->get_result();

                                // Check if the discount percentage is retrieved successfully
                                if ($discount_result && $discount_result->num_rows > 0) {
                                    $discount_info = $discount_result->fetch_assoc();
                                    $discount_percentage = $discount_info['discountpercentage'];

                                    // Calculate the discount amount based on the total price
                                    $discount_amount = ($totalPrice + $shippingFee) * ($discount_percentage / 100);

                                    // Cap the discount amount at 100 pesos
                                    $discount_amount = min($discount_amount, 100);
                                }
                            }
                        }
                    }

                    // Calculate the percentage of the capped discount relative to the cap
                    $discount_percentage_relative_to_cap = ($discount_amount / 100) * 100;

                    // Display the discount amount
                    echo '<li class="list-group-item d-flex justify-content-between bg-light">';
                    echo '<div class="text-success">';
                    echo '<h6 class="my-0">Discount</h6>';
                    echo '</div>';
                    echo '<span class="text-success">₱' . number_format($discount_amount, 2) . ' / 100 ( ' . $discount_percentage_relative_to_cap . '% )</span>';
                    echo '</li>';

                    // Calculate the total price after applying the discount
                    $totalPriceWithDiscount = $totalPrice + $shippingFee - $discount_amount;
                    ?>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (PHP)</span>
                        <strong>₱<?php echo number_format($totalPriceWithDiscount, 2); ?></strong>
                    </li>

                </ul>
                <select class="form-control" id="paymentMethod" name="paymentMethod">
                    <option value="COD">Cash on Delivery</option>
                    <option value="PayPal">PayPal</option>
                </select>
                <div class="btnpaypal" id="paypal-button-container"></div>

                <button id="proceedButton" class="btn btn-success btn-lg btn-block">Proceed to Checkout</button>
                <a href="./cart.php" class="btn btn-danger btn-lg btn-block">Cancel</a>


            </div>

            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">First name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="First name"
                                value="<?php echo isset($shippingAddress['firstname']) ? $shippingAddress['firstname'] : ''; ?>"
                                required disabled>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Last name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Last name"
                                value="<?php echo isset($shippingAddress['lastname']) ? $shippingAddress['lastname'] : ''; ?>"
                                required disabled>
                            <div class="invalid-feedback">
                                Valid last name is required disabled.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email <span class="text-muted"></span></label>
                        <input type="email" class="form-control" id="email" placeholder="you@example.com"
                            value="<?php echo isset($shippingAddress['email']) ? $shippingAddress['email'] : ''; ?>"
                            disabled>
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="1234 Main St"
                            value="<?php echo isset($shippingAddress['addressline1']) ? $shippingAddress['addressline1'] : ''; ?>"
                            required disabled>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address2">Address 2 <span class="text-muted"></span></label>
                        <input type="text" class="form-control" id="address2" placeholder="Apartment or suite"
                            value="<?php echo isset($shippingAddress['addressline2']) ? $shippingAddress['addressline2'] : ''; ?>"
                            disabled>
                    </div>

                    <div class="mb-3">
                        <label for="contact">Contact </label>
                        <input type="number" class="form-control" id="contact" placeholder="Contact No"
                            value="<?php echo isset($shippingAddress['contact']) ? $shippingAddress['contact'] : ''; ?>"
                            disabled>
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" placeholder="Country"
                                value="<?php echo isset($shippingAddress['country']) ? $shippingAddress['country'] : ''; ?>"
                                required disabled>
                            <div class="invalid-feedback">
                                Please enter a valid country.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="region">Region</label>
                            <input type="text" class="form-control" id="region" placeholder="Region"
                                value="<?php echo isset($shippingAddress['region']) ? $shippingAddress['region'] : ''; ?>"
                                required disabled>
                            <div class="invalid-feedback">
                                Please provide a valid region.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" placeholder="Province"
                                value="<?php echo isset($shippingAddress['province']) ? $shippingAddress['province'] : ''; ?>"
                                required disabled>
                            <div class="invalid-feedback">
                                Please provide a valid province.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" placeholder="City"
                                value="<?php echo isset($shippingAddress['city']) ? $shippingAddress['city'] : ''; ?>"
                                required disabled>
                            <div class="invalid-feedback">
                                Please provide a valid city.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="barangay">Barangay</label>
                            <input type="text" class="form-control" id="barangay" placeholder="Barangay"
                                value="<?php echo isset($shippingAddress['barangay']) ? $shippingAddress['barangay'] : ''; ?>"
                                required disabled>
                            <div class="invalid-feedback">
                                Please provide a valid Barangay.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" id="zip" placeholder="Zip"
                                value="<?php echo isset($shippingAddress['zipcode']) ? $shippingAddress['zipcode'] : ''; ?>"
                                required disabled>
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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

    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AYFau3bcpG1dM1gCEBPpIzp2npDmLbQP9D1dy8i8_tE0KA01LlZzfH5IJdetwQTwK8lcINc-q6ZLNU9L&currency=PHP&disable-funding=card"
        data-sdk-integration-source="button-factory"></script>
    <script>
    document.getElementById("proceedButton").addEventListener("click", function() {
        console.log("Clicked Proceed to Checkout button");

        var paymentMethod = document.getElementById("paymentMethod").value;
        if (paymentMethod === "PayPal") {
            var container = document.getElementById("paypal-button-container");
            container.innerHTML = "";

            var totalAmount = <?php echo $totalPrice + $shippingFee - $discount_amount; ?>;
            console.log("Total Amount:", totalAmount);

            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                currency_code: 'PHP',
                                value: totalAmount
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        var transactionID = details.id;

                        <?php
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $productID = $row['productid'];
                                $quantity = $row['quantity'];
                                ?>
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "./insert_order.php", true);
                        xhr.setRequestHeader("Content-Type",
                            "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                console.log(xhr.responseText);
                            }
                        };
                        var data =
                            "userID=<?php echo $userID; ?>&productID=<?php echo $productID; ?>&quantity=<?php echo $quantity; ?>&totalPrice=<?php echo $totalPrice + $shippingFee - $discount_amount; ?>&totalProductPrice=<?php echo $totalPrice; ?>&shippingFee=<?php echo $shippingFee; ?>&status=Processing&paymentMethod=PayPal&addressID=<?php echo $shippingAddress['addressid']; ?>&discount_percentage=<?php echo $discount_amount; ?>&transactionID=" +
                            transactionID;
                        xhr.send(data);
                        <?php
                            }
                            ?>
                        window.location.href = 'transactioncomplete.php';

                    });
                }
            }).render('#paypal-button-container');
        } else if (paymentMethod === "COD") {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            var hours = String(today.getHours()).padStart(2, '0');
            var minutes = String(today.getMinutes()).padStart(2, '0');
            var seconds = String(today.getSeconds()).padStart(2, '0');
            var randomSuffix = Math.floor(Math.random() *
                10000);
            var transactionID = randomSuffix + mm + seconds + dd + hours + minutes + yyyy;


            <?php
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $productID = $row['productid'];
                    $quantity = $row['quantity'];
                    ?>
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./insert_order.php", true);
            xhr.setRequestHeader("Content-Type",
                "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                }
            };
            var data =
                "userID=<?php echo $userID; ?>&productID=<?php echo $productID; ?>&quantity=<?php echo $quantity; ?>&totalPrice=<?php echo $totalPrice + $shippingFee - $discount_percentage; ?>&totalProductPrice=<?php echo $totalPrice; ?>&shippingFee=<?php echo $shippingFee; ?>&status=Pending&paymentMethod=COD&addressID=<?php echo $shippingAddress['addressid']; ?>&discount_amount=<?php echo $discount_amount; ?>&transactionID=" +
                transactionID;
            xhr.send(data);
            <?php
                }
                ?>
            window.location.href = 'transactioncomplete.php';
        } else {
            alert("Proceeding with other payment method.");
        }
    });
    </script>

    <?php

    $userID = $_SESSION['userid'];

    $sql = "SELECT * FROM shippingaddresses WHERE userid = $userID";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        $message = "Add shipping address";

        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: '" . $message . "',
                    icon: 'error',
                    confirm: 'Add Shipping',
                    confirmButtonText: 'Add Shipping'

                }).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href = './customer/delivery.php';
                    }
                });
            </script>";
    }
    ?>
</body>

</html>