const logoutBtn =
    document.getElementById("logoutBtn");


logoutBtn.addEventListener(
    "click",
    async function () {

        const confirmLogout = confirm(
            "Bạn có chắc muốn đăng xuất Admin?"
        );

        if (!confirmLogout) {
            return;
        }


        try {

            const response = await fetch(
                "../api/admin-logout.php",
                {
                    method: "POST"
                }
            );


            const data =
                await response.json();


            if (data.success) {

                window.location.href =
                    "../auth/admin-login.php";

            } else {

                alert(
                    data.message ||
                    "Đăng xuất thất bại."
                );

            }

        } catch (error) {

            console.error(error);

            alert(
                "Không thể kết nối đến máy chủ."
            );

        }

    }
);