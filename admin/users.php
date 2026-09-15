<?php
session_start();

if (
    !isset($_SESSION["admin_id"]) ||
    !isset($_SESSION["admin_role"]) ||
    $_SESSION["admin_role"] !== "admin"
) {
    header("Location: ../auth/admin-login.php");
    exit;
}

require_once "../config/db.php";

try {
    $stmt = $pdo->query("
        SELECT
            id,
            name,
            email,
            phone,
            role,
            created_at
        FROM users
        ORDER BY id DESC
    ");

    $users = $stmt->fetchAll();

} catch (PDOException $e) {
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý tài khoản</title>

    <link rel="stylesheet" href="admin.css?v=3.0">
</head>

<body>

<div class="admin-container">

    <div class="admin-header">
        <div>
            <h1>👤 Quản lý tài khoản</h1>
            <p>Danh sách tài khoản người dùng trong hệ thống</p>
        </div>

        <a href="admin.php" class="back-button">
            ← Quay lại
        </a>
    </div>


    <div class="admin-card">

        <div class="card-header">
            <h2>Danh sách tài khoản</h2>

            <span>
                Tổng: <?php echo count($users); ?> tài khoản
            </span>
        </div>


        <?php if (empty($users)): ?>

            <div class="empty-state">
                Chưa có tài khoản nào.
            </div>

        <?php else: ?>

            <div class="table-container">

                <table class="admin-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Vai trò</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($users as $user): ?>

                        <tr>

                            <td>
                                <?php echo (int)$user["id"]; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($user["name"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($user["email"]); ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $user["phone"] ?? "Chưa cập nhật"
                                );
                                ?>
                            </td>

                            <td>

                                <?php if ($user["role"] === "admin"): ?>

                                    <span class="status-badge status-admin">
                                        Admin
                                    </span>

                                <?php else: ?>

                                    <span class="status-badge status-user">
                                        User
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>
                                <?php
                                echo date(
                                    "d/m/Y H:i",
                                    strtotime($user["created_at"])
                                );
                                ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>