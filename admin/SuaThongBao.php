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
    if (isset($_GET['id'])) {
        $IdThongBao = $_GET['id'];
        $conn = open_database();
        $sql1 = "SELECT * from thongbao where IdThongBao = ?";
        $smtm1 = $conn->prepare($sql1);
        $smtm1->bind_param('i', $IdThongBao);
        if (!$smtm1->execute()) {
            die('error SQL' . $smtm1->error);
        }

        $result1 = $smtm1->get_result();
        $row1 = $result1->fetch_assoc();
    }
    if (isset($_POST['IdThongBao'])) {
        $IdThongBao = $_POST['IdThongBao'];
        $ChuDe = $_POST['ChuDe'];
        $NoiDung = $_POST['NoiDung'];
        $conn = open_database();
        $sql2 = "UPDATE thongbao set ChuDe = ? ,NoiDung = ? Where IdThongBao= ?";
        $smtm2 = $conn->prepare($sql2);
        $smtm2->bind_param('ssi',$ChuDe, $NoiDung, $IdThongBao);
        if(!$smtm2->execute()){
            die('Error sql: '.$smtm2->error);
        }
        
        header('Location: ChiTietThongBao.php?id='.$IdThongBao);
        
    }
    ?>
    <!-- nav bar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <button class="btn btn-link btn-sm order-0 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-0">
            <li class="text-light mt-2">
                xin ch??o,
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
                            <div class="card shadow-lg border-0 rounded-lg">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-nomal my-4">S???a th??ng b??o</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="SuaThongBao.php" enctype="multipart/form-data">
                                        <input name="IdThongBao" type="hidden" value="<?php echo $IdThongBao ?>" />
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputChuDe">Ch??? ?????</label>
                                            <input value="<?php echo $row1['ChuDe'] ?>" name="ChuDe" class="form-control py-4" id="inputChuDe" type="text" placeholder="Nh???p ch??? ?????" />
                                        </div>

                                        <div class="form-group">
                                            <label class="small mb-1" for="inputNoiDungThongBao">N???i dung</label>
                                            <textarea class="form-control py-4" rows="9" cols="55" name="NoiDung" id="inputNoiDungThongBao"><?php echo $row1['NoiDung'] ?></textarea>
                                            <!--<input name="NoiDung" class="form-control py-4" id="inputNoiDungThongBao" type="text" placeholder="Nh???p n???i dung th??ng b??o" />-->
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
                                            <button type="submit" class="btn btn-primary m-auto">S???a th??ng b??o</button>
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