<?php
session_start();
require '../db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 0) {
    header('location:../login.php');
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

    <link href="../style.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
        if(isset($_POST['email'])){
            $IdLop = $_GET['id'];
            $email = $_POST['email'];
            if(check_email($email)){ //kiểm tra email có tồn tại trong DB kh
                $sql1 = "SELECT * from nguoidung where Email = ?";
                $conn = open_database();
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param('s',$email);
                if(!$stmt1->execute()){
                    die("Query error:" . $stmt1->error);
                }
                $result1 = $stmt1->get_result();
                $row1 = $result1->fetch_assoc();
                $IdNguoiDung = $row1['IdNguoiDung'];  //Lấy id của người dùng có email được nhập

                $sql = "SELECT * from thanhvien where IdLop = ? and IdNguoiDung=?";  //Xét email có đang là học viên của lớp đó kh
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $IdLop, $IdNguoiDung);
                if (!$stmt->execute()) {
                    die("Query error:" . $stmt->error);
                }

                $result = $stmt->get_result();
                if($result->num_rows > 0){
                    $error = "Học viên này đã là thành viên";
                }
                else {
                    if(isset($_GET['agree'])){
                        $sql3 = "UPDATE thanhvien SET agree =? where IdLop=? and IdNguoiDung = ?";
                        $stmt3 = $conn->prepare($sql3);
                        $stmt3->bind_param('iii',1,$IdLop,$IdNguoiDung);
                        if(!$stmt2->execute()){
                            die("Query error:" . $stmt->error);
                        }
                        else{
                            header("Location: index.php");
                        }
                    }
                    else{
                        $sql2 = "INSERT INTO thanhvien(IdLop, IdNguoiDung, agree) VALUES (?, ?, ?)";
                        $stmt2 = $conn->prepare($sql2);
                        $agree=0;
                        $stmt2->bind_param('iii',$IdLop,$IdNguoiDung,$agree);
                        if(!$stmt2->execute()){
                            die("Query error:" . $stmt->error);
                        }
                        else{
                            $t = createToken($email);
                            sendEmailAcceptToStudent($IdLop,$IdNguoiDung,$email,$t['token']);//Sửa địa chỉ của localhost trong hàm này lại (đang là localhost:8080 chỉ chạy được trên máy t)
                            $success = "Đã gửi lời mời cho học viên";
                        }
                    }
                }
            }
            else {
                $error = "Email này không hợp lệ";
            }
        }
    ?>
    <!-- nav bar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <button class="btn btn-link btn-sm order-0 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-0">
            <li class="text-light mt-2">
                xin chào,
                <span class="font-weight-bold">
                    <?php
                    echo $_SESSION["Name"];
                    ?>
                </span>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <!-- <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Activity Log</a>
                    <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav" class="h-auto">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="PhanQuyen.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-edit"></i></div>
                            Phân quyền
                        </a>
                        
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-nomal my-4">Thêm thành viên</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="ThemThanhVien.php?id=<?php echo $_GET['id'] ?>"  enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmail">Email</label>
                                            <input name="email"  class="form-control py-4" id="inputEmail" type="text" placeholder="Nhập Email" />
                                        </div>    
                                        <div class="form-group">
                                            <?php
                                            if (!empty($error)) {
                                                echo "<div class='alert alert-danger text-center'>$error</div>";
                                            }
                                            if (!empty($success) && empty($error)) {
                                                echo "<div class='alert alert-success text-center'>$success</div>";
                                            }
                                            ?>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button name="ThemThanhVien" type="submit" class="btn btn-primary m-auto">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../main.js"></script>
</body>

</html>