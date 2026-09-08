<?php include 'partials/header.php'; ?>

<!-- Liên kết CSS riêng theo yêu cầu của Leader -->
<link rel="stylesheet" href="assets/sanpham.css">

<div class="product-page-container">
    
    <!-- CỘT TRÁI: BỘ LỌC -->
    <aside class="filter-sidebar">
        <h3>Bộ lọc tìm kiếm</h3>

        <div class="filter-group">
            <h4>Danh mục</h4>
            <label><input type="checkbox"> Laptop Gaming</label>
            <label><input type="checkbox"> PC Đồ họa</label>
            <label><input type="checkbox"> Màn hình máy tính</label>
            <label><input type="checkbox"> Phụ kiện Gear</label>
        </div>

        <div class="filter-group">
            <h4>Khoảng giá</h4>
            <label><input type="radio" name="filter_price"> Dưới 10 triệu</label>
            <label><input type="radio" name="filter_price"> 10 - 20 triệu</label>
            <label><input type="radio" name="filter_price"> 20 - 30 triệu</label>
            <label><input type="radio" name="filter_price"> Trên 30 triệu</label>
        </div>

        <div class="filter-group">
            <h4>Thương hiệu</h4>
            <label><input type="checkbox"> ASUS ROG</label>
            <label><input type="checkbox"> MSI</label>
            <label><input type="checkbox"> Dell</label>
            <label><input type="checkbox"> Lenovo</label>
        </div>

        <div class="filter-group">
            <h4>Đánh giá</h4>
            <label><input type="checkbox"> Từ 5 sao</label>
            <label><input type="checkbox"> Từ 4 sao</label>
        </div>

        <div class="filter-group">
            <h4>Tình trạng</h4>
            <label><input type="checkbox"> Còn hàng</label>
            <label><input type="checkbox"> Khuyến mãi sốc</label>
        </div>
    </aside>

    <!-- CỘT PHẢI: KHU VỰC SẢN PHẨM -->
    <main class="product-main">
        
        <div class="product-toolbar">
            <div class="search-box">
                <input type="text" placeholder="🔍 Tìm kiếm sản phẩm...">
            </div>
            <div class="sort-box">
                <label>Sắp xếp: </label>
                <select>
                    <option>Mới nhất</option>
                    <option>Giá thấp → cao</option>
                    <option>Giá cao → thấp</option>
                    <option>Bán chạy nhất</option>
                </select>
            </div>
        </div>

        <div class="product-grid">

            <!-- Item 1 -->
            <div class="product-card">
                <span class="badge-discount">-8%</span>
                <div class="product-img-wrapper">[ Ảnh sản phẩm ]</div>
                <span class="badge-stock">● Còn hàng</span>
                <span class="product-category">Laptop Gaming</span>
                <h3 class="product-title">Laptop Gaming ASUS ROG Strix G16 G614JV</h3>
                <div class="product-rating">⭐ 4.8 <span class="sold-count">| Đã bán 125</span></div>
                <div class="price-box">
                    <span class="current-price">22.990.000đ</span>
                    <span class="old-price">25.000.000đ</span>
                </div>
                <div class="product-actions">
                    <a href="product-detail.php" class="btn-detail">Xem chi tiết</a>
                    <button class="btn-add-cart">Thêm vào giỏ</button>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="product-card">
                <span class="badge-discount">-12%</span>
                <div class="product-img-wrapper">[ Ảnh sản phẩm ]</div>
                <span class="badge-stock">● Còn hàng</span>
                <span class="product-category">PC Workstation</span>
                <h3 class="product-title">PC Đồ Họa GearZone Intel i7 14700K / RTX 4070</h3>
                <div class="product-rating">⭐ 5.0 <span class="sold-count">| Đã bán 42</span></div>
                <div class="price-box">
                    <span class="current-price">28.500.000đ</span>
                    <span class="old-price">32.000.000đ</span>
                </div>
                <div class="product-actions">
                    <a href="product-detail.php" class="btn-detail">Xem chi tiết</a>
                    <button class="btn-add-cart">Thêm vào giỏ</button>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="product-card">
                <span class="badge-discount">-15%</span>
                <div class="product-img-wrapper">[ Ảnh sản phẩm ]</div>
                <span class="badge-stock" style="color: #ef4444;">● Hết hàng</span>
                <span class="product-category">Màn hình</span>
                <h3 class="product-title">Màn hình Gaming LG UltraGear 27 inch 144Hz</h3>
                <div class="product-rating">⭐ 4.6 <span class="sold-count">| Đã bán 89</span></div>
                <div class="price-box">
                    <span class="current-price">5.290.000đ</span>
                    <span class="old-price">6.200.000đ</span>
                </div>
                <div class="product-actions">
                    <a href="product-detail.php" class="btn-detail">Xem chi tiết</a>
                    <button class="btn-add-cart" disabled style="background: #9ca3af; cursor: not-allowed;">Hết hàng</button>
                </div>
            </div>

        </div>
    </main>
</div>

<?php include 'partials/footer.php'; ?>