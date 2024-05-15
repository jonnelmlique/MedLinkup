<?php
include '../src/config/config.php';

try {
    $current_year_month = date('Y-m');

    // Construct the SQL query to fetch orders for the current month
    $sql_orders = "SELECT op.*, p.productname, u.username, op.totalprice
                    FROM orderprocess op
                    JOIN products p ON op.productid = p.productid
                    JOIN users u ON op.userid = u.userid
                    WHERE op.status = 'Completed' 
                    AND DATE_FORMAT(op.ordercompleted, '%Y-%m') = '$current_year_month'
                    GROUP BY op.transactionid 
                    ORDER BY op.ordercompleted DESC";
    $result_orders = $conn->query($sql_orders);
    $num_orders = $result_orders->num_rows;

    $overall_total = 0;
    $sales_history = array();
    while ($row = $result_orders->fetch_assoc()) {
        $overall_total += $row['totalprice'];
        $sales_history[] = $row;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale</title>
    <link rel="stylesheet" href="../public/css/admin/lowstockprint.css">

</head>

<body>
    <div id="printSection" class="receipt">
        <img src="../public/img/medlinkuplandscape.png" alt="MedLinkup Logo" class="logo">

        <h1>Monthly Sales</h1>
        <div class="details">
            <p>Overall Monthly Total: <?php echo number_format($overall_total, 2, '.', ','); ?></p>
            <table class="table" id="medicine-table">
                <thead>
                    <tr>
                        <th>Order by</th>
                        <th>Product</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales_history as $row): ?>
                    <tr onclick="window.location='orderdetails.php?transactionid=<?php echo $row['transactionid']; ?>';"
                        style="cursor: pointer;">
                        <td>
                            <p><?php echo $row['username']; ?></p>
                        </td>
                        <td>
                            <p><?php echo $row['productname']; ?></p>
                        </td>
                        <td>
                            <p><?php echo number_format($row['totalprice'], 2, '.', ','); ?></p>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button id="printButton" style="display: none;">Print Sales</button>
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
        printReceipt();
    };
    </script>
</body>

</html>