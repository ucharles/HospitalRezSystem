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
        $doc_data = array();
        $query = "select 의사.*, 과목.과목이름 from 의사 inner join 과목 on 과목.과목코드 = 의사.과목코드 where 의사.병원코드='".$hospital_code."';";
        $result = mysql_query($query) or die(mysql_error());
        $doc_count = mysql_num_rows($result);
        if($doc_count > 0) {
            while($row = mysql_fetch_assoc($result)) {
                $doc_data[] = $row;
            }
        }
    } else {
        echo "<script language='JavaScript'> alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>