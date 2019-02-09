<?php
    require_once("../database/db_connect.php");
     
    $id = $_REQUEST['id'];
    $pwd = $_REQUEST['pwd'];
    $name = $_REQUEST['name'];
    $bnum1 = $_REQUEST['bnum1'];
    $bnum2 = $_REQUEST['bnum2'];
    $bnum3 = $_REQUEST['bnum3'];
    $onum = $_REQUEST['onum'];
    $zipcode = $_REQUEST['zip1'];
    $zipcode2 = $_REQUEST['zip2'];
    $add1 = $_REQUEST['address'];
    $add2 = $_REQUEST['add2'];
    $phone = $_REQUEST['phone'];
    $phone2 = $_REQUEST['phone2'];
    $phone3 = $_REQUEST['phone3'];
    $email = $_REQUEST['email'];
    $email2 = $_REQUEST['email2'];
    $info = $_REQUEST['info'];
    
    $sql = "INSERT INTO 병원 VALUES(default,'" . $id .
            "','" . SUBSTR(md5($pwd),0,20) . "','" . $name .
            "','" . $bnum1 . $bnum2 . $bnum3 .
            "','" . $onum .
            "','" . $zipcode . $zipcode2 .
            "','" . $add1 .
            "','" . $add2 .
            "','" . $phone ."-". $phone2 ."-". $phone3 .
            "','" . $email."@".$email2 .
            "','" . $info . "');";
            
            //"','','','','','','');";
    $result = mysql_query($sql) or die(mysql_error());

    echo "<script>alert('가입완료!'); self.location.replace('../index.php');</script>";
?>

