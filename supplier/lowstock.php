<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
    <link rel="stylesheet" href="../public/css/supplier/sidebar.css">
    <link rel="stylesheet" href="../public/css/supplier/products.css">

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
                <a href="../supplier/dashboard.php">
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
                    <li class="active"><a href="../supplier/products.php">Products</a></li>
                    <li><a href="../supplier/lowstock.php">Low Stock</a></li>
                    <li><a href="../supplier/unavailableproducts.php">Unavailable Products</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-shopping-bag'></i>
                    <span class="text"> Orders</span>
                </a>
                <ul class="submenu">
                    <li><a href="../supplier/pending.php">Pending</a></li>
                    <li><a href="../supplier/completed.php">Completed</a></li>
                </ul>
            </li>
            <li>
                <a href="sales.php">
                    <i class='fas fa-chart-bar'></i>
                    <span class="text"> Sales</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class='fa fa-cogs'></i>
                    <span class="text"> Settings</span>
                </a>
                <ul class="submenu">
                    <li><a href="../supplier/manageaccount.php">Manage Account</a></li>
                    <li><a href="../supplier/changepassword.php">Change Password</a></li>
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
                <img src="../public/img/logo.png">
            </a>
        </nav>
    </section>

    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="box-section">

                        <div class="search-bar">

                            <div class="print">
                                <button class="printLowStock">Print
                                </button>
                            </div>

                            <input type="text" id="searchInput" placeholder="Search...">
                            <button disabled><i class="fas fa-search"></i></button>

                        </div>

                        <h1 class="lefth">Low Stock Medicine List </h1>
                        <table class="table" id="productTable">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Supplier Price</th>
                                    <th>Category</th>
                                    <th>Supplier Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../src/config/config.php';

                                try {
                                    $sql = "SELECT * FROM products WHERE supplierprice IS NOT NULL AND supplierstock IS NOT NULL AND supplierstock BETWEEN 0 AND 20";
                                    $result = $conn->query($sql);

                                    if ($result !== false && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td><img src='../productimg/{$row['image']}' alt='{$row['productname']}' style='width: 100px; height: auto;'></td>";
                                            echo "<td>{$row['productname']}</td>";
                                            echo "<td class='supplierprice'>₱{$row['supplierprice']}</td>";
                                            echo "<td>{$row['productcategory']}</td>";
                                            echo "<td>{$row['supplierstock']}</td>";
                                            echo "<td class='actions'>";
                                            echo "<a href='../supplier/editproducts.php?id=" . $row["productid"] . "' class='button-like btn btn-sm btn-primary'>";
                                            echo "<i class='fas fa-edit'></i>";
                                            echo "</a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No products found</td></tr>";
                                    }
                                } catch (Exception $e) {
                                    echo "<tr><td colspan='7'>Error fetching products: " . $e->getMessage() . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>