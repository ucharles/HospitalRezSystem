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
		 function validchk(){
            if(document.f.id.value=="")
            {
                alert("아이디를 입력하지 않았습니다.")
                document.f.id.focus()
                return
            }
            //아이디 유효성 검사 (영문소문자, 숫자만 허용)
           for (i=0;i<document.f.id.value.length ;i++ )
            {
                ch=document.f.id.value.charAt(i)
                if (!(ch>='0' && ch<='9') && !(ch>='a' && ch<='z'))
                {
                    alert ("아이디는 소문자, 숫자만 입력가능합니다.")
                    document.f.id.focus()
                    document.f.id.select()
                    return
                }
            }
            //아이디에 공백 사용하지 않기
            if (document.f.id.value.indexOf(" ")>=0)
            {
             alert("아이디에 공백을 사용할 수 없습니다.")
             document.f.id.focus()
             document.f.id.select()
             return
            }
            
            //아이디 길이 체크 (6~12자)
            if (document.f.id.value.length<6 || document.f.id.value.length>12)
            {
                alert ("아이디를 6~12자까지 입력해주세요.")
               document.f.id.focus()
               document.f.id.select()
               return
            }
    
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
            }
            //사업자,요양기관번호
             if(document.f.bnum1.value=="" || document.f.bnum2.value=="" || document.f.bnum3.value=="")
            {
                alert("사업자번호를 입력하지 않았습니다.")
                document.f.bnum1.focus()
                return
            }
              if(document.f.onum.value=="")
            {
                alert("요양기관번호를 입력하지 않았습니다.")
                document.f.onum.focus()
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
            if(document.f.phone.value=="" || document.f.phone2.value=="" || document.f.phone3.value=="")
            {
                alert("전화번호를 입력하지 않았습니다.")
                document.f.phone.focus()
                return
            }
            //이메일
            if(document.f.email.value=="" || document.f.email2.value=="")
            {
                alert("이메일을 입력하지 않았습니다.")
                document.f.email.focus()
                return
            }
            document.f.submit()
        }

        function chkID() {
            if(document.f.id.value=="")
            {
                alert("아이디를 입력하지 않았습니다.")
                document.f.id.focus()
                return
            }else{
                var userid = document.getElementById("id").value
                window.open('id_check.php?userid='+userid,'','width=300,height=130');
            }
        }
        function validBNum() {
            var bnum1 = document.getElementById("bnum1").value;
            var bnum2 = document.getElementById("bnum2").value;
            var bnum3 = document.getElementById("bnum3").value;
            
            if(bnum1 == "" || bnum2 == "" || bnum3 == "") {
                alert("사업자번호를 입력해주세요");
            }
            else{
             window.open('bnum_check_hospital.php?bnum1='+bnum1+'&bnum2='+bnum2+'&bnum3='+bnum3,'','width=300,height=130');
            }
        }
        function validONum() {
            var onum = document.getElementById("onum").value;
            
            if (onum == "") {
                alert("요양기관번호를 입력해주세요");
            }else{
                window.open('onum_check_hospital.php?onum='+onum,'','width=300,height=130');
            }
        }
        function search_zipcode() {
            window.open('insert_zipcode.html', 'search_zip', 'width=500, height=400');
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
            <a href="choice.php">회원가입</a>
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
		<a href ="JOIN.html"><img border="0"  src="../img/me.jpg" width="120" height="80"  alt="예약조회" onmouseover="this.src='../img/me2.jpg'" onmouseout="this.src='../img/me.jpg'"	style="borer:0 solid"></a>
		<br><br><br>

		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		
		<img src="../img/info.jpg" width="150" height="60" alt="welcome/">

		</div>

	<div id="main_content">
<!--MAIN-->
    <form name="f" action="insert_hospital.php" method="post" name="zipform" >
	<img src="../img/nav9.jpg" width="120" height="50" border="0" alt=""><br><br>
        <table border="1" cellspacing="0" cellpadding="3" align="center">
        <tr><td bgcolor="#BOD6FB">아이디</td>
			<td colspan="2" align="left"><input type="text" id="id" name="id" >
        <input type="button" id="idcheck" name="idcheck" value="중복확인" onClick="chkID()"></td>
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
		    <td colspan="2" align="left"><input type="text" name="name"/></td>
		</tr>
        
        <tr>
            <td bgcolor="#BOD6FB">사업자번호</td>
            <td colspan="2">
                <input type="text" id="bnum1" name="bnum1" size="3" maxlength="3"/> -
                <input type="text" id="bnum2" name="bnum2" size="2" maxlength="2"/> -
                <input type="text" id="bnum3" name="bnum3" size="5" maxlength="5"/>
                <input type="button" id="bnumcheck" name="bnumcheck" value="중복확인" onClick="validBNum()">
            </td>
        </tr>
        
        <tr>
            <td bgcolor="#BOD6FB">요양기관번호</td>
            <td colspan="2" align="left">
                <input type="text" id="onum" name="onum" size="6" maxlength="10"/>
                <input type="button" id="onumcheck" name="onumcheck" value="중복확인" onClick="validONum()"/>
            </td>
        </tr>
        
        <tr>
            <td rowspan='3' bgcolor="#BOD6FB">주소</td>
            <td colspan="2" align="left">
                <input type="text" id="zip1" name="zip1" size="3" readonly onclick="search_zipcode()"/> -
                <input type="text" id="zip2" name="zip2" size="3" readonly onclick="search_zipcode()"/>
                <input type="button" value="우편번호 검색" onclick="search_zipcode()">
            </td>
        </tr>
        <tr><td colspan="3" align="left"><input type="text" id="address" name="address" readonly size="35"/></td></tr>
        <tr><td colspan="3" align="left"><input type="text" id="add2" name="add2" size="35"/></td></tr>
        
        <tr><td bgcolor="#BOD6FB">병원전화번호</td>
		<td colspan="2" align="left">
        <select name="phone">
            <option value="010">010</option>
            <option value="011">011</option>
            <option value="016">016</option>
            <option value="017">017</option>
            <option value="018">018</option>
            <option value="019">019</option>
            <option value="02">02</option>
            <option value="032">032</option>
            <option value="042">042</option>
            <option value="062">062</option>
            <option value="051">051</option>
            <option value="052">052</option>
            <option value="031">031</option>
            <option value="033">033</option>
            <option value="041">041</option>
            <option value="043">043</option>
            <option value="061">061</option>
            <option value="063">063</option>
            <option value="055">055</option>
            <option value="054">054</option>
            <option value="064">064</option>
        </select> - 
        <input type="text" size="4" id="phone2" name="phone2" maxlength="4"/> - <input type="text" id="phone3" name="phone3" size="4" maxlength="5"/></td></tr>
       
        <tr>
            <td bgcolor="#BOD6FB">병원e-mail</td>
            <td colspan='3' align="left">
                <input type="text" id="email" name="email" size="10"/> @
                <!--
                <select id="email2" name="email2" onchange="javascript:if (this.value=='etc'){div_email.style.display=''; div_email.focus();}else{div_email.style.display='none'}">
                    <option value="naver.com">naver.com</option>
                    <option value="daum.net">daum.net</option>
                    <option value="nate.com">nate.com</option>
                    <option value="gmail.com">gmail.com</option>
                    <option value="etc">직접입력</option>
                </select>
                <input id="div_email" name="email2" size="20" value="" style="border:1px solid;border-color:#cecfce;font-size:9pt;color:#042330;background-color:white;height:20px;position:ralative;z-index:1;display:none;ime-mode:inactive;" />
                -->
                <input type="text" id="email2" name="email2" size="10"/>
            </td>
        </tr>
        
        <tr><td bgcolor="#BOD6FB">병원정보</td><td colspan="3" align="left"><textarea name="info" row="5" cols="30"></textarea></tr>
        
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