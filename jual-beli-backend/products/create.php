// products/create.php
<?php
include '../db.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validasi input
    if (!isset($data['user_id'], $data['name'], $data['price'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $user_id = $data['user_id'];
    $name = $data['name'];
    $description = $data['description'] ?? null; // Optional field
    $price = $data['price'];
    $image_url = $data['image_url'] ?? null; // Optional field

    // Validasi apakah user_id valid
    $sqlUser = "SELECT COUNT(*) FROM users WHERE user_id = :user_id";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->execute(['user_id' => $user_id]);
    if ($stmtUser->fetchColumn() == 0) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Insert product
    $sql = "INSERT INTO products (user_id, name, description, price, image_url) VALUES (:user_id, :name, :description, :price, :image_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'name' => $name, 'description' => $description, 'price' => $price, 'image_url' => $image_url]);

    http_response_code(201);
    echo json_encode(['message' => 'Product created successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
