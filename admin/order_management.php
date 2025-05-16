<?php
// Kết nối database
$mysqli = new mysqli("localhost", "root", "", "fclothes");
if ($mysqli->connect_error) {
    die("Kết nối thất bại: " . $mysqli->connect_error);
}

// Lấy filter từ URL nếu có
$statusFilter = $_GET['status'] ?? 'all';
$districtFilter = $_GET['district'] ?? 'all';
$startDate = $_GET['start_date'] ?? '';
$endDate = $_GET['end_date'] ?? '';

// Phân trang
$ordersPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $ordersPerPage;

// Escape giá trị đầu vào để tránh SQL injection
$escapedStatus = $mysqli->real_escape_string($statusFilter);
$escapedDistrict = $mysqli->real_escape_string($districtFilter);
$escapedStartDate = $mysqli->real_escape_string($startDate);
$escapedEndDate = $mysqli->real_escape_string($endDate);

// Xây dựng câu truy vấn chính
$sql = "SELECT * FROM orders WHERE 1";

if ($statusFilter !== 'all') {
    $sql .= " AND order_status = '$escapedStatus'";
}
if ($districtFilter !== 'all') {
  $sql .= " AND shipping_address LIKE '%" . str_replace('Quận ', 'Q.', $escapedDistrict) . "%'";
}

if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND order_date BETWEEN '$escapedStartDate 00:00:00' AND '$escapedEndDate 23:59:59'";
}

// Tính tổng đơn hàng để phân trang
$countSql = "SELECT COUNT(*) AS total FROM orders WHERE 1";
if ($statusFilter !== 'all') {
    $countSql .= " AND order_status = '$escapedStatus'";
}
if ($districtFilter !== 'all') {
    $countSql .= " AND shipping_address LIKE '%$escapedDistrict%'";
}
if (!empty($startDate) && !empty($endDate)) {
    $countSql .= " AND order_date BETWEEN '$escapedStartDate 00:00:00' AND '$escapedEndDate 23:59:59'";
}

$countResult = $mysqli->query($countSql);
$totalOrders = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalOrders / $ordersPerPage);

// Thêm LIMIT OFFSET vào câu SQL để lấy dữ liệu trang hiện tại
$sql .= " LIMIT $ordersPerPage OFFSET $offset";

// Thực thi truy vấn chính
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="order_management.css">
</head>
<body>
   <div class="container">
      <aside>
           
         <div class="top">
           <div class="logo">
             <h2><span class="danger">Fclothes</span> </h2>
           </div>
           <div class="close" id="close_btn">
            <span class="material-symbols-sharp">
              close
              </span>
           </div>
         </div>
         <!-- end top -->
          <div class="sidebar">
           <a href="index.php" >
              <span class="material-symbols-sharp">person_outline </span>
              <h3>Quản lý người dùng</h3> 
              
            <a href="product_management.php">
            <span class="material-symbols-sharp"> inventory </span>
            <h3>Quản lý sản phẩm</h3>
         </a>
            <a href="order_management.php">
              <span class="material-symbols-sharp">receipt_long </span>
              <h3>Quản lý đơn hàng</h3>
           </a> 

           </a>
           <a href="view_statistic.php">
              <span class="material-symbols-sharp">insights </span>
              <h3>Thống kê kinh doanh</h3>
           </a>

           <a href="#">
              <span class="material-symbols-sharp">add </span>
              <h3>Add Product</h3>
           </a>
          
           <a href="login.php">
              <span class="material-symbols-sharp">logout </span>
              <h3>Đăng xuất</h3>
           </a>
             


          </div>

      </aside>
      <!-- --------------
        end asid
      -------------------- -->

      <!-- --------------
        start main part
      --------------- -->

      <main>
        <section class="recent_order">
          <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px;">Quản lý đơn hàng</h2>
            <div class="filters">
              <label for="time-range">Thời gian:</label>
              <input type="date" id="start-date"> đến <input type="date" id="end-date">
             


        
              <label for="district-filter">Quận:</label>
              <select id="district-filter" onchange="filterOrders()">
                <option value="all">Tất cả</option>
                <option value="Q.1">Quận 1</option> 
                <option value="Q.2">Quận 2</option>
                <option value="Q.3">Quận 3</option>
                <option value="Q.4">Quận 4</option>  
                <option value="Q.5">Quận 5</option>
                <option value="Q.6">Quận 6</option>

                <!-- Add more districts as needed -->
              </select>

              <label for="status-filter">Trạng thái:</label>
<select id="status-filter">
    <option value="all">Tất cả</option>
    <option value="Chờ xác nhận">Chờ xác nhận</option>
    <option value="Đang giao">Đang giao</option>
    <option value="Đã giao thành công">Đã giao thành công</option>
    <option value="Đã hủy">Đã hủy</option>
