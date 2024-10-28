<?php
session_start();
include 'config.php'; // Connect to the database

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Your Shopping Cart</h1>

<section class="cart-container">
    <?php if (mysqli_num_rows($cart_query) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cart_item = mysqli_fetch_assoc($cart_query)): ?>
                    <?php
                    $item_total = $cart_item['price'] * $cart_item['quantity'];
                    $total_price += $item_total;
                    ?>
                    <tr>
                        <td><?php echo $cart_item['name']; ?></td>
                        <td><img src="<?php echo $cart_item['image']; ?>" alt="<?php echo $cart_item['name']; ?>" width="50"></td>
                        <td>$<?php echo number_format($cart_item['price'], 2); ?></td>
                        <td>
                            <form method="post" action="update_cart.php">
                                <input type="hidden" name="cart_id" value="<?php echo $cart_item['id']; ?>">
                                <input type="number" name="quantity" min="1" value="<?php echo $cart_item['quantity']; ?>">
                                <button type="submit" name="update_cart">Update</button>
                            </form>
                        </td>
                        <td>$<?php echo number_format($item_total, 2); ?></td>
                        <td>
                            <a href="remove_from_cart.php?cart_id=<?php echo $cart_item['id']; ?>" onclick="return confirm('Remove this item?');">Remove</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="cart-total">
            <h3>Total: $<?php echo number_format($total_price, 2); ?></h3>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <p>Your cart is empty!</p>
    <?php endif; ?>
</section>

</body>
</html>
