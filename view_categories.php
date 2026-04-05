<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM categories ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Categories</title>
</head>
<body>

<h2>📋 All Categories</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Date</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
    </tr>
    <?php } ?>

</table>

<br>
<a href="add_category.php">➕ Add Category</a><br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>