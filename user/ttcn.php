<?php
session_start();

// Xử lý cập nhật thông tin nếu có POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    // Kết nối database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fclothes";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
    
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['sdt'];
    $address = $_POST['dia_chi'];
    $user_id = $_SESSION['user']['id'];
    
    // Chuẩn bị câu lệnh SQL để cập nhật thông tin
    $sql = "UPDATE user SET 
            name = ?, 
            gender = ?, 
            email = ?, 
            sdt = ?, 
            dia_chi = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $gender, $email, $phone, $address, $user_id);
    
    // Thực thi câu lệnh
    if ($stmt->execute()) {
        // Cập nhật thành công, cập nhật lại session
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['gender'] = $gender;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['sdt'] = $phone;
        $_SESSION['user']['dia_chi'] = $address;
        
        $success_message = "Cập nhật thông tin thành công!";
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật thông tin!";
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fclothes - Thông tin cá nhân</title>
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

<div id="wrapper" class="homepage-1">
    <div id="header">
        <div class="top">
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
                
                <div class="clearfix"></div>
                <div class="top-offers show-mobile">
                    <div class="alert alert-warning alert-dismissible fade in offers" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
                        Free Shipping <a href="">on All Orders Over</a> $75!
                    </div>
                </div>
            </div>
        </div>
        
        <div id="believe-nav">
            <div class="container">
                <div class="min-marg">
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="index.php"><img src="images/logofc.png" style="width: 100px;height: 100px;" alt=""></a>
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li class="dropdown menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sản phẩm <i class="fa fa-angle-down"></i></a>
                                    <ul class="dropdown-menu megamenu" role="menu">
                                        <li>
                                            <div class="">
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a href="kit.php">Trang phục thể thao</a></li>
                                                        <li><a href="giaythethao.php">Giày thể thao</a></li>
                                                        <li><a href="phukienkhac.php">Các phụ kiện khác</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                             
                            
                        </div>
                    </nav>
                </div>

            </div>
        </div>
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
                        </ul>
                    </div>
                </nav>
            </div>
        </div>      
    </div>

    <div class="container">
        <h1>Thông tin cá nhân của bạn</h1>
        
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="full-name">Họ và tên</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['user']['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="gioitinh">Giới tính</label>
                <select name="gender" id="gioitinh" required>
                    <option value="">-- Chọn giới tính --</option>
                    <option value="male" <?php echo (isset($_SESSION['user']['gender']) && $_SESSION['user']['gender'] == 'male') ? 'selected' : ''; ?>>Nam</option>
                    <option value="female" <?php echo (isset($_SESSION['user']['gender']) && $_SESSION['user']['gender'] == 'female') ? 'selected' : ''; ?>>Nữ</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" name="sdt" value="<?php echo htmlspecialchars($_SESSION['user']['sdt']); ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <textarea name="dia_chi" required><?php echo isset($_SESSION['user']['dia_chi']) ? htmlspecialchars($_SESSION['user']['dia_chi']) : ''; ?></textarea>
            </div>

            <div>
                <button type="submit" class="custom-btn primary-btn btn-announce"
                    type-announce="success"
                    message="Đã cập nhật thông cá nhân thành công!">
                    Cập nhật thay đổi
                </button>
            </div>
        </form>
    </div>

    <div id="footer">
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
    </div>
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

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/popperjs/popper.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Custom script - Các file js do mình tự viết -->
<script src="../assets/js/app.js"></script>

</body>
</html>