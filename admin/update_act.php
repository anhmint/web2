<?php
$pdo = new PDO("mysql:host=localhost;dbname=fclothes", "root", "");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Lấy trạng thái hiện tại
    $stmt = $pdo->prepare("SELECT act FROM user WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $currentAct = $user['act'];
        $newAct = ($currentAct === "Mở khóa") ? "Khóa" : "Mở khóa";
        $newStatus = ($newAct === "Khóa") ? "Không hoạt động" : "Hoạt động";

        // Cập nhật cả act và status
        $update = $pdo->prepare("UPDATE user SET act = ?, status = ? WHERE id = ?");
        if ($update->execute([$newAct, $newStatus, $id])) {
            echo $newAct;
        } else {
            echo "Lỗi";
        }
    } else {
        echo "Không tìm thấy người dùng";
    }
}
?>
