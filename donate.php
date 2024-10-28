<?php
session_start();
include 'config.php';

$message = "";

if (isset($_POST['send'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $amount = mysqli_real_escape_string($conn, $_POST['number']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insert_query = "INSERT INTO donations (name, email, amount, message) VALUES ('$name', '$email', '$amount', '$message')";
    
    if (mysqli_query($conn, $insert_query)) {
        $message = "Donation recorded successfully.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Pass the message to JavaScript safely
$message = addslashes($message); // Escape single quotes
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="header">
        <nav>
            <a href="index.html"><img src="../pett/images/logo.JPG" class="logo"></a>
            <div class="nav-links">
                <ul>
                    <li><a href="index.php"> HOME  |</a></li>
                    <li><a href="adoption.php"> ADOPTION  |</a></li>
                    <li><a href="accessories.php"> FOOD PRODUCTS   |</a></li>
                    <li><a href="donate.php"> DONATE  |</a></li>
                    <li><a href="about.php"> ABOUT  </a></li>
                </ul>
            </div>
        </nav>
        <section class="donate-section">
            <div class="dog-image">
                <img src="../pett/images/adopt6.jpg" alt="Dog">
            </div>
            <div class="centered-content">
                <h2>Make a Donation</h2>
                <div class="donate-form">
                    <form action="donate.php" method="post">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required>

                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>

                        <label for="number">Donation Amount:</label>
                        <input type="text" id="number" name="number" placeholder="Enter amount" required>

                        <label for="message">Leave a Message (optional):</label>
                        <textarea id="message" name="message" placeholder="Leave a message"></textarea>

                        <input type="submit" value="Donate" name="send" class="btn"> 
                    </form>
                </div>
            </div>
        </section>

        <section class="footer">
            <p>PetPals Pvt Ltd , All Rights Reserved</p>
            <div class="icons">
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-linkedin"></i>
            </div>
        </section>

        <!-- Modal HTML -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
                <p id="modal-message"></p>
            </div>
        </div>

        <style>
        
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%; /* Set a fixed width to make the modal smaller */
    max-height: 300px; /* Set a max height for the modal */
    overflow-y: auto; /* Allow vertical scrolling if content exceeds max height */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
</style>



        <script>
        function showModal(message) {
            document.getElementById('modal-message').innerText = message;
            document.getElementById('myModal').style.display = "block";
        }

        // Show the modal if there is a message
        <?php if ($message): ?>
            showModal("<?php echo $message; ?>");
        <?php endif; ?>
        </script>
    </body>
</html>
