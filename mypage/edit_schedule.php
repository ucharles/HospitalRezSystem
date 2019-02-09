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
        
        $doc_id = $_REQUEST['doctor'];
        $schedule_date = $_REQUEST['schedule_date'];
        $view_or_update = $_REQUEST['select_schedule'];
        if($view_or_update == 'view') {
            $delete_array = array();
            foreach($_REQUEST['delete_schedule'] as $delete_schedule) {
                $delete_array[] = $delete_schedule;
                // 일정순서
            }
            if(count($delete_array)==0) {
                echo "<script language=\"JavaScript\"> alert('변경된 내용이 없습니다.'); history.back();</script>";
            } else {
                for($i=0; $i<count($delete_array); $i++) {
                    $query = "delete from 진찰일정 where 일정순서='".$delete_array[$i]."';";
                    mysql_query($query) or die(mysql_error());
                }
            }
            echo "<script language=\"JavaScript\"> alert('".$schedule_date." 삭제 완료! 변경된 내용을 꼭 확인해주세요.'); history.back();</script>";
        } else {
            $insert_array = array();
            foreach($_REQUEST['insert_schedule'] as $insert_schedule) {
                $insert_array[] = $insert_schedule;
            }
            if(count($insert_array)==0) {
                echo "<script language=\"JavaScript\"> alert('변경된 내용이 없습니다.'); history.back();</script>";
            } else {
                for($i=0; $i<count($insert_array); $i++) {
                    $query = "insert into 진찰일정 values(DEFAULT,'".$doc_id."','".$schedule_date."','".$insert_array[$i]."','0');";
                    mysql_query($query) or die(mysql_error());
                }
                echo "<script language=\"JavaScript\"> alert('".$schedule_date." 삽입 완료! 변경된 내용을 꼭 확인해주세요.'); history.back();</script>";
            }
        }
    } else {
        echo "<script language=\"JavaScript\"> alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>