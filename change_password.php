<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$old_password = $new_password = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);

    if (empty($old_password) || empty($new_password)) {
        $error = "All fields are required!";
    } else {

        // Fetch current password
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check old password
        if ($user['password'] !== $old_password) {
            $error = "Old password is incorrect!";
        } else {

            // Update password
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("si", $new_password, $user_id);

            if ($stmt->execute()) {
                $success = "Password updated successfully!";
                $old_password = $new_password = "";
            } else {
                $error = "Error updating password!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="change-password-page">

    <div class="change-password-card">

        <h2>🔑 Change Password</h2>

        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <?php if($success) echo "<p class='success'>$success</p>"; ?>

        <form method="POST">

            <label>Old Password</label>
            <input type="password" name="old_password" placeholder="Enter old password">

            <label>New Password</label>
            <input type="password" name="new_password" placeholder="Enter new password">

            <button type="submit">🔄 Update Password</button>

        </form>

        <a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

    </div>

</div>

</body>
</html>