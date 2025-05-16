<?php
$conn = new mysqli('localhost', 'root', '', 'fclothes');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = !empty($_POST['name']) ? $_POST['name'] : null;
    $id = !empty($_POST['id']) ? $_POST['id'] : null;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : null;
    $size = !empty($_POST['size']) ? $_POST['size'] : null;
    $description = !empty($_POST['description']) ? $_POST['description'] : null;
    $price = isset($_POST['price']) ? floatval($_POST['price']) : null;
    $color = !empty($_POST['color']) ? $_POST['color'] : null;
    $material = !empty($_POST['material']) ? $_POST['material'] : null;
    $category = !empty($_POST['category']) ? $_POST['category'] : null;

    // Upload ảnh (không bắt buộc)
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);
    }

    // SQL thêm sản phẩm
    $sql = "INSERT INTO products 
            (name, id, image, quantity, size, description, price, color, material, category, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$status = !empty($_POST['status']) ? $_POST['status'] : 'active';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
      "sssissdssss", 
      $name, $id, $image, $quantity, $size, $description, $price, $color, $material, $category, $status
  );

    $stmt->execute();

    header("Location: product_management.php");
    exit;
}
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
  <link rel="stylesheet" href="add_user.css">
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
              <span class="material-symbols-sharp">logout</span>
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
<!-- Form HTML -->
<main>

<form method="POST" enctype="multipart/form-data">
  <input type="file" name="image">
  <input type="text" name="name" placeholder="Tên sản phẩm">
  <input type="text" name="id" placeholder="Mã sản phẩm">
  <input type="number" name="quantity" placeholder="Số lượng" min="0">
  
  <select name="size">
    <option value="">--Chọn size--</option>
    <option value="L">L</option>
    <option value="XL">XL</option>
    <option value="XXL">XXL</option>
  </select>

  <textarea name="description" placeholder="Mô tả sản phẩm"></textarea>
  <input type="number" name="price" placeholder="Giá tiền (VNĐ)" step="0.01" min="0">
  <input type="text" name="color" placeholder="Màu sắc sản phẩm">
  <input type="text" name="material" placeholder="Chất liệu sản phẩm">
  
  <select name="category">
    <option value="">--Chọn loại sản phẩm--</option>
    <option value="Phụ kiện thể thao">Phụ kiện thể thao</option>
    <option value="Áo thi đấu">Áo thi đấu</option>
    <option value="Giày thể thao">Giày thể thao</option>
  </select>
  <select name="status">
  <option value="active" selected>Hoạt động</option>
  <option value="hidden">Ẩn</option>
</select>

  <button type="submit">Thêm sản phẩm</button>
</form>

</main>


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
</html>
