<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>

<body>

<h1>📊 Blog System Dashboard</h1>
<hr>

<h3>👋 Welcome, <?php echo $_SESSION['user_name']; ?></h3>

<hr>

<!-- POST MANAGEMENT -->
<h2>📝 Post Management</h2>

<ul>
    <li><a href="create_posts.php">➕ Create New Post</a></li>
    <li><a href="view_posts.php">📄 View All Posts</a></li>
</ul>

<hr>

<!-- CATEGORY MANAGEMENT -->
<h2>📂 Category Management</h2>

<ul>
    <li><a href="add_category.php">➕ Add Category</a></li>
    <li><a href="view_categories.php">📋 View Categories</a></li>
</ul>

<hr>

<!-- USER ACTIONS -->
<h2>👤 User Panel</h2>

<ul>
    <li><a href="profile.php">🙍 My Profile</a></li>
    <li><a href="change_password.php">🔑 Change Password</a></li>
</ul>

<hr>

<!-- EXTRA FEATURES -->
<h2>⚙️ More Options</h2>

<ul>
    <li><a href="#">💬 View Comments</a></li>
    <li><a href="#">📊 Dashboard Stats</a></li>
</ul>

<hr>

<!-- LOGOUT -->
<h2>🚪 Exit</h2>

<a href="logout.php">Logout</a>

<hr>

</body>
</html>