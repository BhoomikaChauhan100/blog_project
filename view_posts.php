<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// JOIN query (IMPORTANT 🔥)
$sql = "SELECT posts.*, categories.name AS category_name 
        FROM posts 
        JOIN categories ON posts.category_id = categories.id 
        ORDER BY posts.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Posts</title>
</head>
<body>

<h2>📄 All Posts</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Category</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['content']; ?></td>
        <td><?php echo $row['category_name']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td>
            <a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a> |
            <a href="delete_post.php?id=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php } ?>

</table>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>