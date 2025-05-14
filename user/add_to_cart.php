<?php
session_start();

// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "fclothes");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra dữ liệu POST
if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    die("Dữ liệu không hợp lệ.");
}

$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);

// Truy vấn thông tin sản phẩm
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Sản phẩm không tồn tại.");
}

$product = $result->fetch_assoc();

// Kiểm tra tồn kho
if ($quantity > $product['quantity']) {
    die("Số lượng mua vượt quá số lượng còn lại.");
}

// Nếu giỏ hàng chưa được khởi tạo, khởi tạo một giỏ hàng mới
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
$product_found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $product_id) {
        // Cập nhật số lượng nếu sản phẩm đã có trong giỏ
        $item['quantity'] += $quantity;
        $product_found = true;
        break;
    }
}

// Nếu sản phẩm chưa có trong giỏ, thêm mới
if (!$product_found) {
    $_SESSION['cart'][] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'quantity' => $quantity,
        'price' => $product['price'],
        'image' => $product['image']
    ];
}

// Chuyển hướng về trang giỏ hàng hoặc sản phẩm
header("Location: cart.php");
exit;
?>
