// products/read.php
<?php
include '../db.php';

$sql = "SELECT product_id, user_id, name, description, price, image_url, created_at FROM products";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();

echo json_encode($products);
?>