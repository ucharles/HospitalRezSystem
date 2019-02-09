<?php

    $userid = $_GET['userid'];
    require_once("../database/db_connect.php");
     
         $p_query = "SELECT * FROM 환자 WHERE 회원id  = '" . $userid . "';";
         $p_result = mysql_query($p_query) or die (mysql_error());
         $p_count = mysql_num_rows($p_result);
         
         $h_query = "SELECT * FROM 병원 WHERE 병원id  = '" . $userid . "';";
         $h_result = mysql_query($h_query) or die (mysql_error());
         $h_count = mysql_num_rows($h_result);

    //when the id exists
       if($p_count == 0 && $h_count ==0) {
        //$row = mysql_fetch_array($result);
            $message = "<h3>가입가능합니다.</h3>";
        }else{
            $message = "<h3>이미 등록된 아이디 입니다.</h3>";
        }
    
?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
</head>

<body>
<?echo $message;?>
<table width="280" heigth="40" border="0" align="center" cellpadding="0"
cellspacing="0" bgcolor="#EBDBF2" style="border:0px #333333 solid;border-bottom-
width:3px;">
<tr><td align="center">
<input type="button" name="Button" value="닫기" onClick="self.close();"></td></tr>
</table>
</body>

</html>
