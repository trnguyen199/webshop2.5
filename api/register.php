<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/db.php";

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$password = $_POST["password"] ?? "";


if (
    $name === "" ||
    $email === "" ||
    $phone === "" ||
    $password === ""
) {
    echo json_encode([
        "success" => false,
        "message" => "Vui lòng nhập đầy đủ thông tin."
    ]);
    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        "success" => false,
        "message" => "Email không hợp lệ."
    ]);

    exit;
}


if (strlen($password) < 6) {

    echo json_encode([
        "success" => false,
        "message" => "Mật khẩu phải có ít nhất 6 ký tự."
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

    if ($stmt->fetch()) {

        echo json_encode([
            "success" => false,
            "message" => "Email đã được sử dụng."
        ]);

        exit;
    }



    $password_hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );



    $stmt = $pdo->prepare("
        INSERT INTO users
        (
            name,
            email,
            phone,
            password_hash,
            role
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            'user'
        )
    ");

    $stmt->execute([
        $name,
        $email,
        $phone,
        $password_hash
    ]);


    
    echo json_encode([
        "success" => true,
        "message" => "Đăng ký tài khoản thành công."
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Lỗi database: " . $e->getMessage()
    ]);

}

exit;
?>