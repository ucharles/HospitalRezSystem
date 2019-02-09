<?php
    $p_jumin = $_GET['jumin'];
    $jumin_md6 = SUBSTR(md5($p_jumin), 0, 20);
    
    require_once("../database/db_connect.php");
    mysql_query("set names utf8");
    
         $p_query = "SELECT * FROM 환자 WHERE 주민번호  = '" . $jumin_md6 . "';";
         $p_result = mysql_query($p_query) or die (mysql_error());
         $p_count = mysql_num_rows($p_result);

    //when the id exists
       if($p_count == 0) {
        //$row = mysql_fetch_array($result);
            $message = "<h3>가입가능합니다.</h3>";
        }else{
            $message = "<h3>이미 등록된 주민번호 입니다.</h3>";
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
