<?php
header("Content-Type: application/json");

// Sertakan koneksi database
require 'database.php';

// Ambil data input
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["error" => "Invalid request"]);
    http_response_code(400);
    exit;
}

$id = $data->id;

try {
    // Siapkan pernyataan SQL untuk menghapus pengguna berdasarkan ID
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Periksa apakah pengguna berhasil dihapus
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "User deleted successfully",
            "data" => null
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "User not found",
            "data" => null
        ]);
        http_response_code(404);
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
