<?php
    header("Content-Type: text/html; charset=UTF-8");
    
    require_once("../database/db_connect.php");
    
    $data = array();
    
    $query = "SELECT 시도, 순서 FROM 주소 GROUP BY 시도 ORDER BY 순서;";
    $result = mysql_query($query) or die (mysql_error());
    
    $count = mysql_num_rows($result);
    
    $data['count'] = $count;
    
    while($row = mysql_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>