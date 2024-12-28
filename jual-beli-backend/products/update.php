// products/update.php
<?php
include '../db.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['product_id'], $data['name'], $data['price'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $product_id = $data['product_id'];
    $name = $data['name'];
    $description = $data['description'] ?? null; // Optional field
    $price = $data['price'];
    $image_url = $data['image_url'] ?? null; // Optional field

    // Validasi apakah product_id valid
    $sqlProduct = "SELECT COUNT(*) FROM products WHERE product_id = :product_id";
    $stmtProduct = $pdo->prepare($sqlProduct);
    $stmtProduct->execute(['product_id' => $product_id]);
    if ($stmtProduct->fetchColumn() == 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        exit;
    }

    // Update product
    $sql = "UPDATE products SET name = :name, description = :description, price = :price, image_url = :image_url WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'image_url' => $image_url,
        'product_id' => $product_id
    ]);

    echo json_encode(['message' => 'Product updated successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
