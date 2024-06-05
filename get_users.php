<?php
header("Content-Type: application/json");

// Sertakan koneksi database
require 'database.php';

try {
    // Siapkan pernyataan SQL
    $stmt = $pdo->query("SELECT * FROM users");

    // Ambil semua baris hasil
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Tampilkan data pengguna
    echo json_encode([
        "status" => "success",
        "message" => "Users retrieved successfully",
        "data" => $users
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Internal server error",
        "data" => null,
        "error" => $e->getMessage()
    ]);
    http_response_code(500);
}
