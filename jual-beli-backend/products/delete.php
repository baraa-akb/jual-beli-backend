// products/delete.php
<?php
include '../db.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['product_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing product_id']);
        exit;
    }

    $product_id = $data['product_id'];

    // Validasi apakah product_id valid
    $sqlProduct = "SELECT COUNT(*) FROM products WHERE product_id = :product_id";
    $stmtProduct = $pdo->prepare($sqlProduct);
    $stmtProduct->execute(['product_id' => $product_id]);
    if ($stmtProduct->fetchColumn() == 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        exit;
    }

    // Delete product
    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['product_id' => $product_id]);

    echo json_encode(['message' => 'Product deleted successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
