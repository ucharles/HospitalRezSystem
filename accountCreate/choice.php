<?php
	session_start();
    header("Content-Type: text/html; charset=UTF-8");
	if(isset($_SESSION['member_code']) && isset($_SESSION['member_name'])) {
		$member_code = $_SESSION['member_code'];
		$member_name = $_SESSION['member_name'];
	} else if(isset($_SESSION['hospital_code']) && isset($_SESSION['hospital_name'])) {
		$hospital_code = $_SESSION['hospital_code'];
		$hospital_name = $_SESSION['hospital_name'];
	}
?>

<!DOCTYPE html>

<html>
<!-- 헤드-->
 <head>
  <title> choice </title>
    <meta charset="utf-8">
	<meta name="Generator" content="EditPlus">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">

	<link href="./joins.css" rel="stylesheet" type="text/css">

	<script type="application/x-javascript">
        function logout() {
            location.href="login/logout.php";
        }
    </script>
</head>

<!--body-->
 <body>
 <div id="wrap"> <!--WRAP-->
	<div id="top">
		<!--로그인에 대한 정보 넣기 -->
		<font color="black"> 
<?
    if(!isset($member_code) && !isset($member_name) && !isset($hospital_code) && !isset($hospital_name)) {
?>
	<div id="login">
		 <form action="login/login.php" method="post">
            ID <input type="text" id="login_id" name="login_id"/>
            Password <input type="password" id="login_pwd" name="login_pwd"/>
            <input type="submit" value="Login"/>
            <a href="choice.php">회원가입</a>
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
				<li> <a href="../search/search_page.php"><font color ="black">병원 검색</font></a></li>
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
		<a href ="JOIN.html"><img border="0"  src="../img/me.jpg" width="120" height="80"  alt="예약조회" onmouseover="this.src='../img/me2.jpg'" onmouseout="this.src='../img/me.jpg'"	style="borer:0 solid"></a>
		<br><br><br>

		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		
		<img src="../img/info.jpg" width="150" height="60" alt="welcome/">

		</div>

	<div id="main_content">
<!--MAIN-->
<?
    if(!isset($member_code) && !isset($member_name) && !isset($hospital_code) && !isset($hospital_name)) {
?>
	<img src="../img/nav1.jpg" width="120" height="50" border="0" alt="" align="center">
	<table border="0"   align="center">
	 <tr>
	 </tr>
		<tr>
			<td>고객님께 해당하는 유형을 선택해주세요</td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td>유형에 따라 가입 절차가 다릅니다</td>
		</tr>
	</table>
<table border="1 width=800 height=500"   align="center">
<tr>
	<br><br><br>
</tr>
	<td><img src="../img/personal.jpg" width="396" height="130" border="0" alt="개인회원" usemap="#Map"></td>
</tr>

<tr>
	<td><img src="../img/hospital.jpg" width="394" height="127" border="0" alt="병원회원"usemap="#Map2"></td>
</tr>
</table>
<map name="Map" id="Map">
  <area shape="rect" coords="24,92,83,111" href="insertfrom_patient.php" alt="">
</map>
<map name="Map2" id="Map2">
  <area shape="rect" coords="25,93,83,112" href="insertfrom_hospital.php" alt="">
</map>
<?
    } else {
?>
    <div id="message">
        이미 로그인 중입니다.^_^
        <a href="index.php">Main Page</a>
    </div>
<?
    }
?>
</body>
</html>
