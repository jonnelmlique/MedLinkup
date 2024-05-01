<?php
include '../src/config/config.php';

session_start();

$message = "";

try {
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $new_firstname = "";
    $new_lastname = "";
    $new_email = "";
    $new_contact = "";
    $new_country = "";
    $new_region = "";
    $new_province = "";
    $new_city = "";
    $new_barangay = "";
    $new_zipcode = "";
    $new_addressline1 = "";
    $new_addressline2 = "";

    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM shippingaddresses WHERE userid = $userid";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $email = $row["email"];
        $contact = $row["contact"];
        $country = $row["country"];
        $region = $row["region"];
        $province = $row["province"];
        $city = $row["city"];
        $barangay = $row["barangay"];
        $zipcode = $row["zipcode"];
        $addressline1 = $row["addressline1"];
        $addressline2 = $row["addressline2"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Assigning new values from the form
        $new_firstname = htmlspecialchars($_POST["firstname"]);
        $new_lastname = htmlspecialchars($_POST["lastname"]);
        $new_email = htmlspecialchars($_POST["email"]);
        $new_contact = htmlspecialchars($_POST["contact"]);
        $new_country = htmlspecialchars($_POST["country"]);
        $new_region = htmlspecialchars($_POST["region"]);
        $new_province = htmlspecialchars($_POST["province"]);
        $new_city = htmlspecialchars($_POST["city"]);
        $new_barangay = htmlspecialchars($_POST["barangay"]);
        $new_zipcode = htmlspecialchars($_POST["zipcode"]);
        $new_addressline1 = htmlspecialchars($_POST["address"]);
        $new_addressline2 = htmlspecialchars($_POST["address2"]);

        if (
            $new_firstname == $firstname &&
            $new_lastname == $lastname &&
            $new_email == $email &&
            $new_contact == $contact &&
            $new_country == $country &&
            $new_region == $region &&
            $new_province == $province &&
            $new_city == $city &&
            $new_barangay == $barangay &&
            $new_zipcode == $zipcode &&
            $new_addressline1 == $addressline1 &&
            $new_addressline2 == $addressline2
        ) {
            $message = "No changes have been made.";
        } else {
            $stmt = $conn->prepare("UPDATE shippingaddresses SET firstname=?, lastname=?, email=?, contact=?, country=?, region=?, province=?, city=?, barangay=?, zipcode=?, addressline1=?, addressline2=? WHERE userid=?");
            $stmt->bind_param("ssssssssssssi", $new_firstname, $new_lastname, $new_email, $new_contact, $new_country, $new_region, $new_province, $new_city, $new_barangay, $new_zipcode, $new_addressline1, $new_addressline2, $userid);

            if ($stmt->execute()) {
                $message = "success";
            } else {
                throw new Exception("Error: " . $stmt->error);
            }

            $stmt->close();
        }
    }
} catch (Exception $e) {
    $message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Delivery Address</title>
    <link rel="stylesheet" href="../public/css/customer/sidebar.css">
    <link rel="stylesheet" href="../public/css/customer/delivery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>

    </style>

</head>

<body>
    <section id="sidebar">
        <a href="../admin/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="MedLinkup Logo" class="logo">
            <span class="text"> MedLinkup</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="../admin/dashboard.php">
                    <i class='fas fa-clone'></i>
                    <span class="text"> Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-capsules'></i>
                    <span class="text">Inventory</span>
                </a>
                <ul class="submenu">
                    <li><a href="../admin/products.php">Products</a></li>
                    <li><a href="../admin/lowstock.php">Low Stock</a></li>
                    <li><a href="../admin/categories.php">Categories</a></li>
                </ul>
            </li>
            <li>
                <a href="../admin/order.php">
                    <i class='fas fa-shopping-bag'></i>
                    <span class="text"> Orders</span>
                </a>
            </li>
            <li>
                <a href="../admin/sales.php">
                    <i class='fas fa-chart-bar'></i>
                    <span class="text"> Sales</span>
                </a>
            </li>
            <li>
                <a href="../admin/customer.php">
                    <i class='fas fa-portrait'></i>
                    <span class="text"> Customers</span>
                </a>
            </li>
            <li>
                <a href="../admin/contact.php">
                    <i class='fas fa-envelope'></i>
                    <span class="text"> Contact</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text">Shipping Settings</span>
                </a>
                <ul class="submenu">
                    <li><a href="../admin/location.php">Location</a></li>
                    <li><a href="../admin/shippingfee.php">Shipping Fee</a></li>
                </ul>
            </li>

            <li>
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text"> Supplier</span>
                </a>
                <ul class="submenu">
                    <li><a href="../supplier/suppliershop.php">Order</a></li>
                    <li><a href="../admin/orderstatus.php">Order Status</a></li>
                    <li><a href="../admin/history.php">History</a></li>
                </ul>
            </li>
            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='fa fa-user-cog'></i>
                        <span class="text">System Maintenane</span>
                    </a>
                    <ul class="submenu">
                        <li class="active"><a href="../admin/about.php">About</a></li>
                        <li><a href="../admin/privacypolicy.php">Privacy Policy</a></li>
                        <li><a href="../admin/termsofservice.php">Terms of Service</a></li>
                    </ul>
                </li>
                <ul class="side-menu">
                    <li>
                        <a href="#">
                            <i class='fa fa-cogs'></i>
                            <span class="text">Settings</span>
                        </a>
                        <ul class="submenu">
                            <li class="active"><a href="../admin/delivery.php">Delivery Address</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="../logout.php" class="logout">
                            <i class='fas fa-user'></i>
                            <span class="text"> Logout</span>
                        </a>
                    </li>
                </ul>
    </section>


    <section id="content">
        <nav>
            <i class='fa-pills'></i>
            <a href="#" class="profile">
                <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg">
            </a>
        </nav>
    </section>
    <main>
        <div class="box-section">
            <div class="head-title">
                <div class="left">
                    <h1>Update Delivery Address</h1>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="add-location-section">

                            <div id="form-container">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                    enctype="multipart/form-data">

                                    <div class="mb-3">
                                        <label for="country">First Name:</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            placeholder="First Name"
                                            value="<?php echo isset($firstname) ? $firstname : ''; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Last Name:</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            placeholder="Last Name"
                                            value="<?php echo isset($lastname) ? $lastname : ''; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>"
                                            required>

                                    </div>

                                    <div class="mb-3">
                                        <label for="country">Contact:</label>
                                        <input type="number" class="form-control" id="contact" name="contact"
                                            placeholder="Contact" value="<?php echo isset($contact) ? $contact : ''; ?>"
                                            required>

                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Country:</label>
                                        <select class="form-control" id="country" name="country"
                                            onchange="fetchRegions(this.value)" required>
                                            <option value="" disabled>Select Country</option>
                                            <?php
                                            $sql = "SELECT DISTINCT country FROM availablelocations";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = ($country == $row['country']) ? 'selected' : '';
                                                    echo '<option value="' . $row['country'] . '" ' . $selected . '>' . $row['country'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <div class="mb-3">
                                        <label for="region">Region:</label>
                                        <select class="form-control" id="region" name="region"
                                            onchange="fetchRegions(this.value)" required>
                                            <option value="" disabled>Select Region</option>
                                            <?php
                                            $sql = "SELECT DISTINCT region FROM availablelocations";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = ($region == $row['region']) ? 'selected' : '';
                                                    echo '<option value="' . $row['region'] . '" ' . $selected . '>' . $row['region'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <div class="mb-3">
                                        <label for="province">Province:</label>
                                        <select class="form-control" id="province" name="province"
                                            onchange="fetchRegions(this.value)" required>
                                            <option value="" disabled>Select Province</option>
                                            <?php
                                            $sql = "SELECT DISTINCT province FROM availablelocations";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = ($province == $row['province']) ? 'selected' : '';
                                                    echo '<option value="' . $row['province'] . '" ' . $selected . '>' . $row['province'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <div class="mb-3">
                                        <label for="city">City:</label>
                                        <select class="form-control" id="city" name="city"
                                            onchange="fetchRegions(this.value)" required>
                                            <option value="" disabled>Select City</option>
                                            <?php
                                            $sql = "SELECT DISTINCT city FROM availablelocations";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = ($city == $row['city']) ? 'selected' : '';
                                                    echo '<option value="' . $row['city'] . '" ' . $selected . '>' . $row['city'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <div class="mb-3">
                                        <label for="barangay">Barangay:</label>
                                        <select class="form-control" id="barangay" name="barangay"
                                            onchange="fetchRegions(this.value)" required>
                                            <option value="" disabled>Select Barangay</option>
                                            <?php
                                            $sql = "SELECT DISTINCT barangay FROM availablelocations";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = ($city == $row['barangay']) ? 'selected' : '';
                                                    echo '<option value="' . $row['barangay'] . '" ' . $selected . '>' . $row['barangay'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country">Zip Code:</label>
                                        <input type="number" class="form-control" id="zipcode" name="zipcode"
                                            placeholder="Zip Code"
                                            value="<?php echo isset($zipcode) ? $zipcode : ''; ?>" required>

                                    </div>

                                    <div class="mb-3">
                                        <label for="country">Address:</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Address"
                                            value="<?php echo isset($addressline1) ? $addressline1 : ''; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country">Address 2:</label>
                                        <input type="text" class="form-control" id="address2" name="address2"
                                            placeholder="Address 2"
                                            value="<?php echo isset($addressline2) ? $addressline2 : ''; ?>" required>
                                    </div>



                                    <button type="submit" class="btn btn-submit">Update</button>
                                    <a href="./delivery.php" class="cancel-btn" style="display: inline-block; padding: 13px 16px; 
                                        background-color: #f44336; color: #fff; text-decoration: 
                                        none; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='#d32f2f';"
                                        onmouseout="this.style.backgroundColor='#f44336';">Cancel</a>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <!-- JavaScript -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
                Swal.fire({
                    title: 'Address updated successfully.',
                    text: 'You have successfully updated the deliver address.',
                    icon: 'success',
                    confirmButtonText: 'OK',                
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../customer/delivery.php';
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
    <script>
        function fetchRegions(country) {
            $.ajax({
                url: 'fetch_regions.php',
                type: 'POST',
                data: {
                    country: country
                },
                success: function (response) {
                    $('#region').html(response);
                    $('#region').prop('disabled', false);
                    $('#province').prop('disabled', true).val('');
                    $('#city').prop('disabled', true).val('');
                    $('#barangay').prop('disabled', true).val('');
                }
            });
        }

        function fetchProvinces(region) {
            $.ajax({
                url: 'fetch_provinces.php',
                type: 'POST',
                data: {
                    region: region
                },
                success: function (response) {
                    $('#province').html(response);
                    $('#province').prop('disabled', false);
                    $('#city').prop('disabled', true).val('');
                    $('#barangay').prop('disabled', true).val('');
                }
            });
        }

        function fetchCities(province) {
            $.ajax({
                url: 'fetch_cities.php',
                type: 'POST',
                data: {
                    province: province
                },
                success: function (response) {
                    $('#city').html(response);
                    $('#city').prop('disabled', false);
                    $('#barangay').prop('disabled', true).val('');
                }
            });
        }

        function fetchBarangays(city) {
            $.ajax({
                url: 'fetch_barangays.php',
                type: 'POST',
                data: {
                    city: city
                },
                success: function (response) {
                    $('#barangay').html(response);
                    $('#barangay').prop('disabled', false);
                }
            });
        }
    </script>


</body>

</html>