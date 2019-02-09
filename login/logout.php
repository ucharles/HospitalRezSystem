<?php
    header("Content-Type: text/html; charset=UTF-8");
    session_start();
    if (isset($_SESSION['member_code']) && isset($_SESSION['member_name'])) {
        $member_code = $_SESSION['member_code'];
        $member_name = $_SESSION['member_name'];
    } else if(isset($_SESSION['hospital_code']) && isset($_SESSION['hospital_name'])) {
        $hospital_code = $_SESSION['hospital_code'];
        $hospital_name = $_SESSION['hospital_name'];
    }
	 
    if(!isset($member_code) && !isset($member_name) && !isset($hospital_code) && !isset($hospital_name)) {
//        echo "<a href='../index.php'>Main Page</a>";
        echo "<script language=\"JavaScript\"> self.location.replace('../index.php');</script>";
    } else if(isset($member_code) && isset($member_name)) {
        echo "<script language=\"JavaScript\">self.location.replace('../index.php');</script>";
        session_destroy();
    } else {
        echo "<script language=\"JavaScript\"> self.location.replace('../index.php');</script>";
        session_destroy();
    }
?>