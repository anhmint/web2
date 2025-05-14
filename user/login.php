<?php
session_start();
include 'config.php';

$error = '';
$login_success = false; // Define the variable to prevent the warning

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Dùng name vì tên người dùng nằm trong cột 'name'
    $stmt = $conn->prepare("SELECT * FROM user WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Kiểm tra password bình thường hoặc đã mã hóa
        if ($user['password'] === $password || password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // 🔥 Thêm dòng này để lưu user_id
            $_SESSION['user'] = $user;
            $login_success = true;  // Set login success to true
            header('Location: index.php');
            exit;
        } else {
            $error = "Sai mật khẩu!";
        }
    } else {
        $error = "Tài khoản không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
        <link href="login.css" rel="stylesheet">
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
                                            <li class="active"><a href="index.php">Trang chủ</a></li>
                                            <li class="dropdown menu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sản phẩm <i class="fa fa-angle-down"></i></a>
                                                <ul class="dropdown-menu megamenu" role="menu">
                                                    <li>
                                                        <div class="">
                                                            <div class="dropdown-menu">
                                                                <ul>
                                                                    <li><a href="kit.html">Trang phục thể thao</a></li>
                                                                    <li><a href="giaythethao.html">Giày thể thao</a></li>
                                                                    <li><a href="phukienkhac.html">Các phụ kiện khác</a></li>
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
              <div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <div class="divider">
        <span>---------------</span>
    </div>
    <a href="register.php" class="register-link"><button type="button">Đăng ký</button></a>
</div>

            <script>
                function login(event) {
                    event.preventDefault();  // Ngăn chặn gửi form thật sự
                    
                    // Đặt tên người dùng mặc định nếu ô tên trống
                    var username = document.getElementById('username').value || "Guest";
                    
                    // Lưu tên đăng nhập vào localStorage
                    localStorage.setItem('username', username);
                    
                    document.getElementById('message').textContent = "Đăng nhập thành công!";
                    window.location.href = "index.php";  // Chuyển hướng đến trang sau khi đăng nhập
                }
            </script>
            <?php
// Sau khi kiểm tra đăng nhập thành công:
if ($login_success) {
    echo "<script>
        localStorage.setItem('username', '" . htmlspecialchars($username) . "');
        window.location.href = 'index.php'; // hoặc trang chủ sau đăng nhập
    </script>";
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
                   
                </div>
            </div>
        </div>
        <div class="footer-text">
            <div class="container">
                <p>Copyright © 2024 FCLOTHES - TRANG BÁN HÀNG UY TÍN SỐ MỘT CHÂU Á</p>
            </div>
        </div>
    </div>
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
<script src="js/timkiemsanpham.js"></script>
</body>
</html>
