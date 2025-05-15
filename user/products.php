<?php
$conn = new mysqli("localhost", "root", "", "fclothes");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// Phân trang
$limit = 4;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Đếm tổng số sản phẩm
$countSql = "SELECT COUNT(*) AS total FROM products WHERE status != 'hidden'";
$countResult = $conn->query($countSql);
$total = $countResult->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Truy vấn sản phẩm
$sql = "SELECT * FROM products WHERE status != 'hidden' LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $count = 0;
    echo '<div class="row clearfix">';
    while ($row = $result->fetch_assoc()) {
        $imageFile = htmlspecialchars($row['image']);
        $imagePath = "";

        // Ưu tiên thư mục upload/
        if (!empty($imageFile) && file_exists(__DIR__ . "/../upload/" . $imageFile)) {
            $imagePath = "../upload/" . $imageFile;
        } elseif (!empty($imageFile) && file_exists("images/" . $imageFile)) {
            $imagePath = "images/" . $imageFile;
        } else {
            $imagePath = "images/default.jpg";
        }

        // Tạo hàng mới sau mỗi 4 sản phẩm
        if ($count > 0 && $count % 4 == 0) {
            echo '</div><div class="row clearfix">';
        }
        ?>
        <div class="col-md-3">
            <div class="product-card">
                <div class="product-img">
                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="img-responsive">
                </div>
                <div class="product-info">
                    <h4><?= htmlspecialchars($row['name']) ?></h4>
                    <p>Giá: <?= number_format($row['price'], 0, ',', '.') ?> VND</p>
                    <a href="product_detail.php?id=<?= $row['id'] ?>" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <?php
        $count++;
    }
    echo '</div>'; // Đóng dòng cuối
} else {
    echo "<p>Không có sản phẩm nào.</p>";
}
?>

<!-- PHÂN TRANG -->
<nav class="text-center">
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li><a href="?page=<?= $page - 1 ?>">&laquo;</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="<?= ($i == $page) ? 'active' : '' ?>">
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <li><a href="?page=<?= $page + 1 ?>">&raquo;</a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php $conn->close(); ?>
