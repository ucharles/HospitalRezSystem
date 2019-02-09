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
    <div id="message"><?echo "병원 [".$hospital_name."] 환영합니다."?><input type="button" value="Logout" onclick="logout()"/></div>
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
		<a href="mypage_reservation_hospital_page.php"><img border="0"src="../img/menure.jpg"  width="120" height="40" alt="예약관리" onmouseover="this.src='../img/menure11.jpg'" onmouseout="this.src='../img/menure.jpg'"     style="borer:0 solid"></a>
		<br><br>
		<img border="0" src="../img/menudocm.jpg"  width="120" height="40"alt="의사관리" style="borer:0 solid">

		<a href ="mypage_view_doctor_page.php"><img border="0"  src="../img/menudoc1.jpg" width="120" height="40"  alt="의사목록조회" onmouseover="this.src='../img/menudoc11.jpg'" onmouseout="this.src='../img/menudoc1.jpg'"	style="borer:0 solid"></a>

		<a href ="mypage_doctor_schedule.php"><img border="0"  src="../img/menudoc2.jpg" width="120" height="40"  alt="의사일정관리" onmouseover="this.src='../img/menudoc22.jpg'" onmouseout="this.src='../img/menudoc2.jpg'"	style="borer:0 solid"></a>

		<a href ="mypage_edit_doctor_page.php?q=insert"><img border="0"  src="../img/menudoc3.jpg" width="120" height="40"  alt="의사등록" onmouseover="this.src='../img/menudoc33.jpg'" onmouseout="this.src='../img/menudoc3.jpg'"	style="borer:0 solid"></a>
		<br><br>
		<img border="0"  src="../img/menuhosm.jpg" width="120" height="40"  alt="병원정보" style="borer:0 solid">

		<a href ="update_hospital_page.php"><img border="0"  src="../img/menuhos1.jpg" width="120" height="40"  alt="병원정보수정" onmouseover="this.src='../img/menuhos11.jpg'" onmouseout="this.src='../img/menuhos1.jpg'"	style="borer:0 solid"></a>

		<a href ="delete_hospital.php"><img border="0"  src="../img/menuhos2.jpg" width="120" height="40"  alt="병원회원탈퇴" onmouseover="this.src='../img/menuhos22.jpg'" onmouseout="this.src='../img/menuhos2.jpg'"	style="borer:0 solid"></a>

		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		
		<img src="../img/info.jpg" width="150" height="60" alt="welcome/">

		</div>

	<div id="main_content">
<!--MAIN-->
        <h3>명지메디 사용설명서</h3>
        <ol>
            <li>회원가입 후 의사를 등록합니다.</li>
            <ul>
                <li>의사를 등록하기 전까진 검색 결과에 표시되지 않습니다.</li>
            </ul>
            <li>의사 등록 후 의사 스케줄을 등록합니다.</li>
            <ul>
                <li>스케줄을 관리하려면 의사, 날짜, 분류를 모두 입력해야 합니다.</li>
                <li>스케줄 보기는 스케줄 조회와 등록된 스케줄 삭제가 가능합니다</li>
                <li>스케줄 조회는 언제든 가능합니다.</li>
                <li>스케줄 편집(업데이트, 삭제)은 오전 9시를 기준으로 오늘부터 이틀 후 ~ 열흘 후 까지 가능합니다.</li>
                <li>예약된 스케줄은 삭제할 수 없습니다.</li>
                <li>스케줄을 업데이트하면 환자 회원이 진료예약을 할 수 있습니다.</li>
                <li></li>
            </ul>
            <li>예약 관리에서 예약내역을 관리합니다.</li>
            <ul>
                <li>예약 상태는 4가지가 존재합니다. <br/> 1.예약완료, 2.예약취소, 3.진료완료, 4.예약불이행</li>
                <li>예약완료 상태는 상태변경이 가능합니다. 그 외의 상태는 상태변경이 불가능합니다.</li>
                <li>예약완료 상태인 내역은 예약시간이 지나면 붉은색으로 표시됩니다.</li>
                <li>진료완료 상태에서 진찰기록을 작성할 수 있습니다.</li>
                <li>진찰기록이 작성되면 예약회원이 진찰기록을 볼 수 있습니다.</li>
                <li>약속한 시간에 예약회원이 오지 않았다면 예약불이행으로 표시하면 됩니다.</li>
            </ul>
        </ol>
	</div>
</body>
</html>
