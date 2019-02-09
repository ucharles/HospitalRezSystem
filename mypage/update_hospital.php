<?php
    session_start();
    header("Content-Type: text/html; charset=UTF-8");
    if (isset($_SESSION['member_code']) && isset($_SESSION['member_name'])) {
        $member_code = $_SESSION['member_code'];
        $member_name = $_SESSION['member_name'];
    } else if(isset($_SESSION['hospital_code']) && isset($_SESSION['hospital_name'])) {
        $hospital_code = $_SESSION['hospital_code'];
        $hospital_name = $_SESSION['hospital_name'];
    }

    $pwd = $_REQUEST['pwd'];
    $name = $_REQUEST['name'];;
    $zip1 = $_REQUEST['zip1'];
    $zip2 = $_REQUEST['zip2'];
    $add = $_REQUEST['address'];
    $add2 = $_REQUEST['add2'];
    $phone = $_REQUEST['phone'];
    $email = $_REQUEST['email'];
    $info = $_REQUEST['info'];

    if(isset($hospital_code)) {
        require_once('../database/db_connect.php');
        
        $sql = "UPDATE 병원 SET " .
                "병원pwdmd5 = '" . md5($pwd) . "', " .
                "병원이름 = '" . $name . "', " .
                "병원우편번호= '" . $zip1 . $zip2 . "', " .
                "병원주소= '" . $add . "', " .
                "병원상세주소= '" . $add2 . "', " .
                "병원전화번호= '" . $phone . "', " .
                "병원이메일= '" . $email . "', " .
                "병원정보 = '" . $info . "'" .
                "where 병원코드= '" . $hospital_code . "';";
            
        $result = mysql_query($sql) or die(mysql_error());
    
        echo "<script language='JavaScript'>alert('수정완료!'); self.location.replace('mypage_index.php') </script>";
    } else {
        echo "<script language='JavaScript'>alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>