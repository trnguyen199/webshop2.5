<?php
session_start();

if (
    isset($_SESSION["admin_id"]) &&
    isset($_SESSION["admin_role"]) &&
    $_SESSION["admin_role"] === "admin"
) {
    header("Location: ../admin/admin.php");
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

    <title>Đăng nhập Admin</title>

    <link
        rel="stylesheet"
        href="auth.css"
    >

</head>


<body>


<div class="auth-container">


    <div class="auth-box admin-auth-box">


        <!-- HEADER -->

        <div class="auth-header">

            <div class="admin-icon">
                🔐
            </div>

            <h1>
                Đăng nhập Admin
            </h1>

            <p>
                Đăng nhập vào trang quản trị
            </p>

        </div>


        <!-- FORM -->

        <form id="adminLoginForm">


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">

                    Email
                    <span>*</span>

                </label>


                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Nhập email Admin"
                    autocomplete="email"
                    required
                >

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">

                    Mật khẩu
                    <span>*</span>

                </label>


                <div class="password-box">


                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Nhập mật khẩu"
                        autocomplete="current-password"
                        required
                    >


                    <button
                        type="button"
                        id="togglePassword"
                        class="show-password"
                        aria-label="Hiện mật khẩu"
                    >
                        👁️
                    </button>


                </div>

            </div>


            <!-- MESSAGE -->

            <div
                id="message"
                class="message"
            ></div>


            <!-- BUTTON -->

            <button
                type="submit"
                class="auth-button"
            >
                ĐĂNG NHẬP ADMIN
            </button>


        </form>


        <!-- BACK USER LOGIN -->

        <div class="back-login">

            <a href="login.php">
                ← Đăng nhập User
            </a>

        </div>


    </div>


</div>


<script>

const form =
    document.getElementById("adminLoginForm");

const emailInput =
    document.getElementById("email");

const passwordInput =
    document.getElementById("password");

const togglePassword =
    document.getElementById("togglePassword");

const message =
    document.getElementById("message");


/* =========================
   HIỆN / ẨN MẬT KHẨU
========================= */

togglePassword.addEventListener(
    "click",
    function () {

        if (passwordInput.type === "password") {

            passwordInput.type = "text";

            togglePassword.textContent = "🙈";

            togglePassword.setAttribute(
                "aria-label",
                "Ẩn mật khẩu"
            );

        } else {

            passwordInput.type = "password";

            togglePassword.textContent = "👁️";

            togglePassword.setAttribute(
                "aria-label",
                "Hiện mật khẩu"
            );

        }

    }
);


/* =========================
   ĐĂNG NHẬP ADMIN
========================= */

form.addEventListener(
    "submit",
    async function (event) {

        event.preventDefault();


        message.textContent = "";

        message.className = "message";


        const email =
            emailInput.value.trim();

        const password =
            passwordInput.value;


        /* KIỂM TRA */

        if (
            email === "" ||
            password === ""
        ) {

            message.textContent =
                "Vui lòng nhập đầy đủ thông tin.";

            message.classList.add("error");

            return;

        }


        try {


            const response =
                await fetch(
                    "../api/admin-login.php",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type":
                                "application/json"
                        },

                        body: JSON.stringify({
                            email: email,
                            password: password
                        })
                    }
                );


            const data =
                await response.json();


            /* ĐĂNG NHẬP THÀNH CÔNG */

            if (data.success) {

                message.textContent =
                    data.message ||
                    "Đăng nhập Admin thành công.";

                message.classList.add(
                    "success"
                );


                setTimeout(
                    function () {

                        window.location.href =
                            "../admin/admin.php";

                    },
                    500
                );


            } else {


                /* ĐĂNG NHẬP THẤT BẠI */

                message.textContent =
                    data.message ||
                    "Đăng nhập Admin thất bại.";

                message.classList.add(
                    "error"
                );

            }


        } catch (error) {


            console.error(
                "Lỗi đăng nhập Admin:",
                error
            );


            message.textContent =
                "Không thể kết nối đến máy chủ.";

            message.classList.add(
                "error"
            );

        }

    }
);

</script>


</body>

</html>