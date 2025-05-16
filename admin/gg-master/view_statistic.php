<?php
include 'config.php'; // Kết nối CSDL

$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';

$topCustomers = [];

// Mặc định: lấy top 5 khách hàng theo tổng chi tiêu
$sql = "SELECT u.id, u.name, SUM(o.total_price) AS total_spent
        FROM user u
        JOIN orders o ON u.id = o.user_id";

$conditions = [];
$params = [];
$types = "";

// Nếu có ngày bắt đầu và kết thúc thì thêm điều kiện lọc theo ngày
if (!empty($start) && !empty($end)) {
    $conditions[] = "o.order_date BETWEEN ? AND ?";
    $params[] = $start;
    $params[] = $end;
    $types .= "ss";
}

// Gộp điều kiện WHERE nếu có
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " GROUP BY u.id
          ORDER BY total_spent DESC
          LIMIT 5";

// Chuẩn bị và bind
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$topCustomers = [];
while ($row = $result->fetch_assoc()) {
    $row['orders'] = [];
    $topCustomers[] = $row;
}

// Lấy đơn hàng cho mỗi khách hàng
foreach ($topCustomers as &$customer) {
    $sqlOrders = "SELECT id, order_date, total_price
                  FROM orders
                  WHERE user_id = ?";
    $orderParams = [$customer['id']];
    $orderTypes = "i";

    if (!empty($start) && !empty($end)) {
        $sqlOrders .= " AND order_date BETWEEN ? AND ?";
        $orderParams[] = $start;
        $orderParams[] = $end;
        $orderTypes .= "ss";
    }

    $stmtOrders = $conn->prepare($sqlOrders);
    $stmtOrders->bind_param($orderTypes, ...$orderParams);
    $stmtOrders->execute();
    $resultOrders = $stmtOrders->get_result();

    while ($order = $resultOrders->fetch_assoc()) {
        $customer['orders'][] = $order;
    }
}
unset($customer);


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
  <link rel="stylesheet" href="view_statistic.css">
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
              <span class="material-symbols-sharp"> receipt_long </span>
              <h3>Quản lý đơn hàng</h3>
           </a> 

           </a>
           <a href="view_statistic.php">
              <span class="material-symbols-sharp">insights </span>
              <h3>Thống kê kinh doanh</h3>
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
        <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px; text-align: center;">Thống Kê Kinh Doanh</h2>
      
        <!-- Bộ Lọc -->
        <div class="filter-section">
        <form method="GET" action="">
    <label for="start-date">Từ ngày:</label>
    <input type="date" id="start-date" name="start" value="<?php echo htmlspecialchars($_GET['start'] ?? ''); ?>">
    <label for="end-date">Đến ngày:</label>
    <input type="date" id="end-date" name="end" value="<?php echo htmlspecialchars($_GET['end'] ?? ''); ?>">
    <button type="submit" class="filter-button">Lọc</button>
</form>
        </div>
      
        <!-- Thống kê các mặt hàng -->
        
        <!-- Thống kê khách hàng -->
        <section class="statistic-section">
    <h3>Những khách hàng tiềm năng</h3>

    <?php if (!empty($topCustomers)) : ?>
        <?php foreach ($topCustomers as $index => $customer) : ?>
            <h4><?php echo ($index + 1) . '. ' . htmlspecialchars($customer['name']); ?> (Tổng mua: <?php echo number_format($customer['total_spent'], 0, ',', '.'); ?>đ)</h4>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Đơn Hàng</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Xem Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customer['orders'] as $orderIndex => $order) : ?>
                        <tr>
                            <td><?php echo $orderIndex + 1; ?></td>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?>đ</td>
                            <td><a href="order_detail.php?id=<?php echo $order['id']; ?>">Xem chi tiết</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Chọn ngày tháng để tìm kiếm khách hàng.</p>
    <?php endif; ?>

        
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
    <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px; text-align: center;">
      Cập nhật thông tin
    </h2>
    
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
    <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px; text-align: center;">
      Phân tích bán hàng
    </h2>

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
    function filterOrdersByTime() {
  const startDate = document.getElementById('start-date').value;
  const endDate = document.getElementById('end-date').value;
  alert(`Đơn hàng đã được lọc theo thời gian: ${startDate} to ${endDate}`);
  // Implement the logic to filter orders based on the time range
} 


   </script>
</body>
</html>