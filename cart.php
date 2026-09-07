<?php $pageTitle = 'Giỏ hàng'; require __DIR__ . '/partials/header.php'; ?>

<main class="page-main container" style="max-width: 1000px; margin: 40px auto; font-family: 'Inter', system-ui, sans-serif; padding: 24px; color: #f8fafc;">
  
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; background: #1e293b; padding: 20px; border-radius: 12px; border: 1px solid #334155;">
    <div>
      <p class="eyebrow" style="color: #38bdf8; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 4px 0;">GearZone Store</p>
      <h1 style="font-size: 24px; font-weight: 800; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 10px;">
        🛒 Giỏ Hàng Công Nghệ
      </h1>
    </div>
    <a href="products.php" style="text-decoration: none; color: #38bdf8; font-weight: 600; font-size: 14px; border: 1px solid #38bdf8; padding: 10px 18px; border-radius: 8px; transition: all 0.2s; background: rgba(56, 189, 248, 0.1);">
      ← Tiếp tục mua sắm
    </a>
  </div>

  <!-- BAR CHỌN TẤT CẢ & XÓA NHIỀU SẢN PHẨM -->
  <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; background: #1e293b; border-radius: 10px; margin-bottom: 16px; border: 1px solid #334155;">
    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 600; font-size: 14px; color: #e2e8f0;">
      <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)" style="width: 18px; height: 18px; cursor: pointer; accent-color: #38bdf8;">
      Chọn tất cả (<span id="total-stock-items" style="color: #38bdf8;">0</span> sản phẩm còn hàng)
    </label>

    <button onclick="removeSelectedItems()" style="border: 1px solid #ef4444; background: rgba(239, 68, 68, 0.1); color: #f87171; padding: 8px 14px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600;">
      🗑️ Xóa sản phẩm đã chọn
    </button>
  </div>

  <!-- DANH SÁCH SẢN PHẨM TRONG GIỎ -->
  <div id="cart-list" style="display: flex; flex-direction: column; gap: 14px;"></div>

  <!-- KHU VỰC TỔNG KẾT ĐƠN HÀNG & MÃ GIẢM GIÁ -->
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 24px;">
    
    <!-- KHỐI 1: MÃ GIẢM GIÁ (VOUCHER) -->
    <div style="background: #1e293b; padding: 20px; border-radius: 12px; border: 1px solid #334155; align-self: start;">
      <h4 style="margin: 0 0 12px 0; font-size: 16px; color: #f8fafc; display: flex; align-items: center; gap: 8px;">🏷️ Mã giảm giá (Voucher)</h4>
      
      <div style="display: flex; gap: 10px;">
        <input type="text" id="coupon-code" placeholder="Nhập mã (VD: GEAR10)..." style="flex: 1; padding: 12px; border: 1px solid #475569; border-radius: 8px; text-transform: uppercase; outline: none; color: #ffffff; background: #0f172a; font-weight: 600;">
        <button onclick="applyCoupon()" style="padding: 12px 20px; background: #0284c7; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: 700;">
          Áp dụng
        </button>
      </div>

      <div id="coupon-msg" style="font-size: 13px; margin-top: 10px; font-weight: 500;"></div>
      
      <div style="margin-top: 14px; font-size: 12px; color: #94a3b8; background: #0f172a; padding: 10px; border-radius: 8px; border: 1px solid #334155;">
        📌 <strong>Gợi ý mã test:</strong><br>
        • <code style="color: #38bdf8;">GEAR10</code>: Giảm 10%<br>
        • <code style="color: #38bdf8;">MIN500K</code>: Giảm 50k (đơn từ 500.000đ)<br>
        • <code style="color: #f87171;">HETHAN</code>: Mã đã hết hạn
      </div>
    </div>

    <!-- KHỐI 2: CHI TIẾT TỔNG TÍNH TIỀN -->
    <div style="background: #1e293b; padding: 20px; border-radius: 12px; border: 1px solid #334155;">
      <h4 style="margin: 0 0 14px 0; font-size: 16px; color: #f8fafc; border-bottom: 1px solid #334155; padding-bottom: 10px;">📊 Tóm tắt đơn hàng</h4>

      <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #cbd5e1;">
        <span>Tổng số sản phẩm chọn:</span>
        <strong id="total-count" style="color: #ffffff;">0 món</strong>
      </div>

      <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #cbd5e1;">
        <span>Tổng tiền hàng:</span>
        <span id="sub-total" style="color: #ffffff; font-weight: 600;">0 đ</span>
      </div>

      <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #4ade80;">
        <span>Số tiền được giảm:</span>
        <span id="discount-amount" style="font-weight: 600;">-0 đ</span>
      </div>

      <div style="display: flex; justify-content: space-between; margin-bottom: 14px; font-size: 14px; color: #cbd5e1;">
        <span>Phí vận chuyển:</span>
        <span id="shipping-fee" style="color: #ffffff;">0 đ</span>
      </div>

      <div style="display: flex; justify-content: space-between; border-top: 1px solid #334155; padding-top: 14px; margin-top: 14px;">
        <span style="font-size: 16px; font-weight: 700; color: #ffffff;">Tổng thanh toán:</span>
        <strong id="final-total" style="color: #f87171; font-size: 24px;">0 đ</strong>
      </div>

      <button onclick="goToCheckout()" style="width: 100%; margin-top: 18px; padding: 14px; background: #22c55e; color: #fff; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);">
        Tiến hành thanh toán ➔
      </button>
    </div>

  </div>

  <!-- KHU VỰC CHECKOUT & VIETQR -->
  <div id="checkout-section" style="display: none; margin-top: 32px; padding: 24px; background: #1e293b; border-radius: 12px; border: 1px solid #0284c7;">
    <h3 style="color: #38bdf8; margin-top: 0;">💳 Thanh Toán Qua Mã VietQR</h3>
    <p style="font-size: 14px; color: #cbd5e1;">Mã đơn hàng: <strong id="order-id" style="color: #38bdf8;"></strong></p>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 16px;">
      <!-- Form giao hàng -->
      <div style="background: #0f172a; padding: 18px; border-radius: 10px; border: 1px solid #334155;">
        <h4 style="margin-top: 0; color: #f8fafc;">Thông tin giao hàng</h4>
        <input type="text" id="cust-name" placeholder="Họ và tên (*)" style="width: 100%; box-sizing: border-box; padding: 10px; margin-bottom: 12px; border: 1px solid #475569; border-radius: 6px; background: #1e293b; color: #fff;">
        <input type="text" id="cust-phone" placeholder="Số điện thoại (*)" style="width: 100%; box-sizing: border-box; padding: 10px; margin-bottom: 12px; border: 1px solid #475569; border-radius: 6px; background: #1e293b; color: #fff;">
        <textarea id="cust-address" placeholder="Địa chỉ nhận hàng (*)" style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #475569; border-radius: 6px; height: 70px; background: #1e293b; color: #fff;"></textarea>
      </div>

      <!-- Khối VietQR -->
      <div style="border: 1px solid #334155; padding: 18px; border-radius: 10px; text-align: center; background: #0f172a;">
        <h4 style="margin-top: 0; color: #f8fafc;">Tài khoản nhận tiền</h4>
        <select id="bank-id" onchange="updateQR()" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 6px; border: 1px solid #475569; background: #1e293b; color: #fff;">
          <option value="MB">MBBank - Ngân hàng Quân Đội</option>
          <option value="VCB">Vietcombank</option>
          <option value="TCB">Techcombank</option>
        </select>
        <input type="text" id="bank-acc" placeholder="Số tài khoản" value="0987654321" oninput="updateQR()" style="width: 100%; box-sizing: border-box; padding: 10px; margin-bottom: 12px; border-radius: 6px; border: 1px solid #475569; background: #1e293b; color: #fff;">
        
        <img id="qr-img" src="" alt="VietQR" style="max-width: 180px; border-radius: 8px; display: block; margin: 0 auto; padding: 6px; background: #fff;">
      </div>
    </div>

    <button onclick="confirmOrder()" style="width: 100%; margin-top: 20px; padding: 14px; background: #0284c7; color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 16px;">
      Xác nhận đã chuyển khoản
    </button>
  </div>

