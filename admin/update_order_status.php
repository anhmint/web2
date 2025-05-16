<?php
$mysqli = new mysqli("localhost", "root", "", "fclothes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = (int)$_POST['order_id'];
    $newStatus = $_POST['new_status'];

    // Lấy trạng thái hiện tại
    $result = $mysqli->query("SELECT order_status FROM orders WHERE id = $orderId");
    $row = $result->fetch_assoc();
    $currentStatus = $row['order_status'];

    $statusLevels = [
        'Chờ xác nhận' => 1,
        'Đang giao' => 2,
        'Đã giao thành công' => 3,
        'Đã hủy' => 4
    ];

    if ($statusLevels[$newStatus] >= $statusLevels[$currentStatus]) {
        // Cập nhật hợp lệ
        $stmt = $mysqli->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $orderId);
        $stmt->execute();
    } else {
        // Cập nhật không hợp lệ
        echo "Không thể cập nhật ngược trạng thái!";
        exit;
    }
}

// Quay về trang quản lý đơn hàng
header("Location: order_management.php");
exit;
?>
