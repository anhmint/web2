<?php
// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "fclothes"); // Đổi 'ten_csdl' thành tên CSDL bạn dùng
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}

// Lấy id đơn hàng từ URL
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin đơn hàng
$sql_order = "SELECT o.*, u.name AS customer_name 
              FROM orders o 
              JOIN user u ON o.user_id = u.id 
              WHERE o.id = $order_id";
$result_order = $conn->query($sql_order);
$order = $result_order->fetch_assoc();

// Lấy sản phẩm trong đơn hàng
// Thay đổi truy vấn lấy sản phẩm trong đơn hàng
$sql_items = "SELECT od.*, p.name AS product_name 
              FROM order_items od
              JOIN products p ON od.product_id = p.id 
              WHERE od.order_id = $order_id";
$result_items = $conn->query($sql_items);
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
  <link rel="stylesheet" href="order_details.css">
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

        
          
           <a href="login.php">
              <span class="material-symbols-sharp">logout </span>
              <h3>logout</h3>
           </a>
             


          </div>

      </aside>
      <!-- --------------
        end asid
      -------------------- -->

      <!-- --------------
        start main part
      --------------- -->

      
      <main class="order-details">
    <h1>Chi tiết đơn hàng</h1>
    <section class="order-info">
      <h2>THÔNG TIN CHI TIẾT ĐƠN HÀNG</h2>
      <p><strong>Mã đơn hàng:</strong> <?= $order['id'] ?></p>
      <p><strong>Tình trạng đơn hàng:</strong> <span class="status success"><?= $order['order_status'] ?></span></p>
      <p><strong>Thời gian đặt:</strong> <?= $order['order_date'] ?></p>
      <p><strong>Thời gian giao:</strong> <?= $order['delivery_date'] ?></p>
      <p><strong>Tên tài khoản đặt hàng:</strong> <?= $order['customer_name'] ?></p>
      <p><strong>Phương thức thanh toán:</strong> <?= $order['payment_method'] ?></p>
      <p><strong>Địa chỉ giao hàng:</strong> <?= $order['shipping_address'] ?></p>
      <p><strong>Ghi chú:</strong></p>
      <textarea readonly rows="3"><?= $order['note'] ?></textarea>
    </section>

    <section class="invoice-details">
      <h2>HÓA ĐƠN KHÁCH HÀNG</h2>
      <table>
      <thead>
  <tr>
    <th>Tên sản phẩm</th>
    <th>Số lượng</th>
    <th>Giá</th>
    <th>Tổng</th>
  </tr>
</thead>
<tbody>
  <?php
    $total = 0;
    while ($item = $result_items->fetch_assoc()):
      $subtotal = $item['quantity'] * $item['price'];
      $total += $subtotal;
  ?>
    <tr>
      <td><?= $item['product_name'] ?></td>
      <td><?= $item['quantity'] ?></td>
      <td>$<?= $item['price'] ?></td>
      <td>$<?= $subtotal ?></td>
    </tr>
  <?php endwhile; ?>
</tbody>

        <tfoot>
          <tr>
            <td colspan="3"><strong>Tổng tiền:</strong></td>
            <td><strong>$<?= $total ?></strong></td>
          </tr>
        </tfoot>
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
     <h2>Cập nhật thông tin</h2>
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
     <h2>Phân tích bán hàng</h2>

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
    // Function to handle user lock
function lockUser(userName) {
  const confirmation = confirm(`Bạn có chắc muốn khóa người dùng ${userName}?`);
  if (confirmation) {
    alert(`Bạn đã khóa người dùng ${userName}`);
  }
}

   </script>
</body>
</html>