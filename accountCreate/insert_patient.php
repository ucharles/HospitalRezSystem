<?php
    header("Content-Type: text/html; charset=UTF-8");
    require_once("../database/db_connect.php");
     
    $id = $_REQUEST['id'];
    $pwd = $_REQUEST['pwd'];
    $name = $_REQUEST['name'];
    $jumin = $_REQUEST['jumin'];
    $jumin2 = $_REQUEST['jumin2'];
    $zipcode = $_REQUEST['zip1'];
    $zipcode2 = $_REQUEST['zip2'];
    $add1 = $_REQUEST['address'];
    $add2 = $_REQUEST['add2'];
    $phone = $_REQUEST['phone'];
    $phone2 = $_REQUEST['phone2'];
    $phone3 = $_REQUEST['phone3'];
    $email = $_REQUEST['email'];
    $email2 = $_REQUEST['email2'];
    
    $valid_gender = SUBSTR($jumin2, 0 ,1);
    
    if($valid_gender == 1 || $valid_gender == 3 || $valid_gender == 9) {
        $gender = 0;    // 남자
    } else if($valid_gender == 2 || $valid_gender == 4 || $valid_gender == 0) {
        $gender = 1;    // 여자
    }
    
    $sql = "INSERT INTO 환자 VALUES(default,'" . $id .
            "','" . SUBSTR(md5($pwd),0,20) . "','" . $name .
            "','" . SUBSTR(md5($jumin . $jumin2),0,20) .
            "','" . $gender .
            "','" . $zipcode . $zipcode2 .
            "','" . $add1 .
            "','" . $add2 .
            "','" . $phone . $phone2 . $phone3 .
            "','" . $email."@".$email2 . "');";
            
            //"','','','','','','');";
    $result = mysql_query($sql) or die(mysql_error());
    echo "<script>alert('가입완료!'); self.location.replace('../index.php');</script>";
?>

