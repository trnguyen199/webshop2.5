<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: ../account/account.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="auth.css?v=1.2">
</head>

<body>

<div class="auth-container">
    <div class="auth-box">

        <!-- TIÊU ĐỀ -->
        <div class="auth-header">
            <h1>Đăng nhập</h1>
            <p>Nếu bạn có một tài khoản, xin vui lòng đăng nhập</p>
        </div>

        <!-- FORM ĐĂNG NHẬP -->
        <form id="loginForm">
            <div class="form-group">
                <label for="loginEmail">Email <span>*</span></label>
                <input
                    type="email"
                    id="loginEmail"
                    name="email"
                    placeholder="Nhập email"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="form-group">
                <label for="loginPassword">Mật khẩu <span>*</span></label>
                <div class="password-box">
                    <input
                        type="password"
                        id="loginPassword"
                        name="password"
                        placeholder="Nhập mật khẩu"
                        autocomplete="current-password"
                        required
                    >
                </div>
            </div>

            <!-- THÔNG BÁO -->
            <div id="loginMessage" class="message"></div>

            <!-- NÚT ĐĂNG NHẬP -->
            <button type="submit" class="auth-button">ĐĂNG NHẬP</button>
        </form>

        <!-- ĐĂNG KÝ & QUÊN MẬT KHẨU -->
        <div class="switch-page">
            <span>Bạn chưa có tài khoản?</span>
            <a href="register.php">Đăng ký tại đây</a>
        </div>

        <div class="switch-page" style="margin-top: 8px;">
            <span>Bạn quên mật khẩu?</span>
            <a href="forgot-password.php">Lấy lại tại đây</a>
        </div>

    </div>
</div>

<script src="auth.js?v=2.1"></script>
</body>
</html>