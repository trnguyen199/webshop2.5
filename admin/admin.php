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

$adminId = $_SESSION["admin_id"];
$adminName = $_SESSION["admin_name"] ?? "Admin";
$adminEmail = $_SESSION["admin_email"] ?? "";
$adminRole = $_SESSION["admin_role"];

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Dashboard</title>

    <link
        rel="stylesheet"
        href="admin.css?v=2.0">
    

</head>

<body>

<div class="admin-container">


    <header class="admin-header">

        <div class="admin-title">

            <h1>Admin Dashboard</h1>

            <p>
                Trang quản trị hệ thống
            </p>

        </div>

        <button
            id="logoutBtn"
            class="logout-btn"
        >
            Đăng xuất
        </button>

    </header>



    <main class="admin-main">


        <section class="welcome-card">

            <div class="welcome-icon">
                👋
            </div>

            <div>

                <h2>
                    Xin chào,
                    <?php
                    echo htmlspecialchars($adminName);
                    ?>!
                </h2>

                <p>
                    Bạn đã đăng nhập thành công
                    với quyền quản trị viên.
                </p>

            </div>

        </section>


        <section class="section">

            <h2 class="section-title">
                👤 Thông tin Admin
            </h2>

            <div class="info-card">

                <div class="info-row">

                    <span class="info-label">
                        ID
                    </span>

                    <span>
                        <?php
                        echo htmlspecialchars($adminId);
                        ?>
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Họ tên
                    </span>

                    <span>
                        <?php
                        echo htmlspecialchars($adminName);
                        ?>
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Email
                    </span>

                    <span>
                        <?php
                        echo htmlspecialchars($adminEmail);
                        ?>
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Quyền
                    </span>

                    <span class="role-badge">
                        <?php
                        echo htmlspecialchars($adminRole);
                        ?>
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Phiên đăng nhập
                    </span>

                    <span class="session-active">
                        ● Đang hoạt động
                    </span>

                </div>

            </div>

        </section>



        <section class="section">

            <h2 class="section-title">
                📊 Tổng quan
            </h2>
        <div class="dashboard-grid">

    <a href="users.php" class="dashboard-card">
        <div class="card-icon">👤</div>
        <h3>Tài khoản</h3>
        <p>Quản lý tài khoản người dùng</p>
    </a>

    <a href="orders.php" class="dashboard-card">
        <div class="card-icon">📦</div>
        <h3>Đơn hàng</h3>
        <p>Theo dõi và quản lý đơn hàng</p>
    </a>

    <a href="security.php" class="dashboard-card">
        <div class="card-icon">🔐</div>
        <h3>Bảo mật</h3>
        <p>Quản lý phiên đăng nhập Admin</p>
    </a>

</div>

        </section>


        <section class="status-card">

            <div>

                <h3>
                    🔒 Bảo mật phiên đăng nhập
                </h3>

                <p>
                    Phiên Admin đang được bảo vệ bằng PHP Session.
                </p>

            </div>

            <span class="status-online">
                Online
            </span>

        </section>

    </main>


    <footer class="admin-footer">

        <p>
            Webshop Admin System
        </p>

    </footer>

</div>


<script src="admin.js"></script>

</body>

</html>