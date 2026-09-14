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

$receiverName = trim($data["receiver_name"] ?? "");
$receiverPhone = trim($data["receiver_phone"] ?? "");
$addressDetail = trim($data["address_detail"] ?? "");
$ward = trim($data["ward"] ?? "");
$district = trim($data["district"] ?? "");
$city = trim($data["city"] ?? "");
$isDefault = !empty($data["is_default"]) ? 1 : 0;

if (
    $receiverName === "" ||
    $receiverPhone === "" ||
    $addressDetail === ""
) {

    echo json_encode([
        "success" => false,
        "message" => "Vui lòng nhập đầy đủ thông tin địa chỉ."
    ]);

    exit;
}

$userId = $_SESSION["user_id"];

try {

    $pdo->beginTransaction();

    if ($isDefault === 1) {

        $stmt = $pdo->prepare("
            UPDATE addresses
            SET is_default = 0
            WHERE user_id = ?
        ");

        $stmt->execute([$userId]);
    }

    $stmt = $pdo->prepare("
        INSERT INTO addresses
        (
            user_id,
            receiver_name,
            receiver_phone,
            address_detail,
            ward,
            district,
            city,
            is_default
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $userId,
        $receiverName,
        $receiverPhone,
        $addressDetail,
        $ward !== "" ? $ward : null,
        $district !== "" ? $district : null,
        $city !== "" ? $city : null,
        $isDefault
    ]);

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Thêm địa chỉ thành công."
    ]);

} catch (Exception $e) {

    $pdo->rollBack();

    echo json_encode([
        "success" => false,
        "message" => "Không thể thêm địa chỉ."
    ]);
}
?>