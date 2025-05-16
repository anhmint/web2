<?php
// Kết nối Database
$pdo = new PDO("mysql:host=localhost;dbname=fclothes", "root", "");

// Lấy số trang hiện tại
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Số khách hàng mỗi trang
$offset = ($page - 1) * $limit;

// Đếm tổng số khách hàng
$total_users = $pdo->query("SELECT COUNT(*) FROM user")->fetchColumn();
$total_pages = ceil($total_users / $limit);

// Lấy danh sách khách hàng
$stmt = $pdo->prepare("SELECT id, name, sdt, email, status, act FROM user LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
  <link rel="stylesheet" href="product_management.css">
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
        <div style="display: flex; justify-content: center; align-items: center; ">
            <h1>ADMIN</h1>
        </div>

           <div class="date">
             <input type="date" >
           </div>

        <div class="insights">

           <!-- start seling -->
            <div class="sales">
               <span class="material-symbols-sharp"> trending_up </span>
               <div class="middle">

                 <div class="left">
                   <h3>Tổng doanh số</h3>
                   <h1>$25,024</h1>
                 </div>
                  <div class="progress">
                      <svg>
                         <circle  r="30" cy="40" cx="40"></circle>
                      </svg>
                      <div class="number"><p>80%</p></div>
                  </div>

               </div>
               <small>Trong 24 giờ qua</small>
            </div>

           <!-- end seling -->
              <!-- start expenses -->
              <div class="expenses">
                <span class="material-symbols-sharp"> insights </span>
                <div class="middle">
 
                  <div class="left">
                    <h3>Số đơn</h3>
                    <h1>$20,024</h1>
                  </div>
                   <div class="progress">
                       <svg>
                          <circle  r="30" cy="40" cx="40"></circle>
                       </svg>
                       <div class="number"><p>80%</p></div>
                   </div>
 
                </div>
                <small>Trong 24 giờ qua</small>
             </div>

            <!-- end seling -->
               <!-- start seling -->
               <div class="income">
                <span class="material-symbols-sharp"> stacked_line_chart </span>
                <div class="middle">
 
                  <div class="left">
                    <h3>Tổng giao dịch thành công</h3>
                    <h1>$45,024</h1>
                  </div>
                   <div class="progress">
                       <svg>
                          <circle  r="30" cy="40" cx="40"></circle>
                       </svg>
                       <div class="number"><p>100%</p></div> 
                   </div>  
                  
                </div>
                <small>Trong 24 giờ qua</small>
             </div>
            <!-- end seling -->

        </div>
       <!-- end insights -->
      <div class="recent_order">
        <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px;">
         Khách hàng sử dụng
        </h2>
        <div class="add-product-container">
    <a href="add_user.php" class="add-button">➕ Thêm Người Dùng</a>
    <form action="find_user.php" method="GET" class="search-form">
        <input type="text" name="query" placeholder="Tìm kiếm khách hàng..." class="search-input" />
        <button type="submit" class="search-button">🔍 Tìm kiếm</button>
    </form>
</div>

         <table> 
             <thead>
              <tr>
                <th>Tên khách hàng</th>
                <th>Mã số khách hàng</th>
                <th> Số điện thoại </th>
                <th> Email </th>
                <th>Tình trạng</th>
                <th>Trạng thái</th>
                <th>Thêm</th>
              </tr>
             </thead>
             <tbody>
             <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['sdt']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                           <td>
            <button class="toggle-status" data-id="<?= $user['id'] ?>" data-status="<?= $user['status'] ?>">
                <?= $user['status'] == 'Hoạt động' ? '🔵 Hoạt động' : '🔴 Không hoạt động' ?>
            </button>
               </td>
                        

               <td>
    <button class="toggle-act" data-id="<?= $user['id'] ?>" data-act="<?= $user['act'] ?>">
        <?= $user['act'] == 'Mở khóa' ? '🔵 Mở' : '🔴 Khóa' ?>
    </button>
</td>



 <td>
                            <a href="details.php?id=<?= $user['id'] ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php } ?>
</tbody>

         </table>

         
         <div class="pagination">
         <?php if ($page > 1) { ?>
                <li class="page">
                    <a href="?page=1" class="page-link">««</a>
                </li>
            <?php } ?>
            <?php if ($page > 1) { ?>
                <li class="page">
                    <a href="?page=<?= $page - 1 ?>" class="page-link">«</a>
                </li>
            <?php } ?>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page <?= ($i == $page) ? 'active' : ''; ?>">
                    <a href="?page=<?= $i ?>" class="page-link"><?= $i ?></a>
                </li>
            <?php } ?>
            <?php if ($page < $total_pages) { ?>
                <li class="page">
                    <a href="?page=<?= $page + 1 ?>" class="page-link">»</a>
                </li>
            <?php } ?>
            <?php if ($page < $total_pages) { ?>
                <li class="page">
                    <a href="?page=<?= $total_pages ?>" class="page-link">»»</a>
                </li>
            <?php } ?>
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
       document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".toggle-status").forEach(button => {
        button.addEventListener("click", function () {
            let userId = this.getAttribute("data-id");
            let buttonElement = this; 

            fetch("update_status.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${userId}`
            })
            .then(response => response.text())
            .then(newStatus => {
    console.log(newStatus);  // In ra trạng thái mới để kiểm tra
    if (newStatus === "hoạt động" || newStatus === "không hoạt động") {
        buttonElement.setAttribute("data-status", newStatus);
        buttonElement.innerHTML = (newStatus === "hoạt động") 
            ? "🔵 Hoạt động" 
            : "🔴 Không hoạt động";
    } else {
        alert("Lỗi khi cập nhật trạng thái!");
    }
})

            .catch(error => console.error("Lỗi:", error));
        });
    });
}); 
      </script> 

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".toggle-act").forEach(button => {
        button.addEventListener("click", function () {
            let userId = this.getAttribute("data-id");
            let currentAct = this.getAttribute("data-act");
            let buttonElement = this;

            // Nếu đang là Mở khóa và chuẩn bị Khóa thì hiện xác nhận
            if (currentAct === "Mở khóa") {
                const confirmLock = confirm("Bạn có chắc muốn khóa người dùng này?");
                if (!confirmLock) return; // Hủy thì không làm gì
            }

            fetch("update_act.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${userId}`
            })
            .then(response => response.text())
            .then(newAct => {
                if (newAct === "Mở khóa" || newAct === "Khóa") {
                    buttonElement.setAttribute("data-act", newAct);
                    buttonElement.innerHTML = (newAct === "Mở khóa") 
                        ? "🔵 Mở" 
                        : "🔴 Khóa";
                } else {
                    alert("Lỗi khi cập nhật trạng thái!");
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    });
});

</script>


</body>
</html>