// transactions/read.php
<?php
include '../db.php';

$sql = "SELECT t.transaction_id, p.name AS product_name, u.username AS buyer_name, t.amount, t.transaction_date 
        FROM transactions t
        JOIN products p ON t.product_id = p.product_id
        JOIN users u ON t.buyer_id = u.user_id";
$stmt = $pdo->query($sql);
$transactions = $stmt->fetchAll();

echo json_encode($transactions);
?>