<?php
session_start();
require_once "db.php";
// Đăng xuất
if (isset($_GET["logout"])) {
    $_SESSION = [];
    session_destroy();
    header("Location: admin.php");
    exit;
}
// Đăng nhập
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($admin && password_verify($password, $admin["password"])) {
        session_regenerate_id(true);
        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_name"] = $admin["username"];
        header("Location: admin.php");
        exit;
    } else {
        $error = "Sai tên đăng nhập hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị trà sữa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>QUẢN TRỊ TIỆM TRÀ SỮA</h1>
</header>
<div class="form-box">
<?php if (empty($_SESSION["admin_id"])): ?>
    <h2>Đăng nhập Admin</h2>
    <?php if ($error !== ""): ?>
        <p style="color:red"><?= h($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" required>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
        <button type="submit">Đăng nhập</button>
    </form>
    <p><a href="index.php">Về trang chủ</a></p>
<?php else: ?>
    <h2>Xin chào, <?= h($_SESSION["admin_name"] ?? "Admin") ?>!</h2>
    <p>Bạn đã đăng nhập thành công.</p>
    <p><a class="btn" href="admin/products.php">Quản lý đồ uống</a></p>
    <p><a class="btn" href="admin/orders.php">Quản lý đơn hàng</a></p>
    <p><a class="btn" href="admin/stats.php">Thống kê doanh thu</a></p>
    <p><a class="btn" href="admin.php?logout=1">Đăng xuất</a></p>
<?php endif; ?>
</div>
</body>
</html>