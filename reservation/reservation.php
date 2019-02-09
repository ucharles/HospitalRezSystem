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
        $hos_num = $_GET['q'];
        require_once("../database/db_connect.php");
        $hos_query = "select * from 병원 where 병원코드='".$hos_num."';";
        $sub_query = "select 과목.*, 의사.* from 의사
                    inner join 병원 on 의사.병원코드 = 병원.병원코드
                    inner join 과목 on 의사.과목코드 = 과목.과목코드
                    where 병원.병원코드='".$hos_num."';";
        $hos_result = mysql_query($hos_query) or die (mysql_error());
        $sub_result = mysql_query($sub_query) or die (mysql_error());
        $sub_count = mysql_num_rows($sub_result);        
            
        $sub_data = array();
            
        while($row = mysql_fetch_assoc($hos_result)) {
            $hos_data = $row;
        }
        //$hos_data['병원전화번호'] = preg_replace("/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/", "$1-$2-$3", $hos_data['병원전화번호']);
        // 정규식을 사용하여 전화번호를 보기 편하게 바꿈.
        while($row2 = mysql_fetch_assoc($sub_result)) {
            $sub_data[] = $row2;
        }
    } else {
        
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
  function isPastDate(date) {
            var sel_date = new Date(date);
            var today = new Date();
            if (sel_date < today) {
                document.getElementById('check_date').innerHTML = '오늘 이후의 날짜를 선택해 주세요.';
                document.getElementById('res_time').innerHTML = ' ';
            } else {
                document.getElementById('check_date').innerHTML = ' ';
                
                var doctor = document.getElementById('sub_doc').options[document.getElementById('sub_doc').options.selectedIndex].id;
                
                var http = new XMLHttpRequest();
                http.onreadystatechange = function() {
                if (http.readyState == 4) {
                    if (http.status == 200) {
                        var data = JSON.parse(http.responseText);
                        var append = "<select id='select_time' name='select_time'>";
                        append += "<option id='0' selected>-</option>";
                        for(var i=0; i<data.count; i++) {
                            append += "<option value='"+data[i].시간+"'>"+data[i].화면시간+"</option>";
                        }
                        append += '</select>';
                        document.getElementById('res_time').innerHTML = append;
                    }
                }
            }
            http.open('GET', 'confirm.php?q='+date+'&hos=<?echo $hos_data['병원코드'];?>&doc='+doctor, true);
            http.send();
            }
        }
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
		<a href ="../mypage/mypage_index.php"><img border="0"  src="../img/me.jpg" width="120" height="80"  alt="예약조회" onmouseover="this.src='../img/me2.jpg'" onmouseout="this.src='../img/me.jpg'"	style="borer:0 solid"></a>
		<br><br><br>

		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		
		<img src="../img/info.jpg" width="150" height="60" alt="welcome/">

		</div>

	<div id="main_content">
<!--MAIN-->
		<img src="../img/nav8.jpg" width="120" height="50" border="0" alt=""><br><br>
		 <?echo "<h3>".$hos_data['병원이름']." Tel.".$hos_data['병원전화번호']."</h3>";?>
        <form action='reservation_result.php' method='post'>
            <table border="1" cellspacing="0" cellpadding="5" align="center">
                <tr>
                    <td bgcolor="#BOD6FB">진료과목 - 의사명</td>
                    <td colspan="2"><select id='sub_doc' name='sub_doc'>
                    <?
                        for($i=0; $i<$sub_count; $i++) {
                            echo "<option id='".$sub_data[$i]['의사코드']."' value='".$sub_data[$i]['의사코드']."'>".$sub_data[$i]['과목이름']." - ".$sub_data[$i]['의사이름']."</option>";
                        }
                    ?>
                    </select></td>
                </tr>
                <tr>
                    <td bgcolor="#BOD6FB">날짜</td>
                    <td id='doc_select'><input type='date' id='res_date' name='res_date' onChange='javascript:isPastDate(this.value)'/></td>
                    <td id='check_date'></td>
                </tr>
                <tr><td bgcolor="#BOD6FB">예약 시간</td>
                    <td id='res_time' colspan="2">날짜를 선택해주세요.</td>
                </tr>
                <tr><td colspan="3"><input type='submit' value='예약하기'/></td></tr>
			 </table>
			</form>
		</div>
		 <br/>
		<div id='information'>
			개원시간부터 폐원시간 중 <u><b>30분 단위로</b></u> 예약 가능.<br/> (점심시간 제외)
			표시되지 않는 시간은 예약이 불가능한 시간입니다.
		</div>
	</div>
</body>
</html>
