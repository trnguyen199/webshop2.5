<?php
session_start();

if (isset($_SESSION["admin_id"]) && $_SESSION["admin_role"] === "admin") {
    header("Location: ../admin/admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>

    <link rel="stylesheet" href="auth.css">
</head>

<body>

<div class="auth-container">

    <div class="auth-box">

        <h1>Đăng nhập Admin</h1>

        <p class="auth-subtitle">
            Đăng nhập vào trang quản trị
        </p>

        <form id="adminLoginForm">

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Nhập email Admin"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>

                <div class="password-box">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Nhập mật khẩu"
                        required
                    >

                    <button
                        type="button"
                        id="togglePassword"
                    >
                        👁️
                    </button>

                </div>
            </div>

            <button
                type="submit"
                class="auth-button"
            >
                Đăng nhập Admin
            </button>

            <p
                id="message"
                class="message"
            ></p>

        </form>

        <div class="back-login">
            <a href="login.php">
                ← Đăng nhập User
            </a>
        </div>

    </div>

</div>


<script>

const form = document.getElementById("adminLoginForm");

const emailInput = document.getElementById("email");

const passwordInput = document.getElementById("password");

const togglePassword =
    document.getElementById("togglePassword");

const message =
    document.getElementById("message");

togglePassword.addEventListener("click", function () {

    if (passwordInput.type === "password") {

        passwordInput.type = "text";

        togglePassword.textContent = "🙈";

    } else {

        passwordInput.type = "password";

        togglePassword.textContent = "👁️";

    }

});

form.addEventListener("submit", async function (event) {

    event.preventDefault();

    message.textContent = "";
    message.className = "message";

    const email = emailInput.value.trim();

    const password = passwordInput.value;


    if (email === "" || password === "") {

        message.textContent =
            "Vui lòng nhập đầy đủ thông tin.";

        message.classList.add("error");

        return;
    }


    try {

        const response = await fetch(
            "../api/admin-login.php",
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({
                    email: email,
                    password: password
                })
            }
        );


        const data = await response.json();


        if (data.success) {

            message.textContent =
                "Đăng nhập Admin thành công!";

            message.classList.add("success");


            setTimeout(function () {

                window.location.href =
                    "../admin/admin.php";

            }, 500);

        } else {

            message.textContent =
                data.message || "Đăng nhập thất bại.";

            message.classList.add("error");

        }

    } catch (error) {

        console.error(error);

        message.textContent =
            "Không thể kết nối đến máy chủ.";

        message.classList.add("error");

    }

});

</script>

</body>
</html>