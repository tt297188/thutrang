<?php
$tensanpham = "bánh mì";
$dongia = "15000";
$soluong = "3";

$thanhTien = $dongia * $soluong;
$vat = $thanhTien * 10 / 100;
$tongTien = $thanhTien + $vat;

echo "Tên sản phẩm: $tenSanPham <br>\n";
echo "Đơn giá: $donGia đồng <br>\n";
echo "Số lượng: $soLuong <br>\n";
echo "Thành tiền: $thanhTien đồng <br>\n";
echo "VAT 10%: $vat đồng <br>\n";
echo "Tổng tiền phải trả: $tongTien đồng\n";

?>

