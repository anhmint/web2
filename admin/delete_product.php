<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fclothes";

// Kết nối CSDL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Kết nối thất bại: " . $conn->connect_error);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra sản phẩm tồn tại
$product_check = $conn->query("SELECT * FROM products WHERE id = $id");
if ($product_check->num_rows === 0) {
    die("Sản phẩm không tồn tại.");
}

// Kiểm tra xem sản phẩm đã từng được bán chưa (ví dụ từ bảng 'orders')
$order_check = $conn->query("SELECT * FROM order_items WHERE id = $id LIMIT 1");

if ($order_check->num_rows > 0) {
    // Đã bán → cập nhật trạng thái để ẩn
    $conn->query("UPDATE products SET status = 'hidden' WHERE id = $id");
    echo "<script>
        alert('Sản phẩm đã được bán. Đã ẩn sản phẩm khỏi trang web.');
        window.location.href = 'product_management.php';
    </script>";
} else {
    // Chưa bán → hỏi xác nhận rồi xóa
    echo "<script>
        var confirmDelete = confirm('Sản phẩm chưa được bán. Bạn có chắc muốn xóa sản phẩm này?');
        if (confirmDelete) {
            window.location.href = 'delete_product_confirm.php?id=$id';
        } else {
            window.location.href = 'product_management.php';
        }
    </script>";
}
?>
