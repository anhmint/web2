<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = max(1, intval($_POST['quantity'])); // Tối thiểu là 1

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] = $quantity;
            break;
        }
    }
}

header("Location: cart.php");
exit;
