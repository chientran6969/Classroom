<?php
    session_start();
    require_once 'db.php';
    if (isset($_SESSION['Username'])) {
        if ($_SESSION['Role'] == 0) {
            header('location:admin/index.php');
        }
        else if ($_SESSION['Role'] == 1) {
            header('location:GV/index.php');
        }
        else if ($_SESSION['Role'] == 2) {
            header('location:index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Đăng nhập</title>
        <link href="styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>

    <?php
        $Username = '';
        $Password = '';
        $error = '';

        if (isset($_POST['Username']) && isset($_POST['Password'])){
            $Username = $_POST['Username'];
            $Password = $_POST['Password'];

            if ($Username == ''){
                $error = 'Vui lòng nhập tên tài khoản.';
            }
            else if ($Password == ''){
                $error = 'Vui lòng nhập mật khẩu.';
            }
            else {
                $result = login($Username, $Password);

                if($result['code'] == 0){
                   $data = $result['data'];

                   $_SESSION['Username'] = $Username;
                   $_SESSION['Role'] = $data['Role'];
                   $_SESSION['id'] = $data['IdNguoiDung'];
                   $_SESSION['Name'] = $data['Name'];


                   if ($_SESSION['Role'] == 0) {
                        header('location:admin/index.php');
                    }
                    else if ($_SESSION['Role'] == 1) {
                        header('location:GV/index.php');
                    }
                    else if ($_SESSION['Role'] == 2) {
                        header('location:index.php');
                    } 
                }
                else {
                    $error = "tài khoản hoặc mật khẩu không đúng.";
                }

                // $password = md5($Password);
                // $sql = "select * from nguoidung where UserName = '$UserName' and Password = '$password'";

                // echo $sql;
                // $query = mysqli_query($conn, $sql);

                // if (mysqli_num_rows($query) == 1){
                //     $_SESSION['UserName'] = $UserName;
                //     $sql = "select Role from nguoidung where UserName='$UserName'";
                //     $query = mysqli_query($conn, $sql);
                //     while ($row = $query->fetch_assoc()){
                //     $_SESSION['Role'] = $row['Role'];
                //     }
                //     if ($_SESSION['Role'] == 0) {
                //         header('location:admin/dashboard.php');
                //     }
                //     else if ($_SESSION['Role'] == 1) {
                //         header('location:Giaovien.php');
                //     }
                //     else if ($_SESSION['Role'] == 2) {
                //         header('location:index.php');
                //     } 
                // }
                // else {
                //     $error = "Tài khoản hoặc mật khẩu không đúng.";
                // }
            }

            
        }
    ?>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-nomal my-4">Đăng nhập</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputUserName">Tài khoản</label>
                                                <input name="Username" value="<?= $Username ?>" class="form-control py-4" id="inputUserName" type="text" placeholder="Nhập tài khoản" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Mật khẩu</label>
                                                <input name="Password" value="<?= $Password ?>" class="form-control py-4" id="inputPassword" type="password" placeholder="Nhập Mật Khẩu" />
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                    if (!empty($error)){
                                                        echo "<div class='alert alert-danger text-center'>$error</div>";
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="foget.php">Quên Mật khẩu?</a>
                                                <button class="btn btn-primary">Đăng Nhập</button> 
                                            </div>
                                        </form>
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
        
        <script src="main.js"></script>
    </body>
</html>
