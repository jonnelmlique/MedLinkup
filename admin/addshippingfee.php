<?php
include '../src/config/config.php';

$message = "";

try {

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $region = htmlspecialchars($_POST["region"]);
        $fee = htmlspecialchars($_POST["fee"]);

        $stmt = $conn->prepare("SELECT * FROM shippingfees WHERE region = ?");
        $stmt->bind_param("s", $region);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            throw new Exception("A shipping fee for the selected region already exists.");
        } else {

            $stmt = $conn->prepare("SELECT locationid FROM availablelocations WHERE region = ?");
            $stmt->bind_param("s", $region);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $locationid = $row["locationid"];

                $stmt = $conn->prepare("INSERT INTO shippingfees (locationid, region, fee) VALUES (?, ?, ?)");
                $stmt->bind_param("isd", $locationid, $region, $fee);

                if ($stmt->execute()) {
                    $message = "success";
                } else {
                    throw new Exception("Error: " . $stmt->error);
                }

                $stmt->close();
            } else {
                throw new Exception("No location found for the selected region.");
            }
        }
    }
} catch (Exception $e) {
    $message = $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/addshippingfee.css">

    <!-- <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <section id="sidebar">
        <a href="../supplier/dashboard.php" class="brand">
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
                <a href="#">
                    <i class='fas fa-shopping-bag'></i>
                    <span class="text"> Orders</span>
                </a>
                <ul class="submenu">
                    <li><a href="../admin/pending.php">Pending</a></li>
                    <li><a href="../admin/completed.php">Completed</a></li>
                </ul>
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
                <a href="#">
                    <i class='fas fa-clone'></i>
                    <span class="text"> Supplier</span>
                </a>
                <ul class="submenu">
                    <li><a href="../public/Shared/Layout/error.php">Order</a></li>
                    <li><a href="../public/Shared/Layout/error.php">Pending Order</a></li>
                    <li><a href="../public/Shared/Layout/error.php">Completed Order</a></li>
                    <li><a href="../public/Shared/Layout/error.php">Add Supplier</a></li>
                </ul>
            </li>

            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='fa fa-cogs'></i>
                        <span class="text"> Settings</span>
                    </a>
                    <ul class="submenu">
                        <li ><a href="../admin/location.php">Location</a></li>
                        <li class="active"><a href="../admin/shippingfee.php">shipping Fee</a></li>

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
                    <h1>Add Shipping Fee</h1>
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
                                        <label for="region">Region</label>
                                        <select class="form-control" id="region" name="region" required>
                                            <option value="" disabled selected>Select Region</option>

                                            <?php
        include '../src/config/config.php';

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT DISTINCT region FROM availablelocations";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['region'] . '">' . $row['region'] . '</option>';
            }
        }
        $conn->close();
        ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fee">Fee</label>
                                        <input type="number" class="form-control" id="fee" name="fee" placeholder="Fee"
                                            required>
                                    </div>
                                    <button type="submit" class="btn btn-submit">Add</button>
                                    <a href="./shippingfee.php" class="cancel-btn" 
                                        style="display: inline-block; padding: 13px 16px; 
                                        background-color: #f44336; color: #fff; text-decoration: 
                                        none; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;"
                                        onmouseover="this.style.backgroundColor='#d32f2f';"
                                         onmouseout="this.style.backgroundColor='#f44336';">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- node -->
    <script src=zznode_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
                Swal.fire({
                    title: 'Shipping Fee Added Successfully!',
                    text: 'You have successfully added the Shipping Fee.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'View Shipping Fee'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Do something if user clicks OK
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = '../admin/shippingfee.php';
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