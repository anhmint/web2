<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fclothes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Kết nối thất bại: " . $conn->connect_error);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Xóa sản phẩm
$conn->query("DELETE FROM products WHERE id = $id");

echo "<script>
    alert('Sản phẩm đã được xóa thành công.');
    window.location.href = 'product_management.php';
</script>";
?>
