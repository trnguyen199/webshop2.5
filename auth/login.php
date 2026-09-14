<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng nhập</title>

    <link rel="stylesheet" href="auth.css">
</head>

<body>

<div class="auth-container">

    <div class="auth-box">

        <div class="auth-header">
            <h1>Đăng nhập</h1>
            <p>Đăng nhập vào tài khoản của bạn</p>
        </div>

        <form id="loginForm">

            <div class="form-group">

                <label for="loginEmail">
                    Email
                </label>

                <input
                    type="email"
                    id="loginEmail"
                    name="email"
                    placeholder="Nhập email"
                    autocomplete="email"
                >

                <small
                    class="error"
                    id="loginEmailError">
                </small>

            </div>


            <div class="form-group">

                <label for="loginPassword">
                    Mật khẩu
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="loginPassword"
                        name="password"
                        placeholder="Nhập mật khẩu"
                        autocomplete="current-password"
                    >

                    <button
                        type="button"
                        class="show-password"
                        onclick="togglePassword('loginPassword', this)">
                        👁
                    </button>

                </div>

                <small
                    class="error"
                    id="loginPasswordError">
                </small>

            </div>


            <div class="forgot-link">

                <a href="forgot-password.php">
                    Quên mật khẩu?
                </a>

            </div>


            <button
                type="submit"
                class="auth-button">
                Đăng nhập
            </button>


            <div
                id="loginMessage"
                class="message">
            </div>

        </form>


        <div class="switch-page">

            <span>Chưa có tài khoản?</span>

            <a href="register.php">
                Đăng ký
            </a>

        </div>

    </div>

</div>


<script src="auth.js"></script>

</body>
</html>