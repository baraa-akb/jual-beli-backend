// transactions/update.php
<?php
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$transaction_id = $data['transaction_id'];
$amount = $data['amount'];

$sql = "UPDATE transactions SET amount = :amount WHERE transaction_id = :transaction_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['amount' => $amount, 'transaction_id' => $transaction_id]);

echo json_encode(['message' => 'Transaction updated successfully']);
?>