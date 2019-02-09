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
        require_once("../database/db_connect.php");
        $query = "delete from 환자 where 회원코드='".$member_code."'";
    } else {
        echo "<script language=\"JavaScript\">alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>
<script>
    var result = confirm('정말 탈퇴하시겠습니까?');
    if (result) {
        <?mysql_query($query) or die(mysql_error());?>
        alert('탈퇴 완료 되었습니다.');
        self.location.replace('../index.php');
        <?session_destroy();?>
    } else {
        
    }
</script>