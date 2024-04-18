<?php
include '../src/config/config.php';

// Fetch regions based on selected country
if(isset($_POST['country']) && !empty($_POST['country'])){
    $country = $_POST['country'];

    $sql = "SELECT DISTINCT region FROM availablelocations WHERE country = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $country);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<option value="" disabled selected>Select Region</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['region'] . '">' . $row['region'] . '</option>';
        }
    } else {
        echo '<option value="" disabled selected>No regions found</option>';
    }
}
?>
