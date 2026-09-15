console.log("AUTH JS VERSION 2.0 ĐANG CHẠY");
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    if (!input) return;

    if (input.type === "password") {
        input.type = "text";
        button.textContent = "🙈";
    } else {
        input.type = "password";
        button.textContent = "👁";
    }
}

function showMessage(elementId, message, type) {
    const element = document.getElementById(elementId);
    if (!element) return;

    element.textContent = message;
    element.className = "message " + type;
}

function clearMessage(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;

    element.textContent = "";
    element.className = "message";
}

function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function isValidPhone(phone) {
    const regex = /^(0|\+84)[0-9]{9,10}$/;
    return regex.test(phone);
}
const loginForm = document.getElementById("loginForm");

if (loginForm) {
    loginForm.addEventListener("submit", async function (event) {
        event.preventDefault();
        clearMessage("loginMessage");

        const email = document.getElementById("loginEmail").value.trim();
        const password = document.getElementById("loginPassword").value;

        let valid = true;
            if (email === "") {
         showMessage("loginMessage", "Vui lòng nhập email.", "error");
             valid = false;
}

            if (password === "") {
    showMessage("loginMessage", "Vui lòng nhập mật khẩu.", "error");
            valid = false;
}

            if (!valid) return;

    showMessage("loginMessage", "Đang xử lý đăng nhập...", "info");

        try {
    const response = await fetch("../api/login.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        email: email,
        password: password
    })
});

            const data = await response.json();

            if (data.success) {
                showMessage("loginMessage", data.message || "Đăng nhập thành công! Đang chuyển hướng...", "success");
                setTimeout(() => {
                   window.location.href = data.redirect || "../account/account.php";
                }, 1000);
            } else {
                showMessage("loginMessage", data.message || "Email hoặc mật khẩu không chính xác.", "error");
            }
        } catch (error) {
            showMessage("loginMessage", "Có lỗi xảy ra khi kết nối server.", "error");
        }
    });
}

const registerForm = document.getElementById("registerForm");

if (registerForm) {
    registerForm.addEventListener("submit", async function (event) {

        event.preventDefault();

        clearMessage("registerMessage");

        const name = document.getElementById("fullName").value.trim();
        const email = document.getElementById("registerEmail").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const password = document.getElementById("registerPassword").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        // Kiểm tra
        if (name === "") {
            showMessage("registerMessage", "Vui lòng nhập họ và tên.", "error");
            return;
        }

        if (email === "") {
            showMessage("registerMessage", "Vui lòng nhập email.", "error");
            return;
        }

        if (!isValidEmail(email)) {
            showMessage("registerMessage", "Email không hợp lệ.", "error");
            return;
        }

        if (phone === "") {
            showMessage("registerMessage", "Vui lòng nhập số điện thoại.", "error");
            return;
        }

        if (password === "") {
            showMessage("registerMessage", "Vui lòng nhập mật khẩu.", "error");
            return;
        }

        if (password.length < 6) {
            showMessage("registerMessage", "Mật khẩu phải có ít nhất 6 ký tự.", "error");
            return;
        }

        if (password !== confirmPassword) {
            showMessage("registerMessage", "Mật khẩu nhập lại không khớp.", "error");
            return;
        }

        showMessage("registerMessage", "Đang xử lý đăng ký...", "info");

        try {
            const response = await fetch("../api/register.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body:
                    "name=" + encodeURIComponent(name) +
                    "&email=" + encodeURIComponent(email) +
                    "&phone=" + encodeURIComponent(phone) +
                    "&password=" + encodeURIComponent(password)
            });

            const text = await response.text();

            console.log("API register trả về:", text);

            const data = JSON.parse(text);

            if (data.success) {

                showMessage(
                    "registerMessage",
                    (data.message || "Đăng ký thành công!") + " Đang chuyển hướng sang đăng nhập...",
                    "success"
                );

                registerForm.reset();

                // THÊM ĐOẠN NÀY ĐỂ TỰ ĐỘNG CHUYỂN SANG TRANG LOGIN SAU 1.5 GIÂY
                setTimeout(() => {
                    window.location.href = "login.php";
                }, 1500);

            } else {

                showMessage(
                    "registerMessage",
                    data.message || "Đăng ký thất bại.",
                    "error"
                );
            }

        } catch (error) {

            console.error("Lỗi đăng ký:", error);

            showMessage(
                "registerMessage",
                "Có lỗi xảy ra khi kết nối server.",
                "error"
            );
        }
    });
}

