<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/db.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Webshop của tôi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        h1 { color: #333; }
        .product-list { display: flex; gap: 20px; flex-wrap: wrap; }
        .product-card { background: #fff; border: 1px solid #ddd; padding: 15px; border-radius: 8px; width: 220px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .price { color: #e44d26; font-weight: bold; font-size: 1.1em; }
    </style>
</head>
<body>

    <h1>Danh Sách Sản Phẩm Webshop</h1>

    <div class="product-list">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p class="price"><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</p>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có sản phẩm nào trong cơ sở dữ liệu.</p>
        <?php endif; ?>
    </div>

</body>
</html>