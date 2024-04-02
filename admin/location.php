<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
    <link rel="stylesheet" href="../public/css/supplier/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/location.css">

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
                        <i class='fas fa-clone' ></i>
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
                        <i class='fas fa-shopping-bag' ></i>
                        <span class="text"> Orders</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../admin/pending.php">Pending</a></li>
                        <li><a href="../admin/completed.php">Completed</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../admin/sales.php">
                        <i class='fas fa-chart-bar' ></i>
                        <span class="text"> Sales</span>
                    </a>
                </li>
                <li>
                    <a href="../admin/customer.php">
                        <i class='fas fa-portrait' ></i>
                        <span class="text"> Customers</span>
                    </a>
                </li>
                <li>
                 <a href="#">
                        <i class='fas fa-clone' ></i>
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
                        <i class='fa fa-cogs' ></i>
                        <span class="text"> Settings</span>
                    </a>
                    <ul class="submenu">
                        <li class="active"><a href="../admin/location.php">Location</a></li>
                        <li><a href="../admin/shippingfee.php">Shipping Fee</a></li>

                    </ul>

                </li>
                <li>
                    <a href="#" class="logout">
                        <i class='fas fa-user' ></i>
                        <span class="text"> Logout</span>
                    </a>
                </li>
            </ul>
        </section>

        <section id="content">
		<nav>
            <i class='fa-pills' ></i>
			<a href="#" class="profile">
				<img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg">
			</a>
		</nav>
        </section>

   
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="box-section">
                    
            <div class="search-bar">
                <div class="add-button">
                    <a href="../admin/addlocation.php" class="btn-link"> 
                        <button>Add</button>
                    </a>
                </div>
                
                <input type="text" placeholder="Search...">
                <button><i class="fas fa-search"></i></button>
            </div>

         
                <?php
include '../src/config/config.php';

$message = ""; 

try {
  
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT country, region, province, city, barangay FROM availablelocations";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        echo '<h2>Available Location List</h2>';
        echo '<table class="table">';
        echo '<thead><tr><th>Country</th><th>Region</th><th>Province</th><th>City</th><th>Barangay</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['country'] . '</td>';
            echo '<td>' . $row['region'] . '</td>';
            echo '<td>' . $row['province'] . '</td>';
            echo '<td>' . $row['city'] . '</td>';
            echo '<td>' . $row['barangay'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "No available locations found";
    }

    $conn->close();
} catch (Exception $e) {
    $message = $e->getMessage();
}
?>

              
</tbody>
            </table>
                </div>
            </div>
        </div>
    </div>

        </main>
    </section>

    <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>
