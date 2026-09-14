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

$userId = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $stmt = $pdo->prepare("
        SELECT id, name, email, phone, avatar, role, created_at
        FROM users
        WHERE id = ?
    ");

    $stmt->execute([$userId]);

    $user = $stmt->fetch();

    if (!$user) {

        echo json_encode([
            "success" => false,
            "message" => "Không tìm thấy tài khoản."
        ]);

        exit;
    }

    echo json_encode([
        "success" => true,
        "user" => $user
    ]);

    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    $name = trim($data["name"] ?? "");
    $phone = trim($data["phone"] ?? "");

    if ($name === "") {

        echo json_encode([
            "success" => false,
            "message" => "Họ tên không được để trống."
        ]);

        exit;
    }

    $stmt = $pdo->prepare("
        UPDATE users
        SET name = ?, phone = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $name,
        $phone !== "" ? $phone : null,
        $userId
    ]);

    $_SESSION["user_name"] = $name;

    echo json_encode([
        "success" => true,
        "message" => "Cập nhật thông tin thành công."
    ]);

    exit;
}

http_response_code(405);

echo json_encode([
    "success" => false,
    "message" => "Phương thức không được hỗ trợ."
]);
?>