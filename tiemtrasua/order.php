<?php
require_once "db.php";
$productId = (int)($_GET["product_id"] ?? $_POST["product_id"] ?? 0);
$stmt = $pdo->prepare(
    "SELECT * FROM products WHERE id = ? AND status = 1"
);
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    die("Không tìm thấy đồ uống. Vui lòng quay lại menu.");
}
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["customer_name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $quantity = (int)($_POST["quantity"] ?? 1);
    if ($name === "" || $phone === "" || $address === "") {
        $error = "Vui lòng nhập đầy đủ thông tin.";
    } elseif (!preg_match('/^[0-9+\s-]{9,15}$/', $phone)) {
        $error = "Số điện thoại không hợp lệ.";
    } elseif ($quantity < 1 || $quantity > 100) {
        $error = "Số lượng phải từ 1 đến 100.";
    } else {
        $total = (float)$product["price"] * $quantity;
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare(
                "INSERT INTO orders
                (customer_name, phone, address, total, status)
                VALUES (?, ?, ?, ?, 'Chờ xác nhận')"
            );
            $stmt->execute([$name, $phone, $address, $total]);
            $orderId = $pdo->lastInsertId();
            $stmt = $pdo->prepare(
                "INSERT INTO order_items
                (order_id, product_id, product_name, price, quantity)
                VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $orderId,
                $product["id"],
                $product["name"],
                $product["price"],
                $quantity
            ]);
            $pdo->commit();
            header("Location: lookup.php?phone=" . urlencode($phone));
            exit;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $error = "Đặt hàng thất bại. Vui lòng thử lại.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>🧋 ĐẶT HÀNG TRÀ SỮA</h1>
    <nav>
        <a href="index.php">Trang chủ</a>
        <a href="lookup.php">Tra cứu đơn hàng</a>
    </nav>
</header>
<div class="form-box">
    <h2><?= h($product["name"]) ?></h2>
    <p>Giá:
        <strong>
            <?= number_format((float)$product["price"], 0, ",", ".") ?> đ
        </strong>
    </p>
    <?php if ($error !== ""): ?>
        <p style="color:red"><?= h($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="product_id"
               value="<?= (int)$product["id"] ?>">
        <label>Họ và tên:</label>
        <input type="text" name="customer_name"
               value="<?= h($_POST["customer_name"] ?? "") ?>"
               required>
        <label>Số điện thoại:</label>
        <input type="tel" name="phone"
               value="<?= h($_POST["phone"] ?? "") ?>"
               required>
        <label>Địa chỉ giao hàng:</label>
        <textarea name="address" required><?= h($_POST["address"] ?? "") ?></textarea>
        <label>Số lượng:</label>
        <input type="number" name="quantity"
               min="1" max="100"
               value="<?= (int)($_POST["quantity"] ?? 1) ?>"
               required>
        <button type="submit">Xác nhận đặt hàng</button>
    </form>
</div>
</body>
</html>
