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
    if(isset($hospital_code) && isset($hospital_name)) {
        $res_id = $_REQUEST['res_id'];
        $docnote = $_REQUEST['docnote'];
        
        require_once('../database/db_connect.php');
        
        $query = "update 예약 set 진찰기록='".$docnote."' where 예약번호='".$res_id."';";
        mysql_query($query) or die(mysql_error());
        
        echo "<script language='JavaScript'> alert('적용 완료!'); opener.location.reload(); window.close();</script>";
    } else {
        echo "<script language='JavaScript'> alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>