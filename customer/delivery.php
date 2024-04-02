<?php
include '../src/config/config.php';

session_start();

$message = "";

try {
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userid = $_SESSION['userid'];
        $firstname = htmlspecialchars($_POST["firstname"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $email = htmlspecialchars($_POST["email"]);
        $contact = htmlspecialchars($_POST["contact"]);
        $country = htmlspecialchars($_POST["country"]);
        $region = htmlspecialchars($_POST["region"]);
        $province = htmlspecialchars($_POST["province"]);
        $city = htmlspecialchars($_POST["city"]);
        $barangay = htmlspecialchars($_POST["barangay"]);
        $zipcode = htmlspecialchars($_POST["zipcode"]);
        $addressline1 = htmlspecialchars($_POST["address"]);
        $addressline2 = htmlspecialchars($_POST["address2"]);

        $stmt = $conn->prepare("INSERT INTO shippingaddresses (userid, firstname, lastname, email, contact, country, region, province, city, barangay, zipcode, addressline1, addressline2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssssss", $userid, $firstname, $lastname, $email, $contact, $country, $region, $province, $city, $barangay, $zipcode, $addressline1, $addressline2);

        if ($stmt->execute()) {
            $message = "success";
        } else {
            throw new Exception("Error: " . $stmt->error);
        }

        $stmt->close();
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
    <title>Delivery Address</title>
    <!-- <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../public/css/customer/sidebar.css">
    <link rel="stylesheet" href="../public/css/customer/delivery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        
    </style>
   
</head>
<body>
    <section id="sidebar">
        <a href="../supplier/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="Pharmawell Logo" class="logo">
            <span class="text"> Pharmawell</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="../customer/dashboard.php">
                    <i class="fas fa-clone"></i>
                    <span class="text"> Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-portrait"></i>
                    <span class="text"> Profile</span>
                </a>
                <ul class="submenu">
                    <li><a href="../customer/myprofile.php">My Profile</a></li>
                    <li class="active"><a href="../admin/categories.php">Delivery Address</a></li>
                </ul>
            </li>
            <li>
                <a href="../cart.php">
                    <i class="fas fa-cart-plus"></i>
                    <span class="text"> Cart</span>
                </a>
            </li>
            <li>
                <a href="../customer/pendingorder.php">
                    <i class="fas fa-cart-arrow-down"></i>
                    <span class="text"> Pending Order</span>
                </a>
            </li>
            <li >
                <a href="../customer/history.php">
                    <i class="fas fa-shopping-basket"></i>
                    <span class="text"> History</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span class="text"> Settings</span>
                </a>
                <ul class="submenu">
                    <li><a href="../customer/changepassword.php">Change Password</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="logout">
                    <i class="fas fa-user"></i>
                    <span class="text"> Logout</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <i class="fa-pills"></i>
            <a href="#" class="profile">
                <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg" alt="Profile Picture">
            </a>
        </nav>
    </section>
    <main>
        <div class="box-section">
        <div class="head-title">
            <div class="left">
                <h1>Delivery Address</h1>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="add-location-section">
                   
                        <div id="form-container">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                           
                               <div class="mb-3">
                                    <label for="country">First Name:</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                     placeholder="First Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="country">Last Name:</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                     placeholder="Last Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="country">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                     placeholder="Email" required>
                                </div>
                              
                                <div class="mb-3">
                                    <label for="country">Contact:</label>
                                    <input type="number" class="form-control" id="contact" name="contact"
                                     placeholder="Contact" required>
                                </div>
                                <div class="mb-3">
    <label for="country">Country:</label>
    <select class="form-control" id="country" name="country" onchange="fetchRegions(this.value)" required>
        <option value="" disabled selected>Select Country</option>
        <?php
        // Fetch countries from the database and populate the dropdown options
        include 'config.php'; // Include database configuration file

        $sql = "SELECT DISTINCT country FROM availablelocations";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['country'] . '">' . $row['country'] . '</option>';
            }
        }
        $conn->close();
        ?>
    </select>
</div>

<div class="mb-3">
    <label for="region">Region:</label>
    <select class="form-control" id="region" name="region" disabled onchange="fetchProvinces(this.value)" required>
        <option value="" disabled selected>Select Region</option>
    </select>
</div>

<div class="mb-3">
    <label for="province">Province:</label>
    <select class="form-control" id="province" name="province" disabled onchange="fetchCities(this.value)" required>
        <option value="" disabled selected>Select Province</option>
    </select>
</div>

<div class="mb-3">
    <label for="city">City:</label>
    <select class="form-control" id="city" name="city" disabled onchange="fetchBarangays(this.value)" required>
        <option value="" disabled selected>Select City</option>
    </select>
</div>

<div class="mb-3">
    <label for="barangay">Barangay:</label>
    <select class="form-control" id="barangay" name="barangay" disabled required>
        <option value="" disabled selected>Select Barangay</option>
    </select>
</div>

                                <div class="mb-3">
                                    <label for="country">Zip Code:</label>
                                    <input type="number" class="form-control" id="zipcode" name="zipcode"
                                     placeholder="Zip Code" required>
                                </div>

                                <div class="mb-3">
                                    <label for="country">Address:</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                     placeholder="Address" required>
                                </div>

                                 <div class="mb-3">
                                    <label for="country">Address 2:</label>
                                    <input type="text" class="form-control" id="address2" name="address2"
                                     placeholder="Address 2" required>
                                </div>
                               
                               
            
                                <button type="submit" class="btn btn-submit">Add</button>
                                <a href="./location.php" class="cancel-btn" 
                                        style="display: inline-block; padding: 13px 16px; 
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
                    title: 'Address added successfully.',
                    text: 'You have successfully added the deliver address.',
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
<script>
function fetchRegions(country) {
    $.ajax({
        url: 'fetch_regions.php',
        type: 'POST',
        data: {country: country},
        success: function(response) {
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
        data: {region: region},
        success: function(response) {
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
        data: {province: province},
        success: function(response) {
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
        data: {city: city},
        success: function(response) {
            $('#barangay').html(response);
            $('#barangay').prop('disabled', false);
        }
    });
}
</script>

    
</body>
</html>