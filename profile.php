<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="profile-page">

    <div class="profile-card">

        <!-- Avatar -->
        <div class="profile-avatar">
            <img src="image/generic.avif" alt="User">
        </div>

        <!-- Title -->
        <h2>👤 My Profile</h2>

        <!-- Info -->
        <div class="profile-info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <!-- Buttons -->
        <div class="profile-actions">
            <a href="dashboard.php" class="back-btn">⬅ Back</a>
            <a href="#" class="edit-profile">✏️ Edit Profile</a>
        </div>

    </div>

</div>

</body>
</html>