<?php
session_start();  // Bắt đầu session để lưu trữ thông báo lỗi

// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fclothes";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý dữ liệu gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['name']);
    $pass = $_POST['password'];
    $email = trim($_POST['email']);
    $sdt = trim($_POST['sdt']);

    // Kiểm tra nếu các trường không rỗng
    if (empty($user) || empty($pass) || empty($email) || empty($sdt)) {
        $_SESSION['message'] = "Vui lòng điền đầy đủ thông tin!";
        header("Location: register.php");
        exit();
    }

    // Kiểm tra tên người dùng đã tồn tại chưa
    $sql_check = "SELECT id FROM user WHERE name = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $user);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $_SESSION['message'] = "Tên người dùng đã tồn tại!";
        header("Location: register.php");
        exit();
    }

    // Bảo mật: mã hóa mật khẩu
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Thêm người dùng vào CSDL
    $act = "mở";
    $status = "hoạt động";
    
    $sql = "INSERT INTO user (name, password, email, sdt, act, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $user, $hashed_pass, $email, $sdt, $act, $status);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Đăng ký thành công!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['message'] = "Có lỗi xảy ra. Vui lòng thử lại!";
        header("Location: register.php");
        exit();
    }

    if (isset($stmt)) {
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fclothes - Đăng Ký</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Playfair+Display:400,700" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/logofc.png" type="image/x-icon">
    <link rel="icon" href="/logofc.png" type="image/x-icon">    
    <link href="style.css" rel="stylesheet">
    <link href="register.css" rel="stylesheet">
</head>
<body>

<div id="wrapper" class="homepage-1">
    <div id="header">
        <!-- Header -->
    </div>

    <div class="register-container">
        <h2>Đăng Ký</h2>

        <?php
        if (isset($_SESSION['message'])) {
            echo "<p style='color: red;'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>

        <form action="register.php" method="POST">
            <input type="text" name="name" placeholder="Tên" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="sdt" placeholder="Số điện thoại" required>
            <button type="submit">Đăng Ký</button>
        </form>
    </div>

    <div id="footer">
        <!-- Footer -->
    </div>

    <script src="js/library.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/theme-script.js"></script>
</body>
</html>
