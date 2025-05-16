<?php
$conn = new mysqli('localhost', 'root', '', 'fclothes');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("UPDATE products SET status = 'locked' WHERE id = $id");
}
header("Location: product_management.php");
exit;
