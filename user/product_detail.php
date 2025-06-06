<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fclothes");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Lấy ID sản phẩm
if (!isset($_GET['id'])) {
    die("Không có ID sản phẩm.");
}

$product_id = intval($_GET['id']);

// Truy vấn sản phẩm
$sql = "SELECT * FROM products WHERE id = $product_id AND status != 'hidden'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Sản phẩm không tồn tại.");
}

$product = $result->fetch_assoc();

// Xác định đường dẫn hình ảnh
$imageFile = htmlspecialchars($product['image']);
$imagePath = '';

if (!empty($imageFile) && file_exists(__DIR__ . '/../upload/' . $imageFile)) {
    $imagePath = '../upload/' . $imageFile;
} elseif (!empty($imageFile) && file_exists('images/' . $imageFile)) {
    $imagePath = 'images/' . $imageFile;
} else {
    $imagePath = 'images/default.jpg';
}
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
  <li><a href="kit.php?category_id=3">Áo thi đấu</a></li>
<li><a href="kit.php?category_id=1">Giày thể thao</a></li>
<li><a href="kit.php?category_id=4">Phụ kiện khác</a></li>

</ul>
</li>



                                      </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>


                                      </ul>

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
          <div class="newest">
                  <div class="container">
                      <div class="newest-content">
                          <div class="newest-tab">
                              <ul id="myTab" class="nav nav-tabs newest" role="tablist">
                                  <li role="presentation" class="active">
                                      <a href="#1" id="cat-1" role="tab" data-toggle="tab" aria-controls="1" aria-expanded="true"></a>
                                  </li>
                              </ul>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm - Fclothes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .product-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .product-container img {
            max-width: 300px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .price {
            color: green;
            font-weight: bold;
            font-size: 18px;
        }
        .btn-back {
            margin-top: 20px;
            display: inline-block;
        }
        .btn-add {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container product-container">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <img src="<?= $imagePath ?>" alt="Ảnh sản phẩm">

    <table>
        <tr>
            <th>Mô tả</th>
            <td><?= nl2br(htmlspecialchars($product['description'])) ?></td>
        </tr>
        <tr>
            <th>Giá</th>
            <td class="price"><?= number_format($product['price'], 0, ',', '.') ?> VND</td>
        </tr>
        <tr>
            <th>Màu sắc</th>
            <td><?= htmlspecialchars($product['color']) ?></td>
        </tr>
        <tr>
            <th>Kích thước</th>
            <td><?= htmlspecialchars($product['size']) ?></td>
        </tr>
        <tr>
            <th>Chất liệu</th>
            <td><?= htmlspecialchars($product['material']) ?></td>
        </tr>
        <tr>
            <th>Số lượng còn lại</th>
            <td><?= $product['quantity'] ?></td>
        </tr>
    </table>

    <form action="add_to_cart.php" method="POST" class="btn-add">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <label for="quantity">Số lượng:</label>
        <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['quantity'] ?>">
        <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
    </form>

    <a href="index.php" class="btn btn-secondary btn-back">← Quay lại danh sách sản phẩm</a>
</div>
</div> <!-- đóng div.row -->

                                    </div>

                                  </div>
                                  
                              </div>
                              
                          </div>
                      <nav class="text-center">

</nav>
             
              <script>
                // Kiểm tra xem người dùng đã đăng nhập hay chưa
                document.addEventListener('DOMContentLoaded', function () {
                    var username = localStorage.getItem('username'); // Lấy tên đăng nhập từ localStorage
    
                    if (username) {
                        document.getElementById('welcome-message').textContent = 'Xin chào, ' + user + '!';
                        document.getElementById('login-area').style.display = 'none';
                        document.getElementById('user-area').style.display = 'block';
                    }
                });
    
                // Xử lý sự kiện đăng xuất
                document.getElementById('logout-btn').addEventListener('click', function () {
                    localStorage.removeItem('username'); // Xóa tên đăng nhập
                    document.getElementById('login-area').style.display = 'block';
                    document.getElementById('user-area').style.display = 'none';
                });

            </script>
          <div id="footer"><!-- Footer -->
              <div class="footer-widget">
                  <div class="container">
                      <div class="row">
                          <div class="col-md-3">
                              <div class="text-widget">
                                  <div class="wid-title">Welcome to</div>
                                  <h1> FClothes</h1>
                                  <p>415 Điện Biên Phủ, Phường 25, Bình Thạnh, Hồ Chí Minh, Việt Nam<br/>Thời gian làm việc: 6h00-20h00</a>
                                  </p>
                                  <ul class="ft-soc clearfix">
                                      <li><a href=""><i class="fa fa-facebook-square"></i></a></li>
                                      <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                      <li><a href=""><i class="fa fa-google-plus-square"></i></a></li>
                                      <li><a href=""><i class="fa fa-instagram"></i></a></li>
                                      <li><a href=""><i class="fa fa-pinterest"></i></a></li>
                                  </ul>
                                  <div class="clearfix"></div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="subscribe">
                                  <div class="wid-title">Đánh giá</div>
                                  <p>
                                    Hãy đánh giá Fclothes. Bạn sẽ nhận được ưu đãi cho các đợt mua sau. 
                                  </p>
                                  <form>
                                      <div class="form-group">
                                          <input type="text" class="form-control" placeholder="Nhập đánh giá...">
                                      </div>
                                      <button type="submit" class="btn btn-default">Nhập</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="footer-text">
                  <div class="container">
                      <p>Copyright © 2024 FCLOTHES - TRANG BÁN HÀNG UY TÍN SỐ MỘT CHÂU Á</p>
                  </div>
              </div>
          </div><!-- Footer -->
      </div> <!-- wrapper -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/library.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/ui.js"></script>
<script src="js/jquery.raty.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>
<script src="js/jquery.selectbox-0.2.js"></script>
<script src="js/theme-script.js"></script>
  </body>
</html>

</body>
</html>
