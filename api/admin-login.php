<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/db.php";


$data = json_decode(
    file_get_contents("php://input"),
    true
);


$email = trim(
    $data["email"] ?? ""
);

$password =
    $data["password"] ?? "";




if ($email === "" || $password === "") {

    echo json_encode([
        "success" => false,
        "message" => "Vui lòng nhập email và mật khẩu."
    ]);

    exit;
}




$stmt = $pdo->prepare("
    SELECT
        id,
        name,
        email,
        phone,
        avatar,
        role,
        password_hash
    FROM users
    WHERE email = ?
    LIMIT 1
");

$stmt->execute([
    $email
]);

$user = $stmt->fetch();



if (!$user) {

    echo json_encode([
        "success" => false,
        "message" => "Tài khoản Admin không tồn tại."
    ]);

    exit;
}




if ($user["role"] !== "admin") {

    echo json_encode([
        "success" => false,
        "message" => "Tài khoản này không có quyền Admin."
    ]);

    exit;
}


if (!password_verify(
    $password,
    $user["password_hash"]
)) {

    echo json_encode([
        "success" => false,
        "message" => "Email hoặc mật khẩu Admin không chính xác."
    ]);

    exit;
}


session_regenerate_id(true);


$_SESSION["admin_id"] =
    $user["id"];

$_SESSION["admin_name"] =
    $user["name"];

$_SESSION["admin_email"] =
    $user["email"];

$_SESSION["admin_role"] =
    $user["role"];



echo json_encode([

    "success" => true,

    "message" =>
        "Đăng nhập Admin thành công.",

    "admin" => [

        "id" =>
            $user["id"],

        "name" =>
            $user["name"],

        "email" =>
            $user["email"],

        "role" =>
            $user["role"]
    ]

]);

?>