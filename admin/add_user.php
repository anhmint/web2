<?php
$pdo = new PDO("mysql:host=localhost;dbname=fclothes", "root", "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $id = $_POST["id"];
    $status = $_POST["status"];
    $act = $_POST["act"];
    $sdt = $_POST["sdt"]; 
    $dia_chi = $_POST["dia_chi"];         // <-- thêm dòng này
    $email = $_POST["email"];     // <-- và dòng này
    $gender = $_POST["gender"];  

    // Kiểm tra nếu ID đã tồn tại
    $check = $pdo->prepare("SELECT COUNT(*) FROM user WHERE id = :id OR name = :name OR email = :email");
    $check->bindParam(':id', $id);
    $check->bindParam(':name', $name);
    $check->bindParam(':email', $email);
    $check->execute();
    
    if ($check->fetchColumn() > 0) {
        echo "ID, tên hoặc email đã tồn tại. Vui lòng kiểm tra lại.";
        exit();
    }
    

if ($check->fetchColumn() > 0) {
    echo "ID đã tồn tại. Vui lòng nhập ID khác.";
    exit();
}

    $stmt = $pdo->prepare("INSERT INTO user (name, id, status, act, sdt, email, dia_chi, gender) VALUES (:name, :id, :status, :act, :sdt, :email, :dia_chi, :gender)");

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':act', $act);
    $stmt->bindParam(':sdt', $sdt);
    $stmt->bindParam(':dia_chi', $dia_chi);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':gender', $gender);
    if ($stmt->execute()) {
        header("Location: index.php?message=success");
        exit();
    } else {
        echo "Lỗi khi thêm người dùng!";
    }
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

      <main>
  <form method="POST">
    <label>Tên:</label>
    <input type="text" name="name" required>
    <br>

    <label>Mã số khách hàng:</label>
    <input type="text" name="id" required>
    <br>

    <label>Tình trạng:</label>
    <select name="status">
      <option value="Hoạt động">Hoạt động</option>
      <option value="Không hoạt động">Không hoạt động</option>
    </select>
    <br>
    <label>Địa chỉ:</label>
    <input type="text" name="dia_chi" required>

    <label>Trạng thái:</label>
    <select name="act">
      <option value="Mở">Mở</option>
      <option value="Khóa">Khóa</option>
    </select>
    <br>

    <label for="gender">Giới tính:</label>
              <select id="gender" name="gender">
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
              </select>

    <label>Số điện thoại:</label>
    <input type="text" name="sdt" required>
    <br>

    <label>Email:</label>
    <input type="email" name="email" required>
    <br>

    <button type="submit">Thêm</button>
  </form>
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


</body>
</html>