<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fclothes";

// Kết nối CSDL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Kết nối thất bại: " . $conn->connect_error);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$action = $_GET['action'] ?? '';

// Nếu action=delete thì xóa sản phẩm luôn
if ($action === 'delete') {
    $delete = $conn->query("DELETE FROM products WHERE id = $id");
    if ($delete) {
        echo "<script>
            alert('Sản phẩm đã được xóa thành công.');
            window.location.href = 'product_management.php';
        </script>";
    } else {
        echo "<script>
            alert('Xóa sản phẩm thất bại.');
            window.location.href = 'product_management.php';
        </script>";
    }
    exit;
}

// Kiểm tra sản phẩm tồn tại
$product_check = $conn->query("SELECT * FROM products WHERE id = $id");
if ($product_check->num_rows === 0) {
    echo "<script>
        alert('Sản phẩm này đã bị xóa trước đó hoặc không tồn tại.');
        window.location.href = 'product_management.php';
    </script>";
    exit;
}

// Kiểm tra xem sản phẩm đã từng được bán chưa (phải kiểm tra product_id, không phải id!)
$order_check = $conn->query("SELECT * FROM order_items WHERE product_id = $id LIMIT 1");

if ($order_check->num_rows > 0) {
    // Đã bán → cập nhật trạng thái để ẩn
    $conn->query("UPDATE products SET status = 'hidden' WHERE id = $id");
    echo "<script>
        alert('Sản phẩm đã được bán. Đã ẩn sản phẩm khỏi trang web.');
        window.location.href = 'product_management.php';
    </script>";
} else {
    // Chưa bán → hỏi xác nhận và xóa trực tiếp
    echo "<script>
        var confirmDelete = confirm('Sản phẩm chưa được bán. Bạn có chắc muốn xóa sản phẩm này?');
        if (confirmDelete) {
            window.location.href = 'delete_product.php?action=delete&id=$id';
        } else {
            window.location.href = 'product_management.php';
        }
    </script>";
}
?>
