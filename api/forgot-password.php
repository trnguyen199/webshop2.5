<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        "success" => false,
        "message" => "Email không hợp lệ."
    ]);

    exit;
}

$stmt = $pdo->prepare("
    SELECT id
    FROM users
    WHERE email = ?
    LIMIT 1
");

$stmt->execute([$email]);

$user = $stmt->fetch();

if (!$user) {

    echo json_encode([
        "success" => false,
        "message" => "Email chưa được đăng ký."
    ]);

    exit;
}

$otp = str_pad(
    random_int(0, 999999),
    6,
    "0",
    STR_PAD_LEFT
);

$expiresAt = date("Y-m-d H:i:s", time() + 300);

$stmt = $pdo->prepare("
    DELETE FROM password_resets
    WHERE email = ?
");

$stmt->execute([$email]);

$stmt = $pdo->prepare("
    INSERT INTO password_resets
    (email, otp, expires_at)
    VALUES (?, ?, ?)
");

$stmt->execute([
    $email,
    $otp,
    $expiresAt
]);

echo json_encode([
    "success" => true,
    "message" => "Đã tạo mã OTP.",
    "otp" => $otp
]);
?>