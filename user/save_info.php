<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_SESSION['username'];  // sửa dòng này
    $email = $_POST['email'];
    $sdt= $_POST['phone'];
    $dia_chi = $_POST['dia_chi'];
    $gender = $_POST['gender'];

    // SỬA 'address' thành 'dia_chi' nếu đúng với CSDL
    $sql = "UPDATE user SET email = ?, sdt = ?, dia_chi = ?, gender = ? WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $email, $sdt, $dia_chi, $gender, $user);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Thông tin đã được cập nhật!";
        header("Location: ttcn.php");
        exit();
    } else {
        $_SESSION['message'] = "Có lỗi xảy ra. Vui lòng thử lại!";
        header("Location: ttcn.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
