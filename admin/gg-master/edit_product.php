<?php
$conn = new mysqli('localhost', 'root', '', 'fclothes');
$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $code = $_POST['code'];
    $quantity = intval($_POST['quantity']);

    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);
        $conn->query("UPDATE products SET name='$name', code='$code', quantity=$quantity, image='$image' WHERE id=$id");
    } else {
        $conn->query("UPDATE products SET name='$name', code='$code', quantity=$quantity WHERE id=$id");
    }

    header("Location: product_management.php");
    exit;
}

$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
?>

<form method="POST" enctype="multipart/form-data">
  <input type="text" name="name" value="<?= $product['name'] ?>" required>
  <input type="text" name="code" value="<?= $product['code'] ?>" required>
  <input type="number" name="quantity" value="<?= $product['quantity'] ?>" required>
  <input type="file" name="image">
  <button type="submit">Cập nhật sản phẩm</button>
</form>
