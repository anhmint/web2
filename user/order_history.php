<?php
session_start();

// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "fclothes");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Lấy các đơn hàng của người dùng
$sql_orders = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fclothes</title>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700' rel='stylesheet' type='text/css'>
    <link href='font-awesome/css/font-awesome.css' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/logofc.png" type="image/x-icon">
    <link rel="icon" href="/logofc.png" type="image/x-icon">    
    <link href="style.css" rel="stylesheet">
    <link href="responsive.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
    <link href="css/owl.transitions.css" rel="stylesheet"> 
    <link href="css/prettyPhoto.css" rel="stylesheet">
  </head>
  <body>

      <div id="wrapper" class="homepage-1"> <!-- wrapper -->
          <div id="header"> <!-- header -->
              <div class="top"> <!-- top -->
                  <div class="container">
                      <ul class="top-support"> 
                          <li><i class="fa fa-phone-square"></i><span>(+84) 892 329 1123</span></li>
                          <li><a href=""><i class="fa fa-envelope-square"></i><span>fclothesstore@gmail.com</span></a></li>
                      </ul>
                      <div class="top-offers">
                          <div class="alert alert-warning alert-dismissible fade in offers" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
                              Free Shipping <a href="">on All Orders Over</a> $75!
                          </div>
                      </div>



<div class="top-control">
  <ul>
    <?php if (isset($_SESSION['user'])): ?>
      <li id="user-area" class="dropdown" style="position: relative;">
        <a href="#" class="dropdown-toggle" onclick="toggleDropdown()" id="welcome-message-btn" style="cursor: pointer;">
          <span id="welcome-message" style="color:white;">Xin chào, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
        </a>
        <div class="dropdown-menu" id="user-dropdown" style="display: none; position: absolute; background-color: white; border: 1px solid #ccc; padding: 10px; z-index: 999;">
          <a href="logout.php">Đăng xuất</a><br>
          <a href="ttcn.php">Thông tin cá nhân</a><br>
          <a href="order_history.php">Lịch sử mua hàng</a><br>
          <a href="cart.php">Giỏ hàng</a>
        </div>
      </li>
    <?php else: ?>
      <li id="login-area"><a href="login.php">Đăng nhập</a></li>
    <?php endif; ?>
  </ul>
</div>

<script>
// Toggle dropdown visibility
function toggleDropdown() {
  var dropdown = document.getElementById("user-dropdown");
  dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
}

// Optional: close dropdown when clicking outside
window.onclick = function(event) {
  if (!event.target.matches('#welcome-message-btn') && !event.target.closest('.dropdown')) {
    var dropdown = document.getElementById("user-dropdown");
    if (dropdown) dropdown.style.display = "none";
  }
}
</script>

                      
                      <div class="clearfix"></div>
                      <div class="top-offers show-mobile">
                          <div class="alert alert-warning alert-dismissible fade in offers" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
                              Free Shipping <a href="">on All Orders Over</a> $75!
                          </div>
                      </div>
                  </div>
              </div> <!-- top -->
              
              <div id="believe-nav"> <!-- Nav -->
                  <div class="container">
                      <div class="min-marg">
                          <nav class="navbar navbar-default">
                              <!-- <div class="container-fluid"> -->
                                  <!-- Brand and toggle get grouped for better mobile display -->
                                  <div class="navbar-header">
                                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                          <span class="sr-only">Toggle navigation</span>
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                      </button>
                                      <a class="navbar-brand" href="index.php"><img src="images/logofc.png" style="width: 100px;height: 100px;" alt=""></a>
                                  </div>

                                  <!-- Collect the nav links, forms, and other content for toggling -->
                                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                      <ul class="nav navbar-nav">
                                        <li><a href="index.php">Trang chủ</a></li>
                                        <li class="dropdown menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    Sản phẩm <i class="fa fa-angle-down"></i>
  </a>
  <ul class="dropdown-menu">
    <li><a href="kit.php">Áo thi đấu</a></li>
    <li><a href="shoes.php">Giày thể thao</a></li>
    <li><a href="other_products.php">Phụ kiện khác</a></li>
  </ul>
</li>


                                      </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>


                                      </ul>
                                     
                                     
                                  </div><!-- /.navbar-collapse -->
                              <!--</div> -->
                              
                          </nav>
                      </div>

              </div> <!-- Nav -->
              <div id="cat-nav">
              <div class="container">
                  <nav class="navbar navbar-default">
                      <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#cat-nav-mega">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                          </button>
                      </div>
                      <div class="collapse navbar-collapse" id="cat-nav-mega">
                          <ul class="nav navbar-nav">
                            <p>.</p>
                            
                              </li>
                          </ul>
                           
                      </div><!-- /.navbar-collapse -->
                  </nav>
              </div>
              </div>      
          </div> <!-- header -->
<head>
    <meta charset="UTF-8">
    <title>Lịch sử mua hàng</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .order-container { margin: 20px auto; max-width: 800px; }
        .order { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .order h4 { margin-bottom: 10px; }
        table { width: 100%; margin-top: 10px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container order-container">
    <div style="text-align: center;">
  <h2>Lịch sử mua hàng</h2>
</div>

        <?php if ($result_orders->num_rows > 0): ?>
            <?php while ($order = $result_orders->fetch_assoc()): ?>
                <div class="khoa">
                    <h4>Đơn hàng #<?= isset($order['id']) ? htmlspecialchars($order['id']) : 'N/A' ?></h4>
                    <p><strong>Ngày tạo:</strong> <?= isset($order['created_at']) ? htmlspecialchars($order['created_at']) : 'N/A' ?></p>
                    <p><strong>Trạng thái:</strong> <?= isset($order['order_status']) ? htmlspecialchars($order['order_status']) : 'N/A' ?></p>

                    <?php
                    // Lấy chi tiết sản phẩm trong đơn hàng này
                    if (isset($order['id'])) {
                        $order_id = $order['id'];
                        $sql_items = "SELECT oi.*, p.name, p.image 
                                      FROM order_items oi
                                      JOIN products p ON oi.product_id = p.id
                                      WHERE oi.order_id = ?";
                        $stmt_items = $conn->prepare($sql_items);
                        $stmt_items->bind_param("i", $order_id);
                        $stmt_items->execute();
                        $result_items = $stmt_items->get_result();
                    }
                    ?>

                    <?php if (isset($result_items) && $result_items->num_rows > 0): ?>
                        <table>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                            </tr>
                            <?php while ($item = $result_items->fetch_assoc()): ?>
                                <tr>
                                    <td><?= isset($item['name']) ? htmlspecialchars($item['name']) : 'N/A' ?></td>
                                    <td><img src="images/<?= isset($item['image']) ? htmlspecialchars($item['image']) : 'default.jpg' ?>" width="60"></td>
                                    <td><?= isset($item['quantity']) ? $item['quantity'] : '0' ?></td>
                                    <td><?= isset($item['price']) ? number_format($item['price'], 2) : '0.00' ?> USD</td>
                                </tr>
                            <?php endwhile; ?>
                        </table>
                    <?php else: ?>
                        <p>Không có sản phẩm nào trong đơn hàng này.</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Bạn chưa có đơn hàng nào.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
