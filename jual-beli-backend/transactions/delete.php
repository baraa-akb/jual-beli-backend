// transactions/delete.php
<?php
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$transaction_id = $data['transaction_id'];

$sql = "DELETE FROM transactions WHERE transaction_id = :transaction_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['transaction_id' => $transaction_id]);

echo json_encode(['message' => 'Transaction deleted successfully']);
?>