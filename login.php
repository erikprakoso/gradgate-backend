<?php
header("Content-Type: application/json");

// Sertakan koneksi database
require 'database.php';

// Ambil data input
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->email) || !isset($data->password)) {
    echo json_encode(["error" => "Invalid request"]);
    http_response_code(400);
    exit;
}

$email = $data->email;
$password = $data->password;

try {
    // Siapkan pernyataan SQL
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {
        // Kata sandi benar
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "data" => [
                "id" => $user['id'],
                "email" => $user['email'],
            ]
        ]);
    } else {
        // Kredensial tidak valid
        echo json_encode([
            "status" => "error",
            "message" => "Invalid credentials",
            "data" => null
        ]);
        http_response_code(401);
    }
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Internal server error",
        "data" => null,
        "error" => $e->getMessage()
    ]);
    http_response_code(500);
}
