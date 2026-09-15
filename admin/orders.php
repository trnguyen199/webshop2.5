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

$stmt = $pdo->query("
    SELECT
        o.id,
        o.order_code,
        o.total_amount,
        o.status,
        o.created_at,
        u.name AS user_name,
        u.email AS user_email
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    ORDER BY o.id DESC
");

$orders = $stmt->fetchAll();

$statusMap = [
    "pending" => "Chờ xử lý",
    "confirmed" => "Đã xác nhận",
    "shipping" => "Đang giao",
    "completed" => "Hoàn thành",
    "cancelled" => "Đã hủy"
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý đơn hàng</title>

    <link rel="stylesheet" href="admin.css?v=4.0">
</head>

<body>

<div class="admin-container">

    <!-- HEADER -->
    <header class="admin-header">

        <div class="admin-title">
            <h1>📦 Quản lý đơn hàng</h1>
            <p>Theo dõi các đơn hàng của khách hàng</p>
        </div>

        <button
            type="button"
            class="logout-btn"
            onclick="logoutAdmin()">
            Đăng xuất
        </button>

    </header>


    <!-- MAIN -->
    <main class="admin-main">

        <!-- QUAY LẠI -->
        <div class="section">

            <a href="admin.php" class="primary-button">
                ← Quay lại
            </a>

        </div>


        <!-- DANH SÁCH -->
        <section class="section">

            <h2 class="section-title">
                Danh sách đơn hàng
            </h2>

            <div class="info-card">

                <div class="info-row">

                    <span class="info-label">
                        Tổng số đơn hàng
                    </span>

                    <span class="role-badge">
                        <?= count($orders) ?> đơn hàng
                    </span>

                </div>

            </div>

        </section>


        <!-- BẢNG ĐƠN HÀNG -->
        <section class="section">

            <div class="card">

                <?php if (count($orders) > 0): ?>

                    <div class="table-wrapper">

                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Email</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php foreach ($orders as $order): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($order["id"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($order["order_code"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $order["user_name"] ?? "Không xác định"
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $order["user_email"] ?? "Không có"
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= number_format(
                                            $order["total_amount"],
                                            0,
                                            ",",
                                            "."
                                        ) ?> ₫
                                    </td>

                                    <td>
                                        <span class="role-badge">
                                            <?= htmlspecialchars(
                                                $statusMap[$order["status"]]
                                                ?? $order["status"]
                                            ) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= date(
                                            "d/m/Y H:i",
                                            strtotime($order["created_at"])
                                        ) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php else: ?>

                    <div class="empty-state">

                        <div class="empty-icon">
                            📦
                        </div>

                        <h3>
                            Chưa có đơn hàng nào
                        </h3>

                        <p>
                            Hiện tại hệ thống chưa có đơn hàng của khách hàng.
                        </p>

                    </div>

                <?php endif; ?>

            </div>

        </section>

    </main>


    <!-- FOOTER -->
    <footer class="admin-footer">
        © 2026 WebShop Admin
    </footer>

</div>


<script src="admin.js?v=4.0"></script>

</body>
</html>
```
