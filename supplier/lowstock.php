<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Low Stock</title>
    <link rel="stylesheet" href="../public/css/supplier/sidebar.css">
    <link rel="stylesheet" href="../public/css/supplier/lowstock.css">

    <!-- <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  
</head>

<body>
    <section id="sidebar">
        <a href="../supplier/dashboard.php" class="brand">
            <img src="../public/img/logo.png" alt="Pharmawell Logo" class="logo">
            <span class="text"> Pharmawell</span>
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
                    <li class="active"><a href="../supplier/lowstock.php">Low Stock</a></li>
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

    <section id="medicine-list">
        <main>
            <div class="search-bar">
                <div class="print">
                    <a href="#" class="btn-link"> 
                        <button>Print</button>
                    </a>
                </div>
                
                <input type="text" placeholder="Search...">
                <button><i class="fas fa-search"></i></button>
            </div>

            <h2>Low Stock Medicine List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Action</th> <!-- New column for actions -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="https://via.placeholder.com/100x100" alt="Medicine Image"></td>
                        <td>Sample</td>
                        <td class="price">&#8369;7.49</td>
                        <td>Sample</td>
                        <td>1</td>
                        <td class="actions">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    <!-- Add more table rows as needed -->
                    <tr>
                        <td><img src="https://via.placeholder.com/100x100" alt="Medicine Image"></td>
                        <td>Antibiotics</td>
                        <td class="price">&#8369;7.49</td>
                        <td>Sample</td>
                        <td>10</td>
                        <td class="actions">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    <!-- Add more table rows as needed -->
                </tbody>
            </table>
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
