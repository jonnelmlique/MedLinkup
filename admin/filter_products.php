<?php
include '../src/config/config.php';

$categoryIds = isset($_POST['categoryIds']) ? $_POST['categoryIds'] : '';

$sql = "SELECT p.productid, p.productname, p.supplierprice, p.image FROM products p WHERE p.supplierstock IS NOT NULL AND p.supplierprice IS NOT NULL";

if (!empty($categoryIds)) {
    $categoryIdsArray = explode(',', $categoryIds);
    $categoryIdsString = implode(',', array_map('intval', $categoryIdsArray));
    $sql .= " AND p.productcategory IN (SELECT categoryname FROM categories WHERE categoryid IN ($categoryIdsString))";
}

try {
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productName = strlen($row["productname"]) > 35 ? substr($row["productname"], 0, 35) . '...' : $row["productname"];
            ?>
            <div class="col-md-15">
                <a href="../product.php?id=<?php echo $row["productid"]; ?>" class="product-card-link"
                    style="text-decoration: none;">
                    <div class="product-card">
                        <img src="../productimg/<?php echo $row["image"]; ?>" alt="Product Image" />
                        <div class="product-card-body">
                            <h3 class="product-card-title"><?php echo $productName; ?></h3>
                            <p class="product-card-price">₱<?php echo $row["supplierprice"]; ?></p>
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