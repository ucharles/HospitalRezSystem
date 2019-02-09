<?php
    header("Content-Type: text/html; charset=UTF-8");

    $connect = mysql_connect("localhost", "root", "root") or die (mysql_error());
    mysql_select_db('wpp13', $connect) or die (mysql_error());
    
    mysql_set_charset("utf8");
?>