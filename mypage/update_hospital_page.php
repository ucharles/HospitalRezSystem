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
        $sql = "SELECT * FROM 병원 WHERE 병원코드 = '" . $hospital_code . "';";
        $result = mysql_query($sql) or die (mysql_error());
        $row = mysql_fetch_array($result);
    } else {
	echo "<script>alert('권한이 없습니다.'); self.location.replace('../index.php')</script>";
    }
?>


<!DOCTYPE html>

<html>

<head>
  <title>병원정보수정 - MJMEDI</title>
    <meta charset="utf-8">
	<meta name="Generator" content="EditPlus">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">

	<link href="../accountCreate/joins.css" rel="stylesheet" type="text/css">
	
	<!--<script type="application/x-javascript">-->
	<script type="text/javascript">
	    function validchk(){
            //비밀번호 입력여부 체크
            if(document.f.pwd.value=="")
            {
             alert("비밀번호를 입력하지 않았습니다.")
             document.f.pwd.focus()
             return
            }
            
            //비밀번호 길이 체크(4~8자 까지 허용)
            if (document.f.pwd.value.length<4 || document.f.pwd.value.length>8)
            {
             alert ("비밀번호를 4~8자까지 입력해주세요.")
             document.f.pwd.focus()
             document.f.pwd.select()
             return
            }
            //비밀번호와 비밀번호 확인 일치여부 체크
            if (document.f.pwd.value!=document.f.pwd2.value)
            {
             alert("비밀번호가 일치하지 않습니다")
             document.f.pwd.value=""
             document.f.pwd2.value=""
             document.f.pwd.focus()
             return
            }
            //이름
             if(document.f.name.value=="")
            {
                alert("병원이름를 입력하지 않았습니다.")
                document.f.name.focus()
                return
            }            //주소
             if(document.f.zip1.value=="" || document.f.zip2.value=="" || document.f.address.value=="")
            {
                alert("주소를 입력하지 않았습니다.")
                document.f.zip1.focus()
                return
            }
            //폰번호
            if(document.f.phone.value=="")
            {
                alert("전화번호를 입력하지 않았습니다.")
                document.f.phone.focus()
                return
            }
            //이메일
            if(document.f.email.value=="")
            {
                alert("이메일을 입력하지 않았습니다.")
                document.f.email.focus()
                return
            }
            document.f.submit()
        }
        function search_zipcode() {
            window.open('../accountCreate/insert_zipcode.html', 'search_zip', 'width=500, height=400');
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
    <div id="message"><?echo "병원 [".$hospital_name."] 환영합니다.";?> <input type="button" value="Logout" onclick="logout()"/></div>

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
				<li> <a href="mypage_index.php"><font color ="black">My page</font></a></li>
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
    <form name="f" action="update_hospital.php" method="post" name="zipform" >
	<h3>회원정보수정 - 병원회원</h3>
        <table cellspacing="0" cellpadding="3" align="center">
        <tr><td bgcolor="#BOD6FB">아이디</td>
			<td colspan="2" align="left">
        <input type="text" id="id" name="id" readonly value="<?php print $row['병원id']; ?>" /></td>
		</tr>
        
        <tr>
            <td bgcolor="#BOD6FB">비밀번호</td>
            <td colspan="2" align="left"><input type="password" id="pwd" name="pwd"/></td>
        </tr>
        <tr>
            <td bgcolor="#BOD6FB">비밀번호 확인</td>
            <td align="left"><input type="password" id="pwd2" name="pwd2" onblur="validPwd()"/></td>
            <td><div id="mcpwd"></div></td>
        </tr>
        
        <tr><td bgcolor="#BOD6FB">병원이름</td>
		    <td colspan="2" align="left"><input type="text" name="name" value='<?php echo $row['병원이름'];?>'/></td>
		</tr>
        
        <tr>
            <td bgcolor="#BOD6FB">사업자번호</td>
            <td colspan="2" align='left'>
                <input type="text" id="bnum1" name="bnum1" size="3" maxlength="3" readonly value="<?php print substr($row['bnum'],0,3); ?>" /> -
                <input type="text" id="bnum2" name="bnum2" size="2" maxlength="2" readonly value="<?php print substr($row['bnum'],3,2); ?>" /> -
                <input type="text" id="bnum3" name="bnum3" size="5" maxlength="5" readonly value="<?php print substr($row['bnum'],5,5); ?>" />
            </td>
        </tr>
        
        <tr>
            <td bgcolor="#BOD6FB">요양기관번호</td>
            <td colspan="2" align="left">
                <input type="text" id="onum" name="onum" size="6" maxlength="10" readonly value="<?php print $row['onum']; ?>" />
            </td>
        </tr>
        
        <tr>
            <td rowspan='3' bgcolor="#BOD6FB">주소</td>
            <td colspan="2" align="left">
                <input type="text" id="zip1" name="zip1" size="3" readonly onclick="search_zipcode()" value="<?php print substr($row['병원우편번호'],0,3); ?>" /> -
                <input type="text" id="zip2" name="zip2" size="3" readonly onclick="search_zipcode()" value="<?php print substr($row['병원우편번호'],3,3); ?>" />
                <input type="button" value="우편번호 검색" onclick="search_zipcode()">
            </td>
        </tr>
        <tr><td align='left'><input type="text" id="address" name="address" readonly size="35" value='<?php print $row['병원주소'];?>'/></td></tr>
        <tr><td align='left'><input type="text" id="add2" name="add2" size="35" value='<?php print $row['병원상세주소'];?>'/></td></tr>
        
        <tr><td bgcolor="#BOD6FB">병원전화번호</td>
		<td colspan="2" align="left">
        <input type="text" id="phone" name="phone" maxlength="13" value="<?php print $row['병원전화번호']; ?>" />- 를 포함하여 입력해주세요.</td></tr>
       
        <tr>
            <td bgcolor="#BOD6FB">병원e-mail</td>
            <td colspan='3' align="left">
                <input type="text" id="email" name="email" size="30" value="<?php print $row['병원이메일']; ?>" />
            </td>
        </tr>
        
        <tr><td bgcolor="#BOD6FB">병원정보</td><td colspan="3" align="left"><textarea name="info" row="5" cols="30"><?php print $row['병원정보']; ?></textarea></tr>
        
		<tr>
			<td colspan=3 align=center>
				<A HREF="javascript:validchk()">[전송]</A>&nbsp;&nbsp;
				<A HREF="javascript:document.f.reset()">[취소]</A>
			</td>
	</tr>
        </table>
    </form>
	</div>
</body>
</html>