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

$adminId = $_SESSION["admin_id"];

$stmt = $pdo->prepare("
    SELECT id, name, email, phone, role, created_at
    FROM users
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$adminId]);

$admin = $stmt->fetch();

if (!$admin) {
    session_destroy();
    header("Location: ../auth/admin-login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Bảo mật Admin</title>

    <link rel="stylesheet" href="admin.css?v=4.0">

</head>

<body>

<div class="admin-container">

    <!-- HEADER -->
    <header class="admin-header">

        <div class="admin-title">

            <h1>🔐 Bảo mật</h1>

            <p>
                Quản lý thông tin và phiên đăng nhập Admin
            </p>

        </div>

        <button
            type="button"
            class="logout-btn"
            onclick="logoutAdmin()"
        >
            Đăng xuất
        </button>

    </header>


    <!-- MAIN -->
    <main class="admin-main">

        <!-- QUAY LẠI -->
        <div class="section">

            <a
                href="admin.php"
                class="primary-button"
            >
                ← Quay lại
            </a>

        </div>


        <!-- THÔNG TIN ADMIN -->
        <section class="section">

            <h2 class="section-title">
                Thông tin tài khoản Admin
            </h2>

            <div class="info-card">

                <div class="info-row">

                    <span class="info-label">
                        ID tài khoản
                    </span>

                    <span>
                        <?= htmlspecialchars($admin["id"]) ?>
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Họ tên
                    </span>

                    <span>
                        <?= htmlspecialchars($admin["name"]) ?>
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Email
                    </span>

                    <span>
                        <?= htmlspecialchars($admin["email"]) ?>
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Số điện thoại
                    </span>

                    <span>
                        <?= htmlspecialchars(
                            $admin["phone"] ?? "Chưa cập nhật"
                        ) ?>
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Vai trò
                    </span>

                    <span class="role-badge">
                        Admin
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Ngày tạo tài khoản
                    </span>

                    <span>
                        <?= date(
                            "d/m/Y H:i",
                            strtotime($admin["created_at"])
                        ) ?>
                    </span>

                </div>

            </div>

        </section>


        <!-- PHIÊN ĐĂNG NHẬP -->
        <section class="section">

            <h2 class="section-title">
                Phiên đăng nhập
            </h2>

            <div class="status-card">

                <div>

                    <h3>
                        Trạng thái phiên
                    </h3>

                    <p>
                        Tài khoản Admin hiện đang đăng nhập
                    </p>

                </div>

                <span class="status-online">
                    ● Đang hoạt động
                </span>

            </div>

        </section>


        <!-- BẢO MẬT -->
        <section class="section">

            <h2 class="section-title">
                Bảo mật hệ thống
            </h2>

            <div class="info-card">

                <div class="info-row">

                    <span class="info-label">
                        Xác thực mật khẩu
                    </span>

                    <span class="session-active">
                        ✓ Đã bật
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Session
                    </span>

                    <span class="session-active">
                        ✓ Đang hoạt động
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Mật khẩu
                    </span>

                    <span class="session-active">
                        ✓ Được mã hóa
                    </span>

                </div>

            </div>

        </section>


        <!-- ĐĂNG XUẤT -->
        <section class="section">

            <h2 class="section-title">
                Phiên làm việc
            </h2>

            <div class="card">

                <p style="margin-bottom: 15px; color: #777;">
                    Khi đăng xuất, phiên làm việc Admin hiện tại
                    sẽ được kết thúc.
                </p>

                <button
                    type="button"
                    class="logout-btn"
                    onclick="logoutAdmin()"
                >
                    Đăng xuất Admin
                </button>

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
