<?php
// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fclothes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// Thiết lập phân trang
$limit = 8; // Số sản phẩm mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Lấy tổng số sản phẩm
$countSql = "SELECT COUNT(*) as total FROM products WHERE status != 'hidden'";
$countResult = $conn->query($countSql);
$total = $countResult->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Truy vấn sản phẩm có phân trang
$sql = "SELECT * FROM products WHERE status != 'hidden' LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $count = 0;
    while($row = $result->fetch_assoc()) {
        if ($count % 4 == 0 && $count != 0) {
            echo '</div><div class="row clearfix">'; // Xuống hàng sau mỗi 4 sản phẩm
        }
        ?>
        <div class="col-md-3">
            <div class="product-card">
                <div class="product-img">
                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="img-responsive">
                </div>
                <div class="product-info">
                    <h4><?php echo $row['name']; ?></h4>
                    <p>Giá: <?php echo number_format($row['price'], 0, ',', '.'); ?> VND</p>
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <?php
        $count++;
    }
} else {
    echo "<p>Không có sản phẩm nào.</p>";
}
?>
</div> <!-- đóng div.row -->

<!-- PHÂN TRANG -->
<nav class="text-center">
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li><a href="?page=<?php echo $page - 1; ?>">&laquo;</a></li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        
        <?php if ($page < $totalPages): ?>
            <li><a href="?page=<?php echo $page + 1; ?>">&raquo;</a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php
$conn->close();
?>
