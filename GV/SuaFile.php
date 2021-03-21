<?php
session_start();
require '../db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 1) {
    header('location:../login.php');
}
check_role_access_noti($_GET['IdThongBao']);
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
        if(isset($_POST['ThemTaiLieu'])){
            $IdFile = $_POST['IdFile'];
            $IdThongBao = $_POST['IdThongBao'];
            $TenFile = $_FILES["fileUpload"]["name"];
            $taget_files = "../uploads/".$_FILES["fileUpload"]["name"];
            if(!move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $taget_files)){
                $error = "Vui lòng kiểm tra lại file!";
            }
            else{
                $conn = open_database();
                $sql1 = "SELECT * from fileUpload where IdFile =?";
                $smtm1 = $conn->prepare($sql1);
                $smtm1->bind_param('i',$IdFile);
                if(!$smtm1->execute()){
                    die('error sql: '.$smtm1->error);
                }
                $result1 = $smtm1->get_result();
                $row1 = $result1->fetch_assoc();
                unlink($row1['Link']);  //Xóa file cũ trong database

                $sql2 = "UPDATE fileUpload set TenFile=?, Link=? where IdFile=?";
                $smtm2 = $conn->prepare($sql2);
                $smtm2->bind_param('ssi',$TenFile, $taget_files, $IdFile);
                if(!$smtm2->execute()){
                    die('error sql: '.$smtm2->error);
                }
                header('Location: ChiTietThongBao.php?id='.$IdThongBao);
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
                    echo $_SESSION["Username"];
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
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-nomal my-4">Thêm tài liệu</h3>
                                </div>
                                <div class="card-body">
                                    <form action="SuaFile.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input name="IdFile" type="hidden" value="<?php echo $_GET['id'] ?>"/>
                                            <input name="IdThongBao" type="hidden" value="<?php echo $_GET['IdThongBao'] ?>"/>
                                            <label class="small mb-1" for="fileToUpload">File</label>
                                            <input name="fileUpload" class="form-control-file" id="fileToUpload" type="file" required />
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
                                            <button name="ThemTaiLieu" type="submit" class="btn btn-primary m-auto">Thêm tài liệu</button>
                                        </div>
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