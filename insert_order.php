<?php
include './src/config/config.php';
date_default_timezone_set('Asia/Manila');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userID = $_POST['userID'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    $totalProductPrice = $_POST['totalProductPrice']; 
    $shippingFee = $_POST['shippingFee']; 
    $totalPrice = $_POST['totalPrice'];
    $status = $_POST['status'];
    $paymentMethod = $_POST['paymentMethod'];
    $addressID = $_POST['addressID'];
    $transactionID = $_POST['transactionID'];
    $discount_amount = $_POST['discount_amount'];
    $orderDate = date("Y-m-d H:i:s");


    $sql = "INSERT INTO orderprocess (userid, productid, quantity, totalproductprice, shippingfee, totalprice, orderdate, status, paymentmethod, addressid, transactionid, discount_percentage) 
    VALUES ('$userID', '$productID', '$quantity', '$totalProductPrice', '$shippingFee', '$totalPrice', '$orderDate', '$status', '$paymentMethod', '$addressID', '$transactionID', '$discount_amount')";


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