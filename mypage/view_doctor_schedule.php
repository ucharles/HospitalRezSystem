<?php
    header("Content-Type: text/html; charset=UTF-8");
    session_start();
    if (isset($_SESSION['member_code']) && isset($_SESSION['member_name'])) {
        $member_code = $_SESSION['member_code'];
        $member_name = $_SESSION['member_name'];
    } else if(isset($_SESSION['hospital_code']) && isset($_SESSION['hospital_name'])) {
        $hospital_code = $_SESSION['hospital_code'];
        $hospital_name = $_SESSION['hospital_name'];
    }
    
    if(isset($hospital_code) && isset($hospital_name)) {
        require_once('../database/db_connect.php');
        $doc_id = $_GET['q'];
        $date = $_GET['date'];
        
        $data = array();
        $query = "select * from 진찰일정 where 의사코드='".$doc_id."' and 날짜='".$date."';";
        $result = mysql_query($query) or die (mysql_error());
        $count = mysql_num_rows($result);
        $data['count'] = $count;
        if($count > 0) {
            while($row = mysql_fetch_assoc($result)) {
                $data[] = $row;
            }
            for($i=0; $i<$count; $i++) {
                $pre_time = $data[$i]['시간'];
                $hour = SUBSTR($pre_time, 0, 2);
                $min = SUBSTR($pre_time, 3, 2);
                $a_time = $hour."시 ".$min."분";
                $data[$i]['화면시간'] = $a_time;
                
                if($data[$i]['일정여부'] == 1) {
                    $data[$i]['일정여부'] = "예약됨";
                } else {
                    $data[$i]['일정여부'] = "-";
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo "<script language='JavaScript'> alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>