</main>

<script>
let cartItems = [
  { 
    id: 1, 
    name: 'Laptop Gaming ASUS ROG Strix G16', 
    variant: 'RAM 16GB | SSD 512GB | RTX 4060', 
    price: 24990000, 
    origPrice: 26990000, 
    qty: 1, 
    stock: 5, 
    inStock: true, 
    selected: true, 
    img: 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=150' 
  },
  { 
    id: 2, 
    name: 'Màn hình PC Dell UltraSharp 27 inch', 
    variant: '4K IPS | 60Hz | USB-C 90W', 
    price: 9500000, 
    origPrice: 10500000, 
    qty: 1, 
    stock: 8, 
    inStock: true, 
    selected: true, 
    img: 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=150' 
  },
  { 
    id: 3, 
    name: 'Smart Tivi Samsung Neo QLED 55 inch', 
    variant: 'Khung viền Đen | QLED 4K', 
    price: 13490000, 
    origPrice: 15000000, 
    qty: 1, 
    stock: 0, 
    inStock: false, 
    selected: false, 
    img: 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=150' 
  }
];

const SYSTEM_COUPONS = {
  'GEAR10': { type: 'percent', value: 10, minOrder: 0, expired: false },
  'MIN500K': { type: 'amount', value: 50000, minOrder: 500000, expired: false },
  'HETHAN': { type: 'percent', value: 20, minOrder: 0, expired: true }
};

