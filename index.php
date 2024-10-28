<?include'login.php';?>
<?include'register.php';?>
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
        <link rel="stylesheet" href="style.css">
        <style>
        /* Modal styles */
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
      <section class="header">
         <nav>
            <a href="index.php"><img src="../pett/images/logo.JPG" class="logo"> </a>
            <div class ="nav-links">
            <ul>
               <li><a href="index.php"> HOME  |</a></li>
               <li><a href="adoption.php"> ADOPTION  |</a></li>
               <li><a href="accessories.php"> FOOD PRODUCTS  |</a></li>
               <li><a href="donate.php"> DONATE  |</a></li>
               <li><a href="about.php"> ABOUT  </a></li>
            </ul>
            </div>
            <a href="cart.php" class="cart-icon">
            <i class="fa-solid fa-cart-shopping"></i>
             <span id="cart-count">
            </a>
<!-- Sign In Button in index.php -->
<button id="signInButton" type="button" onclick="openLoginModal()">Sign In</button>

            
          </div>
         </nav>
          <!-- Login Modal -->
          <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeLoginModal()">&times;</span>
            <form action="login.php" method="post">
                <h3>Login Now</h3>
                <input type="email" name="email" placeholder="Enter Your Email" required class="box">
                <input type="password" name="password" placeholder="Enter Your Password" required class="box">
                <input type="submit" name="submit" value="Login Now" class="btn">
                <p>Don't have an account? <a href="#" onclick="switchToRegister()">Register Now</a></p>
            </form>
        </div>
    </div>
    <!-- Registration Modal -->
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

         <div class="welcome">
           <h1>Embrace the journey </h1>
           <h1>Where Every Tail Wag Tells a Story of Happiness</h1>
        </div>
      </section>
      <section class ="adopt-now">
        <h2>Your new best friend awaits Start the adoption journey</h2>
        <a href="adoption.php"class="adopt-btn">Adopt now</a>
      </section>
      <section class="Why-need">
         <div class="row">
             <div class="img-wrapper">
                <img src="../pett/images/adopt3.jpg">
              </div>
              <div class="content-wrapper">
                 <div class="content">
                    <h2>Why adopt a pet?</h2>
                    <p>Adopting a pet not only brings joy and companionship into your life, 
                    but also saves lives. When you adopt, you give a homless animal a second 
                    chance at life and provide them with a loving forever home. Every pet deserves 
                    a chance to be loved, so consider adoption today!</p>
                    <a href="adoption.php"class="adopt-btn">Adopt now</a>
                 </div>
              </div>

        </section>
        <section class="Why-need">
           <div class="row">
               <div class="img-wrapper">
                  <img src="../pett/images/adopt4.jpg">
                </div>
                <div class="content-wrapper">
                   <div class="content">
                      <h2>Find the Perfect Accessories for Your Pet</h2>
                      <p>Explore our wide range of pet Accessories to keep your furry friends happy 
                         and healthy. From cozy beds and interactive toys to stylish collars and nutrition
                          treats,we have everthing you need to pamper your pets.<br>

                          <br>  Whether you have a playful pup, a curious cat, our accessories are designed to meet
                         their unique needs and preferences. Shop now and make your pet's life even more enjoyable!
                      </p>
                      <a href="accessories.php"class="shop-btn">Shop now</a>
                   </div>
                </div>
          </section>

          <section class="Why-need">
           <div class="row">
               <div class="img-wrapper">
                  <img src="../pett/images/adopt7.JPG">
                </div>
                <div class="content-wrapper">
                   <div class="content">
                      <h2>Support Our Mission</h2>
                      <p>Your donation helps us provide care, shelter, and medical treatment to pets in need.
                         By donating, you become a vital part of our mission to save and improve the lives
                         of animals.<br>

                         <br>Whether it's a one-time contribution or a monthly pledge, every donation helps us
                         make a difference in the lives of pets awaiting their forever homes.<br>

                         <br>Together, we can give these animals the love and care they deserve. Please consider making 
                         a donation today!
                      </p>
                      <a href="donate.php"class="donate-btn">Donate Now</a>
                   </div>
                </div>
 
          </section>

        </section>
        <section class="Why-need">
           <div class="row">
               <div class="img-wrapper">
                  <img src="../pett/images/adopt5.jpg">
                </div>
                <div class="content-wrapper">
                   <div class="content">
                      <h2>About Us</h2>
                      <p>At PetPals, our mission is to advocate for the well-being of animals and promote
                         responsible pet ownership. We provide a platform that connects loving homes with
                         pets in need, creating harmonies and fulfilling companionships.<br>

                         <br>  Whether you're lookin to adopt a new furry friend or seeking accessories for your 
                         beloved pet. PetPals is here to help. Join us in fostering a community that cherishes 
                         and respects every animal!
                      </p>
                      <a href="about.php"class="Learn-btn">Learn More</a>
                   </div>
                </div>
 
          </section>
        <section class="footer">
           <p>PetPals Pvt Ltd ,All Rights Reserved</p>
           <div class="icons">
              <i class="fa-brands fa-facebook"></i>
              <i class="fa-brands fa-twitter"></i>
              <i class="fa-brands fa-instagram"></i>
              <i class="fa-brands fa-linkedin"></i>
           </div>
        </section>

        <script>
          function openLoginModal() {
              document.getElementById('loginModal').style.display = 'block';
          }

          function closeLoginModal() {
              document.getElementById('loginModal').style.display = 'none';
          }

          function switchToRegister() {
              closeLoginModal();
              document.getElementById('registerModal').style.display = 'block';
          }

          function switchToLogin() {
              closeRegisterModal();
              document.getElementById('loginModal').style.display = 'block';
          }

          function closeRegisterModal() {
              document.getElementById('registerModal').style.display = 'none';
          }
      </script>

   </body>
       

</html>
