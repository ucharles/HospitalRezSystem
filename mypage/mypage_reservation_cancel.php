<?php
    session_start();
    header("Content-Type: text/html; charset=UTF-8");

    $res_num = $_GET['q'];

    if (isset($_SESSION['member_code']) && isset($_SESSION['member_name'])) {
        $member_code = $_SESSION['member_code'];
        $member_name = $_SESSION['member_name'];
    } else if(isset($_SESSION['hospital_code']) && isset($_SESSION['hospital_name'])) {
        $hospital_code = $_SESSION['hospital_code'];
        $hospital_name = $_SESSION['hospital_name'];
    }
	require_once('../database/db_connect.php');
    
    if(isset($member_code) && isset($member_name)) {
        $update_query = "update 예약 set 상태='2' where 예약번호='".$res_num."';";
        mysql_query($update_query) or die(mysql_error());
        
        $query = "select * from 예약 where 예약번호='".$res_num."';";
        $result = mysql_query($query) or die(mysql_error());
        $count = mysql_num_rows($result);
        
        if($count > 0) {
            $data = mysql_fetch_assoc($result) or die(mysql_error());
            $state = $data['상태'];
            if($state == '1') {
                $data['상태'] = '예약완료';
            } else if($state == '2') {
                $data['상태'] = '예약취소';
            } else if($state == '3') {
                $data['상태'] = '진료완료';
            } else if($state == '4') {
                $data['상태'] = '예약불이행';
            }
        }
        $update_query2 = "update 진찰일정 set 일정여부='0' where 의사코드='".$data['의사코드']."' and 날짜='".$data['예약날짜']."' and 시간='".$data['예약시간']."';";
        mysql_query($update_query2) or die(mysql_error());
    } else {
        echo "<script language='JavaScript'> alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>

<!DOCTYPE html>

<html>

<head>
  <title> Mypage-예약조회 </title>
    <meta charset="utf-8">
	<meta name="Generator" content="EditPlus">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">

	<link href="../accountCreate/joins.css" rel="stylesheet" type="text/css">
	
	<!--<script type="application/x-javascript">-->
	<script type="text/javascript">
		
		function logout() {
            location.href="../login/logout.php";
        }

    </script>
</head>

 <body>
	<div id="wrap"> <!--WRAP-->
		<div id="top">
		<!--로그인에 대한 정보 넣기 -->
		<font color="black"> 
<?
    if(!isset($member_code) && !isset($member_name) && !isset($hospital_code) && !isset($hospital_name)) {
?>
	<div id="login">
		 <form action="../login/login.php" method="post">
            ID <input type="text" id="login_id" name="login_id"/>
            Password <input type="password" id="login_pwd" name="login_pwd"/>
            <input type="submit" value="Login"/>
            <a href="../accountCreate/choice.php">회원가입</a>
        </form>
	</div>

<?} else if(isset($member_code) && isset($member_name)){?>
    <div id="message"><?echo $member_name." 님 환영합니다."?> <input type="button" value="Logout" onclick="logout()"/></div>
<?} else {?>
    <div id="message"><?echo "병원 [".$data['병원이름']."] 환영합니다.";?> <input type="button" value="Logout" onclick="logout()"/></div>
<?}?>
	</div>
	<div id="header"><!--Header-->
		<div id="header_top">
			<div id="header_left">	
			<!--홈페이지의 메인 마크-->
				<img src="../img/logo3.jpg" width="202" height="64" border="0" alt="Myong Gi Medical treatment reservation">
			</div>
				<div id="header_right">
				</div>
			</div>
		<div id="navbar"> <!--Navbar-->
		<!--메뉴선택시 링크로 이동-->
			<ul>
				<li> <a href="../index.php" class="seleced"><font color ="black">Home</font></a></li>
				<li> <a href="../search/search_page2.php"><font color ="black">병원 검색</font></a></li>
				<li> <a href="../mypage/mypage_index.php"><font color ="black">My page</font></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="content"> <!--CONTENT-->
		<div id="left_content" align="left"> <!--img태그를 이용하여 html문서에 대한 링크-->
		<a href="../search/search_page.php"><img border="0"src="../img/me3.jpg"  width="120" height="80" alt="병원검색" onmouseover="this.src='../img/me4.jpg'" onmouseout="this.src='../img/me3.jpg'"
		style="borer:0 solid"></a>
		<br><br><br>
		<a href="../search/search_page.php"><img border="0" src="../img/wlsfy.jpg"  width="120" height="80"alt="진료예약"onmouseover="this.src='../img/wlsfy2.jpg'" onmouseout="this.src='../img/wlsfy.jpg'"	style="borer:0 solid"></a>
		<br><br><br>
		<a href ="../mypage/mypage_index.php"><img border="0"  src="../img/me.jpg" width="120" height="80"  alt="예약조회" onmouseover="this.src='../img/me2.jpg'" onmouseout="this.src='../img/me.jpg'"	style="borer:0 solid"></a>
		<br><br><br>

		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		
		<img src="../img/info.jpg" width="150" height="60" alt="welcome/">

		</div>

	<div id="main_content">
<!--MAIN-->
    <div id='patient_mypage'>
        <p>예약이 취소되었습니다.<br/></p>
        <table border='1' align="center" cellspacing="0" cellpadding="5">
            <tr bgcolor="#BOD6FB">
                <th>예약번호</th><th>진료날짜</th><th>진료시간</th><th>예약자</th><th>병원이름</th><th>과목이름</th><th>의사이름</th><th>예약상태</th>
            </tr>
            <tr>
                <td><?echo $data['예약번호']?></td>
                <td><?echo $data['예약날짜']?></td>
                <td><?echo $data['예약시간']?></td>
                <td><?echo $data['회원이름']?></td>
                <td><?echo $data['병원이름']?></td>
                <td><?echo $data['과목이름']?></td>
                <td><?echo $data['의사이름']?></td>
                <td><?echo $data['상태']?></td>
            </tr>
        </table>
		<br><br>
        <a href="mypage_reservation_patient_page.php">예약확인하기</a>
		</div>
	</div>
</body>
</html>
