<?php
include '../src/config/config.php';

// Fetch barangays based on selected city
if(isset($_POST['city']) && !empty($_POST['city'])){
    $city = $_POST['city'];

    $sql = "SELECT DISTINCT barangay FROM availablelocations WHERE city = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $city);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<option value="" disabled selected>Select Barangay</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['barangay'] . '">' . $row['barangay'] . '</option>';
        }
    } else {
        echo '<option value="" disabled selected>No barangays found</option>';
    }
}
?>