let appliedCoupon = null;
let currentOrderId = '';

// ĐỒNG BỘ SỐ LƯỢNG GIỎ HÀNG VỚI ICON TRÊN HEADER
function updateHeaderCartBadge() {
  const totalQty = cartItems.reduce((sum, item) => sum + item.qty, 0);
  
  // Tìm thẻ chứa số giỏ hàng trên Header (thường có class hoặc nằm trong thẻ giỏ hàng)
  const headerBadge = document.querySelector('.header-cart-badge, header .cart-count, [class*="cart"] span, [href*="cart"] span');
  if (headerBadge) {
    headerBadge.innerText = totalQty;
  }
}

function renderCart() {
  const container = document.getElementById('cart-list');
  container.innerHTML = '';

  const inStockItems = cartItems.filter(i => i.inStock);
  document.getElementById('total-stock-items').innerText = inStockItems.length;

  if (cartItems.length === 0) {
    container.innerHTML = `
      <div style="text-align: center; padding: 50px 0; color: #94a3b8; background: #1e293b; border-radius: 12px; border: 1px solid #334155;">
        <p style="font-size: 18px; margin-bottom: 12px;">Giỏ hàng của bạn đang trống!</p>
        <a href="products.php" style="color: #38bdf8; text-decoration: underline; font-weight: 600;">Quay lại cửa hàng để mua sắm</a>
      </div>
    `;
  } else {
    cartItems.forEach(item => {
      const itemTotal = item.price * item.qty;
      container.innerHTML += `
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border: ${item.selected ? '2px solid #38bdf8' : '1px solid #334155'}; border-radius: 12px; background: ${item.inStock ? '#1e293b' : '#0f172a'}; opacity: ${item.inStock ? 1 : 0.6}">
          
          <input type="checkbox" ${item.selected ? 'checked' : ''} ${!item.inStock ? 'disabled' : ''} onchange="toggleSelect(${item.id})" style="width: 18px; height: 18px; cursor: ${item.inStock ? 'pointer' : 'not-allowed'}; margin-right: 10px; accent-color: #38bdf8;">
          
          <img src="${item.img}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; margin-right: 14px; border: 1px solid #334155;">
          
          <div style="flex: 1;">
            <h4 style="margin: 0 0 6px 0; font-size: 16px; color: #f8fafc;">${item.name}</h4>
            <span style="font-size: 12px; color: #94a3b8; background: #0f172a; padding: 3px 8px; border-radius: 4px; display: inline-block; border: 1px solid #334155;">Biến thể: ${item.variant}</span>
            <div style="font-size: 12px; margin-top: 6px;">
              ${item.inStock ? `<span style="color: #4ade80; font-weight: 600;">✓ Tồn kho: ${item.stock} sp</span>` : '<span style="color: #f87171; font-weight: 600;">✕ Tình trạng: Hết hàng</span>'}
            </div>
          </div>

          <div style="text-align: right; margin-right: 20px;">
            <strong style="color: #f87171; font-size: 16px;">${item.price.toLocaleString('vi-VN')} đ</strong>
            ${item.origPrice > item.price ? `<div style="color: #64748b; text-decoration: line-through; font-size: 12px;">${item.origPrice.toLocaleString('vi-VN')} đ</div>` : ''}
          </div>

          <div style="display: flex; align-items: center; gap: 4px; background: #0f172a; padding: 4px; border-radius: 6px; border: 1px solid #334155;">
            <button ${!item.inStock ? 'disabled' : ''} onclick="changeQty(${item.id}, -1)" style="border:none; background:#1e293b; color:#fff; cursor:pointer; width:28px; height:28px; border-radius:4px; font-weight:bold;">-</button>
            <input type="number" ${!item.inStock ? 'disabled' : ''} value="${item.qty}" onchange="directQty(${item.id}, this.value)" style="width: 40px; text-align: center; border: none; background: transparent; font-weight: bold; color: #ffffff; outline: none;">
            <button ${!item.inStock ? 'disabled' : ''} onclick="changeQty(${item.id}, 1)" style="border:none; background:#1e293b; color:#fff; cursor:pointer; width:28px; height:28px; border-radius:4px; font-weight:bold;">+</button>
          </div>

          <strong style="width: 120px; text-align: right; font-size: 16px; margin-left: 14px; color: #f8fafc;">
            ${itemTotal.toLocaleString('vi-VN')} đ
          </strong>

          <button onclick="removeItem(${item.id})" style="color: #f87171; border: 1px solid #ef4444; background: rgba(239, 68, 68, 0.1); padding: 8px; border-radius: 6px; cursor: pointer; margin-left: 14px;">✕</button>
        </div>
      `;
    });
  }

  calculateTotal();
  updateHeaderCartBadge();
}

