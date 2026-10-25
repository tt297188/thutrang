<?php
require_once "db.php";
$phone = trim($_GET["phone"] ?? $_POST["phone"] ?? "");
$orders = [];
if ($phone !== "") {
    $stmt = $pdo->prepare(
        "SELECT * FROM orders
         WHERE phone = ?
         ORDER BY created_at DESC"
    );
    $stmt->execute([$phone]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>TRA CỨU ĐƠN HÀNG</h1>
    <nav>
        <a href="index.php">Trang chủ</a>
    </nav>
</header>
<div class="form-box">
    <h2>Kiểm tra đơn hàng</h2>
    <form method="GET">
        <label>Nhập số điện thoại:</label>
        <input type="tel" name="phone"
               value="<?= h($phone) ?>" required>
        <button type="submit">Tra cứu</button>
    </form>
</div>
<div class="container">
    <?php if ($phone !== ""): ?>
        <h2>Kết quả tra cứu</h2>
        <?php if (count($orders) > 0): ?>
            <?php foreach ($orders as $order): ?>
                <div class="product">
                    <h3>Đơn hàng #<?= (int)$order["id"] ?></h3>
                    <p>Khách hàng: <?= h($order["customer_name"]) ?></p>
                    <p>Địa chỉ: <?= h($order["address"]) ?></p>
                    <p>Ngày đặt: <?= h($order["created_at"]) ?></p>
                    <p>
                        Tổng tiền:
                        <strong class="price">
                            <?= number_format((float)$order["total"], 0, ",", ".") ?> đ
                        </strong>
                    </p>
                    <p>
                        Trạng thái:
                        <strong><?= h($order["status"]) ?></strong>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không tìm thấy đơn hàng với số điện thoại này.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>