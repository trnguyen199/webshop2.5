<?php

require_once "../config/db.php";

$email = "admin@gmail.com";
$new_password = "123456";

$new_hash = password_hash(
    $new_password,
    PASSWORD_DEFAULT
);

$stmt = $pdo->prepare("
    UPDATE users
    SET password_hash = ?, role = 'admin'
    WHERE email = ?
");

$stmt->execute([
    $new_hash,
    $email
]);

if ($stmt->rowCount() > 0) {
    echo "Đã cập nhật mật khẩu Admin thành công!";
} else {
    echo "Không tìm thấy tài khoản hoặc dữ liệu không thay đổi.";
}
?>