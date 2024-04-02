<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product</title>
    <link rel="stylesheet" href="../public/css/supplier/sidebar.css">
    <link rel="stylesheet" href="../public/css/supplier/addproducts.css">

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
                    <li><a href="../supplier/products.php">Products</a></li>
                    <li><a href="#">Low Stock</a></li>
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
                <a href="#" class="logout">
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
        <div class="box-section">
        <div class="head-title">
            <div class="left">
                <h1>Add Product</h1>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="add-product-section">
                        <div id="image-container">
                            <div id="preview-image">
                                <img src="https://via.placeholder.com/350x350" alt="Preview Image">
                            </div>
                            <input type="file" class="form-control" id="image" name="image"
                                accept="image/*" onchange="previewImage(event)" required>
                        </div>
                        <div id="form-container">
                            <form action="#" method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="categoryname">Product Name</label>

                                    <input type="text" class="form-control" id="productName" name="productName"
                                        placeholder="Product Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="categoryname">Price</label>
                                    <input type="number" class="form-control" id="price" name="price"
                                        placeholder="Price" min="0" step="0.01" required>
                                </div>
                                <div class="mb-3">
                                    <label for="categoryname">Product Details</label>
                                    <textarea class="form-control" id="details" name="details" rows="4"
                                        placeholder="Product Details" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="categoryname">Select Category</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="" disabled selected>Select Category</option>
                                        <option value="category1">Category 1</option>
                                        <option value="category2">Category 2</option>
                                        <option value="category3">Category 3</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="categoryname">Stock</label>
                                    <input type="text" class="form-control" id="stock" name="stock"
                                        placeholder="Stock" required>
                                </div>

                                <button type="submit" class="btn btn-submit">Add Product</button>
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
</body>

</html>
