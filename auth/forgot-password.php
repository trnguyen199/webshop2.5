<!DOCTYPE html>
<html lang="vi">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Quên mật khẩu</title>

    <link rel="stylesheet" href="auth.css">

</head>

<body>

<div class="auth-container">

    <div class="auth-box">

        <div class="auth-header">

            <h1>Quên mật khẩu</h1>

            <p>
                Nhập email để nhận mã xác thực
            </p>

        </div>


        <form id="forgotForm">

            <div class="form-group">

                <label for="forgotEmail">
                    Email
                </label>

                <input
                    type="email"
                    id="forgotEmail"
                    name="email"
                    placeholder="Nhập email đã đăng ký"
                    autocomplete="email"
                >

                <small
                    class="error"
                    id="forgotEmailError">
                </small>

            </div>


            <button
                type="submit"
                class="auth-button">

                Gửi mã OTP

            </button>


            <div
                id="forgotMessage"
                class="message">
            </div>

        </form>


        <div class="switch-page">

            <a href="login.php">
                ← Quay lại đăng nhập
            </a>

        </div>

    </div>

</div>


<script src="auth.js"></script>

</body>
</html>