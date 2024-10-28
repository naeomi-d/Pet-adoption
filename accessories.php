<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['quantity'];


    // Check if the product is already in the cart
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
    
    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart` (user_id, name, price, image, quantity) VALUES ('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
        $message[] = 'Product added to cart!';
        
        // Redirect to the same page to refresh cart count
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
 <style>
.small-image {
           max-width: 150px; /* Set desired max width */
           height: auto; /* Maintain aspect ratio */
       }
.logo{
    position: top;
    height: auto;
    left: 0px;
    width: 150px;
}
*{
    margin: 0;
    padding: 0;
}
nav{
    display: flex;
    padding: 2% 6%;
    justify-content:space-between;
    align-items:center;
    background-color: #4CAF50;; 
}
.nav-links{
    flex: 1;
    text-align: center;
}
.nav-links ul li{
    list-style: none;
    display: inline-block;
    padding: 6px 12 px;
    position: relative;
}
.nav-links ul li a{
    color: ghostwhite;
    text-decoration: none;
    font-size: 20px;
}
.nav-links ul li::after{
    content: '';
    width: 0%;
    height: 2px;
    background: rgba(122, 211, 58, 0.796); 
    display: block;
    margin: auto;
    transition: 0.5s;
}
.nav-links ul li:hover::after{
    width: 100%;

}
.box-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between; /* Distribute items evenly */
    max-width: 1200px;
    margin: 0 auto;
}

.box {
    width: 22%; /* Each item takes up about 22% for 4 items per row */
    margin: 1%; /* Small margin for spacing */
    border: 1px solid #ccc;
    overflow: hidden;
    background-color: #fff;
    transition: transform 0.3s;
    text-align: center;
    padding-top: 30px;
}

.box:hover {
    transform: scale(1.05); /* Hover effect */
}

</style>
   
</head>
<body>
<script src="script.js"></script>
       <section class="adopt-section">
          <nav>
             <a href="index.php"><img src="../pett/images/logo.JPG" class="logo"> </a>
             <div class ="nav-links">
             <ul>
                <li><a href="index.php"> HOME  |</a></li>
                <li><a href="adoption.php"> ADOPTION  |</a></li>
                <li><a href="accessories.php" >FOOD PRODUCTS   |</a></li>
                <li><a href="donate.php"> DONATE  |</a></li>
                <li><a href="about.php"> ABOUT  </a></li>
             </ul>
             </div>
             <a href="cart.php" class="cart-icon">
            <i class="fa-solid fa-cart-shopping"></i>
            <span id="cart-count">
                  <?php
                     $user_id = $_SESSION['user_id'];
                     $cart_query = mysqli_query($conn, "SELECT COUNT(*) AS count FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                     $cart_data = mysqli_fetch_assoc($cart_query);
                     echo $cart_data['count'];
                  ?>
               </span>
            </a>
          </nav>

   <?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message">' . $msg . '</div>';
    }
}
?>

   <!-- Dog Food Section -->
   <h2>Dog Food</h2>
   <div class="box-container">
      <?php  
         $select_dog_food = mysqli_query($conn, "SELECT * FROM `product` WHERE category='Dog Food'") or die('query failed');
         if (mysqli_num_rows($select_dog_food) > 0) {
            while ($fetch_product = mysqli_fetch_assoc($select_dog_food)) {
      ?>
      <form action="" method="post" class="box">
         <img class="small-image" src="products/dog/<?php echo $fetch_product['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_product['name']; ?></div>
         <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
         <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
         <input type="number" name="quantity" value="1" min="1" class="quantity-input" required>
         <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
      </form>
      <?php
            }
         } else {
            echo '<p class="empty">No Dog Food Products Available!</p>';
         }
      ?>
   </div>

   <!-- Cat Food Section -->
   <h2>Cat Food</h2>
   <div class="box-container">
      <?php  
         $select_cat_food = mysqli_query($conn, "SELECT * FROM `product` WHERE category='Cat Food'") or die('query failed');
         if (mysqli_num_rows($select_cat_food) > 0) {
            while ($fetch_product = mysqli_fetch_assoc($select_cat_food)) {
      ?>
      <form action="" method="post" class="box">
         <img class="small-image" src="products/cat/<?php echo $fetch_product['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_product['name']; ?></div>
         <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
         <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
         <input type="number" name="quantity" value="1" min="1" class="quantity-input" required>
         <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
      </form>
      <?php
            }
         } else {
            echo '<p class="empty">No Cat Food Products Available!</p>';
         }
      ?>
   </div>

</section>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>
