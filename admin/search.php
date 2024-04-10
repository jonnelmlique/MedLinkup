<?php
include '../src/config/config.php';

$searchText = $_POST['search'];

try {
    $sql = "SELECT * FROM products WHERE productname LIKE '%$searchText%' OR productcategory LIKE '%$searchText%'";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><img src='../productimg/{$row['image']}' alt='{$row['productname']}' style='width: 100px; height: auto;'></td>";
            echo "<td>{$row['productname']}</td>";
            echo "<td class='price'>₱{$row['price']}</td>";
            echo "<td>{$row['productdetails']}</td>";
            echo "<td>{$row['productcategory']}</td>";
            echo "<td>{$row['stock']}</td>";
            echo "<td class='actions'>";
            echo "<a href='../admin/editproducts.php?id=" . $row["productid"] . "' class='button-like btn btn-sm btn-primary'>";
            echo "<i class='fas fa-edit'></i>";
            echo "</a>";
            echo "<a href='#' class='button-like btn btn-sm btn-primary'>";
            echo "<i class='fas fa-trash-alt'></i>";
            echo "</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No products found</td></tr>";
    }
} catch (Exception $e) {
    echo "<tr><td colspan='7'>Error fetching products: " . $e->getMessage() . "</td></tr>";
}
?>