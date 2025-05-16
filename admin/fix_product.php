<?php
$conn = new mysqli('localhost', 'root', '', 'fclothes');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Nếu là POST (CẬP NHẬT sản phẩm)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = $_POST['productName'];
    $status = $_POST['productStatus'];
    $category = $_POST['productCategory'];
    $description = $_POST['productDescription'];
    $id = $_POST['productCode'];
    $quantity = intval($_POST['productQuantity']);
    $size = $_POST['productSize'];

    if (!empty($_FILES['productImage']['name'])) {
        $image = $_FILES['productImage']['name'];
        move_uploaded_file($_FILES['productImage']['tmp_name'], "images/" . $image);

        $sql = "UPDATE products SET name=?, status=?, category=?, description=?, image=?, id=?, quantity=?, size=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssisi", $name, $status, $category, $description, $image, $id, $quantity, $size, $id);
    } else {
        $sql = "UPDATE products SET name=?, status=?, category=?, description=?, id=?, quantity=?, size=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssisi", $name, $status, $category, $description, $id, $quantity, $size, $id);
    }

    if ($stmt->execute()) {
        header("Location: product_management.php?message=updated"); // Redirect sau khi update
        exit();
    } else {
        die("Lỗi cập nhật: " . $stmt->error);
    }
}

// Nếu là GET (hiển thị form sửa sản phẩm)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM products WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Không tìm thấy sản phẩm có ID: $id");
    }
} else {
    die("Thiếu ID sản phẩm!");
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
  <link rel="stylesheet" href="fix_product.css">
  <link rel="stylesheet" href="fix_detail.css">
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
        <div class="edit-product-form">
          <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px; text-align: center;">Chỉnh sửa sản phẩm</h2>
          <form action="fix_product.php" method="POST" enctype="multipart/form-data">
    <!-- ID ẩn -->
    <input type="hidden" name="id" value="<?= $product['id'] ?>">

    <!-- Tên sản phẩm -->
    <div class="form-group">
        <label for="productName">Tên sản phẩm</label>
        <input type="textarea" name="productName" value="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <!-- Trạng thái -->
    <div class="form-group">
  <label>Trạng thái sản phẩm</label>
  <div class="radio-group">
    
    <input type="radio" id="activeButton" name="productStatus" value="active" <?= $product['status'] == 'active' ? 'checked' : '' ?>>
    <label for="activeButton" class="radio-button">
       Còn hàng
    </label>

    <input type="radio" id="inactiveButton" name="productStatus" value="inactive" <?= $product['status'] == 'inactive' ? 'checked' : '' ?>>
    <label for="inactiveButton" class="radio-button">
       Hết hàng
    </label>

  </div>

    <!-- Danh mục -->
    <div class="form-group">
        <label for="productCategory">Danh mục sản phẩm</label>
        <select name="productCategory">
    <option value="dien-thoai" <?= $product['category'] == 'dien-thoai' ? 'selected' : '' ?>>Áo thi đấu</option>
    <option value="phu-kien" <?= $product['category'] == 'phu-kien' ? 'selected' : '' ?>>Giày bóng đá</option>
    <option value="may-tinh" <?= $product['category'] == 'may-tinh' ? 'selected' : '' ?>>Phụ kiện thể thao </option>
</select>
    </div>

    <!-- Hình ảnh -->
    <div class="form-group">
        <label for="productImage">Hình ảnh sản phẩm</label>
  <!-- Ảnh -->
<img src="images/<?= $product['image'] ?>" style="max-width:150px;"><br>
<input type="file" name="productImage">
    </div>

    <!-- Mô tả -->
    <div class="form-group">
        <label for="productDescription">Mô tả sản phẩm</label>
        <textarea name="productDescription"><?= htmlspecialchars($product['description']) ?></textarea>
    </div>
<!-- Mã sản phẩm -->
<div class="form-group">
    <label for="productCode">Mã sản phẩm</label>
  <!-- Code -->
<input type="text" name="productCode" value="<?= $product['id'] ?>">
</div>

<!-- Số lượng -->
<div class="form-group">
    <label for="productQuantity">Số lượng</label>
    <input type="number" name="productQuantity" value="<?= $product['quantity'] ?>">
</div>

<!-- Size -->
<div class="form-group">
    <label for="productSize">Size</label>
   <!-- Size -->
<select name="productSize">
    <option value="L" <?= $product['size'] == 'L' ? 'selected' : '' ?>>L</option>
    <option value="XL" <?= $product['size'] == 'XL' ? 'selected' : '' ?>>XL</option>
    <option value="XXL" <?= $product['size'] == 'XXL' ? 'selected' : '' ?>>XXL</option>
</select>
</div>
<button type="submit" name="update">Lưu thay đổi</button>

</form>

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
   <script>
    function saveChanges() {
      alert("Thông tin đã được cập nhật thành công!");
    }
  </script>
</body>
</html>