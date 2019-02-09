<?php
    session_start();
    $id = $_REQUEST['login_id'];
    $pwd = $_REQUEST['login_pwd'];
    $pwdmd5 = SUBSTR(md5($pwd), 0, 20);
    
    require_once("../database/db_connect.php");
    
    $p_query = "select 회원코드, 회원id, 회원pwdmd5, 회원이름 from 환자 where 회원id='".$id."' and 회원pwdmd5='".$pwdmd5."';";
    $p_result = mysql_query($p_query) or die(mysql_error());
    $p_count = mysql_num_rows($p_result);
    
    $h_query = "select 병원코드, 병원id, 병원pwdmd5, 병원이름 from 병원 where 병원id='".$id."' and 병원pwdmd5='".$pwdmd5."';";
    $h_result = mysql_query($h_query) or die(mysql_error());
    $h_count = mysql_num_rows($h_result);
    
    if($p_count == 0 && $h_count == 0) {
        echo "<script language=\"JavaScript\">alert('아이디와 비밀번호가 일치하지 않습니다.'); history.back();</script>";
        session_destroy();
    } else if ($h_count == 0){
        $data = mysql_fetch_assoc($p_result);
        
        $_SESSION['member_code'] = $data['회원코드'];
        $_SESSION['member_name'] = $data['회원이름'];
        
        echo "<script language=\"JavaScript\">self.location.replace('../index.php');</script>";
    } else {
        $data = mysql_fetch_assoc($h_result);
        
        $_SESSION['hospital_code'] = $data['병원코드'];
        $_SESSION['hospital_name'] = $data['병원이름'];
        
        echo "<script language=\"JavaScript\">self.location.replace('../index.php');</script>";
    }
?>