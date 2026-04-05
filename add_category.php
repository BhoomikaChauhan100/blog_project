<?php
session_start();
require 'db.php';

// ✅ Check login (same session name as login.php)
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$name = $description = "";
$success = $error = "";

// Form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (empty($name)) {
        $error = "Category name is required!";
    } else {

        // Insert query
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $description);

        if ($stmt->execute()) {
            $success = "Category added successfully!";
            $name = $description = "";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
</head>
<body>

<h2>📂 Add Category</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">

    <label>Category Name:</label><br>
    <input type="text" name="name" value="<?php echo $name; ?>"><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4"><?php echo $description; ?></textarea><br><br>

    <button type="submit">Add Category</button>

</form>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>