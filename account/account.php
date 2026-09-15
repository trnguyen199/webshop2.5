<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$userName = $_SESSION["user_name"] ?? "Bạn";
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tài khoản của tôi</title>

    <link rel="stylesheet" href="account.css">
</head>

<body>

<div class="account-container">

    <aside class="sidebar">

        <div class="sidebar-title">
            <h2>Tài khoản</h2>
            <p id="sidebarName">Xin chào, <?php echo htmlspecialchars($userName); ?>
        </p>    
        </div>

        <button class="menu-item active" onclick="showSection('profile', this)">
            👤 Hồ sơ cá nhân
        </button>

        <button class="menu-item" onclick="showSection('password', this)">
            🔒 Đổi mật khẩu
        </button>

        <button class="menu-item" onclick="showSection('address', this)">
            📍 Địa chỉ
        </button>

        <button class="menu-item" onclick="showSection('orders', this)">
            📦 Đơn hàng
        </button>

        <button class="menu-item logout-button" onclick="logout()">
            🚪 Đăng xuất
        </button>

    </aside>


    <main class="content">

        <div id="message" class="message"></div>



        <section id="profile" class="section active">

            <div class="section-header">
                <h1>Hồ sơ cá nhân</h1>
                <p>Quản lý thông tin cá nhân của bạn.</p>
            </div>

            <div class="card profile-card">


                <div class="profile-form">

                    <div class="form-group">

                        <label>Họ và tên</label>

                        <input
                            type="text"
                            id="profileName"
                            placeholder="Nhập họ tên"
                        >

                    </div>


                    <div class="form-group">

                        <label>Email</label>

                    <input
                         type="email"
                         id="profileEmail"
                        placeholder="Nhập email"
                    >       

                    </div>


                    <div class="form-group">

                        <label>Số điện thoại</label>

                        <input
                            type="text"
                            id="profilePhone"
                            placeholder="Nhập số điện thoại"
                        >

                    </div>


                    <button
                        class="primary-button"
                        onclick="updateProfile()"
                    >
                        Lưu thay đổi
                    </button>

                </div>

            </div>

        </section>



        <section id="password" class="section">

            <div class="section-header">

                <h1>Đổi mật khẩu</h1>

                <p>
                    Cập nhật mật khẩu để bảo vệ tài khoản.
                </p>

            </div>


            <div class="card">

                <div class="form-group">

                    <label>Mật khẩu hiện tại</label>

                    <input
                        type="password"
                        id="currentPassword"
                    >

                </div>


                <div class="form-group">

                    <label>Mật khẩu mới</label>

                    <input
                        type="password"
                        id="newPassword"
                    >

                </div>


                <div class="form-group">

                    <label>Xác nhận mật khẩu mới</label>

                    <input
                        type="password"
                        id="confirmPassword"
                    >

                </div>


                <button
                    class="primary-button"
                    onclick="changePassword()"
                >
                    Đổi mật khẩu
                </button>

            </div>

        </section>



        <section id="address" class="section">

            <div class="section-header address-header">

                <div>

                    <h1>Địa chỉ của tôi</h1>

                    <p>
                        Quản lý địa chỉ nhận hàng.
                    </p>

                </div>


                <button
                    class="primary-button"
                    onclick="openAddressForm()"
                >
                    + Thêm địa chỉ
                </button>

            </div>


            <div
                id="addressForm"
                class="card address-form hidden"
            >

                <h3 id="addressFormTitle">
                    Thêm địa chỉ
                </h3>

                <input
                    type="hidden"
                    id="addressId"
                >


                <div class="form-row">

                    <div class="form-group">

                        <label>Người nhận</label>

                        <input
                            type="text"
                            id="receiverName"
                        >

                    </div>


                    <div class="form-group">

                        <label>Số điện thoại</label>

                        <input
                            type="text"
                            id="receiverPhone"
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label>Địa chỉ chi tiết</label>

                    <input
                        type="text"
                        id="addressDetail"
                        placeholder="Số nhà, tên đường..."
                    >

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label>Phường/Xã</label>

                        <input
                            type="text"
                            id="ward"
                        >

                    </div>


                    <div class="form-group">

                        <label>Quận/Huyện</label>

                        <input
                            type="text"
                            id="district"
                        >

                    </div>


                    <div class="form-group">

                        <label>Tỉnh/Thành phố</label>

                        <input
                            type="text"
                            id="city"
                        >

                    </div>

                </div>


                <label class="checkbox">

                    <input
                        type="checkbox"
                        id="isDefault"
                    >

                    Đặt làm địa chỉ mặc định

                </label>


                <div class="form-actions">

                    <button
                        class="primary-button"
                        onclick="saveAddress()"
                    >
                        Lưu địa chỉ
                    </button>

                    <button
                        class="secondary-button"
                        onclick="closeAddressForm()"
                    >
                        Hủy
                    </button>

                </div>

            </div>


            <div id="addressList"></div>

        </section>


        <section id="orders" class="section">

            <div class="section-header">

                <h1>Đơn hàng của tôi</h1>

                <p>
                    Theo dõi các đơn hàng của bạn.
                </p>

            </div>


            <div id="orderList"></div>

        </section>

    </main>

</div>


<script src="account.js"></script>

</body>
</html>