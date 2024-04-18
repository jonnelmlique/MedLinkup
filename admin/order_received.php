<?php
include '../src/config/config.php';

if(isset($_POST['transactionid'])) {
    $transactionid = mysqli_real_escape_string($conn, $_POST['transactionid']);
    date_default_timezone_set('Asia/Manila');
    $currentTimestamp = date("Y-m-d H:i:s");

    $updateQuery = "UPDATE adminorderprocess SET status = 'Completed', ordercompleted = '$currentTimestamp' WHERE transactionid = '$transactionid'";

    if(mysqli_query($conn, $updateQuery)) {
        echo "Order status updated to Completed";

        $updateStockSQL = "UPDATE products SET stock = stock + (SELECT quantity FROM adminorderprocess WHERE transactionid = '$transactionid') WHERE productid IN (SELECT productid FROM adminorderprocess WHERE transactionid = '$transactionid')";
        if(mysqli_query($conn, $updateStockSQL)) {
            echo "\nProduct stock updated successfully";
        } else {
            echo "\nError updating product stock: " . mysqli_error($conn);
        }

    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
} else {
    echo "Transaction ID not provided";
}
?>