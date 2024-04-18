<?php
// Include database configuration and start session
include './src/config/config.php';
session_start();

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if cartId is provided
    if (isset($_POST["cartId"])) {
        $cartId = $_POST["cartId"];

        try {
            // Prepare and execute SQL statement to delete item from cart
            $sql = "DELETE FROM cart WHERE cartid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $cartId);
            $stmt->execute();

            // Check if deletion was successful
            if ($stmt->affected_rows > 0) {
                echo json_encode(array("success" => true, "message" => "Item deleted from cart successfully"));
            } else {
                echo json_encode(array("success" => false, "message" => "Failed to delete item from cart"));
            }
        } catch (Exception $e) {
            // Handle database error
            echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
        }

        // Close statement
        $stmt->close();
    } else {
        // Cart ID not provided
        echo json_encode(array("success" => false, "message" => "Cart ID not provided"));
    }
} else {
    // Invalid request method
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>