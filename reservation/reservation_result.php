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
    if(isset($member_code) && isset($member_name)) {
        $doctor_code = $_REQUEST['sub_doc'];
        $res_date = $_REQUEST['res_date'];
        if(isset($_REQUEST['select_time'])) {
            $res_time = $_REQUEST['select_time'];
        }
        if($res_date == "" || !isset($_REQUEST['select_time']) || $res_time == "-") {
            echo "<script language='JavaScript'>alert('정보를 모두 입력해 주세요.'); history.back();</script>";
        } else {
            require_once("../database/db_connect.php");
            
            $valid_date_query = "select * from 예약 where 회원코드='".$member_code."' and 예약날짜='".$res_date."' and 예약시간='".$res_time."';";
            $valid_date_result = mysql_query($valid_date_query) or die(mysql_error());
            $valid_date_count = mysql_num_rows($valid_date_result);
            
            if($valid_date_count != 0) {
                echo "<script language='JavaScript'>alert('같은 날, 같은 시간에 이미 예약내역이 존재합니다.'); history.back();</script>";
            } else {
                $resinfo_query = "select 병원.병원코드, 병원.병원이름, 과목.과목코드, 과목.과목이름, 의사.의사이름 from 의사 inner join 병원 on 병원.병원코드 = 의사.병원코드 inner join 과목 on 과목.과목코드 = 의사.과목코드 where 의사.의사코드='".$doctor_code."';";
                $resinfo_result = mysql_query($resinfo_query) or die(mysql_error());
                $data = mysql_fetch_assoc($resinfo_result) or die(mysql_error());
                
                $insert_resinfo_query = "insert into 예약 values(DEFAULT, '".$member_code."', '".$member_name."', '".$doctor_code."', '".$data['의사이름']."', '".$data['병원코드']."', '".$data['병원이름']."', '".$data['과목코드']."', '".$data['과목이름']."', '".$res_date."', '".$res_time."', '1', '');";
                mysql_query($insert_resinfo_query) or die(mysql_error());
                
                $query3 = "select * from 예약 where 회원코드='".$member_code."' and 예약날짜='".$res_date."' and 예약시간='".$res_time."';";
                $result2 = mysql_query($query3) or die(mysql_error());
                
                $print_resinfo = mysql_fetch_assoc($result2) or die(mysql_error());
                
                $print_resinfo['예약시간'] = SUBSTR($print_resinfo['예약시간'], 0,2) ."시 ". SUBSTR($print_resinfo['예약시간'], 3,2) ."분";
                $print_resinfo['상태'] = "예약완료";
                
                $query4 = "update 진찰일정 set 일정여부='1' where 의사코드='".$doctor_code."' and 날짜='".$res_date."' and 시간='".$res_time."';";
                mysql_query($query4) or die(mysql_error());
            }
        }
    } else {
        echo "<script language='JavaScript'>alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>

<!DOCTYPE html>

<html>

<head>
  <title> Join-개인회원 </title>
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
		<a href="search/search_page2.php"><img border="0"src="../img/me3.jpg"  width="120" height="80" alt="병원검색" onmouseover="this.src='../img/me4.jpg'" onmouseout="this.src='../img/me3.jpg'"
		style="borer:0 solid"></a>
		<br><br><br>
		<a href="NEW ARRIVAL.html"><img border="0" src="../img/wlsfy.jpg"  width="120" height="80"alt="진료예약"onmouseover="this.src='../img/wlsfy2.jpg'" onmouseout="this.src='../img/wlsfy.jpg'"	style="borer:0 solid"></a>
		<br><br><br>
		<a href ="JOIN.html"><img border="0"  src="../img/me.jpg" width="120" height="80"  alt="예약조회" onmouseover="this.src='../img/me2.jpg'" onmouseout="this.src='../img/me.jpg'"	style="borer:0 solid"></a>
		<br><br><br>

		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		
		<img src="../img/info.jpg" width="150" height="60" alt="welcome/">

		</div>

	<div id="main_content">
<!--MAIN-->
  <h1>예약완료!!</h1>
        <hr>
        <table border="1" cellspacing="0" cellpadding="5" align="center">
            <tr bgcolor="#BOD6FB">
                <th>예약번호</th><th>진료날짜</th><th>진료시간</th><th>예약자</th><th>병원이름</th><th>과목이름</th><th>의사이름</th><th>예약상태</th>
            </tr>
            <tr>
                <td><?echo $print_resinfo['예약번호']?></td>
                <td><?echo $print_resinfo['예약날짜']?></td>
                <td><?echo $print_resinfo['예약시간']?></td>
                <td><?echo $print_resinfo['회원이름']?></td>
                <td><?echo $print_resinfo['병원이름']?></td>
                <td><?echo $print_resinfo['과목이름']?></td>
                <td><?echo $print_resinfo['의사이름']?></td>
                <td><?echo $print_resinfo['상태']?></td>
            </tr>
        </table>
        <a href="../mypage/mypage_reservation_patient_page.php">예약확인하기</a>
	</div>
</body>
</html>
