<?php
$servername = "localhost"; // nếu dùng XAMPP thì để localhost
$username = "root";         // mặc định của XAMPP là root
$password = "";             // mặc định của XAMPP là không mật khẩu
$dbname = "fclothes";       // tên database bạn vừa tạo

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
