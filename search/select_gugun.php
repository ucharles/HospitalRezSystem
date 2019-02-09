<?php    
    $sido = $_GET["q"];
    require_once("../database/db_connect.php");

    $query = "select 구군, 순서 from 주소 where 시도='".$sido."' group by 구군 order by 순서;";
    $result = mysql_query($query) or die(mysql_error());
    $count = mysql_num_rows($result);
    
    $tmp['count'] = $count;
    
    while($row = mysql_fetch_assoc($result)) {
        $tmp[] = $row;
    }
    
    echo json_encode($tmp, JSON_UNESCAPED_UNICODE);
?>
