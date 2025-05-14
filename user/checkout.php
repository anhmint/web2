<?php
session_start();

// Lấy giỏ hàng từ session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Lấy thông tin người dùng từ session
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Hàm tính tổng tiền (kiểm tra tránh khai báo lại)
if (!function_exists('calculateTotal')) {
    function calculateTotal($cart) {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
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

                      <?php
    ?>

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
                                     
                                      <ul class="nav navbar-nav navbar-right">
                                          <li class="menu-search-form">
                                              <a href="#" id="open-srch-form"><img src="images/srch.png" alt="srch"></a>
                                          </li>
                                          <li id="open-srch-form-mod">
                                            
                                            <form class="side-search" onsubmit="event.preventDefault(); searchProducts();">
                                                <div class="input-group">
                                                  <input type="text" class="form-control search-wid" placeholder="Search Here" aria-describedby="basic-addon1">
                                                  <a href="search.php" class="input-group-addon btn-side-search" id="basic-addon1" onclick="searchProducts()">
                                                    <i class="fa fa-search"></i>
                                                  </a>
                                                </div>
                                              </form>
                                              <div id="search-results" style="margin-top: 10px;"></div>
                                              
                                          </li>
                                      </ul>
                                  </div><!-- /.navbar-collapse -->
                              <!--</div> -->
                              
                          </nav>
                      </div>
                      <div class="srch-form">
                        <form class="side-search" action="search.php" method="GET">
                          <div class="input-group">
                            <input type="text" name="q" class="form-control search-wid" placeholder="Search Here" aria-describedby="basic-addon2">
                            <button type="submit" class="input-group-addon btn-side-serach" id="basic-addon2">
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </form>
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
<body>
<h3>Thông tin đơn hàng</h3>

<?php if (empty($cart)): ?>
    <p>Giỏ hàng của bạn đang trống.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
        <?php foreach ($cart as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫</td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="total">Tổng cộng:</td>
            <td class="total"><?= number_format(calculateTotal($cart), 0, ',', '.') ?>₫</td>
        </tr>
    </table>

    <h3>Thông tin giao hàng</h3>
    <form action="process_checkout.php" method="post" class="checkout-form">
        <div class="form-group">
            <label for="fullname">Họ tên:</label>
            <input type="text" id="fullname" name="fullname" required 
                value="<?= isset($user['name']) ? htmlspecialchars($user['name']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="address">Địa chỉ:</label>
            <textarea id="address" name="address" rows="3" required><?= isset($user['dia_chi']) ? htmlspecialchars($user['dia_chi']) : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="sdt" name="sdt" required 
                value="<?= isset($user['sdt']) ? htmlspecialchars($user['sdt']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="note">Ghi chú (nếu có):</label>
            <textarea id="note" name="note" rows="2"></textarea>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="form-group">
            <label for="payment-method">Phương thức thanh toán:</label>
            <select id="payment-method" name="payment_method" required>
                <option value="Thanh toán khi nhận hàng COD">Thanh toán khi nhận hàng (COD)</option>
                <option value="Thanh toán ATM">Chuyển khoản ngân hàng</option>
                <option value="Thẻ tín dụng">Thẻ tín dụng/Thẻ ghi nợ</option>
            </select>
        </div>

        <button type="submit" class="submit-button">Xác nhận đặt hàng</button>
    </form>
<?php endif; ?>

</body>
</html>
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
