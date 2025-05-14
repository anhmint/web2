<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $product_id) {
                unset($_SESSION['cart'][$index]);
                break;
            }
        }
        // Đảm bảo mảng không bị lỗ hổng chỉ số
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

header('Location: cart.php'); // Quay lại trang giỏ hàng
exit;
