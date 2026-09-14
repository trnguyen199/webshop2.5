<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$otp = trim($data["otp"] ?? "");
$newPassword = $data["newPassword"] ?? "";
$confirmPassword = $data["confirmPassword"] ?? "";

if (
    $email === "" ||
    $otp === "" ||
    $newPassword === "" ||
    $confirmPassword === ""
) {

    echo json_encode([
        "success" => false,
        "message" => "Vui lòng nhập đầy đủ thông tin."
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

if (strlen($newPassword) < 6) {

    echo json_encode([
        "success" => false,
        "message" => "Mật khẩu phải có ít nhất 6 ký tự."
    ]);

    exit;
}

$stmt = $pdo->prepare("
    SELECT id, otp, expires_at
    FROM password_resets
    WHERE email = ?
    ORDER BY id DESC
    LIMIT 1
");

$stmt->execute([$email]);

$reset = $stmt->fetch();

if (!$reset) {

    echo json_encode([
        "success" => false,
        "message" => "Không tìm thấy mã OTP."
    ]);

    exit;
}

if ($reset["otp"] !== $otp) {

    echo json_encode([
        "success" => false,
        "message" => "Mã OTP không chính xác."
    ]);

    exit;
}

if (strtotime($reset["expires_at"]) < time()) {

    echo json_encode([
        "success" => false,
        "message" => "Mã OTP đã hết hạn."
    ]);

    exit;
}

$passwordHash = password_hash(
    $newPassword,
    PASSWORD_DEFAULT
);

$stmt = $pdo->prepare("
    UPDATE users
    SET password_hash = ?
    WHERE email = ?
");

$stmt->execute([
    $passwordHash,
    $email
]);

$stmt = $pdo->prepare("
    DELETE FROM password_resets
    WHERE email = ?
");

$stmt->execute([$email]);

echo json_encode([
    "success" => true,
    "message" => "Đặt lại mật khẩu thành công."
]);
?>