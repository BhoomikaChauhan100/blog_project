<?php
require 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Post not found!";
    exit();
}

$post_id = $_GET['id'];

// Fetch single post
$sql = "SELECT posts.*, categories.name AS category_name 
        FROM posts 
        JOIN categories ON posts.category_id = categories.id 
        WHERE posts.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Post not found!";
    exit();
}

$post = $result->fetch_assoc();

/* ===== CATEGORY BASED IMAGE LOGIC ===== */
$category = strtolower($post['category_name']);
$image = "default.jpg";

if (strpos($category, "health") !== false) {
    $image = "health education.webp";
} elseif (strpos($category, "education") !== false) {
    $image = "education.jpg";
} elseif (strpos($category, "tech") !== false) {
    $image = "tech.jpg";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="single-post">

    <!-- Title -->
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>

    <!-- Meta Info -->
    <div class="post-meta">
        <span class="category"><?php echo htmlspecialchars($post['category_name']); ?></span>
        <span class="date"><?php echo date("F d, Y", strtotime($post['created_at'])); ?></span>
    </div>

    <!-- ✅ Dynamic Image -->
    <img src="images/<?php echo $image; ?>" class="post-image" alt="post">

    <!-- Content -->
    <div class="content">
        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
    </div>

    <!-- Back Button -->
    <a href="view_posts.php" class="back-btn">⬅ Back to Posts</a>

</div>

</body>
</html>