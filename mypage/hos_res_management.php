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
        $doc_id = $_GET['q'];
        $date = $_GET['date'];
        $state = $_GET['state'];
        
        $data = array();
        
        if($doc_id=="-") {
            if($date=="-") {
                if($state=="-") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and (예약날짜 between CURDATE() - INTERVAL 30 DAY and CURDATE() + INTERVAL 10 DAY) and not 상태='2';";
                } else if($state=="1") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and (예약날짜 between CURDATE() - INTERVAL 30 DAY and CURDATE() + INTERVAL 10 DAY) and 상태='1';";
                } else if($state=="3") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and (예약날짜 between CURDATE() - INTERVAL 30 DAY and CURDATE() + INTERVAL 10 DAY) and 상태='3';";
                } else if($state=="4") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and (예약날짜 between CURDATE() - INTERVAL 30 DAY and CURDATE() + INTERVAL 10 DAY) and 상태='4';";
                }
            } else {
                if($state=="-") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 예약날짜='".$date."' and not 상태='2';";
                } else if($state=="1") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 예약날짜='".$date."' and 상태='1';";
                } else if($state=="3") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 예약날짜='".$date."' and 상태='3';";
                } else if($state=="4") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 예약날짜='".$date."' and 상태='4';";
                }
            }
        } else {
            if($date=="-") {
                if($state=="-") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 의사코드='".$doc_id."' and (예약날짜 between CURDATE() - INTERVAL 30 DAY and CURDATE() + INTERVAL 10 DAY) and not 상태='2';";
                } else if($state=="1") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 의사코드='".$doc_id."' and (예약날짜 between CURDATE() - INTERVAL 30 DAY and CURDATE() + INTERVAL 10 DAY) and 상태='1';";
                } else if($state=="3") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 의사코드='".$doc_id."' and (예약날짜 between CURDATE() - INTERVAL 30 DAY and CURDATE() + INTERVAL 10 DAY) and 상태='3';";
                } else if($state=="4") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 의사코드='".$doc_id."' and (예약날짜 between CURDATE() - INTERVAL 30 DAY and CURDATE() + INTERVAL 10 DAY) and 상태='4';";
                }
            } else {
                if($state=="-") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 의사코드='".$doc_id."' and 예약날짜='".$date."' and not 상태='2';";
                } else if($state=="1") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 의사코드='".$doc_id."' and 예약날짜='".$date."' and 상태='1';";
                } else if($state=="3") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 의사코드='".$doc_id."' and 예약날짜='".$date."' and 상태='3';";
                } else if($state=="4") {
                    $query = "select * from 예약 where 병원코드='".$hospital_code."' and 의사코드='".$doc_id."' and 예약날짜='".$date."' and 상태='4';";
                }
            }
        }
        
        $result = mysql_query($query) or die(mysql_error());
        $count = mysql_num_rows($result);
        $data['count'] = $count;
        while($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        for($i=0; $i<$count; $i++) {
            $data[$i]['화면시간'] = SUBSTR($data[$i]['예약시간'], 0,2) ."시 ". SUBSTR($data[$i]['예약시간'], 3,2) ."분";
            $state = $data[$i]['상태'];
            if($state==1) {
                $data[$i]['화면상태'] = "예약완료";
            } else if($state==3) {
                $data[$i]['화면상태'] = "진료완료";
            } else if($state==4) {
                $data[$i]['화면상태'] = "예약불이행";
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        
    } else {
        echo "<script language='JavaScript'> alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>