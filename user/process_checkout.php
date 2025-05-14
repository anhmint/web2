<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Giỏ hàng trống.");
}

$cart = $_SESSION['cart'];
$fullname = $_POST['fullname'] ?? '';
$address = $_POST['address'] ?? '';
$note = $_POST['note'] ?? '';
$payment_method = $_POST['payment_method']; // Kiểm tra giá trị nhận được từ form

// Kiểm tra giá trị trước khi thực hiện câu lệnh SQL
echo $payment_method; 

// Câu lệnh SQL để lưu giá trị vào cơ sở dữ liệu
$query = "INSERT INTO orders (payment_method) VALUES ('$payment_method')";
$user_id = $_SESSION['user']['id'] ?? null;

if (!$user_id) {
    die("Vui lòng đăng nhập để đặt hàng.");
}



function calculateTotal($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

$total_price = calculateTotal($cart);
$now = date('Y-m-d H:i:s');

$conn->begin_transaction();

try {
    // 1. Thêm vào bảng orders
    $sql_order = "INSERT INTO orders (user_id, order_status, order_date, delivery_date, payment_method, shipping_address, note, total_price, created_at)
                  VALUES (?, 'Chờ xác nhận', ?, NULL, ?, ?, ?, ?, ?)";

    $stmt_order = $conn->prepare($sql_order);
    if (!$stmt_order) {
        throw new Exception("Lỗi chuẩn bị đơn hàng: " . $conn->error);
    }

    // Kiểm tra và gắn các giá trị vào câu lệnh SQL
    $stmt_order->bind_param("issssds", 
        $user_id,
        $now,
        $payment_method,
        $address,
        $note,
        $total_price,
        $now
    );

    if (!$stmt_order->execute()) {
        throw new Exception("Lỗi khi thêm đơn hàng: " . $stmt_order->error);
    }

    $order_id = $conn->insert_id;

    // 2. Chuẩn bị truy vấn thêm vào order_items
    $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt_item = $conn->prepare($sql_item);
    if (!$stmt_item) {
        throw new Exception("Lỗi chuẩn bị order_items: " . $conn->error);
    }

    // 3. Lặp qua giỏ hàng và kiểm tra từng sản phẩm
    $check_product = $conn->prepare("SELECT id FROM products WHERE id = ?");
    foreach ($cart as $item) {
        $product_id = $item['id'];  // Sửa ở đây
    
        // Kiểm tra tồn tại sản phẩm
        $check_product->bind_param("i", $product_id);
        $check_product->execute();
        $result = $check_product->get_result();
    
        if ($result->num_rows === 0) {
            throw new Exception("Sản phẩm ID $product_id không tồn tại.");
        }
    
        // Thêm vào order_items
        $stmt_item->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
        if (!$stmt_item->execute()) {
            throw new Exception("Lỗi khi thêm sản phẩm vào đơn hàng: " . $stmt_item->error);
        }
    }
    

    $conn->commit();
    unset($_SESSION['cart']);
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
          <head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công</title>

</head>
<body>
    <div class="container">
        <h2>Đặt hàng thành công!</h2>
        <p>Cảm ơn bạn <strong><?= htmlspecialchars($fullname) ?></strong> đã đặt hàng.</p>
        <p>Mã đơn hàng của bạn là: <strong><?= $order_id ?></strong></p>
        <button><p><a href="index.php">Tiếp tục mua sắm</a></p></button>
    </div>
</body>

    </html>

    <?php

} catch (Exception $e) {
    $conn->rollback();
    die("Lỗi khi xử lý đơn hàng: " . $e->getMessage());
}
?>
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
