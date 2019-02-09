<?php

    $bnum1 = $_GET['bnum1'];
    $bnum2 = $_GET['bnum2'];
    $bnum3 = $_GET['bnum3'];
    require_once("../database/db_connect.php");
    if(isset($bnum1)&&isset($bnum2)&&isset($bnum3)) {
        
         $query = "SELECT bnum FROM 병원 WHERE bnum  = '".$bnum1.$bnum2.$bnum3."';";
         $result = mysql_query($query) or die (mysql_error());
         $count = mysql_num_rows($result);

       if($count != 0 ) {
        //$row = mysql_fetch_array($result);
            $message = "<h3>이미 가입된 사업자번호 입니다.</h3>";
        }else{
            $message = "<h3>가능합니다.</h3>";
        }
        
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
