<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'User Already Exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm Password Not Matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'Registered Successfully!';
         header('location:login.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Left-Side Text Example</title>
    <link rel="stylesheet" href="styles.css">
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
 
 <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRegisterModal()">&times;</span>
            <form action="register.php" method="post">
                <h3>Register Now</h3>
                <input type="text" name="name" placeholder="Enter Your Name" required class="box">
                <input type="email" name="email" placeholder="Enter Your Email" required class="box">
                <input type="password" name="password" placeholder="Enter Your Password" required class="box">
                <input type="password" name="cpassword" placeholder="Confirm Your Password" required class="box">
                <select name="user_type" class="box">
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                </select>
                <input type="submit" name="submit" value="Register Now" class="btn">
                <p>Already have an account? <a href="#" onclick="switchToLogin()">Login Now</a></p>
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