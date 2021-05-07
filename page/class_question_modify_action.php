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

$query  = " SELECT A.lq_id, A.coach_id, A.member_id, A.member_uid, A.q_memo, A.q_img, A.isrt_dt, A.updt_dt, B.co_id   \n";
$query .= " FROM   tbl_lesson_question A, tbl_coach B    \n";
$query .= " WHERE  A.lq_id = '{$strRecordNo}' ";
$query .= " AND     A.member_id = B.member_id ";
$resultInfo = db_query($query); 

if (!$resultInfo) {
    echo("잘못된 정보입니다.");
    exit;
} 

$rowInfo = mysqli_fetch_array($resultInfo);

if (trim($strContents) == "") {
    echo "내용을 입력하세요."; 
    exit;
}

//$strDT = date("Y-m-d");

$strGetImg = "";
if ($strImg[tmp_name] != "") {
	// 기존이미지 삭제
	if (trim($rowInfo['q_img']) != "" && is_file($uploadDirectory_ABS."/LessonQuestion/".trim($rowInfo['co_id'])."/".$rowInfo['q_img'])) { 
		@unlink($uploadDirectory_ABS."/LessonQuestion/".trim($rowInfo['co_id'])."/".$rowInfo['q_img']);     
	}

    $strGetImg = $clsLib->fnGeneralUploadImg_Thumb($strImg, "LessonQuestion/".trim($rowInfo['co_id']), CONST_UPLOAD_FILESIZE_IMG, 700, 10);
}

$query  = " UPDATE tbl_lesson_question SET  \n";
$query .= "        q_memo     = '{$strContents}',  \n";
if ($strGetImg != "") { 
    $query .= "        q_img      = '{$strGetImg}',  \n";
}
$query .= "        updt_dt       = NOW()  \n";
$query .= " WHERE  lq_id = '{$strRecordNo}'  \n";

$result = db_query($query);

if ($result) {
    echo "SUCCESS";
} else {
    echo "FAILED";
}

?>

