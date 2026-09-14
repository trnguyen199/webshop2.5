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

$userId = $_SESSION["user_id"];

try {

    $pdo->beginTransaction();

    $check = $pdo->prepare("
        SELECT id
        FROM addresses
        WHERE id = ? AND user_id = ?
    ");

    $check->execute([$id, $userId]);

    if (!$check->fetch()) {

        $pdo->rollBack();

        echo json_encode([
            "success" => false,
            "message" => "Địa chỉ không tồn tại."
        ]);

        exit;
    }

    $stmt = $pdo->prepare("
        UPDATE addresses
        SET is_default = 0
        WHERE user_id = ?
    ");

    $stmt->execute([$userId]);

    $stmt = $pdo->prepare("
        UPDATE addresses
        SET is_default = 1
        WHERE id = ? AND user_id = ?
    ");

    $stmt->execute([$id, $userId]);

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Đã đặt địa chỉ mặc định."
    ]);

} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        "success" => false,
        "message" => "Không thể đặt địa chỉ mặc định."
    ]);
}
?>