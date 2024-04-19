<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="../public/css/customer/orderreceipt.css">

</head>

<body>
    <?php

    if (isset($_GET['transactionid'])) {
        $transactionid = $_GET['transactionid'];

        $query = "SELECT 
        o.transactionid,
        u.username, 
        p.productid,
        p.productname, 
        p.price, 
        p.image,
        o.quantity, 
        o.shippingfee,
        o.totalproductprice,
        o.totalprice, 
        o.orderdate, 
        o.ordercompleted,
        o.status, 
        o.paymentmethod,
        o.quantity,
        CONCAT(s.firstname, ' ', s.lastname) AS flname,
        CONCAT(s.addressline1, ', ', s.addressline2, ', ', s.city, ', ', s.province, ', ', s.country) AS address 
    FROM 
        orderprocess o
    JOIN 
        users u ON o.userid = u.userid
    JOIN 
        products p ON o.productid = p.productid
    JOIN 
        shippingaddresses s ON o.addressid = s.addressid
    WHERE 
        o.transactionid = '$transactionid'";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $transactionDetails = mysqli_fetch_assoc($result); // Fetch the transaction details
            ?>
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="pending-section">
                        <h1 class="lefth">Order Details</h1>
                        <?php
                                if (!empty($transactionDetails['status']) && $transactionDetails['status'] === 'Completed') {
                                    echo '<button class="printReceipt" data-transactionid="' . $transactionid . '">Print Receipt</button>';
                                }
                                ?>
                        <div class="customerinformation">
                            <p><strong>Name:</strong> <?php echo $transactionDetails['flname']; ?></p>
                            <p><strong>Username:</strong> <?php echo $transactionDetails['username']; ?></p>
                            <p><strong>Shipping Address:</strong> <?php echo $transactionDetails['address']; ?></p>
                        </div>
                        <hr>

                        <?php
                                mysqli_data_seek($result, 0);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                        <a href="../product.php?id=<?php echo $row['productid']; ?>"
                            style="text-decoration: none; color: inherit;">
                            <div class="product-box">
                                <div class="product-details">
                                    <img src="../productimg/<?php echo $row['image']; ?>"
                                        alt="<?php echo $row['productname']; ?>" class="product-image">
                                    <div class="product-info">
                                        <div class="product-name"><?php echo $row['productname']; ?></div>
                                        <div class="product-status">Quantity: <span
                                                class="status <?php echo strtolower($row['quantity']); ?>"><?php echo $row['quantity']; ?></span>
                                        </div>
                                        <div class="product-price price">₱<?php echo $row['price']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php
                                }
                                ?>

                        <hr>
                        <div class="transactiondetails">
                            <p><strong>Transaction ID:</strong> <?php echo $transactionDetails['transactionid']; ?></p>
                            <p><strong>Merchandise Subtotal:</strong>
                                ₱<?php echo $transactionDetails['totalproductprice']; ?></p>
                            <p><strong>Shipping Fee:</strong> ₱<?php echo $transactionDetails['shippingfee']; ?></p>
                            <p><strong>Order Total:</strong> ₱<?php echo $transactionDetails['totalprice']; ?></p>
                            <p><strong>Payment Method:</strong> <?php echo $transactionDetails['paymentmethod']; ?></p>
                            <p><strong>Order Date:</strong> <?php echo $transactionDetails['orderdate']; ?></p>
                            <?php if (!empty($transactionDetails['ordercompleted'])): ?>
                            <p><strong>Order Completed:</strong> <?php echo $transactionDetails['ordercompleted']; ?>
                            </p>
                            <?php endif; ?>
                            <p><strong>Status: </strong><?php echo $transactionDetails['status']; ?></p>

                        </div>

                    </div>
                </div>

            </div>


        </div>

    </main>
    <?php
        } else {
            echo "<p>No products found for this order.</p>";
        }
    } else {
        echo "<p>Transaction ID not provided.</p>";
    }
    ?>

    <script>
    function printReceipt() {
        var printContents = document.getElementById("printSection").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    document.getElementById('printButton').addEventListener('click', printReceipt);

    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const transactionid = urlParams.get('transactionid');
        if (transactionid) {
            printReceipt();
        }
    };
    </script>
</body>

</html>