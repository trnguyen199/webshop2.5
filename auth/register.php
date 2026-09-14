<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng ký tài khoản</title>

    <link rel="stylesheet" href="auth.css">
</head>

<body>

    <div class="auth-container">

        <div class="auth-box">

            <h1>Đăng ký</h1>

            <p class="auth-subtitle">
                Tạo tài khoản mới
            </p>


            <form id="registerForm">

                <!-- HỌ TÊN -->
                <div class="form-group">

                    <label for="registerName">
                        Họ và tên
                    </label>

                    <input
                        type="text"
                        id="registerName"
                        name="name"
                        placeholder="Nhập họ và tên"
                    >

                    <small
                        id="registerNameError"
                        class="error-message">
                    </small>

                </div>


                <!-- EMAIL -->
                <div class="form-group">

                    <label for="registerEmail">
                        Email
                    </label>

                    <input
                        type="email"
                        id="registerEmail"
                        name="email"
                        placeholder="Nhập email"
                    >

                    <small
                        id="registerEmailError"
                        class="error-message">
                    </small>

                </div>


                <!-- SỐ ĐIỆN THOẠI -->
                <div class="form-group">

                    <label for="registerPhone">
                        Số điện thoại
                    </label>

                    <input
                        type="text"
                        id="registerPhone"
                        name="phone"
                        placeholder="Nhập số điện thoại"
                    >

                    <small
                        id="registerPhoneError"
                        class="error-message">
                    </small>

                </div>


                <!-- MẬT KHẨU -->
                <div class="form-group">

                    <label for="registerPassword">
                        Mật khẩu
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="registerPassword"
                            name="password"
                            placeholder="Nhập mật khẩu"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('registerPassword', this)">
                            👁
                        </button>

                    </div>

                    <small
                        id="registerPasswordError"
                        class="error-message">
                    </small>

                </div>


                <!-- NHẬP LẠI MẬT KHẨU -->
                <div class="form-group">

                    <label for="registerConfirmPassword">
                        Nhập lại mật khẩu
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="registerConfirmPassword"
                            name="confirmPassword"
                            placeholder="Nhập lại mật khẩu"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('registerConfirmPassword', this)">
                            👁
                        </button>

                    </div>

                    <small
                        id="registerConfirmPasswordError"
                        class="error-message">
                    </small>

                </div>


                <!-- THÔNG BÁO -->
                <div
                    id="registerMessage"
                    class="message">
                </div>


                <!-- NÚT ĐĂNG KÝ -->
                <button
                    type="submit"
                    class="auth-button">
                    Đăng ký
                </button>

            </form>


            <p class="auth-footer">

                Đã có tài khoản?

                <a href="login.php">
                    Đăng nhập
                </a>

            </p>

        </div>

    </div>


    <script src="auth.js"></script>

</body>

</html>