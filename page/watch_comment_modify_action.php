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
$strBigo     = trim($_POST['txtBigo']);

if ($strRecordNo == "") {
    echo "잘못된 접근입니다."; 
    exit;
}

if ($strBigo == "") {
    echo "댓글을 입력해주세요."; 
    exit;
}


$query  = " UPDATE tbl_watch_video_comment SET  \n";
$query .= "        comment = '{$strBigo}',  \n";
$query .= "        updt_dt = NOW()  \n";
$query .= " WHERE  wvc_id  = '{$strRecordNo}'  \n";

$result = db_query($query);

if ($result) {
    echo "SUCCESS";
} else {
    echo "댓글 수정이 실패했습니다.";
}

?>

