<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Fetch current password
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify old password
    if (password_verify($old_password, $user['password'])) {

        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);

        $update_sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $new_hashed, $user_id);

        if ($stmt->execute()) {
            $success = "Password changed successfully!";
        } else {
            $error = "Something went wrong!";
        }

    } else {
        $error = "Old password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>

<h2>🔑 Change Password</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">

    <label>Old Password:</label><br>
    <input type="password" name="old_password"><br><br>

    <label>New Password:</label><br>
    <input type="password" name="new_password"><br><br>

    <button type="submit">Update Password</button>

</form>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>