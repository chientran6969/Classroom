<?php
session_start();
require 'db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 2) {
    header('location:login.php');
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

    <link href="style.css" rel="stylesheet">

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
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                </div>
            </li>
        </ul>
    </nav>

    <?php
    $search = '';
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        $s = "%" . $search . "%";
    }
    ?>
    <div id="layoutSidenav" class="h-auto" style="height: 600px;">
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
                    <!--<h1 class="mt-4">Quản lý lớp học</h1>-->

                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Danh sách lớp học
                        </div>
                        <div class="row m-2">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <a href="XinGiaNhap.php"><button type="button" class="btn btn-outline-primary"><i class="fas fa-plus mr-2"></i>Tham gia lớp</button> </a>

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
                                
                                $sql = "SELECT IdLop FROM ThanhVien where IdNguoiDung = ? and agree = ?";
                                $agree = 1;

                                $conn = open_database();
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param('si', $_SESSION['id'], $agree);

                                if (!$stmt->execute()) {
                                    die("Query error:" . $stmt->error);
                                }
                                $result = $stmt->get_result();

                                while ($r = $result->fetch_assoc()) {
                                    $l = $r['IdLop'];

                                    if (isset($search) and !empty($search)) {
                                        $stmt1 = $conn->prepare("select * from lop where IdLop = ? and (TenLop like ? or Mon like ? or Phong like ?)");
                                        $stmt1->bind_param('isss', $l, $s, $s, $s);
                                        if (!$stmt1->execute()) {
                                            die("Query error:" . $stmt->error);
                                        }
                                    } else {

                                        $sql1 = "SELECT * FROM lop where IdLop = ?";
                                        $conn = open_database();
                                        $stmt1 = $conn->prepare($sql1);
                                        $stmt1->bind_param('i', $l);
                                        if (!$stmt1->execute()) {
                                            die("Query error:" . $stmt->error);
                                        }
                                    }
                                    $result1 = $stmt1->get_result();
                                    if ($result1->num_rows > 0) {
                                        $row = $result1->fetch_assoc();
                                        ?>
                                    <div class="col-xs-12 col-md-6 col-xl-4 mb-4 ">
                                        <div class="card h-100 h" style="width: 20rem; height:21rem;">
                                            <a href="ChiTietLopHoc.php?id=<?= $row['IdLop'] ?>"><img class="card-img-top" style="max-width: 400px; max-height: 180px;;" src="<?php echo substr($row['HinhLop'],3) ?>" alt="Hinh lop"></a>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $row['TenLop'] ?></h5>
                                                <p class="card-text"><?php echo $row['Phong'] ?></p>
                                                <span class="d-flex justify-content-around">
                                                    <a href="XemThanhVien.php?id=<?php echo $row['IdLop'] ?>" class="btn btn-primary">Xem thành viên</a>
                                                    <a href="ChiTietLopHoc.php?id=<?php echo $row['IdLop'] ?>" class="btn btn-primary">Chi tiết lớp học</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    }
                                }

                                ?>

                            </div>
                        </div>

                        <div style="height: 100vh;"></div>
                        <div class="card mb-4">
                            <div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div>
                        </div>
                    </div>
            </main>
        </div>
    </div>

    <script src="main.js"></script>
</body>

</html>