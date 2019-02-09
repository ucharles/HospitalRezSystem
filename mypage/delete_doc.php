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
        require_once("../database/db_connect.php");
        $doc_id = $_GET['q'];
        $query = "delete from 의사 where 의사코드='".$doc_id."'";
        function noaction_alert() {
            echo "<script language=\"JavaScript\">alert('예약내역이 존재하여 의사를 삭제할 수 없습니다.'); history.back();</script>";
            exit();
        }
        $result = mysql_query($query) or noaction_alert();
        
        echo "<script language=\"JavaScript\">alert('삭제완료!'); history.back();</script>";
    } else {
        echo "<script language=\"JavaScript\">alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>