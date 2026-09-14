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

$id = intval($_GET["id"] ?? 0);

if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "ID đơn hàng không hợp lệ."
    ]);

    exit;
}

$stmt = $pdo->prepare("
    SELECT
        id,
        order_code,
        total_amount,
        status,
        created_at
    FROM orders
    WHERE id = ? AND user_id = ?
    LIMIT 1
");

$stmt->execute([
    $id,
    $_SESSION["user_id"]
]);

$order = $stmt->fetch();

if (!$order) {

    echo json_encode([
        "success" => false,
        "message" => "Không tìm thấy đơn hàng."
    ]);

    exit;
}

echo json_encode([
    "success" => true,
    "order" => $order
]);
?>