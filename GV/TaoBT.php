<?php
session_start();
require '../db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 1) {
    header('location:../login.php');
}
if(!check_role_GV($_GET['id'], $_SESSION['id'])){
    header('location:../401.php');
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
        if(isset($_POST['ThemAssignment'])){
            $conn = open_database();
            $TenBT = $_POST['TenBT'];
            $NoiDung = $_POST['NoiDung'];
            $Link = $_POST['Link'];
            $Due = $_POST['Due'];
            $IdLop = $_GET['id'];
            $sql1 = "INSERT into baitap(TenBT, NoiDung,Link, Due, IdLop) values(?,?,?,?,?)";
            $smtm1 = $conn->prepare($sql1);
            $smtm1->bind_param('ssssi',$TenBT,$NoiDung,$Link,$Due,$IdLop);
            if(!$smtm1->execute()){
                die('error sql '.$smtm1->error);
            }
            header('Location: ChiTietLopHoc.php?id='.$IdLop);

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
                                    <h3 class="text-center font-weight-nomal my-4">Tạo Assignment</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="TaoBT.php?id=<?php echo $_GET['id'] ?>"  enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputAssignmentName">Tên bài tập</label>
                                            <input name="TenBT"  class="form-control py-4" id="inputAssignmentName" type="text" placeholder="Nhập Tên" />
                                        </div> 
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputNoiDung">Yêu cầu</label>
                                            <textarea name="NoiDung"  class="form-control py-4" id="inputNoiDung" type="text" placeholder="Nhập yêu cầu"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputLink">Link nộp</label>
                                            <input name="Link"  class="form-control py-4" id="inputLink" type="text" placeholder="Nhập link nộp" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputDue">Due</label>
                                            <input name="Due"  class="form-control py-4" id="inputDue" type="date" placeholder="Nhập deadline" />
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
                                            <button name="ThemAssignment" type="submit" class="btn btn-primary m-auto">Thêm</button>
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