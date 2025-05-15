<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fclothes");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Giỏ hàng trống.");
}

$cart = $_SESSION['cart'];
$user_id = $_SESSION['user_id'];
$payment_method = "COD";
$shipping_address = "Địa chỉ mặc định";
$note = "";
$order_date = date("Y-m-d H:i:s");
$delivery_date = date("Y-m-d", strtotime("+3 days"));
$order_status = "Đang xử lý";

// Tạo đơn hàng
$sql_order = "INSERT INTO orders (user_id, order_date, delivery_date, payment_method, shipping_address, note, order_status)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_order);
$stmt->bind_param("issssss", $user_id, $order_date, $delivery_date, $payment_method, $shipping_address, $note, $order_status);
$stmt->execute();
$order_id = $stmt->insert_id;

// Thêm từng sản phẩm
foreach ($cart as $product_id => $quantity) {
    $product_id = (int)$product_id;
    $quantity = (int)$quantity;

    $result = $conn->query("SELECT price FROM products WHERE id = $product_id");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price = $row['price'];

        $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt_item = $conn->prepare($sql_item);
        $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $stmt_item->execute();
    } else {
        // Không tìm thấy sản phẩm → bỏ qua hoặc ghi log
        continue;
    }
}

// Xóa giỏ hàng
unset($_SESSION['cart']);

// Chuyển hướng
header("Location: order_details.php?id=" . $order_id);
exit;
?>
