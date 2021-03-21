<?php
session_start();
require '../db.php';
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 1) {
    header('location:../login.php');
}
if (!check_role_GV($_GET['id'], $_SESSION['id'])) {
    header('location:../401.php');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = open_database();

    $stmt = $conn->prepare("delete from lop where IdLop = ?");

    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        //Xóa thành viên
        $sql5 = "DELETE from thanhvien where IdLop = ?";
        $stmt5 = $conn->prepare($sql5);
        $stmt5->bind_param('i', $id);
        if (!$stmt5->execute()) {
            die('sql error: ' . $stmt5->error);
        }
        //Xóa thông báo
        $sql1 = "SELECT * from thongbao where IdLop = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('i', $id);
        if (!$stmt1->execute()) {
            die('error sql: ' . $stmt1->error);
        }
        $result1 = $stmt1->get_result();
        while ($row1 = $result1->fetch_assoc()) {
            $IdThongBao = $row1['IdThongBao'];
            $sql2 = "DELETE FROM thongbao where IdThongBao = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param('i', $IdThongBao);
            if (!$stmt2->execute()) {
                die("Query error:" . $stmt2->error);
            } else {
                //Xóa các file đã được upload trong thông báo
                $sql3 = "SELECT * from fileUpload where IdThongBao=?";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param('i', $IdThongBao);
                if (!$stmt3->execute()) {
                    die('error sql: ' . $stmt3->error);
                }
                $result3 = $stmt3->get_result();
                while ($row3 = $result3->fetch_assoc()) {
                    unlink($row3['Link']);
                }
                //Xóa data trong bảng fileupload của thông báo đó
                $sql4 = "DELETE from fileUpload where IdThongBao= ?";
                $stmt4 = $conn->prepare($sql4);
                $stmt4->bind_param('i', $IdThongBao);
                if (!$stmt4->execute()) {
                    die('error sql:' . $stmt4->error);
                }

                //Xóa bình luận trong thông báo
                $sql5 = "DELETE from binhluan where IdThongBao = ?";
                $stmt5 = $conn->prepare($sql5);
                $stmt5->bind_param('i', $IdThongBao);
                if (!$stmt5->execute()) {
                    die('Error sql' . $stmt5->error);
                }
            }
        }

        //Xóa Assignment
        $sql6 = "DELETE from baitap where IdLop = ?";
        $stmt6 = $conn->prepare($sql6);
        $stmt6->bind_param('i', $id);
        if (!$stmt6->execute()) {
            die('error sql: ' . $stmt6->error);
        }

        header('location:index.php');
    } else {
        die("Query error: " . $stmt->error);
    }
}
