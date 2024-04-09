<?php
include '../src/config/config.php';
if(isset($_POST['transactionid'])) {
    $transactionid = mysqli_real_escape_string($conn, $_POST['transactionid']);
    date_default_timezone_set('Asia/Manila');
    $currentTimestamp = date("Y-m-d H:i:s");
        $updateQuery = "UPDATE orderprocess SET status = 'Completed', ordercompleted = '$currentTimestamp' WHERE transactionid = '$transactionid'";
    if(mysqli_query($conn, $updateQuery)) {
        echo "Order status updated to Completed";
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
} else {
    echo "Transaction ID not provided";
}
?>