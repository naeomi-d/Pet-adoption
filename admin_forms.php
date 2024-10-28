<?php
include 'config.php'; // Include your database connection

// Fetch all adoption form entries
$sql = "SELECT * FROM adoption_form";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_style.css">
    <title>Admin - Adoption Forms</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {background-color: #f5f5f5;}
    </style>
</head>
<body>
<?php include 'admin_header.php'; ?>
    <h1>Adoption Applications</h1>

    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Other Pets</th>
                <th>Reason for Adoption</th>
                <th>Budget</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['other_pets']); ?></td>
                        <td><?php echo htmlspecialchars($row['adopt_reason']); ?></td>
                        <td><?php echo htmlspecialchars($row['budget']); ?></td>
                        <td><?php echo htmlspecialchars($row['comments']); ?></td>
                    </tr>
                <?php }
            } else {
                echo "<tr><td colspan='8'>No adoption applications found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
mysqli_close($conn); // Close the database connection
?>

