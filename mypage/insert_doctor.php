<?php
    session_start();
    header("Content-Type: text/html; charset=UTF-8");
    if (isset($_SESSION['member_code']) && isset($_SESSION['member_name'])) {
        $member_code = $_SESSION['member_code'];
        $member_name = $_SESSION['member_name'];
    } else if(isset($_SESSION['hospital_code']) && isset($_SESSION['hospital_name'])) {
        $hospital_code = $_SESSION['hospital_code'];
        $hospital_name = $_SESSION['hospital_name'];
    }
    
    if(isset($hospital_code) && isset($hospital_name)) {
        $edit = $_REQUEST['edit'];
        $doc_name = $_REQUEST['doc_name'];
        $doc_sub = $_REQUEST['doc_sub'];
        $doc_info = $_REQUEST['doc_info'];
        
        for($i=0; $i<count($doc_name); $i++) {
            if(ord($doc_name[$i]) <= 127) {
                $isKor = false;
                break;
            }
            $isKor = true;
        }
        if(!isset($doc_name) || ctype_space($doc_name) || !$isKor || $doc_sub == '-') {
            echo "<script language=\"JavaScript\">alert('값을 제대로 입력해 주세요.'); history.back(); </script>";
        } else {
            require_once('../database/db_connect.php');
            if($edit == "insert") {
                $query = "insert into 의사 values(DEFAULT,'".$doc_name."', '".$doc_sub."', '".$hospital_code."', '".$doc_info."');";
                mysql_query($query) or die(mysql_error());
                echo "<script language=\"JavaScript\">alert('등록 완료!'); self.location.replace('mypage_view_doctor_page.php');</script>";
            } else {
                $doc_id = $_REQUEST['doc_id'];
                $query = "update 의사 set 의사이름='".$doc_name."', 과목코드='".$doc_sub."', 의사정보='".$doc_info."' where 의사코드='".$doc_id."';";
                mysql_query($query) or die(mysql_error());
                echo "<script language=\"JavaScript\">alert('수정 완료!'); self.location.replace('mypage_view_doctor_page.php');</script>";
            }
            
        }
    } else {
        echo "<script language=\"JavaScript\">alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>