<?php
include '../src/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['transactionid']) && isset($_POST['status'])) {
        $transactionid = mysqli_real_escape_string($conn, $_POST['transactionid']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $query = "UPDATE orderprocess SET status = '$status' WHERE transactionid = '$transactionid'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Order status updated successfully";
        } else {
            echo "Error updating order status: " . mysqli_error($conn);
        }
    } else {
        echo "Transaction ID or status not provided";
    }
} else {
    echo "Invalid request method";
}
?>