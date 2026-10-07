<?php
$products = [
    [
        "name" => "Bánh mì",
        "price" => 15000,
        "quantity" => 2
    ],
    [
        "name" => "Sữa",
        "price" => 30000,
        "quantity" => 1
    ],
    [
        "name" => "Trứng",
        "price" => 25000,
        "quantity" => 3
    ]
];
$total = 0;
echo "===== DANH SÁCH SẢN PHẨM =====\n";

// 1. Duyệt qua danh sách sản phẩm bằng foreach
foreach ($products as $product) {
// 2 & 3. Tính thành tiền từng sản phẩm
    $subtotal = $product["price"] * $product["quantity"];
// Cộng dồn vào tổng tiền đơn hàng
    $total += $subtotal;
// In thông tin sản phẩm
    echo $product["name"] . " - " 
        . number_format($product["price"]) . " VNĐ x " 
        . $product["quantity"] . " = " 
        . number_format($subtotal) . " VNĐ\n";
}

echo "-------------------------------\n";
echo "Tổng tiền: " . number_format($total) . " VNĐ\n";

// 5 & 6. Kiểm tra điều kiện giảm giá (>= 100000 thì giảm 10%)
$discount = 0;
if ($total >= 100000) {
    $discount = $total * 0.1; // 10%
}

$finalTotal = $total - $discount;

echo "Giảm giá: " . number_format($discount) . " VNĐ\n";
echo "Tổng thanh toán: " . number_format($finalTotal) . " VNĐ\n";

?>