<?php
include '../src/config/config.php';

$searchText = $_POST['search'];

try {
    $sql = "SELECT * FROM categories WHERE categoryname LIKE '%$searchText%'";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["categoryid"] . "</td>";
            echo "<td>" . $row["categoryname"] . "</td>";
            echo "<td><img src='" . $row["imagepath"] . "' alt='Category Image' style='width: 100px; height: auto;'></td>";
            echo "<td class='actions'>";
            echo "<a href='../admin/editcategories.php?id=" . $row["categoryid"] . "' class='button-like btn btn-sm btn-primary'>";
            echo "<i class='fas fa-edit'></i>";
            echo "</a>";
            echo "<a href='#' class='button-like btn btn-sm btn-primary'>";
            echo "<i class='fas fa-trash-alt'></i>";
            echo "</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No categories found</td></tr>";
    }
} catch (Exception $e) {
    echo "<tr><td colspan='4'>Error fetching categories: " . $e->getMessage() . "</td></tr>";
}
?>