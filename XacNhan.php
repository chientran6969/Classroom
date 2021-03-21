<?php
    require 'db.php';
    if(isset($_GET['email']) && isset($_GET['token']) && isset($_GET['agree'])){
        $email= $_GET['email'];
        $token= $_GET['token'];
        $IdNguoiDung = $_GET['IdNguoiDung'];
        $IdLop = $_GET['IdLop'];
        if(check_token($email,$token)){
            $agree=1;
            $conn = open_database();
            $sql3 = "UPDATE thanhvien SET agree =? where IdLop=? and IdNguoiDung = ?";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param('iii',$agree,$IdLop,$IdNguoiDung);
            if(!$stmt3->execute()){
                die("Query error:" . $stmt3->error);
            }
            else{
            
               $stmt4 = $conn->prepare("update nguoidung set Token = ? where Email = ?");
               $token = '';
            
               $stmt4->bind_param('ss', $token, $email);
               if(!$stmt4->execute()){
                die("Query error:" . $stmt3->error);
                }

                header('Location: success.php');
            }
        }
    }
?>