<?php
include './src/config/config.php';

$searchText = $_POST['search'];

try {
    $sql = "SELECT productid, productname, price, image FROM products WHERE productname LIKE '%$searchText%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productName = strlen($row["productname"]) > 35 ? substr($row["productname"], 0, 35) . '...' : $row["productname"];
            ?>
<div class="col-md-15">
    <a href="./product.php?id=<?php echo $row["productid"]; ?>" class="product-card-link">
        <div class="product-card">
            <img src="./productimg/<?php echo $row["image"]; ?>" alt="Product Image" />
            <div class="product-card-body">
                <h3 class="product-card-title"><?php echo $productName; ?></h3>
                <p class="product-card-price">₱<?php echo $row["price"]; ?></p>
            </div>
        </div>
    </a>
</div>
<?php
        }
    } else {
        echo "No products available.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>