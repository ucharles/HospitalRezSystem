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
        $res_id = $_GET['q'];
        require_once('../database/db_connect.php');
        
        $query = "select * from 예약 where 예약번호='".$res_id."';";
        $result = mysql_query($query) or die(mysql_error());
        $data = mysql_fetch_assoc($result);
    } else {
        echo "<script language='JavaScript'> alert('권한이 없습니다.'); self.location.replace('../index.php');</script>";
    }
?>
<!DOCTYPE html>

<html>
<head>
    <title>진찰기록 작성하기 - MJMEDI</title>
</head>

<body>
    <form action='write_docnote_db.php' method='post'>
        <input type='text' name='res_id' value='<?echo $data['예약번호'];?>' style='display: none;'/>
        <label><h3>진찰기록 작성</h3></label>
        <table>
            <tr><td>의사</td><td><?echo $data['의사이름'];?></td></tr>
            <tr><td>과목</td><td><?echo $data['과목이름'];?></td></tr>
            <tr><td>일시</td><td><?echo $data['예약날짜'];?> <?echo $data['예약시간'];?></td></tr>
            <tr><td>환자명</td><td><?echo $data['회원이름'];?></td></tr>
        </table>
    <?if($data['진찰기록'] == ""){?>
        <textarea name='docnote' style='width: 100%; height: 150px;'></textarea>
    <?}else{?>
        <textarea name='docnote' style='width: 100%; height: 150px;'><?echo $data['진찰기록'];?></textarea>
    <?}?>
        <input type='submit' value='작성완료'/>
    </form>
</body>
</html>

