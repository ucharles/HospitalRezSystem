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
        require_once('../database/db_connect.php');
        
        $query = "select 의사.*, 과목.과목이름 from 의사 inner join 과목 on 과목.과목코드 = 의사.과목코드 where 의사.병원코드='".$hospital_code."';";
        $result = mysql_query($query) or die(mysql_error());
        $count = mysql_num_rows($result);
        
        if($count > 0) {
            $data = array();
            while($row = mysql_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
    } else if(isset($member_code) && isset($member_name)) {
        echo "<script language='JavaScript'> alert('권한이 없습니다.'); self.location.replace('mypage_reservation_patient_page.php');</script>";
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
	    
	<style type="text/css">
	    .expired {
		color: red;
	    }
	</style>

	<link href="../accountCreate/joins.css" rel="stylesheet" type="text/css">
	
	<!--<script type="application/x-javascript">-->
	<script type="text/javascript">
		
 function is_res_valid(date, time) {
            var today = new Date();
            var res_date = new Date();
            res_date.setTime(Date.parse(date +' '+ time));
            if (res_date < today) {
                return false;
            } else {
                return true;
            }
        }
        function make_res_table() {
            var http = new XMLHttpRequest();
            var doc_id = document.getElementById('doc_sub').options[document.getElementById('doc_sub').options.selectedIndex].value;
            var date = document.getElementById('res_date').value;
            var state = document.getElementById('res_state').options[document.getElementById('res_state').options.selectedIndex].value;
            
            if (date == "") {date = "-";}
            
            http.onreadystatechange = function() {
                if (http.readyState == 4 && http.status == 200) {
                    var data = JSON.parse(http.responseText);
                    if (data.count == 0) {
                        document.getElementById('check_msg').innerHTML = "해당 예약 내역이 존재하지 않거나 열람기한이 지났습니다.";
                        document.getElementById('reservation_table').innerHTML = " ";
                    } else {
                        document.getElementById('check_msg').innerHTML = " ";
                        var append = "<tr><td>의사-과목</td><td>환자명</td><td>날짜</td><td>시간</td><td>상태</td><td>진찰기록</td><td>수정</td>"+
                        "<td><input type='submit' value='적용하기'/></td></tr>"
                        for(var i=0; i<data.count; i++) {
                            if (is_res_valid(data[i].예약날짜, data[i].예약시간) && data[i].화면상태 == "예약완료") { // 상태수정 가능. 진료기록 작성 불가능
                                append += "<tr><td>"+data[i].의사이름+" - "+data[i].과목이름+"</td><td>"+data[i].회원이름+"</td><td>"+data[i].예약날짜+"</td><td>"+data[i].화면시간+"</td><td>"+data[i].화면상태+"</td><td> </td>"+
                                "<td><input type='checkbox' onChange='view_state("+i+","+data[i].예약번호+")'/></td>"+
                                "<td id='edit_check_"+i+"'></td></tr>";
                            } else if (!is_res_valid(data[i].예약날짜, data[i].예약시간) && data[i].화면상태 == "예약완료") { // 만기된 예약. 상태수정 가능, 진료기록 작성 불가능.
                                append += "<tr class='expired'><td>"+data[i].의사이름+" - "+data[i].과목이름+"</td><td>"+data[i].회원이름+"</td><td>"+data[i].예약날짜+"</td><td>"+data[i].화면시간+"</td><td>"+data[i].화면상태+"</td><td> </td>"+
                                "<td><input type='checkbox' onChange='view_state("+i+","+data[i].예약번호+")'/></td>"+
                                "<td id='edit_check_"+i+"'></td></tr>";
                            } else if (data[i].화면상태 == "진료완료") { // 상태수정 불가, 진료기록 작성 가능.
                                append += "<tr><td>"+data[i].의사이름+" - "+data[i].과목이름+"</td><td>"+data[i].회원이름+"</td><td>"+data[i].예약날짜+"</td><td>"+data[i].화면시간+"</td><td>"+data[i].화면상태+"</td>";
                                if (data[i].진찰기록 == "") {
                                    append += "<td><input type='button' value='작성하기' onclick='write_docnote("+data[i].예약번호+")'</td>";
                                } else {
                                    append += "<td><input type='button' value='수정하기' onclick='write_docnote("+data[i].예약번호+")'</td>";
                                }
                                append +="</tr>";
                            } else { // 예약 불이행. 상태수정 불가, 진료기록 작성 불가.
                                append += "<tr><td>"+data[i].의사이름+" - "+data[i].과목이름+"</td><td>"+data[i].회원이름+"</td><td>"+data[i].예약날짜+"</td><td>"+data[i].화면시간+"</td><td>"+data[i].화면상태+"</td>";
                            }
                        }
                        document.getElementById('reservation_table').innerHTML = append;
                    }
                }
            }
            http.open("GET", "hos_res_management.php?q="+doc_id+"&date="+date+"&state="+state, true);
            http.send();
        }
        function view_state(row_id, res_id) {
            var append = "<select id='change_state' name='change_state[]'>"+
                            "<option value='"+res_id+"_1' selected='selected'>예약완료</option>"+
                            "<option value='"+res_id+"_3'>진료완료</option>"+
                            "<option value='"+res_id+"_4'>예약불이행</option>"+
                        "</select>";
            document.getElementById('edit_check_'+row_id).innerHTML = append;
        }
        function write_docnote(res_id) {
            // 새창으로 php 파일 오픈. 정보수정 후 있던 페이지 새로고침. ㅇㅋㅇㅋ
            window.open('write_docnote.php?q='+res_id,'','width=300,height=400');
            self.location.reload();
        }
        function logout() {
            location.href="../login/logout.php";
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

 <body onload='make_res_table()'>
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
		<br><br><br><br><br><br><br><br><br><br>
		
		<img src="../img/info.jpg" width="150" height="60" alt="welcome/">

		</div>

	<div id="main_content">
<!--MAIN-->
    <div id="hospital_mypage">
        <?if($count == 0) {?>
            <p>예약내역이 존재하지 않습니다.<br/>의사 스케줄이 등록되지 않으면 예약을 받을수 없으므로 확인해주세요!</p>
        <?}else{?>
        <table align="center">
            <tr><th>의사-과목</th><th>날짜</th><th>상태</th></tr>
            <tr>
            <td><select id='doc_sub' name='doc_sub' onChange='make_res_table()'>
                <option value='-' selected='selected'>-</option>
            <?
            if($count>0) {
                for($i=0; $i<$count; $i++) {
                    echo "<option value='".$data[$i]['의사코드']."'>".$data[$i]['의사이름']." - ".$data[$i]['과목이름']."</option>";
                }
            }
            ?>
            </select></td>
            <td><input type='date' id='res_date' onChange='make_res_table()'/></td>
            <td><select id='res_state' name='res_state' onChange='make_res_table()'>
                <option value='-' selected='selected'>-</option>
                <option value='1'>예약완료</option>
                <option value='3'>진료완료</option>
                <option value='4'>예약불이행</option>
            </select></td>
            <td></td>
            </tr>
        </table>
            <span id='check_msg'></span>
            <form action='update_reservation.php' method='post'>
            <table border='1' id='reservation_table' align="center"></table>
            </form>
        <?}?>
	 </div>
	</div>
</body>
</html>
