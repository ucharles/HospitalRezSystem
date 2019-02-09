<?php
    require_once("../database/db_connect.php");

    $subject = $_GET['subject'];
    $sido = $_GET['sido'];
    $gugun = $_GET['gugun'];
    $hospital_name = $_GET['hospital_name'];
    
    $hos_data = array();
    $sub_data = array();        
    
    if(isset($hospital_name) == false || ctype_space($hospital_name) == true) {
        if($subject == "-") {
            if($gugun == "-") {
                $hos_query = "select * from 병원 where 병원주소 like '%".$sido."%';";
                        
                $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                inner join 병원 on 의사.병원코드 = 병원.병원코드
                inner join 과목 on 의사.과목코드 = 과목.과목코드
                where 병원.병원주소 like '%".$sido."%';";
            } else {
                $hos_query = "select 병원.* from 의사
                inner join 병원 on 의사.병원코드 = 병원.병원코드
                inner join 과목 on 의사.과목코드 = 과목.과목코드
                where 병원.병원주소 like '%".$sido." ".$gugun."%'
                group by 병원.병원코드;";
                        
                $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                inner join 병원 on 의사.병원코드 = 병원.병원코드
                inner join 과목 on 의사.과목코드 = 과목.과목코드
                where 병원.병원주소 like '%".$sido." ".$gugun."%';";
            }
        } else {
            if($sido == "-" && $gugun == "-") {
                $hos_query = "select 병원.* from 의사
                    inner join 병원 on 의사.병원코드 = 병원.병원코드
                    inner join 과목 on 의사.과목코드 = 과목.과목코드
                    where 과목.과목이름 = '".$subject."' group by 병원.병원코드;";
                        
                    $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                    inner join 병원 on 의사.병원코드 = 병원.병원코드
                    inner join 과목 on 의사.과목코드 = 과목.과목코드
                    where 과목.과목이름 = '".$subject."';";
            } else if($gugun == "-"){
                $hos_query = "select 병원.* from 의사
                            inner join 병원 on 의사.병원코드 = 병원.병원코드
                            inner join 과목 on 의사.과목코드 = 과목.과목코드
                            where 과목.과목이름 = '".$subject."' and 병원.병원주소 like '%".$sido."%'
                            group by 병원.병원코드;";
                            
                            $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                            inner join 병원 on 의사.병원코드 = 병원.병원코드
                            inner join 과목 on 의사.과목코드 = 과목.과목코드
                            where 과목.과목이름 = '".$subject."' and 병원.병원주소 like '%".$sido."%';";
            } else {
                $hos_query = "select 병원.* from 의사
                            inner join 병원 on 의사.병원코드 = 병원.병원코드
                            inner join 과목 on 의사.과목코드 = 과목.과목코드
                            where 과목.과목이름 = '".$subject."' and 병원.병원주소 like '%".$sido." ".$gugun."%'
                            group by 병원.병원코드;";
                            
                            $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                            inner join 병원 on 의사.병원코드 = 병원.병원코드
                            inner join 과목 on 의사.과목코드 = 과목.과목코드
                            where 과목.과목이름 = '".$subject."' and 병원.병원주소 like '%".$sido." ".$gugun."%';";                        
            }
        }
    } else {
        if($subject == "-") {
            if($sido == "-" && $gugun == "-") {
                $hos_query = "select * from 병원 where 병원이름 like '%".$hospital_name."%';";
                
                $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                inner join 병원 on 의사.병원코드 = 병원.병원코드
                inner join 과목 on 의사.과목코드 = 과목.과목코드
                where 병원.병원이름 like '%".$hospital_name."%';";
            } else if($gugun == "-") {
                $hos_query = "select * from 병원 where 병원주소 like '%".$sido."%' and 병원이름 like '%".$hospital_name."%';";
                    
                    $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                    inner join 병원 on 의사.병원코드 = 병원.병원코드
                    inner join 과목 on 의사.과목코드 = 과목.과목코드
                    where 병원.병원주소 like '%".$sido."%' and 병원.병원이름 like '%".$hospital_name."%';";
            } else {
                $hos_query = "select * from 병원 where 병원주소 like '%".$sido." ".$gugun."%' and 병원이름 like '%".$hospital_name."%';";
                    
                    $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                    inner join 병원 on 의사.병원코드 = 병원.병원코드
                    inner join 과목 on 의사.과목코드 = 과목.과목코드
                    where 병원.병원주소 like '%".$sido." ".$gugun."%' and 병원.병원이름 like '%".$hospital_name."%';";
            }
        } else {
            if($sido == "-" && $gugun == "-") {
                $hos_query = "select 병원.* from 의사
                inner join 병원 on 의사.병원코드 = 병원.병원코드
                inner join 과목 on 의사.과목코드 = 과목.과목코드
                where 과목.과목이름 = '".$subject."' and 병원.병원이름 like '%".$hospital_name."%' group by 병원.병원코드;";
                        
                $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                inner join 병원 on 의사.병원코드 = 병원.병원코드
                inner join 과목 on 의사.과목코드 = 과목.과목코드
                where 병원.병원이름 like '%".$hospital_name."%';";
            } else if($gugun == "-") {
                $hos_query = "select 병원.* from 의사
                    inner join 병원 on 의사.병원코드 = 병원.병원코드
                    inner join 과목 on 의사.과목코드 = 과목.과목코드
                    where 과목.과목이름 = '".$subject."' and 병원.병원주소 like '%".$sido."%'
                    and 병원.병원이름 like '%".$hospital_name."%' group by 병원.병원코드;";
                    
                    $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                    inner join 병원 on 의사.병원코드 = 병원.병원코드
                    inner join 과목 on 의사.과목코드 = 과목.과목코드
                    where 병원.병원주소 like '%".$sido."%' and 병원.병원이름 like '%".$hospital_name."%';";
            } else {
                $hos_query = "select 병원.* from 의사
                    inner join 병원 on 의사.병원코드 = 병원.병원코드
                    inner join 과목 on 의사.과목코드 = 과목.과목코드
                    where 과목.과목이름 = '".$subject."' and 병원.병원주소 like '%".$sido." ".$gugun."%'
                    and 병원.병원이름 like '%".$hospital_name."%' group by 병원.병원코드;";
                    
                    $sub_query = "select distinct 병원.병원코드, 과목.* from 의사
                    inner join 병원 on 의사.병원코드 = 병원.병원코드
                    inner join 과목 on 의사.과목코드 = 과목.과목코드
                    where 병원.병원주소 like '%".$sido." ".$gugun."%' and 병원.병원이름 like '%".$hospital_name."%';";
            }
        }
        
    }
    
    $hos_result = mysql_query($hos_query) or die (mysql_error());
    $sub_result = mysql_query($sub_query) or die (mysql_error());
    
    $hos_count = mysql_num_rows($hos_result);
    $sub_count = mysql_num_rows($sub_result);
    
    $hos_data['hos_count'] = $hos_count;
    $hos_data['sub_count'] = $sub_count;
    
    if($hos_count==0) { // 검색 결과가 존재하지 않는 경우
        echo json_encode($hos_data, JSON_UNESCAPED_UNICODE);
    } else  {
        if($sub_count==0) {
            echo json_encode($hos_data, JSON_UNESCAPED_UNICODE);    
        } else {
            while($row = mysql_fetch_assoc($hos_result)) {  // 병원 열
                $hos_data[] = $row;                
            }
            while($row2 = mysql_fetch_assoc($sub_result)) { // 과목 열
                $sub_data[] = $row2;
            }
            for ($i=0; $i<$hos_count; $i++) {   // 한 병원에 여러 과목이 있는데 이 정보를 한 행에 표시하기 위한 문장.
                //$hos_data[$i]['병원전화번호'] = preg_replace("/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/", "$1-$2-$3", $hos_data[$i]['병원전화번호']);
                $hos_code = $hos_data[$i]['병원코드'];
                $hos_data[$i]['과목수'] = 0;
                for($j=0; $j<$sub_count; $j++) {
                    if($hos_code == $sub_data[$j]['병원코드']) {
                        $hos_data[$i]['과목'][$hos_data[$i]['과목수']] = $sub_data[$j];
                        $hos_data[$i]['과목수'] += 1;
                    }
                }
            }
            echo json_encode($hos_data, JSON_UNESCAPED_UNICODE);
        }
    }       
?>