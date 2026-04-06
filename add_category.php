<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$name = $description = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (empty($name)) {
        $error = "Category name is required!";
    } else {

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
    <link rel="stylesheet" href="css/style.css"> <!-- ✅ CSS LINK -->
</head>
<body>

<div class="add-category container">

    <h2> Add New Category</h2>

    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <?php if($success) echo "<p class='success'>$success</p>"; ?>

    <form method="POST">

        <label>Category Name</label>
        <input type="text" name="name" placeholder="Enter category name" value="<?php echo $name; ?>">

        <label>Description</label>
        <textarea name="description" placeholder="Write short description..."><?php echo $description; ?></textarea>

        <button type="submit"> Add Category</button>

    </form>

    <a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

</div>

</body>
</html>