function toggleSelect(id) {
  const item = cartItems.find(i => i.id === id);
  if (item) item.selected = !item.selected;
  renderCart();
}

function toggleSelectAll(master) {
  cartItems.forEach(i => { if (i.inStock) i.selected = master.checked; });
  renderCart();
}

function changeQty(id, delta) {
  const item = cartItems.find(i => i.id === id);
  if (item) {
    let newQty = item.qty + delta;
    if (newQty < 1) newQty = 1;
    if (newQty > item.stock) {
      alert(`Chỉ còn tối đa ${item.stock} sản phẩm trong kho!`);
      newQty = item.stock;
    }
    item.qty = newQty;
  }
  renderCart();
}

function directQty(id, val) {
  const item = cartItems.find(i => i.id === id);
  if (item) {
    let num = parseInt(val) || 1;
    if (num > item.stock) {
      alert(`Số lượng nhập vượt quá tồn kho (${item.stock} sp)!`);
      num = item.stock;
    }
    item.qty = Math.max(1, num);
  }
  renderCart();
}

function removeItem(id) {
  cartItems = cartItems.filter(i => i.id !== id);
  renderCart();
}

function removeSelectedItems() {
  const selectedCount = cartItems.filter(i => i.selected).length;
  if (selectedCount === 0) {
    alert('Vui lòng chọn ít nhất 1 sản phẩm để xóa!');
    return;
  }
  if (confirm(`Bạn có chắc muốn xóa ${selectedCount} sản phẩm đã chọn?`)) {
    cartItems = cartItems.filter(i => !i.selected);
    renderCart();
  }
}// 1. CẬP NHẬT HÀM RENDER GIỎ HÀNG (Ẩn bảng tính tiền khi trống hẳn)
function renderCart() {
  const container = document.getElementById('cart-list');
  container.innerHTML = '';

  const inStockItems = cartItems.filter(i => i.inStock);
  document.getElementById('total-stock-items').innerText = inStockItems.length;

  if (cartItems.length === 0) {
    // Ẩn thanh chọn tất cả và khu vực tổng kết tiền khi giỏ rỗng
    document.querySelector('.page-main > div:nth-child(2)').style.display = 'none'; 
    document.querySelector('.page-main > div:nth-child(4)').style.display = 'none'; 
    
    container.innerHTML = `
      <div style="text-align: center; padding: 50px 0; color: #94a3b8; background: #1e293b; border-radius: 12px; border: 1px solid #334155;">
        <p style="font-size: 18px; margin-bottom: 12px; color: #f8fafc;">Giỏ hàng của bạn đang trống!</p>
        <a href="products.php" style="color: #38bdf8; text-decoration: underline; font-weight: 600;">Quay lại cửa hàng để chọn mua sản phẩm</a>
      </div>
    `;
  } else {
    // Hiện lại nếu có sản phẩm
    document.querySelector('.page-main > div:nth-child(2)').style.display = 'flex';
    document.querySelector('.page-main > div:nth-child(4)').style.display = 'grid';

    cartItems.forEach(item => {
      const itemTotal = item.price * item.qty;
      container.innerHTML += `
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border: ${item.selected ? '2px solid #38bdf8' : '1px solid #334155'}; border-radius: 12px; background: ${item.inStock ? '#1e293b' : '#0f172a'}; opacity: ${item.inStock ? 1 : 0.7}">
          
          <!-- Bỏ disabled ở checkbox để user vẫn chọn xóa được -->
          <input type="checkbox" ${item.selected ? 'checked' : ''} onchange="toggleSelect(${item.id})" style="width: 18px; height: 18px; cursor: pointer; margin-right: 10px; accent-color: #38bdf8;">
          
          <img src="${item.img}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; margin-right: 14px; border: 1px solid #334155;">
          
          <div style="flex: 1;">
            <h4 style="margin: 0 0 6px 0; font-size: 16px; color: #f8fafc;">${item.name}</h4>
            <span style="font-size: 12px; color: #94a3b8; background: #0f172a; padding: 3px 8px; border-radius: 4px; display: inline-block; border: 1px solid #334155;">Biến thể: ${item.variant}</span>
            <div style="font-size: 12px; margin-top: 6px;">
              ${item.inStock ? `<span style="color: #4ade80; font-weight: 600;">✓ Tồn kho: ${item.stock} sp</span>` : '<span style="color: #f87171; font-weight: 600;">✕ Tình trạng: Hết hàng</span>'}
            </div>
          </div>

          <div style="text-align: right; margin-right: 20px;">
            <strong style="color: #f87171; font-size: 16px;">${item.price.toLocaleString('vi-VN')} đ</strong>
            ${item.origPrice > item.price ? `<div style="color: #64748b; text-decoration: line-through; font-size: 12px;">${item.origPrice.toLocaleString('vi-VN')} đ</div>` : ''}
          </div>

          <div style="display: flex; align-items: center; gap: 4px; background: #0f172a; padding: 4px; border-radius: 6px; border: 1px solid #334155;">
            <button ${!item.inStock ? 'disabled' : ''} onclick="changeQty(${item.id}, -1)" style="border:none; background:#1e293b; color:#fff; cursor:pointer; width:28px; height:28px; border-radius:4px; font-weight:bold;">-</button>
            <input type="number" ${!item.inStock ? 'disabled' : ''} value="${item.qty}" onchange="directQty(${item.id}, this.value)" style="width: 40px; text-align: center; border: none; background: transparent; font-weight: bold; color: #ffffff; outline: none;">
            <button ${!item.inStock ? 'disabled' : ''} onclick="changeQty(${item.id}, 1)" style="border:none; background:#1e293b; color:#fff; cursor:pointer; width:28px; height:28px; border-radius:4px; font-weight:bold;">+</button>
          </div>

          <strong style="width: 120px; text-align: right; font-size: 16px; margin-left: 14px; color: #f8fafc;">
            ${itemTotal.toLocaleString('vi-VN')} đ
          </strong>

          <!-- Nút xóa trực tiếp từng món -->
          <button onclick="removeItem(${item.id})" style="color: #f87171; border: 1px solid #ef4444; background: rgba(239, 68, 68, 0.1); padding: 8px; border-radius: 6px; cursor: pointer; margin-left: 14px;">✕</button>
        </div>
      `;
    });
  }

  calculateTotal();
  updateHeaderCartBadge();
}

