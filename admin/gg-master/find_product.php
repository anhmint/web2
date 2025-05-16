<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fclothes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Kết nối thất bại: " . $conn->connect_error);

$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

$sql = "SELECT * FROM products 
        WHERE name LIKE '%$query%' 
        OR id LIKE '%$query%' 
        OR quantity LIKE '%$query%'";

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="product_management.css">
  <link rel="stylesheet" href="style.css">
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

          
           <a href="login.html">
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

      <main>
        <div class="recent_order">
          <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px;">Đơn hàng gần đây</h2>
          <div class="add-product-container">
            <a href="add_product.php" class="add-button">➕ Thêm sản phẩm</a>
            <form action="find_product.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Tìm kiếm sản phẩm..." class="search-input" />
                <button type="submit" class="search-button">🔍 Tìm kiếm</button>
            </form>
        </div>
                    
            <table> 
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Mã số sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                        <th>Thêm</th>
                    </tr>
                </thead>

            
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><img src="images/<?= htmlspecialchars($row['image']) ?>" alt="Product Image"></td>
        <td><?= htmlspecialchars($row['quantity']) ?></td>
        <td class="actions">
            <a href="fix_product.php?id=<?= $row['id'] ?>"><button class="edit">Sửa</button></a>
            <a href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"><button class="lock">Xóa</button></a>
        </td>
        <td class="primary"><a href="product_detail.php?id=<?= $row['id'] ?>">Chi tiết</a></td>
    </tr>
<?php endwhile; ?>
</table>
<a href="product_management.php" class="back-link">Quay lại</a>

                   
           
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
</body>
</html>