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
    
    if(isset($member_code) && isset($member_name)) {
        $res_num = $_GET['q'];
        require_once('../database/db_connect.php');
        
        $query = "select 진찰기록 from 예약 where 예약번호='".$res_num."';";
        $result = mysql_query($query) or die(mysql_error());
        
        $data = mysql_fetch_assoc($result) or die(mysql_error());
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo "<script language=\"JavaScript\"> alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
    
?>