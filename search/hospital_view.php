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
    $hos_id = $_GET['q'];
    
    require_once('../database/db_connect.php');
    $hos_query = "select 병원이름, 병원주소, 병원상세주소, 병원전화번호, 병원이메일, 병원정보 from 병원 where 병원코드='".$hos_id."';";
    $sub_query = "select distinct 과목.과목이름 from 의사 inner join 과목 on 과목.과목코드 = 의사.과목코드 where 의사.병원코드='".$hos_id."';";
    $doc_query = "select 의사.의사이름, 의사.의사정보, 과목.과목이름 from 의사 inner join 과목 on 과목.과목코드 = 의사.과목코드 where 병원코드='".$hos_id."';";
    $hos_result = mysql_query($hos_query) or die(mysql_error());
    $sub_result = mysql_query($sub_query) or die(mysql_error());
    $doc_result = mysql_query($doc_query) or die(mysql_error());
    
    $hospital = mysql_fetch_assoc($hos_result);
    $subject = array();
    $sub_count = mysql_num_rows($sub_result);
    while($row = mysql_fetch_assoc($sub_result)) {
        $subject[] = $row;
    }
    $doctor = array();
    $doc_count = mysql_num_rows($doc_result);
    while($row = mysql_fetch_assoc($doc_result)) {
        $doctor[] = $row;
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
    <div id="message"><?echo "병원 [".$hospital_name."] 환영합니다.";?><input type="button" value="Logout" onclick="logout()"/></div>
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
		<a href="NEW ARRIVAL.html"><img border="0" src="../img/wlsfy.jpg"  width="120" height="80"alt="진료예약"onmouseover="this.src='../img/wlsfy2.jpg'" onmouseout="this.src='../img/wlsfy.jpg'"	style="borer:0 solid"></a>
		<br><br><br>
		<a href ="JOIN.html"><img border="0"  src="../img/me.jpg" width="120" height="80"  alt="예약조회" onmouseover="this.src='../img/me2.jpg'" onmouseout="this.src='../img/me.jpg'"	style="borer:0 solid"></a>
		<br><br><br>

		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		
		<img src="../img/info.jpg" width="150" height="60" alt="welcome/">

		</div>

	<div id="main_content">
<!--MAIN-->
	        <table border='1' align="center">
        <?if(isset($member_code) && isset($member_name)){?>
            <tr><td class='title'>병원명</td><td colspan='2'><?echo $hospital['병원이름'];?> <input type='button' value='예약하기' onclick="window.location='../reservation/reservation.php?q=<?echo $hos_id;?>'"/></td></tr>
        <?}else if(isset($hospital_code) && isset($hospital_name)){?>
            <tr><td class='title'>병원명</td><td colspan='2'><?echo $hospital['병원이름'];?> <input type='button' value='병원은 예약불가'/></td></tr>
        <?}else{?>
            <tr><td class='title'>병원명</td><td colspan='2'><?echo $hospital['병원이름'];?> <input type='button' value='로그인 후 예약가능'/></td></tr>
        <?}?>
            <tr>
                <td class='title'>진료과목</td>
                <td colspan='2'>
                <?
                    for($i=0; $i<$sub_count; $i++) {
                        if($i == $sub_count - 1) {
                            echo $subject[$i]['과목이름'];
                        } else {
                            echo $subject[$i]['과목이름']."/";
                        }
                    }
                ?>
                </td>
            </tr>
        <?
            for($i=0; $i<$doc_count; $i++) {
                if($i==0) {
                    echo "<tr><td class='title' rowspan='".$doc_count."'>의사정보</td><td>".$doctor[$i]['의사이름']."<br/>".$doctor[$i]['과목이름']."</td><td>".$doctor[$i]['의사정보']."</td></tr>";
                } else {
                    echo "<tr><td>".$doctor[$i]['의사이름']."<br/>".$doctor[$i]['과목이름']."</td><td>".$doctor[$i]['의사정보']."</td></tr>";
                }
            }
        ?>
            <tr><td class='title'>주소</td><td colspan='2'><?echo $hospital['병원주소']." ".$hospital['병원상세주소'];?></td></tr>
            <tr><td class='title'>전화번호</td><td colspan='2'><?echo $hospital['병원전화번호'];?></td></tr>
            <tr><td class='title'>병원이메일</td><td colspan='2'><?echo $hospital['병원이메일'];?></td></tr>
            <tr><td class='title'>병원정보</td><td colspan='2'><?echo $hospital['병원정보'];?></td></tr>
        </table>
    </div>

	</div>
</body>
</html>
