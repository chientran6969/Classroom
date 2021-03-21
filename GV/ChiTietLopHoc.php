<?php
session_start();
require '../db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 1) {
    header('location:../login.php');
}
if(!check_role_GV($_GET['id'],$_SESSION['id'])){
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


                    <div class="card mb-4" style="min-height: 600px;">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Danh sách thông báo
                        </div>
                        <div class="row m-1 mt-3">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <a href="ThemThongBao.php?id=<?php echo $_GET['id'] ?>"><button type="button" class="btn btn-outline-primary"><i class="fas fa-plus mr-2"></i>Add News</button> </a>
                                <a href="TaoBT.php?id=<?php echo $_GET['id'] ?>"><button type="button" class="btn btn-outline-primary"><i class="fas fa-plus mr-2"></i>Add Assignment</button> </a>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <!-- Search form -->
                                <form class="ml-auto" method="post">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="search" aria-label="Search" aria-describedby="basic-addon2" />
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="list-bt">
                            <?php
                                if (isset($_GET['id'])) {
                                    $IdLop = $_GET['id'];
                                    $conn = open_database();
                                    $sql2 = "SELECT * from baitap where IdLop = ?";
                                    $stmt2 = $conn->prepare($sql2);
                                    $stmt2->bind_param('i', $IdLop);
                                    if (!$stmt2->execute()) {
                                        die("Query error:" . $stmt2->error);
                                    } else {
                                        $result2 = $stmt2->get_result();
                                        $date1 =strtotime(date('Y-m-d'));
                                        while ($row2 = $result2->fetch_assoc()) {
                                            $date2 = strtotime($row2['Due']);
                                            if($date1-$date2<=0){

                                            
                                ?>
                                            <div class="card bg-light text-dark mb-1">
                                                <div class="card-body tv">
                                                    <i class='fas fa-book-open'></i>
                                                    <a type="submit" href="ChiTietAssignment.php?id=<?php echo $row2['IdBaiTap'] ?>"><?php echo $row2['TenBT'] ?></a>      
                                                    <p>Due: <?php echo $row2['Due'] ?></p>                                               
                                                </div>

                                            </div>
                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="list-tb">
                                <?php
                                if (isset($_GET['id'])) {
                                    $IdLop = $_GET['id'];
                                    
                                    $sql1 = "SELECT * from thongbao where IdLop = ?";
                                    $stmt1 = $conn->prepare($sql1);
                                    $stmt1->bind_param('i', $IdLop);
                                    if (!$stmt1->execute()) {
                                        die("Query error:" . $stmt1->error);
                                    } else {
                                        $result1 = $stmt1->get_result();
                                        while ($row1 = $result1->fetch_assoc()) {
                                ?>
                                            <div class="card bg-light text-dark mb-1">
                                                <div class="card-body tv">
                                                    <i class='fas fa-clipboard'></i>
                                                    <a type="submit" href="ChiTietThongBao.php?id=<?php echo $row1['IdThongBao'] ?>"><?php echo $row1['ChuDe'] ?></a>                                                 
                                                    <a onclick="return confirm('Bạn có muốn xóa thông báo này?');" href="XoaThongBao.php?id=<?php echo $row1['IdThongBao'] ?>&IdLop=<?php echo $IdLop ?>" type="submit" class="btn btn-danger" id="deleteTV">Xóa</a>
                                                    
                                                </div>

                                            </div>
                                <?php
                                        }
                                    }
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