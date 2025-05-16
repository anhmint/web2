<?php
session_start();
require "config.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json"); // Đảm bảo trả về JSON

    // Bỏ kiểm tra email, password luôn
    $_SESSION["admin"] = "Admin Fake"; // Gán tên Admin giả

    echo json_encode(["status" => "success", "message" => "Đăng nhập thành công!"]);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="alert alert-show announce" role="alert"></div>
    <div class="body">
      <div class="login-container">
        <h2 class="login-title">Đăng nhập</h2>
        <form class="login-form" action="login.php" method="POST">
          <div>
            <label for="username">Tài khoản</label>
            <div class="input-wrapper">
              <i class="fas fa-user"></i>
              <input required type="text" id="username" name="email" placeholder="Nhập tài khoản bất kỳ" />

            </div>
          </div>
          <div>
            <label for="password">Mật khẩu</label>
            <div class="input-wrapper">
              <i class="fas fa-lock"></i>
              <input
                required
                type="password"
                id="password"
                name ="password"
                placeholder="Nhập mật khẩu"
              />
            </div>
          </div>
          <button type="submit" class="login-button">Đăng nhập</button>
        </form>
      </div>
    </div>
  </body>



<script>
    function showAnnouncement(type, message) {
    const alertBox = document.querySelector(".alert");
    if (!alertBox) return;

    alertBox.textContent = message;
    alertBox.classList.add("alert-show", `alert-${type}`);

    setTimeout(() => {
        alertBox.classList.remove("alert-show", `alert-${type}`);
    }, 3000);
}

</script>

<script>
    document.querySelector(".login-form").addEventListener("submit", function (event) {
      event.preventDefault(); // Ngăn reload trang

      const formData = new FormData(this);

      fetch("login.php", {
          method: "POST",
          body: formData,
      })
      .then(response => response.json()) 
      .then(data => {
          if (data.status === "danger") {
              showAnnouncement("danger", data.message); // Hiển thị thông báo
          } else {
              window.location.href = "index.php"; // Chuyển hướng nếu đăng nhập thành công
          }
      })
      .catch(error => {
          console.error("Lỗi:", error);
          showAnnouncement("danger", "Lỗi kết nối server!");
      });
  });

</script>
</html>
