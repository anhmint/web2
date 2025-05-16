<?php
session_start(); 
include 'connect_db.php';

if (empty($_SESSION['cart'])) {
    echo "Giỏ hàng trống!";
    exit();
}

$user_id = 1;
$address = "Căn hộ Landmark 81, tầng 78"; 
$payment_method = "Thẻ tín dụng";
$note = "Giao trước 5h chiều";
$status = "Đang xử lý"; 
$created_at = date('Y-m-d H:i:s');

$total_price = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $product_query = $conn->query("SELECT price FROM products WHERE id = $product_id");
    $product = $product_query->fetch_assoc();
    $total_price += $product['price'] * $quantity;
}

$sql_order = "INSERT INTO orders (user_id, created_at, status, total_price, payment_method, shipping_address, note)
              VALUES ('$user_id', '$created_at', '$status', '$total_price', '$payment_method', '$address', '$note')";
$conn->query($sql_order);

$order_id = $conn->insert_id;

foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $product_query = $conn->query("SELECT price FROM products WHERE id = $product_id");
    $product = $product_query->fetch_assoc();
    $price = $product['price'];

    $sql_order_detail = "INSERT INTO order_details (order_id, product_id, quantity, price)
                         VALUES ('$order_id', '$product_id', '$quantity', '$price')";
    $conn->query($sql_order_detail);
}

// Xóa giỏ hàng sau khi đặt hàng xong
unset($_SESSION['cart']);

// Chuyển qua trang chi tiết đơn hàng
header("Location: order_detail.php?order_id=$order_id");
exit();
?>
