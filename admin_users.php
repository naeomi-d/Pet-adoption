<?php
include 'config.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Handle user update
if (isset($_POST['update_user'])) {
    $id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];

    $update_query = "UPDATE users SET name = '$name', email = '$email', user_type = '$user_type' WHERE id = '$id'";
    mysqli_query($conn, $update_query) or die('Update failed: ' . mysqli_error($conn));
    header('location:admin_users.php');
    exit();
}

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $delete_query = "DELETE FROM users WHERE id = '$id'";
    mysqli_query($conn, $delete_query) or die('Delete failed: ' . mysqli_error($conn));
    header('location:admin_users.php');
    exit();
}

// Select data from `users` table
$query = "SELECT id, name, email, user_type FROM users";
$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel - Users</title>
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
      /* Reset basic styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

/* Section styling */
section.users {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.title {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th,
table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

table th {
    background-color: #f7f7f7;
    font-weight: bold;
    color: #333;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Button styling */
.btn {
    padding: 8px 12px;
    font-size: 14px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    margin-right: 5px;
}

.btn:hover {
    background-color: #0056b3;
}

.delete-btn {
    background-color: #dc3545;
}

.delete-btn:hover {
    background-color: #c82333;
}

/* Edit form styling */
.edit-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.edit-form h2 {
    font-size: 20px;
    color: #333;
    margin-bottom: 15px;
}

.edit-form label {
    display: block;
    margin: 8px 0 4px;
    font-weight: bold;
}

.edit-form input[type="text"],
.edit-form input[type="email"],
.edit-form select {
    width: 100%;
    padding: 8px;
    margin-bottom: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.edit-form .btn {
    background-color: #28a745;
}

.edit-form .btn:hover {
    background-color: #218838;
}

.cancel-btn {
    background-color: #6c757d;
    margin-left: 5px;
}

.cancel-btn:hover {
    background-color: #5a6268;
}

      </style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="users">
   <h1 class="title">Users</h1>

   <table>
      <thead>
         <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Actions</th>
         </tr>
      </thead>
      <tbody>
         <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
               <td><?php echo $row['id']; ?></td>
               <td><?php echo $row['name']; ?></td>
               <td><?php echo $row['email']; ?></td>
               <td><?php echo ucfirst($row['user_type']); ?></td>
               <td>
                  <!-- Edit button: triggers display of edit form -->
                  <a href="?edit_id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                  <!-- Delete button with confirmation -->
                  <a href="?delete_id=<?php echo $row['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
               </td>
            </tr>
         <?php endwhile; ?>
      </tbody>
   </table>

   <!-- Display edit form if edit_id is set -->
   <?php if (isset($_GET['edit_id'])): ?>
      <?php
      $edit_id = $_GET['edit_id'];
      $edit_query = "SELECT * FROM users WHERE id = '$edit_id'";
      $edit_result = mysqli_query($conn, $edit_query);
      $user = mysqli_fetch_assoc($edit_result);
      ?>
      <form action="" method="post" class="edit-form">
         <h2>Edit User</h2>
         <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
         <label for="name">Name:</label>
         <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" required>
         <label for="email">Email:</label>
         <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required>
         <label for="user_type">User Type:</label>
         <select name="user_type" id="user_type">
            <option value="user" <?php if ($user['user_type'] == 'user') echo 'selected'; ?>>User</option>
            <option value="admin" <?php if ($user['user_type'] == 'admin') echo 'selected'; ?>>Admin</option>
         </select>
         <input type="submit" name="update_user" value="Update User" class="btn">
         <a href="admin_users.php" class="btn cancel-btn">Cancel</a>
      </form>
   <?php endif; ?>

</section>

</body>
</html>
