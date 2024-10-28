<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>

   <!-- Font Awesome CDN link for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="admin_style.css"> <!-- Link to your admin_style.css file -->
</head>
<body>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">

      <a href="index.php"><img src="../pett/images/logo.JPG" class="logo"> </a>
     

      <nav class="navbar">
         <a href="admin_page.php">Home</a>
         <a href="admin_products.php">Products</a>
         <a href="admin_pets.php">pets</a>
         <a href="admin_forms.php">Adoption Forms</a>
         <a href="admin_users.php">Users</a>
         <a href="admin_donations.php">Donations</a>
      </nav>

      <div class="icons">
         
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>Username : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>Email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <a href="logout.php" class="delete-btn">Logout</a>
         <div>New <a href="login.php">Login</a> | <a href="register.php">Register</a></div>
      </div>

   </div>

</header>
</body>
</html>
<script>
document.getElementById('user-btn').onclick = function () {
    const accountBox = document.querySelector('.account-box');
    accountBox.style.display = accountBox.style.display === 'block' ? 'none' : 'block';
};

// Close message box when clicking the close icon
document.querySelectorAll('.message .fas').forEach(icon => {
    icon.onclick = function () {
        this.parentElement.style.display = 'none';
    };
});
</script>