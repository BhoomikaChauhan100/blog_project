<?php
require 'db.php';

// Check ID
if (!isset($_GET['id'])) {
    die("Invalid Request");
}

$id = intval($_GET['id']);

// Fetch post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

// If post not found
if (!$post) {
    die("Post not found");
}

// Update logic
if (isset($_POST['update'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $id);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Update failed";
        }
    } else {
        echo "All fields required";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<form method="POST">
    <input type="text" name="title" 
        value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>

    <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>

    <button type="submit" name="update">Update Post</button>
</form>

</body>
</html>