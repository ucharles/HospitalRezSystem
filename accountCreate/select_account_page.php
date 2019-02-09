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
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Account Create</title>
</head>

<body>
    <div id="mainpage">
        <a href="../index.php">명지메디</a>
    </div>
<?
    if(!isset($member_code) && !isset($member_name) && !isset($hospital_code) && !isset($hospital_name)) {
?>
    <h2>회원가입</h2>
    <hr>
    <p>회원의 종류를 선택해 주세요<br/></p>
    <ul>
        <li><a href="insertfrom_patient.php">개인회원</a></li>
        <li><a href="insertfrom_hospital.php">병원회원</a></li>
    </ul>
<?
    } else {
?>
    <script language="JavaScript"> alert('이미 로그인 중입니다 ^_^'); self.location.replace('../index.php');</script>
<?
    }
?>
</body>
</html>
