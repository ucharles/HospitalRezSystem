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
  <title> Search-병원검색 </title>
    <meta charset="utf-8">
	<meta name="Generator" content="EditPlus">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">

	<link href="../accountCreate/joins.css" rel="stylesheet" type="text/css">
	
	<!--<script type="application/x-javascript">-->
	<script type="text/javascript">

       function selectSido() {
            var http = new XMLHttpRequest();
            http.onreadystatechange = function() {
                if (http.readyState == 4) {
                    if (http.status == 200) {
                        var data = JSON.parse(http.responseText);
                        var append = "<option name='select-default' selected>-</option>";
                        for(var i=0; i<data.count; i++) {
                            append += "<option id="+data[i].순서+">"+data[i].시도+"</option>";
                        }
                        document.getElementById('sido').innerHTML = append;
                    }
                }
            }
            http.open("GET", "select_sido.php", true);
            http.send();
        }
        
        function select_subject() {
            var http = new XMLHttpRequest();
            http.open("GET", "select_subject.php", true);
            http.onreadystatechange = function() {
                if (http.readyState == 4) {
                    if (http.status==200) {
                        var data = JSON.parse(http.responseText);
                        var append = "<option name='select-default' selected>-</option>";
                        for(var i=0; i<data.count; i++) {
                            append += "<option id="+data[i].과목코드+">"+data[i].과목이름+"</option>";
                        }
                        document.getElementById('subject').innerHTML = append;
                    }
                }
            }
            http.send();            
        }
        
        function sido_sel(sido) {
            var http = new XMLHttpRequest();
            http.open("GET", "select_gugun.php?q="+sido, true);
            http.onreadystatechange = function() {
                if (http.readyState == 4) {
                    if (http.status==200) {
                        var data = JSON.parse(http.responseText);
                        var append = "<option name='select-default' selected>-</option>";
                        for(var i=0; i<data.count; i++) {
                            append += "<option id="+data[i].순서+" value="+data[i].구군+">"+data[i].구군+"</option>";
                        }
                        document.getElementById('gugun').innerHTML = append;
                    }
                }
            }
            http.send();            
        }
        
        function isEmpty(str) {
            return (!str || 0 === str.length);
        }        
        
        function made_hospital_form() {
            var subject = document.getElementById('subject').options[document.getElementById('subject').options.selectedIndex].text;
            var sido = document.getElementById('sido').options[document.getElementById('sido').options.selectedIndex].text;
            var gugun = document.getElementById('gugun').options[document.getElementById('gugun').options.selectedIndex].text;
            var hospital_name = document.getElementById('hospital_name').value;
            
            if (subject == "-" && sido == "-" && gugun == "-" && isEmpty(hospital_name)) {  // 아무 정보도 입력되지 않은 경우
                document.getElementById('hospital_result').innerHTML = "검색할 내용을 입력해 주세요<br/>";
            } else {    // 하나 이상의 정보가 입력됨
                var http = new XMLHttpRequest();
                http.open("GET", "hospital_search.php?subject="+encodeURI(subject)+"&sido="+encodeURI(sido)+"&gugun="+encodeURI(gugun)+"&hospital_name="+encodeURI(hospital_name), true);
                //http.open("GET", "hospital_test.php?sido="+sido, true);
                http.onreadystatechange = function() {
                    if (http.readyState == 4) {
                        if (http.status==200) {
                            var data = JSON.parse(http.responseText);
                            var append = " ";
                            
                            if (data.hos_count == 0) {  // 검색 결과가 존재하지 않는 경우
                                document.getElementById('hospital_result').innerHTML = "조건에 맞는 병원이 존재하지 않습니다.<br/>";
                            } else {
                                if (data.sub_count == 0) {
                                    document.getElementById('hospital_result').innerHTML = "조건에 맞는 병원이 존재하지 않습니다.<br/>";
                                } else {
                                for(var i=0; i<data.hos_count; i++) {
                                    if (data[i].과목수 == 0) {
                                        continue;
                                    }
                                    //append += "<form action='reservation.php?q=" +data[i].병원코드+ "'>";
                                    append += "<table>";
                                <?if(isset($member_code) && isset($member_name)) {?>
                                    append += "<tr><td>병원명</td><td><a href='hospital_view.php?q="+data[i].병원코드+"'>"+data[i].병원이름+"</a></td><td><input type='button' onClick=\"window.location='../reservation/reservation.php?q="+data[i].병원코드+"'\" value='예약'/></td></tr>";
                                <?} else if(isset($hospital_code) && isset($hospital_name)){?>
                                    append += "<tr><td>병원명</td><td><a href='hospital_view.php?q="+data[i].병원코드+"'>"+data[i].병원이름+"</a></td><td><input type='button' value='병원은 예약불가'/></td></tr>";
                                <?} else {?>
                                    append += "<tr><td>병원명</td><td><a href='hospital_view.php?q="+data[i].병원코드+"'>"+data[i].병원이름+"</a></td><td><input type='button' value='로그인 후 예약가능'/></td></tr>";
                                <?}?>
                                    append += "<tr><td>주소</td><td colspan='2'>"+data[i].병원주소+" "+data[i].병원상세주소+"</td></tr>";
                                    append += "<tr><td>전화번호</td><td>"+data[i].병원전화번호+"</td></tr>";
                                    append += "<tr><td>진료과목</td><td>";
                                    for(var j=0; j<data[i].과목수; j++) {
                                        if (j == data[i].과목수 - 1) {
                                            append += data[i].과목[j].과목이름;
                                        } else {
                                            append += data[i].과목[j].과목이름+"/";
                                        }
                                    }
                                    append += "</td></tr>";
                                    append += "</table>";
                                    //append += "</form>";
                                    append += "<br/>";
                                }
                                document.getElementById('hospital_result').innerHTML = append;    
                                }
                            }
                        }
                    }
                }
                http.send();
            }
        }
        
        function test1() {
            var subject = document.getElementById('subject').options[document.getElementById('subject').options.selectedIndex].text;
            var sido = document.getElementById('sido').options[document.getElementById('sido').options.selectedIndex].text;
            var gugun = document.getElementById('gugun').options[document.getElementById('gugun').options.selectedIndex].text;
            var hospital_name = document.getElementById('hospital_name').value;
            alert(subject +" "+ sido +" "+ encodeURI(gugun) +" "+ encodeURI(hospital_name));
        }
        
        function logout() {
            location.href="../login/logout.php";
        }
        
        window.onload = function() {
            selectSido();
            select_subject();
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
				<li> <a href="search_page.php"><font color ="black">병원 검색</font></a></li>
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
	<form>       
		<table border="0"   align="center">
			<tr>
				<td colspan="3" align="left"><img src="../img/nav2.jpg" width="120" height="50" border="0" alt=""></td>
			</tr>
			<tr>
			<br>
                <td>과목</td><td>시도</td><td>구군</td><td>병원이름</td><td></td>
            </tr>
            <tr>
                    <td><select id="subject"></select></td>
                    <td><select id="sido" onChange="sido_sel(this.value)"></select></td>
                    <td><select id="gugun">
                        <option name='select-default' selected>-</option>
                    </select></td>                    
                    <td><input type="text" id="hospital_name"/></td>
                    <td><input type="button" value="검색" onClick="made_hospital_form()"/></td>
            </tr>
        </table>
        </form>
        <div id="hospital-page" align="center">
            <h3>검색 결과</h3>
            <div id="hospital_result"></div>
        </div>
	</div>
</body>
</html>
