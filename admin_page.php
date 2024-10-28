<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="admin_style.css">
<style>
   body {
      min-height: 100vh;
    width: 100%;
    background-image: url('../pett/images/admin 1.jpg');
    background-position: center;
    background-size: cover;
    position: relative;
    font-family: 'Times New Roman', Times, serif;
}
   </style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="title">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php 
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
         ?>
         <p>Normal Users</p>
         <h3><?php echo $number_of_users; ?></h3>
      </div>

      <div class="box">
         <?php 
            $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admins = mysqli_num_rows($select_admins);
         ?>
         <p>Admin Users</p>
         <h3><?php echo $number_of_admins; ?></h3>
      </div>

      <div class="box">
         <?php 
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
         ?>
         <p>Total Accounts</p>
         <h3><?php echo $number_of_account; ?></h3>
      </div>

      <div class="box">
         <?php 
            $select_pets = mysqli_query($conn, "SELECT * FROM `pets`") or die('query failed');
            $number_of_pets = mysqli_num_rows($select_pets);
         ?>
         <p>Total Pets</p>
         <h3><?php echo $number_of_pets; ?></h3>
      </div>

      <div class="box">
         <?php 
            $select_products = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
         ?>
         <p>Total Products</p>
         <h3><?php echo $number_of_products; ?></h3>
      </div>

   </div>

</section>

<!-- admin dashboard section ends -->









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>