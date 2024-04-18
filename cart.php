<?php
include './src/config/config.php';
session_start();

$message = '';

$loginLinkText = '<i class="fas fa-user"></i> Login';
$loginLinkURL = './auth/login.php';

if (isset($_SESSION['userid']) && isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
    $loginLinkText = '<i class="fas fa-user"></i> ' . $loggedInUsername;
    $loginLinkURL = './customer/dashboard.php';
}


function fetch_cart_items($userId, $conn, &$totalAmount)
{
    $cartItemsHtml = '';
    $totalAmount = 0;

    try {
        $sql = "SELECT c.cartid, p.productid, c.productname, c.image, c.price, c.quantity 
                FROM cart c
                JOIN products p ON c.productid = p.productid
                WHERE c.userid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalPrice = $row["price"] * $row["quantity"];
                $totalAmount += $totalPrice;
                $cartItemsHtml .= '
                <div class="cart-item">
                    <div class="cart-item-content">
                        <img src="./productimg/' . $row["image"] . '" alt="Product Image" class="cart-item-image">
                        <div class="cart-item-details">
                            <a href="./product.php?id=' . $row["productid"] . '" class="cart-item-link" style="text-decoration: none;">
                                <h3 class="cart-item-title">' . $row["productname"] . '</h3>
                            </a>
                            <p class="cart-item-quantity">Quantity: ' . $row["quantity"] . '</p>
                            <p class="cart-item-price">Price: ₱' . number_format($row["price"], 2) . '</p>
                        </div>
                        <button class="delete-item" data-cartid="' . $row["cartid"] . '"><i class="fas fa-times"></i></button>
</div>
</div>';
            }
        } else {
            $cartItemsHtml = '<p>There are no items in the cart.</p>';
        }

        $stmt->close();
    } catch (Exception $e) {
        $cartItemsHtml = '<p>Error fetching cart items: ' . $e->getMessage() . '</p>';
    }

    return $cartItemsHtml;
}

if (!isset($_SESSION['userid'])) {
    header("Location: ./auth/login.php");
    exit;
}

$userId = $_SESSION['userid'];

// Fetch cart items for the user and calculate total amount
$cartItemsHtml = fetch_cart_items($userId, $conn, $totalAmount);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/index/nav.css">
    <link rel="stylesheet" href="./public/css/index/cart.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/index.php">
                <img src="./public/img/logo.png" alt="MedLinkup Logo" class="logo"> MedLinkup
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./shop.php">Shop</a>
                    </li>
                </ul>
                <div class="navbar-icons d-flex align-items-center">
                    <a href="<?php echo $loginLinkURL; ?>" class="nav-link"><?php echo $loginLinkText; ?></a> <a
                        href="#" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="container">
            <h2 class="mt-5 mb-4">Cart</h2>
            <div id="cart-items">
                <?php echo $cartItemsHtml; ?>
            </div>
            <div id="total-price" class="text-right mt-4">
                Total: <span id="total-amount">₱<?php echo number_format($totalAmount, 2); ?></span>
                <?php if ($totalAmount > 0): ?>
                <a href="./checkout.php" class="btn btn-success btn-lg ml-2">Check Out</a>
                <?php else: ?>
                <button class="btn btn-success btn btn-lg ml-2" disabled>Check Out</button>
                <?php endif; ?>
            </div>

        </div>
    </div>


    <section class="design-element">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Our Mission</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec dictum nunc. Nullam vitae
                        ligula sed nisi sagittis facilisis vitae nec velit. Integer scelerisque magna sit amet dui
                        suscipit, sed aliquam nunc scelerisque.</p>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>
                &copy; 2024 MedLinkup. All rights reserved. |
                <a href="./privacypolicy.php">Privacy Policy</a> | <a href="./termsofservice.php">Terms of Service</a>
            </p>
        </div>
    </footer>

    <script src="./node_modules/jquery/dist/jquery.min.js">
    </script>
    <script src="./node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // Click event for deleting cart items
        $(".delete-item").click(function(e) {
            e.preventDefault();

            // Get the cart ID
            var cartId = $(this).data("cartid");

            // Confirm deletion
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (result.isConfirmed) {
                    // If confirmed, proceed with deletion
                    deleteCartItem(cartId);
                }
            });
        });

        // Function to delete cart item via AJAX
        function deleteCartItem(cartId) {
            $.ajax({
                url: "delete_item.php",
                method: "POST",
                data: {
                    cartId: cartId
                },
                success: function(response) {
                    // Parse the JSON response
                    var data = JSON.parse(response);

                    // Check if deletion was successful
                    if (data.success) {
                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Item deleted successfully',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            // Reload the page after deletion
                            location.reload();
                        });
                    } else {
                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Display error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error deleting the item. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
    </script>



</body>

</html>