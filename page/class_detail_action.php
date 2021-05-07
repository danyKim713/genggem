<?php 
$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strRecordNo     = $_POST['txtRecordNo'];   // 레슨 ID


if (trim($strRecordNo) == "") {
    echo "FAIL@잘못된 접근입니다. 관리자에게 문의하세요."; 
    exit;
}

// 레슨정보 가져오기
$query  = " SELECT COUNT(l_id) AS cnt   \n";
$query .= " FROM   tbl_lesson    \n";
$query .= " WHERE  l_id='{$strRecordNo}'   \n";  
$rowLesson = db_select($query); 

if ($rowLesson["cnt"] <= 0) {
    echo "FAIL@잘못된 접근입니다. 관리자에게 문의하세요."; 
    exit;
}


// 전체 찜정보 가져오기
$query  = " SELECT COUNT(lz_id) AS cnt   \n";
$query .= " FROM   tbl_lesson_zzim    \n";
$query .= " WHERE  l_id = '{$strRecordNo}'  \n";
$rowTotalZZim = db_select($query); 


// 나의 찜정보 가져오기
$query  = " SELECT COUNT(lz_id) AS cnt   \n";
$query .= " FROM   tbl_lesson_zzim    \n";
$query .= " WHERE  l_id = '{$strRecordNo}'  \n";
$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";

$rowZZim = db_select($query); 

if ($rowZZim["cnt"] <= 0) {
    $query  = " INSERT INTO tbl_lesson_zzim SET  \n";
    $query .= "        l_id       = '{$strRecordNo}',  \n";
    $query .= "        member_id  = '{$rowMember["member_id"]}',  \n";
    $query .= "        member_uid = '{$rowMember["UID"]}',  \n";
    $query .= "        isrt_dt    = NOW()  \n";
    $result = db_query($query);

    if ($result) {
        echo "SUCCESSI@".($rowTotalZZim["cnt"]+1);
    }

} else {
    $query  = " DELETE FROM tbl_lesson_zzim   \n";
    $query .= " WHERE  l_id = '{$strRecordNo}'  \n";
    $query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";
    $result = db_query($query);

    if ($result) {
        echo "SUCCESSD@".($rowTotalZZim["cnt"]-1);
    }

}

?>

