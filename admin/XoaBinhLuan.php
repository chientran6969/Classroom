<?php
session_start();
require '../db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 0) {
    header('location:../login.php');
}

if(isset($_GET['id']) && isset($_GET['IdThongBao'])){
    $IdThongBao = $_GET['IdThongBao'];
    $IdBinhLuan = $_GET['id'];
    $conn = open_database();
    $sql1 = "DELETE FROM binhluan where IdBinhLuan = ?";
    $smtm1 = $conn->prepare($sql1);
    $smtm1->bind_param('i',$IdBinhLuan);
    if(!$smtm1->execute()){
        die('Error sql: '.$smtm1->error);
    }
    header('Location: ChiTietThongBao.php?id='.$IdThongBao);
}

?>