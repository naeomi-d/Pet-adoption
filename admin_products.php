<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

// Handle adding a product
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    
    // Normalize category name for folder structure
    $category_map = [
        'Dog Food' => 'dog',
        'Cat Food' => 'cat',
    ];

    // Get folder path based on category
    $category_folder = $category_map[$category];

    // Ensure the directory exists
    if (!is_dir('products/' . $category_folder)) {
        mkdir('products/' . $category_folder, 0777, true);
    }

    $image_folder = 'products/' . $category_folder . '/' . $image;

    $select_product_name = mysqli_query($conn, "SELECT name FROM `product` WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product Name Already Added';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'Image Size Is Too Large';
        } else {
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                $add_product_query = mysqli_query($conn, "INSERT INTO `product`(name, price, category, image) VALUES('$name', '$price', '$category', '$image')") or die('query failed');
                $message[] = 'Product Added Successfully!';
            } else {
                $message[] = 'Failed to upload image. Please check your directory permissions or path.';
            }
        }
    }
}

// Handle deleting a product
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image, category FROM `product` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    
    // Use the category to determine the image path
    $category_folder = $category_map[$fetch_delete_image['category']];
    unlink('products/' . $category_folder . '/' . $fetch_delete_image['image']);
    
    mysqli_query($conn, "DELETE FROM `product` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_products.php');
}

// Handle updating a product
if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];

    mysqli_query($conn, "UPDATE `product` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_old_image = $_POST['update_old_image'];
    $update_category = $_POST['category'];
    
    $category_folder = $category_map[$update_category];
    $update_folder = 'products/' . $category_folder . '/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image File Size Is Too Large';
        } else {
            mysqli_query($conn, "UPDATE `product` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('products/' . $category_folder . '/' . $update_old_image);
        }
    }

    header('location:admin_products.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
/* General Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Button Styling */
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

/* Form Styling */
.add-products form, .edit-product-form form {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    margin: auto;
}

.add-products h3, .edit-product-form h3 {
    font-size: 1.5em;
    margin-bottom: 10px;
    color: #333;
}

.add-products .box, .edit-product-form .box {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 5px;
    border: 1px solid #ddd;
}

/* Pet Display Styling */
.show-products .box-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}

.show-products .box {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 20px;
    width: calc(25% - 20px); /* 4 products per row */
    box-sizing: border-box;
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}


.show-products .box img {
    width: 100%;
    height: auto;
    margin-bottom: 10px;
    border-radius: 5px;
}

.show-products .box div {
    margin-bottom: 10px;
    font-size: 1em;
    color: #444;
}

/* Small Image in Edit Form */
.small-image {
    max-width: 150px;
    height: auto;
    margin: 10px 0;
}

/* Edit Product Form */
.edit-product-form {
    display: flex;
    justify-content: center;
    padding: 20px;
    margin-top: 20px;
}

.edit-product-form form {
    width: 100%;
    max-width: 300px;
}

/* Title Styling */
.title {
    font-size: 2em;
    font-weight: bold;
    color: #444;
    text-align: center;
    margin: 20px 0;
}
/* Category Title Styling */
.category-title {
    width: 100%;
    text-align: center;
    font-size: 1.8em;
    margin: 20px 0 10px;
    color: #444;
}

/* Row styling to display products in a grid */
.products-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

/* Each product box */
.products-row .box {
    flex: 0 1 calc(25% - 20px); /* Four products per row */
    max-width: 250px;
    box-sizing: border-box;
}


    </style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="add-products">
    <h1 class="title">Shop Products</h1>

    


<h3>Add Product</h3>
<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="name" class="box" placeholder="Enter Product Name" required>
    <input type="number" min="0" name="price" class="box" placeholder="Enter Product Price" required>
    <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
    <select name="category" class="box" required>
        <option value="Dog Food">Dog Food</option>
        <option value="Cat Food">Cat Food</option>
    </select>
    <input type="submit" value="Add Product" name="add_product" class="btn">
</form>

<section class="show-products">
    <div class="box-container">
        
        <!-- Dog Food Products -->
        <h2 class="category-title">Dog Food Products</h2>
        <div class="products-row">
            <?php
            $select_dog_food = mysqli_query($conn, "SELECT * FROM `product` WHERE category = 'Dog Food'") or die('query failed');
            if (mysqli_num_rows($select_dog_food) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_dog_food)) {
            ?>
            <div class="box">
                <img src="products/dog/<?php echo $fetch_product['image']; ?>" alt="" class="small-image">
                <div class="name"><?php echo $fetch_product['name']; ?></div>
                <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
                <a href="admin_products.php?update=<?php echo $fetch_product['id']; ?>" class="option-btn">Update</a>
                <a href="admin_products.php?delete=<?php echo $fetch_product['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">No Dog Food Products Added Yet!</p>';
            }
            ?>
        </div>

        <!-- Cat Food Products -->
        <h2 class="category-title">Cat Food Products</h2>
        <div class="products-row">
            <?php
            $select_cat_food = mysqli_query($conn, "SELECT * FROM `product` WHERE category = 'Cat Food'") or die('query failed');
            if (mysqli_num_rows($select_cat_food) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_cat_food)) {
            ?>
            <div class="box">
                <img src="products/cat/<?php echo $fetch_product['image']; ?>" alt="" class="small-image">
                <div class="name"><?php echo $fetch_product['name']; ?></div>
                <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
                <a href="admin_products.php?update=<?php echo $fetch_product['id']; ?>" class="option-btn">Update</a>
                <a href="admin_products.php?delete=<?php echo $fetch_product['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">No Cat Food Products Added Yet!</p>';
            }
            ?>
        </div>
    </div>
</section>



<section class="edit-product-form">
   <?php
      if (isset($_GET['update'])) {
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id = '$update_id'") or die('query failed');
         if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="products/<?php echo $fetch_update['image']; ?>" alt="" class="small-image">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter Product Name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Enter Product Price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Update" name="update_product" class="btn">
      <input type="reset" value="Cancel" id="close-update" class="option-btn">
   </form>
   <?php
            }
         }
      } else {
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>
</section>

<script src="js/admin_script.js"></script>
</body>
</html>