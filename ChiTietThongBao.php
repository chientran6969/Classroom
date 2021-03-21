<?php
session_start();
require 'db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 2) {
    header('location:login.php');
}
check_access_noti_of_student($_GET['id'],$_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link href="style.css" rel="stylesheet" />

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
        $conn = open_database();
        $IdThongBao = $_GET['id'];
        $sql1 = "SELECT * from thongbao where IdThongBao = ?";
        $smtm1 = $conn->prepare($sql1);
        $smtm1->bind_param('i', $IdThongBao);
        if (!$smtm1->execute()) {
            die('SQL error: ' . $smtm1->error);
        } else {
            $result1 = $smtm1->get_result();
            $row1 = $result1->fetch_assoc();
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
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                </div>
            </li>
        </ul>
    </nav>
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
                    <div class="card mb-4 mt-3">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            <?php echo $row1['ChuDe'] ?>
                        </div>
                        <div class="row m-1 mt-3">
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Tin Tức</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Bài Tập</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Bình Luận</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <br>
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                        <?php echo $row1['NoiDung'] ?>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>File Name</th>
                                                    <th>View</th>

                                                    <th>Download</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql2 = "SELECT * from fileUpload where IdThongBao=?";
                                                $smtm2 = $conn->prepare($sql2);
                                                $smtm2->bind_param('i', $IdThongBao);
                                                if (!$smtm2->execute()) {
                                                    die('error sql' . $smtm2->error);
                                                }
                                                $result2 = $smtm2->get_result();
                                                $i = 1;
                                                while ($row2 = $result2->fetch_assoc()) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i ?></td>
                                                        <td><?php echo $row2['TenFile'] ?></td>
                                                        <td><a href="<?= 'uploads/' . $row2['TenFile'] ?>" target="_blank">View</a></td>
                                                        <td><a href="<?= 'uploads/' . $row2['TenFile'] ?>" download>Download</a></td>
                                                    </tr>
                                                <?php
                                                    $i = $i + 1;
                                                }
                                                ?>

                                            </tbody>
                                        </table>


                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <a href="TaoBinhLuan.php?id=<?php echo $IdThongBao ?>&IdNguoiDung=<?php echo $_SESSION['id'] ?>"><button type="button" class="btn btn-primary">Viết bình luận</button> </a>
                                        <?php
                                        $sql3 = "SELECT * from binhluan where IdThongBao = ?";
                                        $smtm3 = $conn->prepare($sql3);
                                        $smtm3->bind_param('i', $IdThongBao);
                                        if (!$smtm3->execute()) {
                                            die('error sql: ' . $smtm3->error);
                                        }
                                        $result3 = $smtm3->get_result();
                                        while ($row3 = $result3->fetch_assoc()) {
                                            $IdNguoiDung = $row3['IdNguoiDung'];
                                            $sql4 = "SELECT * from nguoidung where IdNguoiDung =?";
                                            $smtm4 = $conn->prepare($sql4);
                                            $smtm4->bind_param('i', $IdNguoiDung);
                                            if (!$smtm4->execute()) {
                                                die('error sql: ' . $smtm4->error);
                                            }
                                            $result4 = $smtm4->get_result();
                                            $row4 = $result4->fetch_assoc();
                                            $User = $row4['Username'];
                                        ?>
                                            <div class="card bg-light text-dark">
                                                <div class="card-body tv">
                                                    <h5 class="card-titile"><?php echo $User ?></h5>
                                                    <p class="card-text"><?php echo $row3['NoiDung'] ?></p>

                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 100vh;"></div>
                    <div class="card mb-4">
                        <div class="card-body">Coppy right TDTU QLLH 51800387-51800759-51800385-51800781</div>
                    </div>
                </div>
        </div>
        </main>
    </div>
    </div>

    <script src="main.js"></script>
</body>

</html>