<?php
include './src/config/config.php';
session_start();

if (isset($_POST['productId'], $_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $userId = $_SESSION['userid'];

    $sql_product = "SELECT productname, price, image FROM products WHERE productid = ?";
    $stmt_product = $conn->prepare($sql_product);
    $stmt_product->bind_param("i", $productId);
    $stmt_product->execute();
    $stmt_product->bind_result($productname, $price, $image);
    $stmt_product->fetch();
    $stmt_product->close();

    // Check if the product already exists in the cart for the user
    $sql_check = "SELECT cartid FROM cart WHERE userid = ? AND productid = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $userId, $productId);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // Product already exists in the cart, update the quantity
        $sql_update = "UPDATE cart SET quantity = quantity + ? WHERE userid = ? AND productid = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("iii", $quantity, $userId, $productId);
        $stmt_update->execute();
        $stmt_update->close();

        echo "Quantity updated successfully.";
    } else {
        // Product doesn't exist in the cart, insert a new row
        try {
            $sql_insert = "INSERT INTO cart (userid, productid, productname, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iisdis", $userId, $productId, $productname, $price, $quantity, $image);
            $stmt_insert->execute();

            echo "Item added to cart successfully.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
