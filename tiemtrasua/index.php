<?php
require_once "db.php";
$keyword = trim($_GET["search"] ?? "");
if ($keyword !== "") {
    $stmt = $pdo->prepare(
        "SELECT * FROM products
         WHERE status = 1 AND name LIKE ?
         ORDER BY id DESC"
    );
    $stmt->execute(["%" . $keyword . "%"]);
} else {
    $stmt = $pdo->query(
        "SELECT * FROM products
         WHERE status = 1
         ORDER BY id DESC"
    );
}
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiệm Trà Sữa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>🧋 TIỆM TRÀ SỮA</h1>
    <nav>
        <a href="index.php">Trang chủ</a>
        <a href="lookup.php">Tra cứu đơn hàng</a>
        <a href="admin/login.php">Quản trị</a>
    </nav>
</header>
<section class="banner">
    <h2>Trà ngon mỗi ngày</h2>
    <p>Chọn món yêu thích và đặt hàng ngay!</p>
</section>
<main class="container">
    <h2>Menu đồ uống</h2>
    <form method="GET" class="search-form">
        <input
            type="text"
            name="search"
            placeholder="Tìm tên đồ uống..."
            value="<?= h($keyword) ?>"
        >
        <button type="submit">Tìm kiếm</button>
    </form>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <?php
                $image = $product["image"] ?? "";
                ?>
                <?php if ($image !== "" && is_file(__DIR__ . "/" . $image)): ?>
                    <img src="<?= h($image) ?>" alt="<?= h($product["name"]) ?>">
                <?php else: ?>
                    <div class="no-image">🧋</div>
                <?php endif; ?>
                <h3><?= h($product["name"]) ?></h3>
                <p><?= h($product["description"] ?? "") ?></p>
                <p class="price">
                    <?= number_format((float)$product["price"], 0, ",", ".") ?> đ
                </p>
                <a class="btn"
                   href="order.php?product_id=<?= (int)$product["id"] ?>">
                    Đặt hàng
                </a>
            </div>
        <?php endforeach; ?>
        <?php if (count($products) === 0): ?>
            <p>Không tìm thấy đồ uống phù hợp.</p>
        <?php endif; ?>
    </div>
</main>
<footer>
    <p>© Tiệm Trà Sữa - Đặt hàng online</p>
</footer>
</body>
</html>