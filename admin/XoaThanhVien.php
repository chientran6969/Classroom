<?php
    session_start();
    require '../db.php';
    if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 0) {
        header('location:../login.php');
    }

    if(isset($_GET['IdLop']) && isset($_GET['IdNguoiDung'])){
        $conn = open_database();
        $IdLop = $_GET['IdLop'];
        $IdNguoiDung = $_GET['IdNguoiDung'];
        $sql = "DELETE FROM thanhvien where IdLop=$IdLop AND IdNguoiDung=$IdNguoiDung";
        $conn->query($sql);
        header('Location: XemThanhVien.php?id='.$IdLop);
    }
?>