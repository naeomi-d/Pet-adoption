<?php
include 'config.php'; // Include your database connection
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the required fields are set
    if (isset($_POST['full_name'], $_POST['email'], $_POST['phone_number'], $_POST['address'], $_POST['other_pets'], $_POST['adopt_reason'], $_POST['budget'], $_POST['comments'])) {
        // Get the form data
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $other_pets = mysqli_real_escape_string($conn, $_POST['other_pets']);
        $adopt_reason = mysqli_real_escape_string($conn, $_POST['adopt_reason']);
        $budget = mysqli_real_escape_string($conn, $_POST['budget']);
        $comments = mysqli_real_escape_string($conn, $_POST['comments']);
        
       
        // Insert into database
        $sql = "INSERT INTO adoption_form ( full_name, email, phone_number, address, other_pets, adopt_reason, budget, comments)
                VALUES ( '$full_name', '$email', '$phone_number', '$address', '$other_pets', '$adopt_reason', '$budget', '$comments')";

if (mysqli_query($conn, $sql)) {
    $message = "Application submitted successfully!";
    header("Location: adoption_form.php"); // Redirect to the same page
        exit();
} else {
    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    header("Location: adoption_form.php"); // Redirect to the same page
        exit();
}
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
        <meta charset="UTF-8"> 
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,intial-scale=1.0">
        <title>Pet adoption form</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" 
        referrerpolicy="no-referrer" />
        <style>
           body {
    min-height: 100vh;
    width: 100%;
    background-image: url('../pett/images/green.jpg');
    background-position: center;
    background-size: cover;
    position: relative;
    font-family: 'Times New Roman', Times, serif;
}

form {
    max-width: 600px;
    margin: 0 auto;
    padding: 10px; /* Reduced padding */
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input, textarea {
    width: 100%;
    padding: 4px; /* Reduced padding for inputs and textareas */
    margin-bottom: 10px; /* Reduced margin */
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    background-color: #28a745;
    color: white;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
}

button:hover {
    background-color: #218838;
}

.footer {
    width: 100%;
    text-align: center;
    padding: 30px 0;
    margin: auto;
    box-sizing: border-box;
    background: rgb(122, 163, 31);
}
h1 {
    text-align: center; /* Center the heading text */
    margin-bottom: 20px; /* Optional: Add space below the heading */
    color:white;
}


        </style>
        
   </head>
   <body>
           <h1>Pet Adoption form </h1>
           
           <form action="adoption_form.php" method="post"> 
            <label for="full-name">Full Name:</label>
            <input type="text" id="full-name" name="full_name" required>
    
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
    
            <label for="phone-number">Phone Number:</label>
            <input type="tel" id="phone-number" name="phone_number" required>
    
            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" required></textarea>
    
            <label for="other-pets">Other Pets in the Household:</label>
            <textarea id="other-pets" name="other_pets" rows="2"></textarea>
    
            <label for="adopt-reason">Why do you want to adopt a pet?</label>
            <textarea id="adopt-reason" name="adopt_reason" rows="4" required></textarea>
    
            <label for="budget">Budget for Pet Care:</label>
            <input type="number" id="budget" name="budget" required>
    
            <label for="comments">Additional Comments or Questions:</label>
            <textarea id="comments" name="comments" rows="4"></textarea>
           
            <button type="submit">Submit Application</button>
            </form>
            <?php
    // Check if there's a message in the session
    if (isset($_SESSION['message'])) {
        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']); // Clear the message after displaying it
    }
    ?>
            

        <section class="footer">
           <p>PetPals Pvt Ltd ,All Rights Reserved</p>
           <div class="icons">
              <i class="fa-brands fa-facebook"></i>
              <i class="fa-brands fa-twitter"></i>
              <i class="fa-brands fa-instagram"></i>
              <i class="fa-brands fa-linkedin"></i>
           </div>
        </section>

       
   </body>
       

</html>


