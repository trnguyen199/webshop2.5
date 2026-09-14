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

$id = intval($data["id"] ?? 0);

$receiverName = trim($data["receiver_name"] ?? "");
$receiverPhone = trim($data["receiver_phone"] ?? "");
$addressDetail = trim($data["address_detail"] ?? "");
$ward = trim($data["ward"] ?? "");
$district = trim($data["district"] ?? "");
$city = trim($data["city"] ?? "");
$isDefault = !empty($data["is_default"]) ? 1 : 0;

if ($id <= 0 || $receiverName === "" || $receiverPhone === "" || $addressDetail === "") {

    echo json_encode([
        "success" => false,
        "message" => "Thông tin địa chỉ không hợp lệ."
    ]);

    exit;
}

$userId = $_SESSION["user_id"];

try {

    $pdo->beginTransaction();

    $check = $pdo->prepare("
        SELECT id
        FROM addresses
        WHERE id = ? AND user_id = ?
    ");

    $check->execute([$id, $userId]);

    if (!$check->fetch()) {

        $pdo->rollBack();

        echo json_encode([
            "success" => false,
            "message" => "Địa chỉ không tồn tại."
        ]);

        exit;
    }

    if ($isDefault === 1) {

        $stmt = $pdo->prepare("
            UPDATE addresses
            SET is_default = 0
            WHERE user_id = ?
        ");

        $stmt->execute([$userId]);
    }

    $stmt = $pdo->prepare("
        UPDATE addresses
        SET
            receiver_name = ?,
            receiver_phone = ?,
            address_detail = ?,
            ward = ?,
            district = ?,
            city = ?,
            is_default = ?
        WHERE id = ? AND user_id = ?
    ");

    $stmt->execute([
        $receiverName,
        $receiverPhone,
        $addressDetail,
        $ward !== "" ? $ward : null,
        $district !== "" ? $district : null,
        $city !== "" ? $city : null,
        $isDefault,
        $id,
        $userId
    ]);

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Cập nhật địa chỉ thành công."
    ]);

} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        "success" => false,
        "message" => "Không thể cập nhật địa chỉ."
    ]);
}
?>