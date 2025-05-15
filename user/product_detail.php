<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fclothes");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Lấy ID sản phẩm
if (!isset($_GET['id'])) {
    die("Không có ID sản phẩm.");
}

$product_id = intval($_GET['id']);

// Truy vấn sản phẩm
$sql = "SELECT * FROM products WHERE id = $product_id AND status != 'hidden'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Sản phẩm không tồn tại.");
}

$product = $result->fetch_assoc();

// Xác định đường dẫn hình ảnh
$imageFile = htmlspecialchars($product['image']);
$imagePath = '';

if (!empty($imageFile) && file_exists(__DIR__ . '/../upload/' . $imageFile)) {
    $imagePath = '../upload/' . $imageFile;
} elseif (!empty($imageFile) && file_exists('images/' . $imageFile)) {
    $imagePath = 'images/' . $imageFile;
} else {
    $imagePath = 'images/default.jpg';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm - Fclothes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .product-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .product-container img {
            max-width: 300px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .price {
            color: green;
            font-weight: bold;
            font-size: 18px;
        }
        .btn-back {
            margin-top: 20px;
            display: inline-block;
        }
        .btn-add {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container product-container">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <img src="<?= $imagePath ?>" alt="Ảnh sản phẩm">

    <table>
        <tr>
            <th>Mô tả</th>
            <td><?= nl2br(htmlspecialchars($product['description'])) ?></td>
        </tr>
        <tr>
            <th>Giá</th>
            <td class="price"><?= number_format($product['price'], 0, ',', '.') ?> VND</td>
        </tr>
        <tr>
            <th>Màu sắc</th>
            <td><?= htmlspecialchars($product['color']) ?></td>
        </tr>
        <tr>
            <th>Kích thước</th>
            <td><?= htmlspecialchars($product['size']) ?></td>
        </tr>
        <tr>
            <th>Chất liệu</th>
            <td><?= htmlspecialchars($product['material']) ?></td>
        </tr>
        <tr>
            <th>Số lượng còn lại</th>
            <td><?= $product['quantity'] ?></td>
        </tr>
    </table>

    <form action="add_to_cart.php" method="POST" class="btn-add">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <label for="quantity">Số lượng:</label>
        <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['quantity'] ?>">
        <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
    </form>

    <a href="index.php" class="btn btn-secondary btn-back">← Quay lại danh sách sản phẩm</a>
</div>

</body>
</html>
