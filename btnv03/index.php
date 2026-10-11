<?php
include "db.php";
// Them san pham
if (isset($_POST['them'])) {
    $ten = $_POST['ten'];
    $gia = $_POST['gia'];
    $soluong = $_POST['soluong'];
    $stmt = $conn->prepare(
        "INSERT INTO sanpham (ten, gia, soluong) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sdi", $ten, $gia, $soluong);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
// Sua san pham
if (isset($_POST['sua'])) {
    $id = $_POST['id'];
    $ten = $_POST['ten'];
    $gia = $_POST['gia'];
    $soluong = $_POST['soluong'];
    $stmt = $conn->prepare(
        "UPDATE sanpham SET ten=?, gia=?, soluong=? WHERE id=?"
    );
    $stmt->bind_param("sdii", $ten, $gia, $soluong, $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
// Xoa san pham
if (isset($_GET['xoa'])) {
    $id = (int)$_GET['xoa'];
    $stmt = $conn->prepare("DELETE FROM sanpham WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
// Lay san pham can sua
$spSua = null;
if (isset($_GET['sua'])) {
    $id = (int)$_GET['sua'];
    $stmt = $conn->prepare("SELECT * FROM sanpham WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $spSua = $stmt->get_result()->fetch_assoc();
}
// Hien thi danh sach
$result = $conn->query("SELECT * FROM sanpham ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <style>
        body {
            font-family: Arial;
            width: 850px;
            margin: 30px auto;
        }
        h2 {
            text-align: center;
            color: blue;
        }
        input {
            padding: 8px;
            margin: 5px;
        }
        button {
            padding: 8px 15px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #ddd;
        }
        a {
            text-decoration: none;
            margin: 5px;
        }
    </style>
</head>
<body>
<h2>QUẢN LÝ SẢN PHẨM</h2>
<h3>
    <?php echo $spSua ? "Sửa sản phẩm" : "Thêm sản phẩm"; ?>
</h3>
<form method="post">
    <input type="hidden" name="id"value="<?= $spSua['id'] ?? '' ?>">
    <input type="text" name="ten" placeholder="Tên sản phẩm" value="<?= htmlspecialchars($spSua['ten'] ?? '') ?>"required>
    <input type="number" name="gia" placeholder="Giá" min="0" step="0.01" value="<?= $spSua['gia'] ?? '' ?>" required>
    <input type="number" name="soluong" placeholder="Số lượng" min="0"value="<?= $spSua['soluong'] ?? '' ?>"required>
    <?php if ($spSua): ?>
        <button type="submit" name="sua">Cập nhật</button>
        <a href="index.php">Hủy</a>
    <?php else: ?>
        <button type="submit" name="them">Thêm sản phẩm</button>
    <?php endif; ?>
</form>
<h3>Danh sách sản phẩm</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Chức năng</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['ten']) ?></td>
        <td><?= number_format($row['gia']) ?> VNĐ</td>
        <td><?= $row['soluong'] ?></td>
        <td>
            <a href="index.php?sua=<?= $row['id'] ?>">Sửa</a>
            <a href="index.php?xoa=<?= $row['id'] ?>"
               onclick="return confirm('Bạn có muốn xóa không?')">
               Xóa
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>