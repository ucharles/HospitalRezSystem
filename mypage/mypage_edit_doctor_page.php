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
        if($_GET['q'] == 'update') {
            $edit = $_GET['q']; // update
            $doc_id = $_GET['doc'];
            
            $query = "select 의사.*, 과목.과목이름 from 의사 inner join 과목 on 과목.과목코드 = 의사.과목코드 where 의사.의사코드='".$doc_id."';";
            $result = mysql_query($query) or die(mysql_error());
            $doc_info = mysql_fetch_assoc($result);
        } else {
            $edit = $_GET['q']; // insert
        }
        $subject = array();
        $query = "select * from 과목;";
        $result = mysql_query($query) or die(mysql_error());
        $subject_count = mysql_num_rows($result);
        while($row = mysql_fetch_assoc($result)) {
            $subject[] = $row;   
        }
    } else {
        echo "<script language='JavaScript'>alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>

<!DOCTYPE html>

<html>

<head>
  <title> Mypage-의사등록/수정 </title>
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
				<li> <a href="../search/search_page.php"><font color ="black">병원 검색</font></a></li>
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

    <?if($edit == "insert"){?>
    <div id='insert_form'>
    <form action='insert_doctor.php' method='post'>
        <input type='text' name='edit' value='insert' style="display: none;"/>
        <table border="1" align="center" cellspacing="0" cellpadding="7">
		<img src="../img/nav7.jpg" width="120" height="50" border="0" alt=""><br><br>
            <tr><td class="title"  bgcolor="#BOD6FB">병원명</td><td><?echo $hospital_name?></td></tr>
            <tr><td class="title"  bgcolor="#BOD6FB">의사명</td><td><input type='text' id='doc_name' name='doc_name'/></td></tr>
            <tr>
                <td class="title"  bgcolor="#BOD6FB">진료과목</td>
                <td><select id='doc_sub' name='doc_sub'>
                <option value='-' selected='selected'>-</option>
                <?
                for($i=0; $i<$subject_count; $i++) {
                    echo "<option value='".$subject[$i]['과목코드']."'>".$subject[$i]['과목이름']."</option>";
                }
                ?>
                </select></td>
            </tr>
            <tr><td class="title"  bgcolor="#BOD6FB">의사정보</td><td><textarea id='doc_info' name='doc_info' style='width:200px; height: 80px;'></textarea></td></tr>
            <tr><td class="title" colspan='2'><input type='submit' value='수정하기'/><br/></td></tr>
        </table>
    </form>
    </div>
    <?}else{?>
    <div id='update_form'>
    <form action='insert_doctor.php' method='post'>
        <input type='text' name='edit' value='update' style="display: none;"/>
        <input type='text' name='doc_id' style="display: none;" <?echo "value='".$doc_info['의사코드']."'";?> />
        <table border="1" align="center" cellspacing="0" cellpadding="7">
		<img src="../img/nav5.jpg" width="120" height="50" border="0" alt=""><br><br>
            <tr><td class="title" bgcolor="#BOD6FB">병원명</td><td><?echo $hospital_name?></td></tr>
            <tr ><td class="title" bgcolor="#BOD6FB">의사명</td><td><input type='text' id='doc_name' name='doc_name' <?echo "value='".$doc_info['의사이름']."'";?> /></td></tr>
            <tr>
                <td class="title" bgcolor="#BOD6FB">진료과목</td>
                <td><select id='doc_sub' name='doc_sub'>
                <?
                for($i=0; $i<$subject_count; $i++) {
                    if($subject[$i]['과목이름'] == $doc_info['과목이름']) {
                        echo "<option value='".$subject[$i]['과목코드']."' selected='selected'>".$subject[$i]['과목이름']."</option>";
                    } else {
                        echo "<option value='".$subject[$i]['과목코드']."'>".$subject[$i]['과목이름']."</option>";
                    }
                }
                ?>
                </select></td>
            </tr>
            <tr><td class="title" bgcolor="#BOD6FB">의사정보</td><td><textarea id='doc_info' name='doc_info' style='width:200px; height: 80px;'><?echo $doc_info['의사정보'];?></textarea></td></tr>
            <tr><td class="title" colspan='2'><input type='submit' value='수정하기'/><br/></td></tr>
        </table>
        
			</form>
		</div>
		<?}?>
	</div>
</body>
</html>
