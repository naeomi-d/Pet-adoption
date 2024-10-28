<?php
include 'config.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Handle deletion of a donation
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Prepare and execute the delete query
    $delete_query = "DELETE FROM donations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, 'i', $delete_id);
    mysqli_stmt_execute($stmt);
    
    // Redirect back to the donations page with a success message
    header('Location: admin_donations.php?message=Donation deleted successfully');
    exit();
}

// Select data from `donations` table
$query = "SELECT id, name, email, amount, message FROM donations";
$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Donations</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
        /* Basic styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    color: #333;
}

/* Donations section styling */
section.donations {
    max-width: 900px;
    margin: 40px auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.title {
    font-size: 26px;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

/* Message styling */
.message {
    background-color: #d4edda;
    color: #155724;
    padding: 12px;
    border: 1px solid #c3e6cb;
    border-radius: 4px;
    margin-bottom: 15px;
    text-align: center;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table th,
table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #f8f9fa;
    font-weight: bold;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Button styling */
.btn {
    display: inline-block;
    padding: 8px 12px;
    color: #fff;
    font-size: 14px;
    text-decoration: none;
    border-radius: 4px;
}

.delete-btn {
    background-color: #dc3545;
    text-align: center;
}

.delete-btn:hover {
    background-color: #c82333;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    section.donations {
        padding: 15px;
    }

    table th, table td {
        padding: 8px 10px;
    }
}

        </style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="donations">
    <h1 class="title">Donations</h1>

    <?php
    // Display success message if exists
    if (isset($_GET['message'])) {
        echo '<div class="message">' . htmlspecialchars($_GET['message']) . '</div>';
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo '$' . number_format($row['amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this donation?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

</body>
</html>