const forgotForm = document.getElementById("forgotForm");

if (forgotForm) {
    forgotForm.addEventListener("submit", async function (event) {
        event.preventDefault();
        clearMessage("forgotMessage");

        const email = document.getElementById("forgotEmail").value.trim();

        if (email === "") {
            document.getElementById("forgotEmailError").textContent = "Vui lòng nhập email.";
            return;
        }

        if (!isValidEmail(email)) {
            document.getElementById("forgotEmailError").textContent = "Email không hợp lệ.";
            return;
        }

        document.getElementById("forgotEmailError").textContent = "";
        showMessage("forgotMessage", "Đang gửi yêu cầu OTP...", "info");

        try {
            const response = await fetch("forgot-password.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams({ email })
            });

            const data = await response.json();

            if (data.success) {
                showMessage("forgotMessage", data.message || "Mã OTP đã được gửi đến email của bạn.", "success");
            } else {
                showMessage("forgotMessage", data.message || "Không thể gửi OTP.", "error");
            }
        } catch (error) {
            showMessage("forgotMessage", "Có lỗi xảy ra khi gửi yêu cầu.", "error");
        }
    });
}

/* =====================================================
   ĐẶT LẠI MẬT KHẨU
===================================================== */
const resetForm = document.getElementById("resetForm");

if (resetForm) {
    resetForm.addEventListener("submit", async function (event) {
        event.preventDefault();
        clearMessage("resetMessage");

        const email = document.getElementById("resetEmail").value.trim();
        const otp = document.getElementById("resetOtp").value.trim();
        const newPassword = document.getElementById("newPassword").value;
        const confirmNewPassword = document.getElementById("confirmNewPassword").value;

        let valid = true;

        if (email === "") {
            document.getElementById("resetEmailError").textContent = "Vui lòng nhập email.";
            valid = false;
        } else if (!isValidEmail(email)) {
            document.getElementById("resetEmailError").textContent = "Email không hợp lệ.";
            valid = false;
        } else {
            document.getElementById("resetEmailError").textContent = "";
        }

        if (otp === "") {
            document.getElementById("resetOtpError").textContent = "Vui lòng nhập mã OTP.";
            valid = false;
        } else if (!/^\d{6}$/.test(otp)) {
            document.getElementById("resetOtpError").textContent = "OTP phải gồm 6 chữ số.";
            valid = false;
        } else {
            document.getElementById("resetOtpError").textContent = "";
        }

        if (newPassword.length < 6) {
            document.getElementById("newPasswordError").textContent = "Mật khẩu phải có ít nhất 6 ký tự.";
            valid = false;
        } else {
            document.getElementById("newPasswordError").textContent = "";
        }

        if (newPassword !== confirmNewPassword) {
            document.getElementById("confirmNewPasswordError").textContent = "Mật khẩu nhập lại không khớp.";
            valid = false;
        } else {
            document.getElementById("confirmNewPasswordError").textContent = "";
        }

        if (!valid) return;

        showMessage("resetMessage", "Đang cập nhật mật khẩu...", "info");

        try {
            const response = await fetch("reset-password.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams({ email, otp, newPassword })
            });

            const data = await response.json();

            if (data.success) {
                showMessage("resetMessage", data.message || "Đặt lại mật khẩu thành công!", "success");
                resetForm.reset();
            } else {
                showMessage("resetMessage", data.message || "Mã OTP không đúng hoặc đã hết hạn.", "error");
            }
        } catch (error) {
            showMessage("resetMessage", "Có lỗi xảy ra khi cập nhật mật khẩu.", "error");
        }
    });
}