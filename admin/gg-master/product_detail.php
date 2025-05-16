<?php
// Kết nối MySQL
$conn = new mysqli('localhost', 'root', '', 'fclothes');
$conn->set_charset('utf8');

// Lấy ID từ URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy sản phẩm!";
        exit;
    }
} else {
    echo "Không có ID sản phẩm!";
    exit;
}
$conn->close();
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
  <link rel="stylesheet" href="fix_detail.css">
  <link rel="stylesheet" href="product_detail.css">
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
           </a>
             <a href="product_management.php">
            <span class="material-symbols-sharp"> inventory </span>
            <h3>Quản lý sản phẩm</h3>
         </a>
           <a href="order_management.php">
              <span class="material-symbols-sharp">receipt_long </span>
              <h3>Quản lý đơn hàng</h3>
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

      <main>
        
      <div class="product-container">

    <div class="product-header">
        <h2><?php echo $product['name']; ?></h2>
    </div>
<div class = "product-main">
    <div class="product-image">
        <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    </div>
</div>

<div class="product-details">
    <table class="product-table">
        <tr>
            <td><b>Giá:</b></td>
            <td>$<?php echo $product['price']; ?></td>
        </tr>
        <tr>
            <td><b>Số lượng:</b></td>
            <td><?php echo $product['quantity']; ?></td>
        </tr>
    
        <tr>
            <td><b>Danh mục:</b></td>
            <td><?php echo $product['category']; ?></td>
        </tr>
        <tr>
            <td><b>Màu sắc:</b></td>
            <td><?php echo $product['color']; ?></td>
        </tr>
        <tr>
            <td><b>Chất liệu:</b></td>
            <td><?php echo $product['material']; ?></td>
        </tr>
        <tr>
            <td><b>Size:</b></td>
            <td><?php echo $product['size']; ?></td>
        </tr>
    </table>
</div>

    <div class="product-description">
        <h3>Mô tả sản phẩm</h3>
        <p><?php echo nl2br($product['description']); ?></p>
    </div>
<br> </br>

<div class="edit-button-container">
    <a href="fix_product.php?id=<?php echo $product['id']; ?>" class="edit-link">
        <button id="editButton">Chỉnh sửa</button>
    </a>
</div>

</div>


        
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
           <p><b>Fclothes</b></p>
           <p>Admin</p>
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
            <small class="text-muted">Đã xem 2 tiếng trước</small>
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