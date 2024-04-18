<?php
include '../src/config/config.php';
session_start();

$message = "";

if (isset($_POST['productId'], $_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];

    if (!is_numeric($productId) || !is_numeric($quantity) || $quantity <= 0) {
        $message = "Invalid product ID or quantity.";
    } else {
        if (!isset($_SESSION['userid'])) {
            $message = "You are not logged in.";
        } else {
            $userId = $_SESSION['userid'];

            $sql_product = "SELECT productname, supplierprice, image, supplierstock FROM products WHERE productid = ?";
            $stmt_product = $conn->prepare($sql_product);
            $stmt_product->bind_param("i", $productId);
            $stmt_product->execute();
            $stmt_product->bind_result($productname, $supplierprice, $image, $supplierstock);
            $stmt_product->fetch();
            $stmt_product->close();

            if ($supplierstock <= 0) {
                $message = "No stock left.";
            } elseif ($quantity > $supplierstock) {
                $message = "Only $supplierstock items left in stock.";
            } else {
                $sql_check = "SELECT cartid FROM cart WHERE userid = ? AND productid = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bind_param("ii", $userId, $productId);
                $stmt_check->execute();
                $stmt_check->store_result();

                if ($stmt_check->num_rows > 0) {
                    $sql_update = "UPDATE cart SET quantity = quantity + ? WHERE userid = ? AND productid = ?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("iii", $quantity, $userId, $productId);
                    $stmt_update->execute();
                    $stmt_update->close();

                    $message = "success";
                } else {
                    $sql_insert = "INSERT INTO cart (userid, productid, productname, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("iisdis", $userId, $productId, $productname, $supplierprice, $quantity, $image); // Replaced $price with $supplierprice
                    $stmt_insert->execute();

                    $message = "success";
                    $stmt_insert->close();
                }

                $stmt_check->close();
            }
        }
    }
    $conn->close();
} else {
    $message = "Invalid request.";
}

$response = array('message' => $message);

header('Content-Type: application/json');
echo json_encode($response);
?>