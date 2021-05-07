<?php 
$NO_LOGIN = true;
include "./inc_program.php";

include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strRecordNo = trim($_POST['txtRecordNo']);    
$strContents = trim($_POST['txtContents']);    
$strImg      = $_FILES["txtImg"];      

$query  = " SELECT co_id, member_id   \n";
$query .= " FROM   tbl_coach \n";
$query .= " WHERE  co_id = '{$strRecordNo}'   \n";    

$resultCoach = db_query($query); 

if (!$resultCoach) {
    echo("잘못된 정보입니다.");
    exit;
} 

$rowCoach = mysqli_fetch_array($resultCoach);

if (trim($strContents) == "") {
    echo "내용을 입력하세요."; 
    exit;
}

//$strDT = date("Y-m-d");

$strGetImg = "";
if ($strImg[tmp_name] != "") {
    $strGetImg = $clsLib->fnGeneralUploadImg_Thumb($strImg, "LessonQuestion/".trim($rowCoach['co_id']), CONST_UPLOAD_FILESIZE_IMG, 700, 10);
}

$query  = " INSERT INTO tbl_lesson_question SET  \n";
$query .= "        coach_id   = '{$rowCoach["member_id"]}',  \n";
$query .= "        member_id  = '{$rowMember["member_id"]}',  \n";
$query .= "        member_uid = '{$rowMember["UID"]}',  \n";
$query .= "        q_memo     = '{$strContents}',  \n";
if ($strGetImg != "") { 
    $query .= "        q_img      = '{$strGetImg}',  \n";
}
$query .= "        isrt_dt       = NOW(),  \n";
$query .= "        updt_dt       = NOW()  \n";
$result = db_query($query);

if ($result) {
    echo "SUCCESS";
} else {
    echo "FAILED";
}

?>

