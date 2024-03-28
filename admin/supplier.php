<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Customer</title>
        <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="./sidebar.css">
            <link rel="stylesheet" href="./supplier.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        
     </head>
   
    <body>
        <section id="sidebar">
            <a href="admin.php" class="brand">
                <img src="logo.png">
                <span class="text"> Pharmawell</span>
            </a>
            <ul class="side-menu top">
                <li>
                    <a href="admin.php">
                        <i class='fas fa-clone' ></i>
                        <span class="text"> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="products.php">
                        <i class='fas fa-capsules' ></i>
                        <span class="text"> Products</span>
                    </a>
                </li>
                <li>
                    <a href="orders.php">
                        <i class='fas fa-shopping-bag' ></i>
                        <span class="text"> Orders</span>
                    </a>
                </li>
                <li>
                    <a href="sales.php">
                        <i class='fas fa-chart-bar' ></i>
                        <span class="text"> Sales</span>
                    </a>
                </li>
                <li>
                    <a href="customer.php">
                        <i class='fas fa-portrait' ></i>
                        <span class="text"> Customers</span>
                    </a>
                </li>
                <li class="active">
                    <a href="supplier.php">
                        <i class='fas fa-clone' ></i>
                        <span class="text"> Supplier</span>
                    </a>
                </li>
            </ul>
            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='fa fa-cogs' ></i>
                        <span class="text"> Settings</span>
                    </a>
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
                <a href="admin.php" class="nav-link">Pharmawell</a>
                <a href="#" class="profile">
                    <img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg">
                </a>
            </nav>
            </section>

            <section id="supplier">
                <main>
                    <h2>Supplier</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stocks</th>
                                <th>Supplier</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="https://via.placeholder.com/100x100" alt="Medicine Image"></td>
                                <td>Antibiotics</td>
                                <td class="price">$7.49</td>
                                <td>40</td>
                                <td>Mercury Drugstore </td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/100x100" alt="Medicine Image"></td>
                                <td>Antibiotics</td>
                                <td class="price">$7.49</td>
                                <td>40</td>
                                <td>Mercury Drugstore </td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/100x100" alt="Medicine Image"></td>
                                <td>Antibiotics</td>
                                <td class="price">$7.49</td>
                                <td>40</td>
                                <td>Mercury Drugstore </td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/100x100" alt="Medicine Image"></td>
                                <td>Antibiotics</td>
                                <td class="price">$7.49</td>
                                <td>40</td>
                                <td>Mercury Drugstore </td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/100x100" alt="Medicine Image"></td>
                                <td>Antibiotics</td>
                                <td class="price">$7.49</td>
                                <td>40</td>
                                <td>Mercury Drugstore </td>
                            </tr>
                        </tbody>
                    </table>
                </main>
            </section>
    
        <!-- node -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./node_modules/bootstrap/js/src/sidebar.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        
    </body>
    </html>