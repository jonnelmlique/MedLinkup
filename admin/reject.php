<?php
include '../src/config/config.php';

if (isset($_POST['verificationid'])) {
    $verificationid = $_POST['verificationid'];

    $update_query = "UPDATE discountverification SET status = 'Rejected' WHERE verificationid = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $verificationid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Success"; 
    } else {
        echo "Failed"; 
    }

    $stmt->close();
} else {
    echo "No verification ID received"; 
}

$conn->close();
?>