</select>
      
              <button class="filter-button" onclick="filterOrders()">Lọc</button>
            </div>
        
            <div class="order-table">
              <table>
                <thead>
                  <tr>
                    <th>Mã đơn hàng</th>
                    <th>Mã khách hàng</th>
                    <th>Địa chỉ</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Thêm</th>
                  </tr>
                </thead>
                <tbody>
<?php while ($row = $result->fetch_assoc()) : ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['user_id']) ?></td> <!-- Nếu muốn hiển thị tên user thì phải join thêm bảng users -->
<td><?= htmlspecialchars($row['shipping_address']) ?></td>
<td><?= date('d/m/Y', strtotime($row['order_date'])) ?></td>
<td>
  <form method="post" action="update_order_status.php">
    <input type="hidden" name="order_id" value="<?= $row['id'] ?>">

    <select name="new_status" onchange="this.form.submit()">
      <?php
      $allStatuses = [
          'Chờ xác nhận' => 1,
          'Đang giao' => 2,
          'Đã giao thành công' => 3,
          'Đã hủy' => 4
      ];

      $currentStatus = $row['order_status'];
      $currentStatusLevel = $allStatuses[$currentStatus] ?? 0;

      foreach ($allStatuses as $statusName => $statusLevel) {
          // Chỉ hiển thị các trạng thái bằng hoặc cao hơn trạng thái hiện tại
          if ($statusLevel >= $currentStatusLevel) {
              $selected = ($statusName == $currentStatus) ? 'selected' : '';
              echo "<option value=\"$statusName\" $selected>$statusName</option>";
          }
      }
      ?>
    </select>
  </form>
</td>

    <td><a href="order_detail.php?id=<?= $row['id'] ?>">Xem</a></td>
</tr>
<?php endwhile; ?>
</tbody>

              </table>
              <div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <a href="?page=<?= $i ?>&status=<?= $statusFilter ?>&district=<?= $districtFilter ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>"
           class="<?= ($i == $page) ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
            </div>
             
            </table>
            
          </section>

      </main>
      <!------------------
         end main
        ------------------->

      <!----------------
        start right main 
      ---------------------->
    <div class="right">

<div class="top">
   <button id="menu_bar">
     <span class="material-symbols-sharp">menu</span>
   </button>
    <div class="profile">
       <div class="info">
           <p><b>Xin chào, Admin</b></p>
           <small class="text-muted"></small>
       </div>
       <div class="profile-photo">
         <img src="images/logo.png" alt=""/>
       </div>
    </div>
</div>

  <div class="recent_updates">
    <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px; text-align: center;">Cập nhật thông tin</h2>
   <div class="updates">
      <div class="update">
         <div class="profile-photo">
            <img src="images/img1.png" alt=""/>
         </div>
        <div class="message">
           <p><b>Raze</b> đã nhận đơn hàng</p>
        </div>
      </div>
      <div class="update">
        <div class="profile-photo">
        <img src="images/img20.png" alt=""/>
        </div>
       <div class="message">
          <p><b>Ali</b> đã nhận đơn hàng</p>
       </div>
     </div>
     <div class="update">
      <div class="profile-photo">
         <img src="images/img31.png" alt=""/>
      </div>
     <div class="message">
        <p><b>Kyle</b> đã nhận đơn hàng </p>
     </div>
   </div>
  </div>
  </div>


   <div class="sales-analytics">
    <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px; text-align: center;">Phân tích bán hàng</h2>

      <div class="item onlion">
        <div class="icon">
          <span class="material-symbols-sharp">shopping_cart</span>
        </div>
        <div class="right_text">
          <div class="info">
            <h3>Đặt hàng online</h3>
            <small class="text-muted">Đã xem 5 tiếng trước</small>
          </div>
          <h5 class="danger">-17%</h5>
          <h3>5040</h3>
        </div>
      </div>
      <div class="item onlion">
        <div class="icon">
          <span class="material-symbols-sharp">shopping_cart</span>
        </div>
        <div class="right_text">
          <div class="info">
            <h3>Đặt hàng online</h3>
            <small class="text-muted">Đã xem 2 tiếng trước</small>
          </div>
          <h5 class="success">-10%</h5>
          <h3>7020</h3>
        </div>
      </div>
      </div>
</div>
</div>
   </div>
   <script src="script.js"></script>
   <script> 
function filterOrders() {
    const status = document.getElementById('status-filter').value;
    const district = document.getElementById('district-filter').value;
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;

    let url = `?status=${encodeURIComponent(status)}&district=${encodeURIComponent(district)}`;

    if (startDate && endDate) {
        url += `&start_date=${startDate}&end_date=${endDate}`;
    }

    window.location.href = url;
}

document.querySelector('.filter-button').addEventListener('click', filterOrders);
</script>

</body>
</html>