<?php
include './src/config/config.php';

$perPage = 10; 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; 

$start = ($page - 1) * $perPage; 

try {
    $sql = "SELECT productid, productname, price, image FROM products LIMIT $start, $perPage";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productName = strlen($row["productname"]) > 35 ? substr($row["productname"], 0, 35) . '...' : $row["productname"];

            echo '<div class="col-md-15">';
            echo '<a href="./product.php?id=' . $row["productid"] . '" class="product-card-link">';
            echo '<div class="product-card">';
            echo '<img src="./productimg/' . $row["image"] . '" alt="Product Image" />';
            echo '<div class="product-card-body">';
            echo '<h3 class="product-card-title">' . $productName . '</h3>';
            echo '<p class="product-card-price">₱' . $row["price"] . '</p>';
            echo '</div></a></div></div>';
        }
    } else {
        echo ""; // No more products available, no need to output anything
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>