// 2. CẬP NHẬT HÀM XÓA NHIỀU MÓM
function removeSelectedItems() {
  const selectedCount = cartItems.filter(i => i.selected).length;
  if (selectedCount === 0) {
    alert('Vui lòng tích chọn sản phẩm muốn xóa!');
    return;
  }
  if (confirm(`Bạn có chắc muốn xóa ${selectedCount} sản phẩm đã chọn khỏi giỏ hàng?`)) {
    cartItems = cartItems.filter(i => !i.selected);
    renderCart();
  }
}

function calculateTotal() {
  const selected = cartItems.filter(i => i.selected && i.inStock);
  const count = selected.reduce((s, i) => s + i.qty, 0);
  const subTotal = selected.reduce((s, i) => s + i.price * i.qty, 0);

  let discount = 0;
  if (appliedCoupon) {
    if (subTotal < appliedCoupon.minOrder) {
      appliedCoupon = null;
      document.getElementById('coupon-msg').innerHTML = `<span style="color: #f87171;">✕ Đơn hàng không đủ điều kiện dùng mã!</span>`;
    } else {
      discount = appliedCoupon.type === 'percent' ? (subTotal * appliedCoupon.value) / 100 : appliedCoupon.value;
    }
  }

  const shippingFee = subTotal > 0 ? 30000 : 0;
  const finalTotal = Math.max(0, subTotal - discount + shippingFee);

  document.getElementById('total-count').innerText = count + ' món';
  document.getElementById('sub-total').innerText = subTotal.toLocaleString('vi-VN') + ' đ';
  document.getElementById('discount-amount').innerText = '-' + discount.toLocaleString('vi-VN') + ' đ';
  document.getElementById('shipping-fee').innerText = shippingFee.toLocaleString('vi-VN') + ' đ';
  document.getElementById('final-total').innerText = finalTotal.toLocaleString('vi-VN') + ' đ';

  if (document.getElementById('checkout-section').style.display !== 'none') {
    updateQR();
  }
}

