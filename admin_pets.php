<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['add_pet'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pet_type = mysqli_real_escape_string($conn, $_POST['pet_type']);
    $breed = mysqli_real_escape_string($conn, $_POST['breed']);
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'images/' . $image;

    $select_pet_name = mysqli_query($conn, "SELECT name FROM `pets` WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_pet_name) > 0) {
        $message[] = 'Pet Name Already Added';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'Image Size Is Too Large';
        } else {
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                $add_pet_query = mysqli_query($conn, "INSERT INTO `pets`(name, pet_type, breed, gender, age, image) VALUES('$name', '$pet_type', '$breed', '$gender', '$age', '$image')") or die('query failed');
                $message[] = 'Pet Added Successfully!';
            } else {
                $message[] = 'Failed to upload image. Please check your directory permissions or path.';
            }
        }
    }
}

// Deleting a pet
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `pets` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('images/' . $fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `pets` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_products.php');
}

// Updating a pet
if (isset($_POST['update_pet'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_pet_type = $_POST['update_pet_type'];
    $update_breed = $_POST['update_breed'];
    $update_gender = $_POST['update_gender'];
    $update_age = $_POST['update_age'];
    

    mysqli_query($conn, "UPDATE `pets` SET name = '$update_name',pet_type ='$update_pet_type', breed = '$update_breed',  gender = '$update_gender', age = '$update_age' WHERE id = '$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'images/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image File Size Is Too Large';
        } else {
            mysqli_query($conn, "UPDATE `pets` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('images/' . $update_old_image);
        }
    }

    header('location:admin_pets.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Manage Pets</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
       /* General styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Buttons */
.btn, .option-btn, .delete-btn {
    padding: 10px 15px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    color: #fff;
    transition: background-color 0.3s;
}

.btn {
    background-color: #28a745;
}

.option-btn {
    background-color: #007bff;
}

.delete-btn {
    background-color: #dc3545;
}

.btn:hover, .option-btn:hover, .delete-btn:hover {
    opacity: 0.8;
}

/* Form styling */
.add-pets form, .edit-pet-form form {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px; /* Adjust max-width as needed */
    width: 100%; /* Ensures it takes full width of its parent until max-width */
    margin: 0 auto; /* Centers the form horizontally */
}

.add-pets h3, .edit-pet-form h3 {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.add-pets .box, .edit-pet-form .box {
    width: 100%; /* Keeps the inputs full width within the form */
    padding: 10px;
    margin: 8px 0;
    border-radius: 5px;
    border: 1px solid #ddd;
}
.btn {
    margin-top: 20px; /* Add space above the button */
    width: 100%; /* Full width */
    max-width: 200px; /* Max width for the button */
    align-self: center; /* Center button horizontally */
}

/* Pet display styling */
.show-pets .box-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}

.show-pets .box {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 20px;
    width: 250px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.show-pets .box img {
    width: 100%;
    height: auto;
    margin-bottom: 10px;
}

.show-pets .box div {
    margin-bottom: 10px;
    font-size: 1em;
}

/* Small image in edit form */
.small-image {
    max-width: 150px;
    height: auto;
    margin: 10px 0;
}

/* Edit form */
.edit-pet-form {
    display: flex;
    justify-content: center;
    padding: 20px;
    margin-top: 20px;
}

.edit-pet-form form {
    width: 300px;
}

/* Title Styling */
.title {
    font-size: 2em;
    font-weight: bold;
    color: #444;
    text-align: center;
    margin: 20px 0;
}

   </style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- Pet CRUD section starts  -->

<section class="add-pets">
   <h1 class="title">Manage pets</h1>
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add Pet</h3>
      <input type="text" name="name" class="box" placeholder="Enter pet Name" required >
      <input type="text" name="pet_type" class="box" placeholder="Enter Pet type" required >
      <input type="text" name="breed" class="box" placeholder="Enter Pet Breed" required >
      <select name="gender" class="box" required>
         <option value="" disabled selected>Select Pet Gender</option>
         <option value="Male">Male</option>
         <option value="Female">Female</option>
      </select>
      <input type="number" min="0" name="age" class="box" placeholder="Enter Pet Age" required >
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required >
      <input type="submit" value="Add Pet" name="add_pet" class="btn">
   </form>
</section>

<!-- Pet CRUD section ends -->

<!-- Show pets  -->

<section class="show-pets">
   <div class="box-container">
      <?php
         $select_pet = mysqli_query($conn, "SELECT * FROM `pets`") or die('query failed');
         if (mysqli_num_rows($select_pet) > 0) {
            while ($fetch_pet = mysqli_fetch_assoc($select_pet)) {
      ?>
      <div class="box">
         <img src="images/<?php echo $fetch_pet['image']; ?>" alt="" class="small-image"> <!-- Add class here -->
         <div class="name">Pet Name:<?php echo $fetch_pet['name']; ?></div>
         <div class="pet_type">Pet type: <?php echo $fetch_pet['pet_type']; ?></div>
         <div class="breed">Breed: <?php echo $fetch_pet['breed']; ?></div>
         <div class="gender">Gender: <?php echo $fetch_pet['gender']; ?></div>
         <div class="age">Age: <?php echo $fetch_pet['age']; ?></div>
         <a href="admin_pets.php?update=<?php echo $fetch_pet['id']; ?>" class="option-btn">Update</a>
         <a href="admin_pets.php?delete=<?php echo $fetch_pet['id']; ?>" class="delete-btn" onclick="return confirm('Delete this pet?');">Delete</a>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">No Pets Added Yet!</p>';
         }
      ?>
   </div>
</section>

<!-- Edit pet form -->
<section class="edit-pet-form">
   <?php
      if (isset($_GET['update'])) {
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `pets` WHERE id = '$update_id'") or die('query failed');
         if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
   ?>
  <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="images/<?php echo $fetch_update['image']; ?>" alt="" class="small-image">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter Pet Name">
      <input type="text" name="update_pet_type" value="<?php echo $fetch_update['pet_type']; ?>" class="box" required placeholder="Enter Pet Type">
      <input type="text" name="update_breed" value="<?php echo $fetch_update['breed']; ?>" class="box" required placeholder="Enter Pet Breed">
      <select name="update_gender" class="box" required>
         <option value="Male" <?php echo ($fetch_update['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
         <option value="Female" <?php echo ($fetch_update['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
      </select>
      <input type="number" name="update_age" value="<?php echo $fetch_update['age']; ?>" min="0" class="box" required placeholder="Enter Pet Age">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Update" name="update_pet" class="btn">
      <input type="reset" value="Cancel" id="close-update" class="option-btn">
   </form>
   <?php
            }
         }
      } else {
         echo '<script>document.querySelector(".edit-pet-form").style.display = "none";</script>';
      }
   ?>
</section>

<!-- Custom admin JS file link -->
<script src="js/admin_script.js"></script>

</body>
</html>
