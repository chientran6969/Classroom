<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function open_database()
{
    $conn = mysqli_connect('localhost', 'root', '', 'qllh');
    if (!$conn) {
        echo 'loi ket noi database';
    }
    $conn->set_charset('utf8');
    return $conn;
}

function login($user, $pass)
{
    $sql = "select * from nguoidung where Username = ?";
    $conn = open_database();

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user);

    if (!$stmt->execute()) {
        die('khong the thuc hien truy van');
    }

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $hashed_password = $data['Password'];
    if (!password_verify($pass, $hashed_password)) {
        return array('code' => 1, 'error' => 'Sai mat khau');
    } else return array('code' => 0, 'data' => $data);
}

function check_email($email)
{
    $sql = "select Email from nguoidung where Email = ?";
    $conn = open_database();

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    if (!$stmt->execute()) {
        die("Query error:" . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return true;
    } else return false;
}

function check_username($username)
{
    $sql = "select Username from nguoidung where Username = ?";
    $conn = open_database();

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    if (!$stmt->execute()) {
        die("Query error:" . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return true;
    } else return false;
}

function register($name, $birth, $email, $username, $pass)
{

    if (check_email($email)) {
        return array('code' => 1, 'error' => 'Email này đã tồi tại.');
    }

    if (check_username($username)) {
        return array('code' => 2, 'error' => 'Tên tài khoản này đã tồi tại.');
    }

    $hash = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "insert into nguoidung(Name, Birth, Email, Username, Password, Role) values (?,?,?,?,?,?)";
    $conn = open_database();

    $stmt = $conn->prepare($sql);
    $role = 2;
    $stmt->bind_param('sssssi', $name, $birth, $email, $username, $hash, $role);

    if (!$stmt->execute()) {
        die("Query error:" . $stmt->error);
    }

    return array('code' => 0, 'error' => 'Thành công');
}

function sendEmailResetPassword($email, $token)
{

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'chientranplus@gmail.com';                     // SMTP username
        $mail->Password   = 'trtnfzdutberkfqc';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('chientranplus@gmail.com', 'Admin QLLH');
        $mail->addAddress($email, 'Người nhận');     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Khôi phục mật khẩu của bạn';
        $mail->Body    = "Click <a href='http://localhost/QLLH/reset_password.php?email=$email&token=$token'>vào đây</a> để khôi phục mật khẩu của bạn";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


function sendEmailAcceptToStudent($IdLop,$TenLop, $IdNguoiDung, $email, $token)
{

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'chientranplus@gmail.com';                     // SMTP username
        $mail->Password   = 'trtnfzdutberkfqc';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('chientranplus@gmail.com', 'Admin QLLH');
        $mail->addAddress($email, 'Người nhận');     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Xác nhận tham gia lớp học';
        $mail->Body    = "Bạn vừa được lời mời tham gia vào lớp $TenLop. Click <a href='http://localhost/QLLH/XacNhan.php?IdLop=$IdLop&IdNguoiDung=$IdNguoiDung&email=$email&token=$token&agree=1'>vào đây</a> để trở thành thành viên chính thức";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendEmailAcceptToTeacher($IdLop, $IdNguoiDung, $TenLop, $EmailSV, $email, $token)
{

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'chientranplus@gmail.com';                     // SMTP username
        $mail->Password   = 'trtnfzdutberkfqc';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('chientranplus@gmail.com', 'Admin QLLH');
        $mail->addAddress($email, 'Người nhận');     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Xác nhận tham gia lớp học';
        $mail->Body    = "$EmailSV vừa yêu cầu được tham gia vào lớp $TenLop Click <a href='http://localhost/QLLH/XacNhan.php?IdLop=$IdLop&IdNguoiDung=$IdNguoiDung&email=$email&token=$token&agree=1'>vào đây</a> để chấp nhận sinh viên đó trở thành thành viên chính thức";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendEmailToNotifyForStudent($email){
    
    $mail = new PHPMailer(true);

    try {
        
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'chientranplus@gmail.com';                     // SMTP username
        $mail->Password   = 'trtnfzdutberkfqc';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('chientranplus@gmail.com', 'Admin QLLH');
        $mail->addAddress($email, 'Người nhận');     // Add a recipient
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Có thông báo mới';
        $mail->Body    = "Lớp học của bạn vừa có thông báo mới. Click <a href='http://localhost/QLLH/login.php'>vào đây</a> để đăng nhập vào tài khoản của bạn";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendEmailNewNotify($IdLop){

    $conn = open_database();

    $sql = "SELECT * from nguoidung where IdNguoiDung = (SELECT IdNguoiDung from thanhvien where IdLop=? and agree = ?) ";
    $agree = 1;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii',$IdLop, $agree);
    if(!$stmt->execute()){
        die('error sql: '.$stmt->error);
    }
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        sendEmailToNotifyForStudent($row['Email']);
    }
}

function createToken($email)
{
    $token = uniqid(md5(time()));


    $conn = open_database();

    $stmt = $conn->prepare('update nguoidung set Token = ? where Email = ?');
    $stmt->bind_param('ss', $token, $email);
    if (!$stmt->execute()) {
        return array('code' => 1, 'error' => 'khong thuc thi duoc truy van');
    } else return array('code' => 0, 'token' => $token);
}

function check_token($email, $token)
{
    $sql = "select * from nguoidung where Email = ? and Token = ?";
    $conn = open_database();

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $token);
    if (!$stmt->execute()) {
        die("Query error:" . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return true;
    } else return false;
}

function check_role_GV($idLop, $idGV)
{
    $conn = open_database();

    $stmt = $conn->prepare("select * from lop where IdLop = ? and IdGV = ?");
    $stmt->bind_param('ii', $idLop, $idGV);

    if (!$stmt->execute()) {
        die('Querry error: ' . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows != 1) {
        return false;
    } else return true;
}

function check_access_class_of_student($IdLop, $IdSV){
    $conn =open_database();
    $agree =1;
    $sql = "SELECT * FROM thanhvien where IdLop = ? and IdNguoiDung = ? and agree =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii',$IdLop, $IdSV,$agree);
    if(!$stmt->execute()){
        die('error sql:' .$stmt->error);
    }
    $result = $stmt->get_result();
    
    if(mysqli_num_rows($result) !=1){
        header('Location: 404.php');
    }else
    {return true;}
    $result->close();
    $conn->close();
}

function check_access_noti_of_student($IdThongBao, $IdNguoiDung){
    $conn = open_database();
    $sql = "SELECT * FROM thanhvien where IdLop=( SELECT IdLop FROM thongbao where IdThongBao = ?) and IdNguoiDung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii',$IdThongBao,$IdNguoiDung);
    if(!$stmt->execute()){
        die('error sql: '.$stmt->error);
    }
    $result = $stmt->get_result();
    if($result->num_rows !=1){
        header('Location: 404.php');
    }
    $result->close();
    $conn->close();

}

function check_access_assignment_of_student($IdBT, $IdNguoiDung){
    $conn = open_database();
    $sql = "SELECT * from thanhvien where IdLop = (SELECT IdLop from baitap where IdBaiTap = ?) and IdNguoiDung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii',$IdBT, $IdNguoiDung);
    if(!$stmt->execute()){
        die('sql error:'.$stmt->error);
    }
    $result = $stmt->get_result();
    if($result->num_rows !=1){
        header('Location: 404.php');
    }
}

function check_role_access_noti($id)
{
    $conn = open_database();

    $s = $conn->prepare("select * from thongbao where IdThongBao = ?");
    $s->bind_param('i', $id);
    if (!$s->execute()) {
        die('SQL error: ' . $s->error);
    }
    $result = $s->get_result();

    if ($result->num_rows == 0) {
        header('location:../404.php');
    } else {
        $r = $result->fetch_assoc();
        if (!check_role_GV($r['IdLop'], $_SESSION['id'])) {
            header('location:../401.php');
        }
    }

    return null;
}
function check_role_access_assi($id)
{
    $conn = open_database();

    $s = $conn->prepare("select * from baitap where IdBaiTap = ?");
    $s->bind_param('i', $id);
    if (!$s->execute()) {
        die('SQL error: ' . $s->error);
    }
    $result = $s->get_result();

    if ($result->num_rows == 0) {
        header('location:../404.php');
    } else {
        $r = $result->fetch_assoc();
        if (!check_role_GV($r['IdLop'], $_SESSION['id'])) {
            header('location:../401.php');
        }
    }

    return null;
}
function check_ClassCode($code)
{

    $conn = open_database();

    $stmt = $conn->prepare("select * from lop where MaLop = ?");
    $stmt->bind_param('i', $code);
    if (!$stmt->execute()) {
        die("Querry error: " . $stmt->error);
    }

    $row = $stmt->get_result()->num_rows;

    if ($row == 0) {
        return false;
    }

    return true;
}
