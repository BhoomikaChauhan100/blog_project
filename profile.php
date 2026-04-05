<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user data
$sql = "SELECT name, email FROM users WHERE id = ?";
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
</head>
<body>

<h2>👤 My Profile</h2>

<p><strong>Name:</strong> <?php echo $user['name']; ?></p>
<p><strong>Email:</strong> <?php echo $user['email']; ?></p>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>