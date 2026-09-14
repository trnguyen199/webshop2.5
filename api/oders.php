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

$stmt = $pdo->prepare("
    SELECT
        id,
        order_code,
        total_amount,
        status,
        created_at
    FROM orders
    WHERE user_id = ?
    ORDER BY created_at DESC
");

$stmt->execute([$_SESSION["user_id"]]);

echo json_encode([
    "success" => true,
    "orders" => $stmt->fetchAll()
]);
?>