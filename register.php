<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Đăng ký</title>
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
        require_once "db.php";

        $Name = '';
        $Username = '';
        $Email = '';
        $error = '';
        $message = '';

        if(isset($_POST['Name']) && isset($_POST['Username']) && isset($_POST['Email']) && isset($_POST['Password']) 
        && isset($_POST['Password']) && isset($_POST['Repassword']) ) {
            $Name = $_POST['Name'];
            $Username = $_POST['Username'];
            $Email = $_POST['Email'];
            $Birth = $_POST['Birth'];
            $Password = $_POST['Password'];
            $Repassword = $_POST['Repassword'];
            

            if ($Name == '' || $Username == '' || $Email == '' || $Birth == '' || $Password == '' || $Repassword == ''){
                $error = 'Vui lòng nhập đầy đủ thông tin!';
            }
            else if (strlen($Password) < 6 || strlen($Password) > 32) {
                $error = "Mật khẩu không được ngắn hơn 6 kí tự và dài hơn 32 kí tự.";
            }
            else if ($Password != $Repassword){
                $error = "Mật khẩu không khớp.";
            }
            else {

                $result = register($Name, $Birth, $Email, $Username, $Password);

                if($result['code'] == 0){
                    $message = "Đăng ký tài khoản thành công.";
                }
                else{
                    $error = $result['error'];
                }


                // $sql = "select * from nguoidung where UserName = '$UserName'";
                // $query = mysqli_query($conn, $sql);
                // if(mysqli_num_rows($query) == 0) {
                //     $sql = "select * from nguoidung where Email = '$Email'";
                //     $query = mysqli_query($conn, $sql);
                //     if(mysqli_num_rows($query) == 0){

                //         $Password = md5($Password);
                //         $sql = "insert into nguoidung (Name, UserName, Email, Password, Birth, Role) values ('$Name', '$UserName', '$Email', '$Password', '$Birth', 2)";
                //         $query = mysqli_query($conn,$sql); 
                //         if ($query) {
                //             $message = 'Đăng ký thành công!';
                //         }
                //     }
                //     else {
                //         $error = "Email Đã tồn tại.";
                //     }
                // }
                // else {
                //     $error = "Tên tài khoản đã tồn tại."; 
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
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Tạo tài khoản</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="register.php">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputName">Họ và tên</label>
                                                        <input value="<?= $Name ?>" name="Name" class="form-control py-4" id="inputName" type="text" placeholder="Nhập họ và tên" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputUserName">Tên tài khoản</label>
                                                        <input value="<?= $Username ?>" name="Username" class="form-control py-4" id="inputUserName" type="text" placeholder="Nhập tên tài khoản" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                            	<div class="col-md-6">
                                            		<div class="form-group">
		                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
		                                                <input value="<?= $Email ?>" name="Email" class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Nhập email" />
                                            		</div>
                                            	</div>
                                            	<div class="col-md-6">
                                            		<div class="form-group">
													  <label for="inputDate" class="small mb-1">Date</label>
													    <input name="Birth" class="form-control py-4" type="date"  value="2000-01-01" id="inputBirth">
													</div>
                                            	</div>
                                            </div>

                                            
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputPassword">Mật Khẩu</label>
                                                        <input name="Password" class="form-control py-4" id="inputPassword" type="password" placeholder="Nhập mật khẩu" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">Xác nhận Mật khẩu</label>
                                                        <input name="Repassword" class="form-control py-4" id="inputConfirmPassword" type="password" placeholder="nhập lại mật khẩu" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <?php
                                                    if (!empty($error)){
                                                        echo "<div class='alert alert-danger text-center'>$error</div>";
                                                    }
                                                    if (!empty($message) && empty($error)){
                                                        echo "<div class='alert alert-success text-center'>$message</div>";
                                                    }
                                                ?>
                                                <button class="btn btn-primary btn-block" name="Register" type="submit">Tạo</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.php">Đã có tài khoản? Đăng nhập!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>           
        </div>
        
        <script src="main.js"></script>
    </body>
</html>
