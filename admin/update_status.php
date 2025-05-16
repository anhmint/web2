<?php
require 'config.php';
$pdo = new PDO("mysql:host=localhost;dbname=fclothes", "root", "");

if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    $stmt = $pdo->prepare("UPDATE user SET status = CASE 
        WHEN status = 'Hoạt động' THEN 'Không hoạt động' 
        ELSE 'Hoạt động' 
    END WHERE id = ?");
    $stmt->execute([$userId]);

    // Lấy trạng thái mới sau khi cập nhật
    $stmt = $pdo->prepare("SELECT status FROM user WHERE id = ?");
    $stmt->execute([$userId]);
    $newStatus = $stmt->fetchColumn();

    echo $newStatus; // Trả về trạng thái mới cho JavaScript
}
?>
