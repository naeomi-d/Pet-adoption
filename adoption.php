<?php
// Include your config.php file to connect to the database
include 'config.php';
?>
<!DOCTYPE html>
 <html lang="en">
    <head>
         <meta charset="UTF-8"> 
         <meta http-equiv="X-UA-compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width,intial-scale=1.0">
         <title>Pet adoption website</title>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
         integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" 
         referrerpolicy="no-referrer" />
         <style>
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
.products {
            padding: 2% 6%;
        }

        .center-text {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .box-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .box {
            flex: 0 0 30%; /* 3 items per row */
            margin: 10px; /* Space between items */
            border: 1px solid #ccc; /* Add a border */
            border-radius: 8px; /* Rounded corners */
            overflow: hidden; /* Prevent content overflow */
            background-color: #fff; /* White background */
            transition: transform 0.3s; /* Smooth hover effect */
            
        }

        .box:hover {
            transform: scale(1.05); /* Slightly enlarge the box on hover */
        }

        .image {
            width: 100%; /* Full width image */
            height: auto; /* Maintain aspect ratio */
        }

        .name, .type, .gender, .breed, .age {
            padding: 5px;
            text-align: center; /* Center align text */
        }

        .btn {
            display: block;
            margin: 10px auto;
            padding: 10px 15px;
            background-color: #007bff; /* Blue background */
            color: white; /* White text */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s; /* Smooth background change */
        }

        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .empty {
            text-align: center;
            font-size: 18px;
            color: #555; /* Grey color for empty message */
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
          </nav>
          </section>
       
          


<section class="products">
<div class="center-text">
         <h2>Pet adoption</h2>
         <p>Find your new furry friend</p>
   <div class="box-container">

<?php  
   $select_products = mysqli_query($conn, "SELECT * FROM pets") or die('query failed');
   if(mysqli_num_rows($select_products) > 0){
      while($fetch_products = mysqli_fetch_assoc($select_products)){
?>
<form action="adoption_form.php" method="post" class="box">
<img class="image" src="images/<?php echo $fetch_products['image']; ?>" alt="">
<div class="name">Pet name:<?php echo $fetch_products['name']; ?></div>
<div class="type"> Pet type:<?php echo $fetch_products['pet_type']; ?></div>
<div class="gender"> Gender:<?php echo $fetch_products['gender']; ?></div>
<div class="breed"> Breed:<?php echo $fetch_products['breed']; ?></div>
<div class="age"> Age:<?php echo $fetch_products['age']; ?></div>

<input type="hidden" name="pet_id" value="<?php echo $fetch_products['id']; ?>">
<input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
<input type="hidden" name="product_type" value="<?php echo $fetch_products['pet_type']; ?>">
<input type="hidden" name="product_gender" value="<?php echo $fetch_products['gender']; ?>">
<input type="hidden" name="product_breed" value="<?php echo $fetch_products['breed']; ?>">
<input type="hidden" name="product_age" value="<?php echo $fetch_products['age']; ?>">
<input type="submit" value="Adopt now" name="adopt_now" class="btn">
</form>
<?php
   }
}else{
   echo '<p class="empty">no products added yet!</p>';
}
?>
</div>

</section>
