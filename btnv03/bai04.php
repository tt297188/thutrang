
}
function printProductList($products) {
    echo "===== DANH SÁCH SẢN PHẨM =====\n";
    foreach ($products as $product) {
        $lineTotal = calculateLineTotal($product);
        echo $product['name'] . " - " 
            . formatMoney($product['price']) . " x " 
            . $product['quantity'] . " = " 
            . formatMoney($lineTotal) . "\n";
    }
}
function printSummary($products) {
    $subtotal = calculateSubtotal($products);
    $discount = calculateDiscount($subtotal);
    $finalTotal = $subtotal - $discount;

    echo "-------------------------------\n";
    echo "Tổng tiền: " . formatMoney($subtotal) . "\n";
    echo "Giảm giá: " . formatMoney($discount) . "\n";
    echo "Tổng thanh toán: " . formatMoney($finalTotal) . "\n";
}

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
printProductList($products);
printSummary($products);

?><?php
function formatMoney($amount) {
    return number_format($amount) . " VNĐ";
}
function calculateLineTotal($product) {
    return $product['price'] * $product['quantity'];
}
function calculateSubtotal($products) {
    $subtotal = 0;
    foreach ($products as $product) {
        $subtotal += calculateLineTotal($product);
    }
    return $subtotal;
}
function calculateDiscount($subtotal) {
    if ($subtotal >= 100000) {
        return $subtotal * 0.1;
    }
    return 0;