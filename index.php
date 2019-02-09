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
  <head>
	<title>MJMedi - 명지메디에 오신것을 환영합니다!</title>
    <meta charset="utf-8">
	<meta name="Generator" content="EditPlus">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">
	
	<link href="./indexs.css" rel="stylesheet" type="text/css">

    <script type="text/javascript">
        function logout() {
            location.href="login/logout.php";
        }
    </script>
  </head>

<body>
    <div id="wrap"><!--WRAP-->
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
            <a href="accountCreate/choice.php">회원가입</a>
        </form>
	</div>

<?} else if(isset($member_code) && isset($member_name)){?>
    <div id="message"><?echo $member_name." 님 환영합니다."?> <input type="button" value="Logout" onclick="logout()"/></div>
<?} else {?>
    <div id="message"><?echo "병원 [".$hospital_name."] 환영합니다.";?><input type="button" value="Logout" onclick="logout()"/></div>
<?}?>
	</div>
    <div id="header"><!--Header-->
		<div id="header_top">
			<div id="header_left">	
			<!--홈페이지의 메인 마크-->
				<a href="index.php"><img src="img/logo3.jpg" width="202" height="64" border="0" alt="Myong Gi Medical treatment reservation"></a>
			</div>
				<div id="header_right">
				</div>
			</div>
		<div id="navbar"> <!--Navbar-->
		<!--메뉴선택시 링크로 이동-->
			<ul>
				<li> <a href="index.php" class="seleced"><font color ="black">Home</font></a></li>
				<li> <a href="search/search_page.php"><font color ="black">병원 검색</font></a></li>
				<li> <a href="mypage/mypage_index.php"><font color ="black">My page</font></a></li>

			</ul>
			</div>
		</div>
	</div>

	<div id="content"> <!--CONTENT-->
		<div id="left_content" align="left"> <!--img태그를 이용하여 html문서에 대한 링크-->
		<a href="search/search_page.php"><img border="0"src="img/me3.jpg"  width="120" height="80" alt="병원검색" onmouseover="this.src='img/me4.jpg'" onmouseout="this.src='img/me3.jpg'"
		style="borer:0 solid"></a>
		<br><br><br>
		<a href="search/search_page.php"><img border="0" src="img/wlsfy.jpg"  width="120" height="80"alt="진료예약"onmouseover="this.src='img/wlsfy2.jpg'" onmouseout="this.src='img/wlsfy.jpg'"	style="borer:0 solid"></a>
		<br><br><br>
		<a href ="mypage/mypage_index.php"><img border="0"  src="img/me.jpg" width="120" height="80"  alt="예약조회" onmouseover="this.src='img/me2.jpg'" onmouseout="this.src='img/me.jpg'"	style="borer:0 solid"></a>
		<br><br><br>


		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		
		<img src="./img/info.jpg" width="150" height="60" alt="welcome/">
		<br><br>
		<img src="img/sid2.jpg" width="120" height="350" border="0" alt="">
	
		</div>

		<div id="main_content">
		<!--MAIN-->

		<table border="0 width=600 height=800" align="left">
			
   			<tr>
				<td style="text-align:center">
				<img src="img/gido.png" width="550" Height="230" border="0" alt="">
				<br><br><br><br>
			</tr>
			<tr>
				<td style="text-align:center"><img src="img/bot.jpg" width="550" height="330" border="0" alt="">
				<br><br><br><br>
			</tr>
		</table>
		</div>
		<div id="right_content">
		<!-- RIGHT MAIN-->
				<img src="./img/manjok.png" width="150" height="60" alt="homepage notice/">
				<br><br>
				<img src="img/sid1.jpg" width="150" height="466" border="0" alt="side">
		</div>
	</div>
	<div id="footer"><!--FOOTER-->
	<!--홈페이지에 대한 정보들-->
	<table align="left">
		<tr>
			<td>&nbsp;&nbsp;&nbsp; copyright 2013 evermedi All right reserved. <br>
			 &nbsp;&nbsp;&nbsp;Contact evermedi@naver.com for more information.<br>
			 &nbsp;&nbsp;&nbsp;사업자 등록 번호: 129-81-84391 / 통신판매업 신고 제 20006-040호<br>
			&nbsp;&nbsp;&nbsp;개인정보관리 책임자: 나종민/ 대표자: 변호숙
			</td>
			<td align="right"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;programed by MJmedi team<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;major : computer engineering<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
			</td>
			<td style="text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="./img/logo3.jpg" width="150" height="50" alt="LOGO/">
		
			</td>
		</tr>
		</table>
	</div>
    <ul>
      <!--  <li><a href="search/search_page.php">병원 검색 및 예약</a></li>
        <li><a href="mypage/mypage_index.php">마이페이지</a></li>-->
    </ul>
</body>
</html>
