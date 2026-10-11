<?php
$conn = new mysqli("localhost", "root", "", "quanlysanpham");
if ($conn->connect_error) {
    die("Loi ket noi: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>