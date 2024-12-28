// transactions/create.php
<?php
include '../db.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validasi input
    if (!isset($data['product_id'], $data['buyer_id'], $data['amount'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $product_id = $data['product_id'];
    $buyer_id = $data['buyer_id'];
    $amount = $data['amount'];

    // Validasi apakah product_id valid
    $sqlProduct = "SELECT COUNT(*) FROM products WHERE product_id = :product_id";
    $stmtProduct = $pdo->prepare($sqlProduct);
    $stmtProduct->execute(['product_id' => $product_id]);
    if ($stmtProduct->fetchColumn() == 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        exit;
    }

    // Validasi apakah buyer_id valid
    $sqlBuyer = "SELECT COUNT(*) FROM users WHERE user_id = :buyer_id";
    $stmtBuyer = $pdo->prepare($sqlBuyer);
    $stmtBuyer->execute(['buyer_id' => $buyer_id]);
    if ($stmtBuyer->fetchColumn() == 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Buyer not found']);
        exit;
    }

    // Insert transaction
    $sql = "INSERT INTO transactions (product_id, buyer_id, amount) VALUES (:product_id, :buyer_id, :amount)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['product_id' => $product_id, 'buyer_id' => $buyer_id, 'amount' => $amount]);

    http_response_code(201);
    echo json_encode(['message' => 'Transaction created successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
