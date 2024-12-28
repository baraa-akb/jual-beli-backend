// users/update.php
<?php
include '../db.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['user_id'], $data['username'], $data['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $user_id = $data['user_id'];
    $username = $data['username'];
    $email = $data['email'];

    // Cek apakah user ada
    $sqlCheck = "SELECT COUNT(*) FROM users WHERE user_id = :user_id";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute(['user_id' => $user_id]);
    if ($stmtCheck->fetchColumn() == 0) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Update data
    $sql = "UPDATE users SET username = :username, email = :email WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'email' => $email, 'user_id' => $user_id]);

    echo json_encode(['message' => 'User updated successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
