<?php
session_start();
require '../db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 1) {
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
    $tenlop = '';
    $phong = '';
    $mon = '';
    $error = '';
    $success = '';



    if (isset($_POST['TaoLop'])) {

        $tenlop = $_POST['tenlop'];
        $phong = $_POST['phong'];
        $mon = $_POST['mon'];
        $GV = $_SESSION['id'];
        $code = rand(1000, 99999);
        $target_file = "../uploads/" . $_FILES["fileAnh"]["name"];
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($tenlop == '' || $phong == '' || $mon == '') {
            $error = 'Vui lòng nhập đầy đủ thông tin';
        } else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ){
            $error = 'File bạn tải lên không phải file ảnh';
        } else if (!move_uploaded_file($_FILES["fileAnh"]["tmp_name"], $target_file)) {
            $error = 'Vui lòng kiểm tra lại ảnh';
        }
        else {

            while(check_ClassCode($code)){
                $code = rand(1000, 99999);
            }

            $conn = open_database();

            $stmt = $conn->prepare("INSERT INTO lop( TenLop, Phong, Mon, HinhLop, MaLop, IdGV ) VALUES (?, ?, ?, ?,?,?)");

            $stmt->bind_param('sssssi', $tenlop, $phong, $mon, $target_file, $code, $GV);
            if (!$stmt->execute()) {
                die("Query error:" . $stmt->error);
            } else {
                header('location:index.php');
            }
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
                        
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <div class="card shadow-lg border-0 rounded-lg">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-nomal my-4">Tạo lớp học</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="TaoLop.php" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputClassName">Tên lớp</label>
                                            <input name="tenlop" value="<?= $tenlop ?>" class="form-control py-4" id="inputClassName" type="text" placeholder="Nhập tên lớp" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputClassRoom">Phòng</label>
                                            <input name="phong" value="<?= $phong ?>" class="form-control py-4" id="inputClassRoom" type="text" placeholder="Nhập phòng" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputClassProject">Môn</label>
                                            <input name="mon" value="<?= $mon ?>" class="form-control py-4" id="inputClassProject" type="text" placeholder="Nhập môn học" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="fileToUpload">Ảnh</label>
                                            <input name="fileAnh" class="form-control-file" id="fileToUpload" type="file" required />
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
                                            <button name="TaoLop" type="submit" class="btn btn-primary m-auto">Lưu</button>
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