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

    <link href="../style.css" rel="stylesheet" >

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
    <?php
    $search = '';
    
    if (isset($_POST['search']) && $_POST['search'] != '') {
        $search = $_POST['search'];

        $s = '%'.$search.'%';

        $conn = open_database();

        $stmt = $conn->prepare("SELECT * from lop Where TenLop like ? or Mon like ? or Phong like ?");

        $stmt->bind_param("sss", $s, $s, $s);

        if (!$stmt->execute()) {
            die("Query error:" . $stmt->error);
        }
    } else {

        $sql = "SELECT * FROM lop";

        $conn = open_database();
        $stmt = $conn->prepare($sql);

        if (!$stmt->execute()) {
            die("Query error:" . $stmt->error);
        }
    }
    ?>


    <div id="layoutSidenav" class="h-auto"">
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
                    <!--<h1 class="mt-4">Quản lý lớp học</h1>-->

                    <div class="card mb-4 mt-3" style="min-height: 600px;">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Danh sách lớp học
                        </div>
                        <div class="row m-2">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <a href="TaoLop.php"><button type="button" class="btn btn-outline-primary"><i class="fas fa-plus mr-2"></i>Tạo lớp học</button> </a>

                            </div>
                            <div class="col-sm-12 col-md-6">
                                <!-- Search form -->
                                <form class="ml-auto" method="post">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="search" value="<?= $search ?>" aria-label="Search" aria-describedby="basic-addon2" />
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row h-100">
                                <?php
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <div class="col-xs-12 col-md-6 col-xl-4 mb-4 ">
                                        <div class="card h-100 h" style="width: 20rem; height:21rem;">
                                        <a href="ChiTietLopHoc.php?id=<?= $row['IdLop']?>">
                                        <img class="card-img-top" style="max-width: 400px; max-height:180px;" src="<?php echo $row['HinhLop'] ?>" alt="Hinh lop">
                                        </a>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $row['TenLop'] ?></h5>
                                                <p class="card-text">Môn: <?php echo $row['Mon'] ?></p>
                                                <p class="card-text">Mã Lớp: <?php echo $row['MaLop'] ?></p>
                                                <span class="d-flex justify-content-around">
                                                    <a href="XemThanhVien.php?id=<?php echo $row['IdLop'] ?>" class="btn btn-primary">Xem thành viên</a>
                                                    <a href="SuaLop.php?id=<?php echo $row['IdLop'] ?>" class="btn btn-primary">Edit</a>
                                                    <a href="XoaLop.php?id=<?php echo $row['IdLop'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có muốn xóa lớp học này?');">Delete</a>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div style="height: 100vh;"></div>
            <div class="card mb-4">
                <div class="card-body">Coppy right TDTU QLLH 51800387-51800759-51800385-51800781</div>
            </div>
                    </div>
            </main>
        </div>
    </div>

    <script src="../main.js"></script>
</body>

</html>