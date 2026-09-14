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

$currentPassword = $data["currentPassword"] ?? "";
$newPassword = $data["newPassword"] ?? "";
$confirmPassword = $data["confirmPassword"] ?? "";

if ($currentPassword === "" || $newPassword === "" || $confirmPassword === "") {

    echo json_encode([
        "success" => false,
        "message" => "Vui lòng nhập đầy đủ thông tin."
    ]);

    exit;
}

if (strlen($newPassword) < 6) {

    echo json_encode([
        "success" => false,
        "message" => "Mật khẩu mới phải có ít nhất 6 ký tự."
    ]);

    exit;
}

if ($newPassword !== $confirmPassword) {

    echo json_encode([
        "success" => false,
        "message" => "Mật khẩu xác nhận không khớp."
    ]);

    exit;
}

$stmt = $pdo->prepare("
    SELECT password_hash
    FROM users
    WHERE id = ?
");

$stmt->execute([$_SESSION["user_id"]]);

$user = $stmt->fetch();

if (!$user || !password_verify($currentPassword, $user["password_hash"])) {

    echo json_encode([
        "success" => false,
        "message" => "Mật khẩu hiện tại không đúng."
    ]);

    exit;
}

$newPasswordHash = password_hash(
    $newPassword,
    PASSWORD_DEFAULT
);

$stmt = $pdo->prepare("
    UPDATE users
    SET password_hash = ?
    WHERE id = ?
");

$stmt->execute([
    $newPasswordHash,
    $_SESSION["user_id"]
]);

echo json_encode([
    "success" => true,
    "message" => "Đổi mật khẩu thành công."
]);
?>