function applyCoupon() {
  const code = document.getElementById('coupon-code').value.trim().toUpperCase();
  const msg = document.getElementById('coupon-msg');

  if (!code) {
    msg.innerHTML = '<span style="color: #f87171;">⚠️ Vui lòng nhập mã giảm giá!</span>';
    return;
  }

  const coupon = SYSTEM_COUPONS[code];

  if (!coupon) {
    msg.innerHTML = '<span style="color: #f87171;">✕ Mã giảm giá không hợp lệ!</span>';
    appliedCoupon = null;
  } else if (coupon.expired) {
    msg.innerHTML = '<span style="color: #f87171;">✕ Mã giảm giá này đã hết hạn!</span>';
    appliedCoupon = null;
  } else {
    const selected = cartItems.filter(i => i.selected && i.inStock);
    const subTotal = selected.reduce((s, i) => s + i.price * i.qty, 0);

    if (subTotal < coupon.minOrder) {
      msg.innerHTML = `<span style="color: #f87171;">✕ Điều kiện chưa đạt! Đơn từ ${coupon.minOrder.toLocaleString('vi-VN')} đ.</span>`;
      appliedCoupon = null;
    } else {
      appliedCoupon = coupon;
      msg.innerHTML = `<span style="color: #4ade80;">✓ Áp dụng mã thành công!</span>`;
    }
  }

  calculateTotal();
}

function goToCheckout() {
  const selected = cartItems.filter(i => i.selected && i.inStock);
  if (selected.length === 0) {
    alert('Vui lòng chọn ít nhất 1 sản phẩm còn hàng để thanh toán!');
    return;
  }
  currentOrderId = 'GZ' + Math.floor(100000 + Math.random() * 900000);
  document.getElementById('order-id').innerText = currentOrderId;
  document.getElementById('checkout-section').style.display = 'block';
  updateQR();
  document.getElementById('checkout-section').scrollIntoView({ behavior: 'smooth' });
}

function updateQR() {
  const bank = document.getElementById('bank-id').value;
  const acc = document.getElementById('bank-acc').value;
  const selected = cartItems.filter(i => i.selected && i.inStock);
  const subTotal = selected.reduce((s, i) => s + i.price * i.qty, 0);
  
  let discount = 0;
  if (appliedCoupon) {
    discount = appliedCoupon.type === 'percent' ? (subTotal * appliedCoupon.value) / 100 : appliedCoupon.value;
  }
  const final = Math.max(0, subTotal - discount + (subTotal > 0 ? 30000 : 0));

  if (acc) {
    document.getElementById('qr-img').src = `https://img.vietqr.io/image/${bank}-${acc}-compact2.png?amount=${final}&addInfo=${currentOrderId}&accountName=GEARZONE%20STORE`;
  }
}

function confirmOrder() {
  const name = document.getElementById('cust-name').value.trim();
  const phone = document.getElementById('cust-phone').value.trim();
  const address = document.getElementById('cust-address').value.trim();

  if (!name || !phone || !address) {
    alert('Vui lòng điền đầy đủ thông tin nhận hàng!');
    return;
  }

  alert(`🎉 Đặt hàng thành công! Mã đơn: #${currentOrderId}`);
  cartItems = cartItems.filter(i => !i.selected);
  appliedCoupon = null;
  document.getElementById('coupon-code').value = '';
  document.getElementById('coupon-msg').innerText = '';
  document.getElementById('checkout-section').style.display = 'none';
  renderCart();
}
cartItems = cartItems.filter(item => item.inStock && item.stock > 0);
renderCart();
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>