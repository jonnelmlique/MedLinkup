<?php
include '../src/config/config.php';

// Check if the verification ID is set in the POST data
if (isset($_POST['verificationid'])) {
    $verificationid = $_POST['verificationid'];

    // Update the status to "Rejected" in the database
    $update_query = "UPDATE discountverification SET status = 'Rejected' WHERE verificationid = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $verificationid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Status updated successfully
        echo "Success"; // Send a success response to the AJAX request
    } else {
        // Failed to update status
        echo "Failed"; // Send a failure response to the AJAX request
    }

    $stmt->close();
} else {
    // Verification ID not received in the POST data
    echo "No verification ID received"; // Send an error response to the AJAX request
}

$conn->close();
?>