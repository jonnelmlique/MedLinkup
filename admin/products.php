<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/products.css">

    <!-- <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

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
                    <li class="active"><a href="../admin/products.php">Products</a></li>
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
                        <i class='fa fa-cogs'></i>
                        <span class="text"> Settings</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../admin/delivery.php">Delivery Address</a></li>


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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="box-section">

                        <div class="search-bar">
                            <div class="add-button">
                                <a href="../admin/addproducts.php" class="btn-link">
                                    <button>Add</button>
                                </a>
                            </div>
                            <div class="print">
                                <button class="printLowStock">Print
                                </button>
                            </div>

                            <input type="text" id="searchInput" placeholder="Search...">
                            <button disabled><i class="fas fa-search"></i></button>

                        </div>

                        <h1 class="lefth">Medicine List</h1>
                        <table class="table" id="productTable">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Details</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../src/config/config.php';

                                try {
                                    $sql = "SELECT * FROM products";
                                    $result = $conn->query($sql);

                                    if ($result !== false && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td><img src='../productimg/{$row['image']}' alt='{$row['productname']}' style='width: 100px; height: auto;'></td>";
                                            echo "<td>{$row['productname']}</td>";
                                            echo "<td class='price'>₱{$row['price']}</td>";
                                            echo "<td>{$row['productdetails']}</td>";
                                            echo "<td>{$row['productcategory']}</td>";
                                            echo "<td>{$row['stock']}</td>";
                                            echo "<td class='actions'>";
                                            echo "<a href='../admin/editproducts.php?id=" . $row["productid"] . "' class='button-like btn btn-sm btn-primary'>";
                                            echo "<i class='fas fa-edit'></i>";
                                            echo "</a>";
                                            echo "<a href='../supplier/product.php?id=" . $row["productid"] . "' class='button-like btn btn-sm btn-primary'>";

                                            echo "<i class='fas fa-redo-alt'></i>";
                                            echo "</a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr>
                                    <td colspan='7'>No products found</td>
                                </tr>";
                                    }
                                } catch (Exception $e) {
                                    echo "<tr>
                                    <td colspan='7'>Error fetching products: " . $e->getMessage() . "</td>
                                </tr>";
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

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().trim();
            if (searchText !== '') {
                $.ajax({
                    url: 'search.php',
                    type: 'post',
                    data: {
                        search: searchText
                    },
                    success: function(response) {
                        $('#productTable tbody').html(response);
                    }
                });
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $(".printLowStock").click(function(e) {
            e.preventDefault();
            window.open('product-print.php', '_blank', 'width=800,height=600');
        });
    });
    </script>

</body>

</html>