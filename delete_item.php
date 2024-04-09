<?php
include './src/config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["cartId"])) {
        $cartId = $_POST["cartId"];

        try {
            $sql = "DELETE FROM cart WHERE cartid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $cartId);
            $stmt->execute();


            if ($stmt->affected_rows > 0) {
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Failed to delete item from cart"));
            }
        } catch (Exception $e) {

            echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
        }

        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "Cart ID not provided"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>