<?php
    require_once("../database/db_connect.php");
    
    $data = array();
    
    $query = "SELECT * FROM 과목;";
    $result = mysql_query($query) or die (mysql_error());
    
    $count = mysql_num_rows($result);
    
    $data['count'] = $count;
    
    while($row = mysql_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    echo json_encode($data, JSON_UNESCAPED_UNICODE);    
?>