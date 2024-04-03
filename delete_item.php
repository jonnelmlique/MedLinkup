<?php
include './src/config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the cart ID is provided
    if (isset($_POST["cartId"])) {
        $cartId = $_POST["cartId"];
        
        try {
            // Prepare and execute the SQL query to delete the item from the cart
            $sql = "DELETE FROM cart WHERE cartid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $cartId);
            $stmt->execute();
            
            // Check if any rows were affected (if deletion was successful)
            if ($stmt->affected_rows > 0) {
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Failed to delete item from cart"));
            }
        } catch (Exception $e) {
            // Handle database errors
            echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
        }

        $stmt->close();
    } else {
        // If cartId is not provided
        echo json_encode(array("success" => false, "message" => "Cart ID not provided"));
    }
} else {
    // If the request method is not POST
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>
