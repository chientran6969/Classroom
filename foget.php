<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Quên mật khẩu</title>
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
        require 'db.php';
        
        $error = '';
        $message = '';
        $Email = '';

        if(isset($_POST['Email'])){
            $Email = $_POST['Email'];

            if ($Email == ''){
                $error = "Vui lòng nhập email.";
            }
            else {

                if(!check_email($Email)){
                    $error = 'Email này không tồn tại.';
                }
                else {
                    $result = createToken($Email);

                    if ($result['code'] == 0){
                        if(sendEmailResetPassword($Email, $result['token'])){
                            $message = 'Link tạo lại mật khẩu đã gửi đến email của bạn';
                        }
                        else {
                            $error = 'Đã có lỗi xảy ra.';
                        }
                    }
                    else {
                        $error = 'Đã có lỗi xảy ra.';
                    }
                }

                
                
               
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Quên Mật khẩu</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Nhập email và chúng tôi sẽ gửi cho bạn đường link để lấy lại mật khẩu.</div>
                                        <form method="post" id="recover-pass">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input name="Email" class="form-control py-4" id="inputEmailAddress" value="<?= $Email ?>" type="email" aria-describedby="emailHelp" placeholder="Nhập email" />
                                            </div>
                                            <div class="form-group" id='error-recover-pass'>
                                                <?php
                                                    if(!empty($error)){
                                                        echo "<div class='alert alert-danger text-center'>$error</div>";
                                                    }
                                                    if(!empty($message) && empty($error)){
                                                        echo "<div class='alert alert-success text-center'>$message</div>";
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="login.php">Trở lại đăng nhập</a>
                                                <button class="btn btn-primary" type="submit">Xác nhận</button>
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
        </div>
        <script src="main.js"></script>
    </body>
</html>
