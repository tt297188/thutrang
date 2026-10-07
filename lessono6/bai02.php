<?php
// Dữ liệu cho trước
$name = "Thu Trang";
$score = 7.5;

if ($score >= 8) { $rank = "Giỏi";} 
elseif ($score >= 6.5) { $rank = "Khá";} 
elseif ($score >= 5) {
    $rank = "Trung bình";
} else {
    $rank = "Không đạt";
}
if ($score >= 5) {$status = "Bạn đã đạt";} 
else {$status = "Bạn chưa đạt";}

echo "Học viên: " . $name . "\n";
echo "Điểm: " . $score . "\n";
echo "Xếp loại: " . $rank . "\n";
echo "Thông báo: " . $status;

?>