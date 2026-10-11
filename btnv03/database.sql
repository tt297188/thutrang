CREATE DATABASE quanlysanpham;
USE quanlysanpham;

CREATE TABLE sanpham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL,
    gia DECIMAL(10,2) NOT NULL,
    soluong INT NOT NULL
);
INSERT INTO sanpham (ten, gia, soluong) VALUES
('Ao thun', 150000, 20),
('Quan jean', 250000, 15),
('Giay the thao', 450000, 10);

SELECT * FROM sanpham;