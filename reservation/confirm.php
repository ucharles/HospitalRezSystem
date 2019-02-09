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
        $date = $_GET['q'];
        $hospital_id = $_GET['hos'];
        $doctor_id = $_GET['doc'];
        
        $data = array();
        
        require_once("../database/db_connect.php");
        
        $query = "select 진찰일정.* from 의사
                inner join 병원 on 의사.병원코드 = 병원.병원코드
                inner join 진찰일정 on 의사.의사코드 = 진찰일정.의사코드
                where 병원.병원코드='".$hospital_id."' and 의사.의사코드='".$doctor_id."' and 진찰일정.날짜='".$date."' and 진찰일정.일정여부='0';";
        $result = mysql_query($query) or die(mysql_error());
        $count = mysql_num_rows($result);
        $data['count'] = $count;
        
        while($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }
        for($i=0; $i<$count; $i++) {
            $pre_time = $data[$i]['시간'];
            $hour = SUBSTR($pre_time, 0, 2);
            $min = SUBSTR($pre_time, 3, 2);
            /*if($min == "00") {
                $a_time = $hour."시";
            } else {*/
                $a_time = $hour."시 ".$min."분";
            //}
            $data[$i]['화면시간'] = $a_time;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo "<script language='JavaScript'>alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>