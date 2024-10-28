<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:index.php');

      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <style>
      body {
           font-family: Arial, sans-serif;
       }

       .modal {
           display: none; /* Hidden by default */
           position: fixed; /* Stay in place */
           z-index: 1; /* Sit on top */
           left: 0;
           top: 0;
           width: 100%; /* Full width */
           height: 100%; /* Full height */
           overflow: auto; /* Enable scroll if needed */
           background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
       }

       .modal-content {
           background-color: #fefefe;
           margin: 15% auto; /* 15% from the top and centered */
           padding: 20px;
           border: 1px solid #888;
           width: 30%; /* Could be more or less, depending on screen size */
           max-width: 400px; /* Max width */
           border-radius: 8px; /* Rounded corners */
       }

       .close {
           color: #aaa;
           float: right;
           font-size: 28px;
           font-weight: bold;
       }

       .close:hover,
       .close:focus {
           color: black;
           text-decoration: none;
           cursor: pointer;
       }

       .box {
           width: 100%;
           padding: 10px;
           margin: 10px 0;
           border: 1px solid #ccc;
           border-radius: 4px;
       }

       .btn {
           background-color: #4CAF50;
           color: white;
           padding: 10px;
           border: none;
           border-radius: 4px;
           cursor: pointer;
           width: 100%;
       }

       .btn:hover {
           background-color: #45a049;
       }
   </style>
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
    
    <div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="login.php" method="post">
            <h3>Login Now</h3>
            <input type="email" name="email" placeholder="Enter Your Email" required class="box">
            <input type="password" name="password" placeholder="Enter Your Password" required class="box">
            <input type="submit" name="submit" value="Login Now" class="btn">
            <p>Don't have an account? <a href="register.php">Register Now</a></p>
        </form>
    </div>
</div>
<script>
        function showModal(message) {
            document.getElementById('modal-message').innerText = message;
            document.getElementById('myModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === document.getElementById('myModal')) {
                closeModal();
            }
        }
    </script>
   

</body>
</html>