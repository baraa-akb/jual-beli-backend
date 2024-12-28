// users/delete.php
<?php
include '../db.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['user_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing user_id']);
        exit;
    }

    $user_id = $data['user_id'];

    // Cek apakah user ada
    $sqlCheck = "SELECT COUNT(*) FROM users WHERE user_id = :user_id";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute(['user_id' => $user_id]);
    if ($stmtCheck->fetchColumn() == 0) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Delete user
    $sql = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);

    echo json_encode(['message' => 'User deleted successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
