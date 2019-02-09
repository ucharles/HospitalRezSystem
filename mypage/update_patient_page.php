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
        require_once('../database/db_connect.php');
        $sql = "SELECT * FROM 환자 WHERE 회원코드 = '" . $member_code . "';";
        $result = mysql_query($sql) or die (mysql_error());
        $row = mysql_fetch_array($result);
    } else {
        echo "<script>alert('권한이 없습니다'); self.location.replace('../index.php');</script>";
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
	<style type="text/css">
	    ul {
		list-style: none;
	    }
	</style>
	
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
                alert("이름를 입력하지 않았습니다.")
                document.f.name.focus()
                return
            }
            //주소
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
		<div id="message"><?echo $member_name." 님 환영합니다."?> <input type="button" value="Logout" onclick="logout()"/></div>
	</div>
	<div id="header"><!--Header-->
		<div id="header_top">
			<div id="header_left">	
			<!--홈페이지의 메인 마크-->
				<a href='../index.php'><img src="../img/logo3.jpg" width="202" height="64" border="0" alt="Myong Gi Medical treatment reservation"></a>
			</div>
				<div id="header_right">
				</div>
			</div>
		<div id="navbar"> <!--Navbar-->
		<!--메뉴선택시 링크로 이동-->
			<ul>
				<li><a href="../index.php" class="seleced"><font color ="black">Home</font></a></li>
				<li><a href="../search/search_page.php"><font color ="black">병원 검색</font></a></li>
				<li><a href="../mypage/mypage_index.php"><font color ="black">My page</font></a></li>
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
    <form name="f" action="update_patient.php" method="post">
	<h3>회원정보수정 - 개인회원</h3>
        <table cellspacing="0" cellpadding="3" align="center">

        <tr>
            <td bgcolor="#BOD6FB">아이디</td>
            <td colspan="2" align="left">
                <input type="text" id="id" name="id" readonly value="<?php print $row['회원id']; ?>" />
            </td>
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
        
        <tr><td bgcolor="#BOD6FB">회원이름</td>
	    <td align='left'><input type="text" name="name" value="<?php print $row['회원이름'];?>" readonly/></td>
	</tr>
        
        <tr>
            <td rowspan='3' bgcolor="#BOD6FB">주소</td>
            <td colspan="2" align="left">
                <input type="text" id="zip1" name="zip1" size="3" readonly onclick="search_zipcode()" value="<?php print substr($row['회원우편번호'],0,3);?>" /> -
                <input type="text" id="zip2" name="zip2" size="3" readonly onclick="search_zipcode()" value="<?php print substr($row['회원우편번호'],3,3);?>" />
                <input type="button" value="우편번호 검색" onclick="search_zipcode()">
            </td>
        </tr>
        <tr><td><input type="text" id="address" name="address" readonly size="35" value="<?php print $row['회원주소']?>" /></td></tr>
        <tr><td><input type="text" id="add2" name="add2" size="35" value="<?php print $row['회원상세주소'];?>" /></td></tr>
        
        <tr><td bgcolor="#BOD6FB">전화번호</td>
		<td colspan="2" align='left'>
        <input type="text" name="phone" size="13" value="<?php print $row['회원전화번호'];?>" /></td></tr>
       
        <tr>
            <td bgcolor="#BOD6FB">e-mail</td>
            <td colspan=3 align='left'>
                <input type="text" name="email" size="30" value="<?php print $row['회원이메일'];?>" /> 
                <!--
         <select name="email2" onchange="javascript:if (this.value=='etc')
         {div_email.style.display='';div_email.focus();}else{div_email.style.display='none'}"> 
            <option value="naver.com">naver.com</option>
            <option value="daum.net">daum.net</option>
            <option value="nate.com">nate.com</option>
            <option value="gmail.com">gmail.com</option>
            <option value="etc">직접입력</option>
        </select>
        <input id="div_email" name="email2" size="20" value=""
            style="border:1px solid;border-color:#cecfce;font-size:9pt;color:#042330;background-color:white;height:20px;position:ralative;z-index:1;display:none;ime-mode:inactive;" />
        -->
            </td>
        </tr>
        <tr>
   <td colspan="3" align=center>
   <A HREF="javascript:validchk()">[전송]</A>&nbsp;&nbsp;
   <A HREF="javascript:document.f.reset()">[취소]</A>
   </td>
 </tr>
        </table>
    </form>
	</div>
</body>
</html>