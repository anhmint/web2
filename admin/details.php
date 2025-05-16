<<?php
// Kết nối database
$pdo = new PDO("mysql:host=localhost;dbname=fclothes", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Lấy id từ URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Lấy thông tin người dùng
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Không tìm thấy người dùng!";
        exit();
    }
} else {
    echo "Không có ID người dùng!";
    exit();
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
      <div class="user-info">
    <h2 style="font-family: 'Arial', sans-serif; font-size: 32px; font-weight: bold; color: #333; margin-bottom: 20px; text-align: center;">
        Chi tiết người dùng
    </h2>
    <div class="user-details">
      <table>
    <tr><th>Họ tên</th><td><?= htmlspecialchars($user['name']) ?></td></tr>
    <tr><th>Mã số khách hàng</th><td><?= htmlspecialchars($user['id']) ?></td></tr>
    <tr><th>Giới tính</th><td>
<?php
    switch ($user['gender']) {
        case 'male':
            echo 'Nam';
            break;
        case 'female':
            echo 'Nữ';
            break;
        case 'other':
            echo 'Khác';
            break;
        default:
            echo 'Không xác định';
    }
?>
</td>
</tr>
    <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
    <tr><th>Số điện thoại</th><td><?= htmlspecialchars($user['sdt']) ?></td></tr>
    <tr><th>Địa chỉ</th><td><?= htmlspecialchars($user['dia_chi']) ?></td></tr>
    
    <tr>
        <th>Trạng thái</th>
        <td>
            <?php
            if ($user['status'] == 'Hoạt động') {
                echo '<span class="status active">Hoạt động</span>';
            } else {
                echo '<span class="status danger">Không hoạt động</span>';
            }
            ?>
        </td>
    </tr>
</table>

            <div class="form-btns">
              
              <a href="fix_detail.php"><button type="button">Sửa thông tin</button></a>
            </div>
            </div>
      </main>
      

   <script src="script.js"></script>
   <script>
function lockUser(userId) {
    if (confirm("Bạn có chắc muốn khóa người dùng này?")) {
        fetch("admin.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "lockUser=" + userId // Gửi id người dùng
        }).then(response => response.json())
          .then(data => {
              // Kiểm tra trạng thái trả về từ server
              if (data.status === 'success') {
                  alert("Người dùng đã bị khóa.");
                  location.reload(); // Tải lại trang
              } else {
                  alert("Không thể khóa người dùng.");
              }
          }).catch(error => {
              console.error("Có lỗi xảy ra:", error);
          });
    }
}

function unlockUser(userId) {
    if (confirm("Bạn có chắc muốn mở khóa người dùng này?")) {
        fetch("admin.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "unlockUser=" + userId // Gửi id người dùng
        }).then(response => response.json())
          .then(data => {
              // Kiểm tra trạng thái trả về từ server
              if (data.status === 'success') {
                  alert("Người dùng đã được mở khóa.");
                  location.reload(); // Tải lại trang
              } else {
                  alert("Không thể mở khóa người dùng.");
              }
          }).catch(error => {
              console.error("Có lỗi xảy ra:", error);
          });
    }
}


    </script>

</body>
</html>