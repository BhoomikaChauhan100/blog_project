<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Invalid Request");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Delete failed";
}
?>