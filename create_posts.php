<?php
session_start();
require 'db.php';

// Check login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$title = $content = $category_id = "";
$success = $error = "";

// Form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = $_POST['category'];

    if (empty($title) || empty($content) || empty($category_id)) {
        $error = "All fields are required!";
    } else {
        $user_id = $_SESSION['id'];

        // 👇 IMPORTANT: order same as table
        $sql = "INSERT INTO posts (user_id, title, content, category_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issi", $user_id, $title, $content, $category_id);

        if ($stmt->execute()) {
            $success = "Post created successfully!";
            $title = $content = "";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}

// Fetch categories
$cat_sql = "SELECT * FROM categories";
$cat_result = $conn->query($cat_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="create-post container">
<h2>📝 Create New Post</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">

    <label>Title:</label><br>
    <input type="text" name="title" value="<?php echo $title; ?>"><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="5"><?php echo $content; ?></textarea><br><br>

    <label>Category:</label><br>
    <select name="category">
        <option value="">Select Category</option>
        <?php while($row = $cat_result->fetch_assoc()) { ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['name']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit">Create Post</button>

</form>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>