<?php include 'partials/header.php'; ?>

<link rel="stylesheet" href="assets/sanpham.css">

<div class="detail-container">
    <div class="detail-top">
        <!-- Khu vực hình ảnh -->
        <div class="gallery-section">
            <div class="main-img-box">[ Hình ảnh chi tiết sản phẩm ]</div>
            <div class="thumb-list">
                <div class="thumb-item">Ảnh 1</div>
                <div class="thumb-item">Ảnh 2</div>
                <div class="thumb-item">Ảnh 3</div>
                <div class="thumb-item">Ảnh 4</div>
            </div>
        </div>

        <!-- Khu vực thông tin mua hàng -->
        <div class="info-section">
            <h2>Laptop Gaming ASUS ROG Strix G16 G614JV</h2>
            <div class="product-meta">
                <span>Mã SP: <strong>ROG-G16-2024</strong></span>
                <span>Thương hiệu: <strong>ASUS</strong></span>
                <span>Tình trạng: <strong style="color: #10b981;">Còn 12 sản phẩm</strong></span>
            </div>

            <div class="product-rating" style="font-size: 15px;">
                ⭐ 4.8 / 5.0 <span class="sold-count">(125 lượt đánh giá)</span>
            </div>

            <div class="price-box-detail">
                <span class="detail-current-price">22.990.000đ</span>
                <span class="detail-old-price">25.000.000đ</span>
                <span class="badge-discount" style="position: static; margin-left: 10px;">-8%</span>
            </div>

            <p class="short-desc">
                Trang bị vi xử lý Intel Core i7 thế hệ mới cùng card đồ họa NVIDIA GeForce RTX 4060, màn hình 16 inch 165Hz chuẩn màu, giải pháp tản nhiệt thông minh ba quạt tối ưu cho game thủ.
            </p>

            <div class="quantity-control">
                <label><strong>Số lượng:</strong></label>
                <button class="qty-btn" type="button">-</button>
                <input type="text" class="qty-input" value="1" readonly>
                <button class="qty-btn" type="button">+</button>
            </div>

            <div class="detail-actions">
                <button class="btn-add-detail" type="button">Thêm vào giỏ</button>
                <button class="btn-buy-now" type="button">MUA NGAY</button>
            </div>
        </div>
    </div>

    <!-- Khu vực mô tả, thông số và đánh giá -->
    <div class="detail-bottom">
        <div class="tab-headers">
            <div class="tab-btn active">Mô tả sản phẩm</div>
            <div class="tab-btn">Thông số kỹ thuật</div>
            <div class="tab-btn">Đánh giá (125)</div>
        </div>

        <!-- Thông số kỹ thuật -->
        <h3>Thông số kỹ thuật</h3>
        <table class="specs-table">
            <tr><td>CPU</td><td>Intel Core i7-13650HX (14 nhân, 20 luồng)</td></tr>
            <tr><td>RAM</td><td>16GB DDR5 4800MHz (Nâng cấp tối đa 32GB)</td></tr>
            <tr><td>Ổ cứng</td><td>512GB PCIe 4.0 NVMe M.2 SSD</td></tr>
            <tr><td>Card đồ họa</td><td>NVIDIA GeForce RTX 4060 8GB GDDR6</td></tr>
            <tr><td>Màn hình</td><td>16 inch FHD+ (1920 x 1200) 165Hz, IPS, 100% sRGB</td></tr>
        </table>

        <!-- Khối đánh giá -->
        <h3 style="margin-top: 35px;">Đánh giá của khách hàng</h3>
        <div class="rating-overview">
            <div>
                <div class="rating-score">4.8 / 5</div>
                <div style="color: #f59e0b; text-align: center;">⭐⭐⭐⭐⭐</div>
            </div>
            <div class="rating-bars">
                <div>★★★★★ : 82%</div>
                <div>★★★★☆ : 10%</div>
                <div>★★★☆☆ : 5%</div>
                <div>★★☆☆☆ : 2%</div>
                <div>★☆☆☆☆ : 1%</div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>