<?php
    session_start();
    require '../db.php';
    if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 0) {
        header('location:../login.php');
    }
    
    if(isset($_GET['id'])){
        $IdThongBao = $_GET['id'];
        $conn = open_database();
        $sql1 = "DELETE FROM thongbao where IdThongBao = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('i',$IdThongBao);
        if(!$stmt1->execute()){
            die("Query error:" . $stmt1->error);
        }
        else{
            //Xóa các file đã được upload trong thông báo
            $sql2 = "SELECT * from fileUpload where IdThongBao=?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param('i',$IdThongBao);
            if(!$stmt2->execute()){
                die('error sql: '.$stmt1->error);
            }
            $result2 = $stmt2->get_result();
            while($row2 = $result2->fetch_assoc()){
                unlink($row2['Link']);
            }
            //Xóa data trong bảng fileupload của thông báo đó
            $sql3 = "DELETE from fileUpload where IdThongBao= ?";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param('i',$IdThongBao);
            if(!$stmt3->execute()){
                die('error sql:'.$stmt3->error);
            }

            //Xóa bình luận trong thông báo
            $sql4 = "DELETE from binhluan where IdThongBao = ?";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param('i',$IdThongBao);
            if(!$stmt4->execute()){
                die('Error sql'.$stmt4->error);
            }
        
            header('Location: ChiTietLopHoc.php?id='.$_GET['IdLop']);
        }
    }
?>