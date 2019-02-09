<?php
    require_once("../database/db_connect.php");
    
    $data = array();
    
    $address = $_GET['q'];
    
    $query = "select * from 주소 where 동 like '".$address."%';";
    $result = mysql_query($query) or die(mysql_error());
    $count = mysql_num_rows($result);
    $data['count'] = $count;
        
    while($row = mysql_fetch_assoc($result)) {
        $data[] = $row;
    }
    for($i=0; $i<$count; $i++) {
        $tmp_zipcode = $data[$i]['우편번호'];
        $zip1 = SUBSTR($tmp_zipcode, 0, 3);
        $zip2 = SUBSTR($tmp_zipcode, 4, 3);
        $data[$i]['zip1'] = $zip1;
        $data[$i]['zip2'] = $zip2;
    }
    
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>