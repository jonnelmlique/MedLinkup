<?php
include '../src/config/config.php';

// Fetch provinces based on selected region
if (isset($_POST['region']) && !empty($_POST['region'])) {
    $region = $_POST['region'];

    $sql = "SELECT DISTINCT province FROM availablelocations WHERE region = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $region);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<option value="" disabled selected>Select Province</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['province'] . '">' . $row['province'] . '</option>';
        }
    } else {
        echo '<option value="" disabled selected>No provinces found</option>';
    }
}
?>