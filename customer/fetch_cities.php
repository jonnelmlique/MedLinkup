<?php
include '../src/config/config.php';

// Fetch cities based on selected province
if(isset($_POST['province']) && !empty($_POST['province'])){
    $province = $_POST['province'];

    $sql = "SELECT DISTINCT city FROM availablelocations WHERE province = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $province);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<option value="" disabled selected>Select City</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['city'] . '">' . $row['city'] . '</option>';
        }
    } else {
        echo '<option value="" disabled selected>No cities found</option>';
    }
}
?>
