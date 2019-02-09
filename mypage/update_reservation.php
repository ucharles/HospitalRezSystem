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
        require_once('../database/db_connect.php');
        $res_id = array();
        $state = array();
        foreach($_REQUEST['change_state'] as $change_state) {
            $data = explode('_', $change_state);
            $res_id[] = $data[0];
            $state[] = $data[1];
            
        } // 짝수번 : res_id, 홀수번 : state
        
        for($i=0; $i<count($res_id); $i++) {
            $query = "update 예약 set 상태='".$state[$i]."' where 예약번호='".$res_id[$i]."';";
            mysql_query($query) or die(mysql_error());
        }
        echo "<script language='JavaScript'>alert('적용완료!'); history.back(); </script>";
    } else {
        echo "<script language='JavaScript'>alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>