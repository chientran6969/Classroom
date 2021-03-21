<?php
session_start();
require '../db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 0) {
    header('location:../login.php');
}

if (isset($_GET['id']) && isset($_GET['IdThongBao'])) {
    $conn = open_database();
    $IdFile = $_GET['id'];
    $IdThongBao = $_GET['IdThongBao'];
    $sql1 = "SELECT * from fileUpload where IdFile =?";
    $smtm1 = $conn->prepare($sql1);
    $smtm1->bind_param('i', $IdFile);
    if (!$smtm1->execute()) {
        die('error sql: ' . $smtm1->error);
    }
    $result1 = $smtm1->get_result();
    $row1 = $result1->fetch_assoc();
    unlink($row1['Link']);  //Xóa file cũ trong database

    $sql2 = "DELETE from fileUpload where IdFile = ?";
    $smtm2 = $conn->prepare($sql2);
    $smtm2->bind_param('i',$IdFile);
    if(!$smtm2->execute()){
        die("error sql: ".$smtm2->error);
    }
    header('Location: ChiTietThongBao.php?id='.$IdThongBao);
}
