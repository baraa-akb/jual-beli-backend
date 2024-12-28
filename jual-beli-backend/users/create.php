// users/create.php
<?php
include '../db.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validasi input
    if (!isset($data['username'], $data['password'], $data['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $email = $data['email'];

    // Cek email duplikat
    $sqlCheck = "SELECT COUNT(*) FROM users WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute(['email' => $email]);
    if ($stmtCheck->fetchColumn() > 0) {
        http_response_code(409); // Conflict
        echo json_encode(['error' => 'Email already exists']);
        exit;
    }

    // Insert data
    $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => $password, 'email' => $email]);

    http_response_code(201);
    echo json_encode(['message' => 'User created successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
