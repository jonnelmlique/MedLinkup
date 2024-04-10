<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>

    <link rel="stylesheet" href="../public/css/admin/lowstockprint.css">

</head>

<body>

    <div id="printSection" class="receipt">
        <img src="../public/img/medlinkuplandscape.png" alt="MedLinkup Logo" class="logo">

        <h1>Product Stocks</h1>
        <div class="details">

            <table class="table" id="medicine-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Stock</th>

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
                                echo "<td>{$row['productname']}</td>";
                                echo "<td class='price'>₱{$row['price']}</td>";
                                echo "<td>{$row['productcategory']}</td>";
                                echo "<td>{$row['stock']}</td>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No low stock products found</td></tr>";
                        }
                    } catch (Exception $e) {
                        echo "<tr><td colspan='7'>Error fetching low stock products: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button id="printButton" style="display: none;">Print Low Stock Products</button>
        </div>
    </div>

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
        printReceipt(); // Automatically trigger print on page load
    };
    </script>
</body>

</html>