<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/db.php";


/* ==============================
   KIỂM TRA ĐĂNG NHẬP
============================== */

if (!isset($_SESSION["user_id"])) {

    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Bạn chưa đăng nhập."
    ]);

    exit;
}


$userId = (int) $_SESSION["user_id"];


/* ==============================
   LẤY THÔNG TIN TÀI KHOẢN
============================== */

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    try {

        $stmt = $pdo->prepare("
            SELECT
              id,
              name,
              email,
              phone,
              role,
              created_at
            FROM users
            WHERE id = ?
            LIMIT 1
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

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Lỗi database."
        ]);
    }

    exit;
}


/* ==============================
   CẬP NHẬT THÔNG TIN
============================== */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );


        $name = trim($data["name"] ?? "");
        $phone = trim($data["phone"] ?? "");
        $email = trim($data["email"] ?? "");


        /* Kiểm tra họ tên */

        if ($name === "") {

            echo json_encode([
                "success" => false,
                "message" => "Họ tên không được để trống."
            ]);

            exit;
        }


        /* Kiểm tra email */

        if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

            echo json_encode([
                "success" => false,
                "message" => "Email không hợp lệ."
            ]);

            exit;
        }


        /* Kiểm tra email trùng */

        if ($email !== "") {

            $stmt = $pdo->prepare("
                SELECT id
                FROM users
                WHERE email = ?
                AND id != ?
                LIMIT 1
            ");

            $stmt->execute([
                $email,
                $userId
            ]);

            if ($stmt->fetch()) {

                echo json_encode([
                    "success" => false,
                    "message" => "Email này đã được sử dụng bởi tài khoản khác."
                ]);

                exit;
            }
        }


        /* Cập nhật database */

        $stmt = $pdo->prepare("
            UPDATE users
            SET
                name = ?,
                email = ?,
                phone = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $name,
            $email,
            $phone !== "" ? $phone : null,
            $userId
        ]);


        /* Cập nhật session */

        $_SESSION["user_name"] = $name;
        $_SESSION["user_email"] = $email;


        echo json_encode([
            "success" => true,
            "message" => "Cập nhật thông tin thành công."
        ]);

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Lỗi database: " . $e->getMessage()
        ]);
    }

    exit;
}


/* ==============================
   METHOD KHÔNG HỖ TRỢ
============================== */

http_response_code(405);

echo json_encode([
    "success" => false,
    "message" => "Phương thức không được hỗ trợ."
]);

?>