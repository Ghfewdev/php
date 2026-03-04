<?php
session_start();
require 'db.php';
// $password = password_hash("77416", PASSWORD_DEFAULT);

//     die($password);

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM user WHERE us_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // กรณี password เป็น plain text (ตาม JSON)
    if ($user && password_verify($password, $user['us_pass'])){

        $_SESSION['us_id'] = $user['us_id'];
        $_SESSION['us_name'] = $user['us_name'];
        $_SESSION['us_dv'] = $user['us_dv'];

        header("Location: admin.php?hospital=" .base64_encode($username));
        exit();

    } else {
        $error = "Username หรือ Password ไม่ถูกต้อง";
        
    }
    
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5 col-lg-4">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <h3 class="fw-bold">เข้าสู่ระบบ</h3>
                        <!-- <p class=" small text-danger">**หมายเหตุ: user และ password คือ <br> รหัส 5 หลักโรงพยาบาล**</p> -->
                    </div>

                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger text-center">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" 
                                   name="username" 
                                   class="form-control rounded-3"
                                   placeholder="กรอก Username"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control rounded-3"
                                   placeholder="กรอก Password"
                                   required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" 
                                    class="btn btn-primary rounded-3">
                                🔐 เข้าสู่ระบบ
                            </button>
                            <br>
                            <!-- <button onclick="Home()"
                                    class="btn btn-danger rounded-3">
                                กลับหน้าหลัก
                            </button> -->

                            <!-- <script>
function Home() {
  window.location.href = './';
}
</script> -->
                        </div>

                    </form>

                </div>
            </div>

            <p class="text-center text-muted mt-3 small">
                © <?= date("Y") ?> ระบบ ติดตามจำนวนคิวผู้ป่วยของโรงพยาบาล
            </p>

        </div>
    </div>
</div>

</body>
</html>