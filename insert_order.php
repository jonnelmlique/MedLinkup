<?php
include './src/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userID = $_POST['userID'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    $totalPrice = $_POST['totalPrice'];
    $status = $_POST['status'];
    $paymentMethod = $_POST['paymentMethod'];
    $addressID = $_POST['addressID'];
    $transactionID = $_POST['transactionID'];

    $sql = "INSERT INTO orderprocess (userid, productid, quantity, totalprice, status, paymentmethod, addressid, transactionid) 
            VALUES ('$userID', '$productID', '$quantity', '$totalPrice', '$status', '$paymentMethod', '$addressID', '$transactionID')";

    if (mysqli_query($conn, $sql)) {

        $updateStockSQL = "UPDATE products SET stock = stock - $quantity WHERE productid = $productID";
        mysqli_query($conn, $updateStockSQL);

        $removeFromCartSQL = "DELETE FROM cart WHERE userid = $userID AND productid = $productID";
        mysqli_query($conn, $removeFromCartSQL);

        echo "Order inserted successfully";
    } else {

        echo "Error inserting order: " . mysqli_error($conn);
    }
} else {

    echo "Invalid request";
}
?>
