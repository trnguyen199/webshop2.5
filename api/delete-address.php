<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

if (!isset($_SESSION["user_id"])) {

    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Bạn chưa đăng nhập."
    ]);

    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data["id"] ?? 0);

if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "ID địa chỉ không hợp lệ."
    ]);

    exit;
}

$stmt = $pdo->prepare("
    DELETE FROM addresses
    WHERE id = ? AND user_id = ?
");

$stmt->execute([
    $id,
    $_SESSION["user_id"]
]);

if ($stmt->rowCount() === 0) {

    echo json_encode([
        "success" => false,
        "message" => "Không tìm thấy địa chỉ."
    ]);

    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Xóa địa chỉ thành công."
]);
?>