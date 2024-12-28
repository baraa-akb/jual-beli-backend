// users/read.php
<?php
include '../db.php';

$sql = "SELECT user_id, username, email, created_at FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll();

echo json_encode($users);
?>