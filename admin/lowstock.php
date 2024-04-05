<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Low Stock</title>
    <link rel="stylesheet" href="../public/css/admin/sidebar.css">
    <link rel="stylesheet" href="../public/css/admin/lowstock.css">
    <!-- <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

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
                    <li class="active"><a href="../admin/lowstock.php">Low Stock</a></li>
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
                        <li><a href="../admin/location.php">Location</a></li>
                        <li><a href="../admin/shippingfee.php">Shipping Fee</a></li>

                    </ul>
            </li>
            <li>
                <a href="../logout.php" class="logout">
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
                <div class="print-button">
                  
                <button id="print-button">Print</button>
                    </a>
                </div>
                
                <input type="text" placeholder="Search...">
                <button><i class="fas fa-search"></i></button>
            </div>


            <h1 class="lefth">Low Stock Medicine List</h1>
            <table class="table" id="medicine-table">
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
        $sql = "SELECT * FROM products WHERE stock BETWEEN 0 AND 20";
        $result = $conn->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
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
                echo "<a href='#' class='button-like btn btn-sm btn-primary'>";
                echo "<i class='fas fa-trash-alt'></i>";
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
    </section>
    <?php

try {

    $sql = "SELECT * FROM products WHERE stock <= 20"; 
    $result = $conn->query($sql);
    $low_stock_products = [];
    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $low_stock_products[] = $row;
        }
    }

    $low_stock_products_json = json_encode($low_stock_products);
} catch (Exception $e) {
    $error_message = "Error fetching low stock products: " . $e->getMessage();
}

$conn->close();
?>

    <!-- node -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- Link Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        var lowStockProducts = <?php echo isset($low_stock_products_json) ? $low_stock_products_json : '[]'; ?>;

        lowStockProducts.forEach(function(product) {
            toastr.options.positionClass = 'toast-bottom-right'; 
            toastr.options.progressBar = true; 
            toastr.options.closeButton = true; 
            toastr.warning('<div class="toast-title">Low stock for:</div><div class="toast-message">' + product.productname + ' (' + product.stock + ' remaining)</div>');
        });
    });
</script>
    <script>
        function previewImage(event) {
            var preview = document.getElementById('preview-image');
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.style.display = 'block';
                preview.querySelector('img').src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
 <script>
    document.getElementById('print-button').addEventListener('click', function() {
        var table = document.getElementById('medicine-table');
        if (table) {
            var printWindow = window.open('', '_blank');
            if (printWindow) {
                printWindow.document.open();
                printWindow.document.write('<html><head><title>MedLinkup - Low Stock Medicine List</title>');

                printWindow.document.write('<style>');
                printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
                printWindow.document.write('th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; }');
                printWindow.document.write('th { background-color: #f2f2f2; }');
                printWindow.document.write('</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h1>MedLinkup - Low Stock Medicine List</h1>');

                printWindow.document.write('<table>');

                printWindow.document.write('<thead><tr>');
                printWindow.document.write('<th>Image</th>');
                printWindow.document.write('<th>Name</th>');
                printWindow.document.write('<th>Price</th>');
                printWindow.document.write('<th>Category</th>');
                printWindow.document.write('<th>Stock</th>');
                printWindow.document.write('</tr></thead>');

                printWindow.document.write('<tbody>');
                var tbody = table.getElementsByTagName('tbody')[0];
                for (var i = 0; i < tbody.rows.length; i++) {
                    printWindow.document.write('<tr>');

                    for (var j = 0; j < 3; j++) {
                        printWindow.document.write(tbody.rows[i].cells[j].outerHTML);
                    }

                    printWindow.document.write(tbody.rows[i].cells[4].outerHTML); 
                    printWindow.document.write(tbody.rows[i].cells[5].outerHTML); 
                    printWindow.document.write('</tr>');
                }
                printWindow.document.write('</tbody>');
                printWindow.document.write('</table>');
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            } else {
                alert('Unable to open print window.');
            }
        } else {
            alert('Table not found.');
        }
    });
</script>





</body>

</html>
