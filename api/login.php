<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/db.php";
$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$password = $data["password"] ?? "";

if ($email === "" || $password === "") {
    echo json_encode([
        "success" => false,
        "message" => "Vui lòng nhập đầy đủ email và mật khẩu."
    ]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, name, email, phone, avatar, role, password_hash
    FROM users
    WHERE email = ?
    LIMIT 1
");

$stmt->execute([$email]);

$user = $stmt->fetch();

if (!$user || !password_verify($password, $user["password_hash"])) {

    echo json_encode([
        "success" => false,
        "message" => "Email hoặc mật khẩu không chính xác."
    ]);

    exit;
}

session_regenerate_id(true);

$_SESSION["user_id"] = $user["id"];
$_SESSION["user_name"] = $user["name"];
$_SESSION["user_email"] = $user["email"];
$_SESSION["user_role"] = $user["role"];

echo json_encode([
    "success" => true,
    "message" => "Đăng nhập thành công.",
    "user" => [
        "id" => $user["id"],
        "name" => $user["name"],
        "email" => $user["email"],
        "phone" => $user["phone"],
        "avatar" => $user["avatar"],
        "role" => $user["role"]
    ]
]);
?>