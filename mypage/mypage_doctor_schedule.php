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
        require_once("../database/db_connect.php");
        $doc_data = array();
        $query = "select 의사.*, 과목.과목이름 from 의사 inner join 과목 on 과목.과목코드 = 의사.과목코드 where 의사.병원코드='".$hospital_code."';";
        $result = mysql_query($query) or die(mysql_error());
        $doc_count = mysql_num_rows($result) or die(mysql_error());
        while($row = mysql_fetch_assoc($result)) {
            $doc_data[] = $row;
        }
    } else {
        echo "<script language='JavaScript'> alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>

<!DOCTYPE html>

<html>

<head>
  <title> Mypage-의사일정관리 </title>
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
        function isValidDate(date) {
            var sel_date = new Date(date);
            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() +1);
            var future = new Date();
            future.setDate(future.getDate() + 10);
            if (sel_date < tomorrow) {
                document.getElementById('check_date').innerHTML = '스케줄 열람 가능/업데이트 불가';
                return false;
            } else if(sel_date > future){
                document.getElementById('check_date').innerHTML = '선택불가';
                document.getElementById('schedule_table').innerHTML = " ";
                return false;
            } else {
                document.getElementById('check_date').innerHTML = " ";
                return true;
            }
        }
        function made_doctor_schedule() {
            var doc_id = document.getElementById('doctor').options[document.getElementById('doctor').options.selectedIndex].value;
            var date = document.getElementById('schedule_date').value;
            var radio = document.querySelector('input[name="select_schedule"]:checked').value;
            if (date == "") {
                date = "-";
                document.getElementById('check_date').innerHTML = "날짜를 선택해 주세요!";
            } else {
                isValidDate(date);
            }
            if (doc_id != "-" && date != "-") {
                if (radio == 'view') {
                    var http = new XMLHttpRequest();
                    http.onreadystatechange = function() {
                        if (http.readyState == 4 && http.status == 200) {
                            var data = JSON.parse(http.responseText);
                            if (data.count == 0) {
                                document.getElementById('schedule_msg').innerHTML = "등록된 일정이 존재하지 않습니다.";
                                document.getElementById('schedule_table').innerHTML = " ";
                            } else {
                                document.getElementById('schedule_msg').innerHTML = " ";
                                var append = "<tr><th>날짜</th><th>시간</th><th>일정여부</th><th>삭제</th></tr>";
                                for(var i=0; i<data.count; i++) {
                                    if (data[i].일정여부 == "예약됨" || isValidDate(date) == false) {
                                        append += "<tr><td>"+data[i].날짜+"</td><td>"+data[i].화면시간+"</td><td>"+data[i].일정여부+"</td><td></td></tr>"
                                    } else {
                                        append += "<tr><td>"+data[i].날짜+"</td><td>"+data[i].화면시간+"</td><td>"+data[i].일정여부+"</td>"+
                                        "<td><input type='checkbox' name='delete_schedule[]' value='"+data[i].일정순서+"'/></td></tr>";
                                    }
                                }
                                append += "<tr><td colspan='4'><input type='submit' value='확인'/></td></tr>";
                                document.getElementById('schedule_table').innerHTML = append;
                                }
                        }
                    }
                    http.open('GET', 'view_doctor_schedule.php?q='+doc_id+'&date='+date, true);
                    http.send();
                } else if (radio == 'update') {
                    var http = new XMLHttpRequest();
                    http.onreadystatechange = function() {
                        if (http.readyState == 4 && http.status == 200) {
                            var data = JSON.parse(http.responseText);
                            var append = "<tr><th>시간</th><th>스케줄<br/>등록여부</th></tr>";
                            var time_array = new Array();
                            var j=0;
                            for(var i=9; i<18; i++) {
                                if (i < 10) {
                                    time_array[j] = "0"+i+":00:00";
                                    time_array[j+1] = "0"+i+":30:00";
                                } else {
                                    time_array[j] = i+":00:00";
                                    time_array[j+1] = i+":30:00";
                                } j = j+2;
                            }
                            if (data.count == 0 && isValidDate(date)) {
                                for(var i=0; i<time_array.length; i++) {
                                        append += "<tr><td><input type='time' value='"+time_array[i]+"' readonly/></td>"+
                                        "<td><input type='checkbox' name='insert_schedule[]' value='"+time_array[i]+"'/></td></tr>";
                                }
                                append += "<tr><td colspan='4'><input type='submit' value='확인'/></td></tr>";
                                document.getElementById('schedule_table').innerHTML = append;
                                document.getElementById('schedule_msg').innerHTML = " ";
                            } else if (data.count > 0 && isValidDate(date)){
                                var printed = false;
                                for(var i=0; i<time_array.length; i++) {
                                    for(var j=0; j<data.count; j++) {
                                        if (time_array[i] == data[j].시간) {
                                            append += "<tr><td><input type='time' value='"+time_array[i]+"' readonly/></td>"+
                                            "<td><input type='checkbox' checked='checked' readonly/></td></tr>";
                                            printed = true;
                                        }
                                    }
                                    if (printed) {
                                        printed = false;
                                    } else {
                                        append += "<tr><td><input type='time' value='"+time_array[i]+"' readonly/></td>"+
                                        "<td><input type='checkbox' name='insert_schedule[]' value='"+time_array[i]+"'/></td></tr>";
                                    }
                                }
                                append += "<tr><td colspan='4'><input type='submit' value='확인'/></td></tr>";
                                document.getElementById('schedule_table').innerHTML = append;
                                document.getElementById('schedule_msg').innerHTML = " ";
                            } else {
                                document.getElementById('schedule_msg').innerHTML = "스케줄 설정이 불가능합니다.";
                                document.getElementById('schedule_table').innerHTML = " ";
                            }
                        }
                    }
                    http.open('GET', 'view_doctor_schedule.php?q='+doc_id+'&date='+date, true);
                    http.send();
                }
            }
        }
	function mediDelete(num) {
            var Num = num;
            var result;
            result = confirm("정말로 탈퇴하시겠습니까?");
                if (Num ==1) {
                    if (result) {
                        location.href="delete_patient.php?member_code=<? $member_code ?>";
                    }else{
                        self.location.replace('mypage_index.php');
                    }
                }else{
                     if (result) {
                        location.href="delete_hospital.php?hospital_code=<? $hospital_code ?>";
                    }else{
                        self.location.replace('mypage_index.php');
                    }
                }
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

    <div id='view_schedule'>
	<img src="../img/nav6.jpg" width="120" height="50" border="0" alt="">
        <p>스케줄 수정은 <b><u>오전 9시</u></b>를 기준으로 <b><u>이틀뒤~열흘뒤</u></b> 까지 가능합니다.<br/>
        <b><u>세 가지 모두 입력</b></u>해야 결과가 표시됩니다!</p>
        <form action='edit_schedule.php' method='post'>
            <table border="1" align="center" cellspacing="0" cellpadding="5">
                <tr bgcolor="#BOD6FB">
                    <td>의사 - 과목</td><td>날짜</td><td></td>
                    
                </tr>
            <tr>
				<td><select id='doctor' name='doctor' onChange='made_doctor_schedule()'>
					<option value='-' selected='selected'>-</option>
				<?
					for($i=0; $i<$doc_count; $i++) {
						echo "<option value='".$doc_data[$i]['의사코드']."'>".$doc_data[$i]['의사이름']." - ".$doc_data[$i]['과목이름']."</option>";
					}
				?> 
				</select></td>
				<td><input type='date' id='schedule_date' name='schedule_date' onChange='made_doctor_schedule()'/></td>
				<td>
					<input type='radio' name='select_schedule' value='view' onclick='made_doctor_schedule()' checked='checked'/>스케줄 보기<br/>
					<input type='radio' name='select_schedule' value='update' onclick='made_doctor_schedule()'/>스케줄 업데이트
					<span id='check_date'></span></td>
			</tr>
            </table><br/>
            <span id='schedule_msg'></span>
            <table id='schedule_table' align="center"></table>
        </form>
		</div>
	</div>
</body>
</html>
