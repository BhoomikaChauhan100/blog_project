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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>📝 Blog Admin</h2>

    <a href="dashboard.php">📊 Dashboard</a>
    <a href="create_posts.php">➕ Create Post</a>
    <a href="view_posts.php">📄 View Posts</a>
    <a href="add_category.php">➕ Add Category</a>
    <a href="view_categories.php">📋 View Categories</a>
    <a href="profile.php">👤 Profile</a>
    <a href="change_password.php">🔑 Change Password</a>
    <a href="#">💬 Comments</a>
    <a href="logout.php" class="logout">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">

    <!-- Navbar -->
    <div class="navbar">
        <h3>📊 Dashboard</h3>
        <p>Welcome, <?php echo $_SESSION['user_name'] ?? 'User'; ?> 👋</p>
    </div>

    <!-- Cards -->
    <div class="dashboard-cards">

        <div class="card">
            <h3>📝 Posts</h3>
            <p>Manage all blog posts</p>
            <a href="view_posts.php">View</a>
        </div>

        <div class="card">
            <h3>📂 Categories</h3>
            <p>Organize your content</p>
            <a href="view_categories.php">View</a>
        </div>

        <div class="card">
            <h3>👤 Profile</h3>
            <p>Manage your account</p>
            <a href="profile.php">View</a>
        </div>

        <div class="card">
            <h3>🔑 Security</h3>
            <p>Update password</p>
            <a href="change_password.php">Update</a>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2026 Blog System | Designed by Trio 🚀</p>
    </div>

</div>

</body>
</html>