<?php
// session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tạo mật khẩu mới</title>
    <link href="styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
</head>
<?php

require 'db.php';

$success = '';
$error = '';



// $sql = "select * from nguoidung where Token = '$Token'";
// $query = mysqli_query($conn, $sql);

// if (mysqli_num_rows($query) > 0) {
//   $row = mysqli_fetch_array($query);
//   $Email = $row['Email'];
//   $_SESSION['Email'] = $Email;
// }
// else {
//   header('location: login.php');
// }


// if (isset($_POST['NewPassword'])){
//     $NewPassword = $_POST['NewPassword'];

//     if($NewPassword == ''){
//         $error = "Vui lòng nhập mật khẩu.";
//     }
//     else if (strlen($NewPassword) < 6 || strlen($NewPassword) > 32) {
//         $error = "Mật khẩu không được ngắn hơn 6 kí tự và dài hơn 32 kí tự.";
//     }
//     else {
//         if(isset($_SESSION['Email'])){

//             $Email = $_SESSION['Email'];

//             $Password = md5($NewPassword);
//             $sql = "update nguoidung set Password = '$Password' where Email = '$Email'";
//             $query = mysqli_query($conn, $sql);
//             $success = 'Mật khẩu mới đã được lưu';

//             $Token = '';
//             $sql = "update nguoidung set Token = '$Token' where Email = '$Email'";
//             $query = mysqli_query($conn, $sql);

//             session_destroy();
//         }
//     }
// }
?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Mật khẩu mới</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['token']) && isset($_GET['email'])) {
                                        $token = $_GET['token'];
                                        $email = $_GET['email'];

                                        if (check_token($email, $token)) {
                                            if (isset($_POST['NewPassword'])) {
                                                $password = $_POST['NewPassword'];
                                                
                                                if ($password == ''){
                                                    $error = "Vui lòng nhập password.";
                                                }
                                                else if (strlen($password) < 6 || strlen($password) > 32) {
                                                    echo $password;
                                                    $error = "Mật khẩu không được ngắn hơn 6 kí tự và dài hơn 32 kí tự.";
                                                }
                                                else{

                                                    $password = password_hash($password, PASSWORD_DEFAULT);

                                                    $conn = open_database();

                                                    $stmt = $conn->prepare("update nguoidung set Password = ? where Email = ?");
                                                    $stmt->bind_param('ss', $password, $email);
                                                    
                                                    if (!$stmt->execute()) {
                                                        die("Query error:" . $stmt->error);
                                                    }
                                                    
                                                    $newToken = '';
                                                    $stmt = $conn->prepare("update nguoidung set Token = ? where Email = ?");
                                                    $stmt->bind_param('ss', $newToken, $email);

                                                    if (!$stmt->execute()) {
                                                        die("Query error:" . $stmt->error);
                                                    }

                                                    $success = "Tạo mới mật khẩu thành công.";
                                                    
                                                }

                                            }

                                    ?>
                                            <div class="small mb-3 text-muted text-center">Nhập mật khẩu mới của bạn.</div>
                                            <form method="post" id="NewPassword">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputNewPassword">Mật Khẩu mới</label>
                                                    <input name="NewPassword" class="form-control py-4" id="inputNewPassword" type="password" placeholder="Nhập Mật khẩu" />
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    if (!empty($error)) {
                                                        echo "<div class='alert alert-danger text-center'>$error</div>";
                                                    }
                                                    if (!empty($success) && empty($error)){
                                                        echo "<div class='alert alert-success text-center'>$success</div>";
                                                    }
                                                    ?>
                                                </div>
                                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                    <a class="small" href="login.php">Trở lại đăng nhập</a>
                                                    <button class="btn btn-primary" type="submit">Xác nhận</button>
                                                </div>
                                            </form>
                                    <?php

                                        } else {

                                            echo "<div class='alert alert-danger text-center font-weight-bold text-danger' >Link không hợp lệ.</div>";
                                        }
                                    } else {

                                        echo "<div class='alert alert-danger text-center font-weight-bold text-danger'>Link không hợp lệ.</div>";
                                    }
                                    ?>


                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="register.php">Chưa có tài khoản? Đăng ký!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="main.js"></script>
</body>

</html>