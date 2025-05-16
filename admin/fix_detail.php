<?php
$pdo = new PDO("mysql:host=localhost;dbname=fclothes", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sdt = $_POST['sdt'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $dia_chi = $_POST['dia_chi'];
    $status = $_POST['status'];
    $act = $_POST['act'];

    // Bước 1: Kiểm tra người dùng có tồn tại với id và name
    $checkStmt = $pdo->prepare("SELECT * FROM user WHERE id = :id AND name = :name");
    $checkStmt->execute([':id' => $id, ':name' => $name]);

    if ($checkStmt->rowCount() == 0) {
        echo "<script>alert('Không tìm thấy người dùng với tên đã nhập!'); window.history.back();</script>";
        exit;
    }

    // Cập nhật dữ liệu
    $sql = "UPDATE user SET 
              sdt = :sdt, 
              gender = :gender, 
              email = :email, 
              dia_chi = :dia_chi, 
              status = :status, 
              act = :act
            WHERE id = :id AND name = :name";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':sdt' => $sdt,
        ':gender' => $gender,
        ':email' => $email,
        ':dia_chi' => $dia_chi,
        ':status' => $status,
        ':act' => $act,
        ':id' => $id
    ]);

    echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php';</script>";
    exit;
}
?>

<!-- 👈 Thêm dấu đóng PHP ở đây -->



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
        
        <div class="container">
          <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px; text-align: center;">Chỉnh sửa thông tin</h2>
            <form action="#" method="post">
              <label for="name">Họ và tên:</label>
              <input type="text" id="name" name="name" placeholder="Nhập họ và tên" required>
        
              <label for="phone">Số điện thoại:</label>
              <input type="text" id="sdt" name="sdt" placeholder="Nhập số điện thoại" required>
        
              <label for="id">Mã số khách hàng:</label>
              <input type="text" id="id" name="id" placeholder="Nhập mã số khách hàng" required>

              <label for="gender">Giới tính:</label>
              <select id="gender" name="gender">
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
              </select>
        
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" placeholder="Nhập email" required>
        
              <label for="address">Địa chỉ giao hàng mặc định:</label>
              <input type="text" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ" required>

              <label for="status">Tình trạng:</label>
              <select id="status" name="status">
                <option value="Hoạt động">Hoạt động</option>
                <option value="Không hoạt động">Không hoạt động</option>
              </select>

              <label for="act">Trạng thái:</label>
              <select id="act" name="act">
              <option value="Mở khóa">Mở</option>
              <option value="Khóa">Khóa</option>
              </select>

              <div class="form-btns">
                <button type="submit" onclick="saveChanges()">Lưu thay đổi</button>
                <a href="index.php"><button type="button">Hủy bỏ</button></a>
              </div>
              
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