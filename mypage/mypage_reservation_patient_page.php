<?php
    session_start();
    date_default_timezone_set("Asia/Seoul");
    header("Content-Type: text/html; charset=UTF-8");
    if (isset($_SESSION['member_code']) && isset($_SESSION['member_name'])) {
        $member_code = $_SESSION['member_code'];
        $member_name = $_SESSION['member_name'];
    } else if(isset($_SESSION['hospital_code']) && isset($_SESSION['hospital_name'])) {
        $hospital_code = $_SESSION['hospital_code'];
        $hospital_name = $_SESSION['hospital_name'];
    }
    require_once('../database/db_connect.php');
    
    if(isset($member_code) && isset($member_name)) {
        $query = "select * from 예약 where 회원코드='".$member_code."';";
        $result = mysql_query($query) or die(mysql_error());
        $count = mysql_num_rows($result);
        
        if($count > 0) {
            $data = array();
            while($row = mysql_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        function is_res_valid($date, $time) {
            $today = Date('Y-m-d H:i:s', time());
            $res_date = Date($date." ".$time);
            if ($res_date < $today) {
                return false;
            } else {
                return true;
            }
        }
    } else if(isset($hospital_code) && isset($hospital_name)) {
        echo "<script language='JavaScript'> alert('권한이 없습니다.'); self.location.replace('mypage_index.php');</script>";
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
		
		function view_docnote(id, res_num) {
            var http = new XMLHttpRequest();
            http.onreadystatechange = function() {
                if (http.readyState == 4) {
                    if (http.status == 200) {
                        var data = JSON.parse(http.responseText);
                        var append = "<td colspan='9'>진찰기록<br/>"+data.진찰기록+"</td><td><input type='button' value='닫기' onclick='close_docnote("+id+")'/></td>";
                        document.getElementById('note_'+id).innerHTML = append;
                    }
                }
            }
            http.open("GET", "made_docnote.php?q="+res_num, true);
            http.send();
        }
        function close_docnote(id) {
            document.getElementById('note_'+id).innerHTML = "";
        }
        function logout() {
            location.href="../login/logout.php";
        }
        function cancel_res(res_num) {
            location.href="mypage_reservation_cancel.php?q="+res_num;
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
		<a href="mypage_reservation_patient_page.php"><img border="0"src="../img/menures.jpg"  width="120" height="40" alt="예약목록" onmouseover="this.src='../img/menures11.jpg'" onmouseout="this.src='../img/menures.jpg'"     style="borer:0 solid"></a>
		<br><br>
		<img border="0" src="../img/menupat.jpg"  width="120" height="40"alt="회원정보" style="borer:0 solid">

		<a href ="update_patient_page.php"><img border="0"  src="../img/menupat1.jpg" width="120" height="40"  alt="회원정보수정" onmouseover="this.src='../img/menupat11.jpg'" onmouseout="this.src='../img/menupat1.jpg'"	style="borer:0 solid"></a>

		<a href ="delete_patient.php"><img border="0"  src="../img/menupat2.jpg" width="120" height="40"  alt="회원탈퇴" onmouseover="this.src='../img/menupat22.jpg'" onmouseout="this.src='../img/menupat2.jpg'"	style="borer:0 solid"></a>
		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->

		<br><br><br><br><br><br><br><br><br><br>
		
		<img src="../img/info.jpg" width="150" height="60" alt="welcome/">

		</div>

	<div id="main_content">
<!--MAIN-->
 
    <div id="patient_mypage">
        <?if($count == 0) {?>
            <p>예약 목록이 존재하지 않습니다.</p>
        <?}else{?>
            <table border='1' cellspacing="0" cellpadding="3" align="center">
			<tr>
				<td colspan="10"><img src="../img/nav3.jpg" width="120" height="50" border="0" alt="예약목록"></td>
			</tr>
            <tr bgcolor="#BOD6FB">
                <th>예약번호</th><th>진료날짜</th><th>진료시간</th><th>예약자</th><th>병원이름</th><th>과목이름</th><th>의사이름</th><th>예약상태</th><th>비고</th><th>진찰기록</th>
            </tr>
        <?
            for($i=0; $i<$count; $i++) {
                $data[$i]['화면시간'] = SUBSTR($data[$i]['예약시간'], 0,2) ."시 ". SUBSTR($data[$i]['예약시간'], 3,2) ."분";
                $state = $data[$i]['상태'];
                if($state == '1') {
                    $data[$i]['상태'] = '예약완료';
                } else if($state == '2') {
                    $data[$i]['상태'] = '예약취소';
                } else if($state == '3') {
                    $data[$i]['상태'] = '진료완료';
                } else if($state == '4') {
                    $data[$i]['상태'] = '예약불이행';
                }
                
                if($data[$i]['상태'] == '예약완료') {
                    if(!is_res_valid($data[$i]['예약날짜'], $data[$i]['예약시간'])){
                        echo "<tr class='expired'><td>".$data[$i]['예약번호']."</td><td>".$data[$i]['예약날짜']."</td><td>".$data[$i]['화면시간'].
                        "</td><td>".$data[$i]['회원이름']."</td><td><a href='../search/hospital_view.php?q=".$data[$i]['병원코드']."'>".$data[$i]['병원이름']."</a></td><td>".$data[$i]['과목이름'].
                        "</td><td>".$data[$i]['의사이름']."</td><td>".$data[$i]['상태']."</td><td>".
                        "</td><td></td></tr>";
                    } else {
                        echo "<tr><td>".$data[$i]['예약번호']."</td><td>".$data[$i]['예약날짜']."</td><td>".$data[$i]['화면시간'].
                        "</td><td>".$data[$i]['회원이름']."</td><td><a href='../search/hospital_view.php?q=".$data[$i]['병원코드']."'>".$data[$i]['병원이름']."</a></td><td>".$data[$i]['과목이름'].
                        "</td><td>".$data[$i]['의사이름']."</td><td>".$data[$i]['상태']."</td><td>".
                        "<input type='button' value='예약취소' onclick='cancel_res(".$data[$i]['예약번호'].")'>".
                        "</td><td></td></tr>";
                    }
                } else if($data[$i]['상태'] == '진료완료' && $data[$i]['진찰기록'] != "") {
                    echo "<tr><td>".$data[$i]['예약번호']."</td><td>".$data[$i]['예약날짜']."</td><td>".$data[$i]['화면시간'].
                        "</td><td>".$data[$i]['회원이름']."</td><td><a href='../search/hospital_view.php?q=".$data[$i]['병원코드']."'>".$data[$i]['병원이름']."</a></td><td>".$data[$i]['과목이름'].
                        "</td><td>".$data[$i]['의사이름']."</td><td>".$data[$i]['상태']."</td><td>".
                        "</td><td><input type='button' value='보기' onclick='view_docnote(".$i.", ".$data[$i]['예약번호'].")'/></td></tr>".
                        "<tr id='note_".$i."'></tr>";
                } else {
                    echo "<tr><td>".$data[$i]['예약번호']."</td><td>".$data[$i]['예약날짜']."</td><td>".$data[$i]['화면시간'].
                        "</td><td>".$data[$i]['회원이름']."</td><td><a href='../search/hospital_view.php?q=".$data[$i]['병원코드']."'>".$data[$i]['병원이름']."</a></td><td>".$data[$i]['과목이름'].
                        "</td><td>".$data[$i]['의사이름']."</td><td>".$data[$i]['상태']."</td><td>".
                        "</td><td></td></tr>";
                }
            }
        ?>
            </table>
        <?}?>
    </div>
</body>
</html>
