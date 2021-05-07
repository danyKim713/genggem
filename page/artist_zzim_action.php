<?php 
//$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strRecordNo     = $_POST['txtRecordNo'];   // 코치 ID


if (trim($strRecordNo) == "") {
    echo "FAIL@잘못된 접근입니다. 관리자에게 문의하세요."; 
    exit;
}



// 아티스트정보 가져오기
$query  = " SELECT A.co_id, A.member_id, B.UID   \n";
$query .= " FROM   tbl_coach A, tbl_member B    \n";
$query .= " WHERE  A.co_id = '{$strRecordNo}'   \n";    
$query .= " AND    A.member_id = B.member_id   \n";    
$result = db_query($query); 
$nCount = mysqli_num_rows($result);
$rowArtist = db_select($query); 

if ($nCount <= 0) {
    echo "FAIL@잘못된 접근입니다. 관리자에게 문의하세요."; 
    exit;
}

// 나의 찜정보 가져오기
$query  = " SELECT COUNT(cz_id) AS cnt   \n";
$query .= " FROM   tbl_coach_zzim    \n";
$query .= " WHERE  co_id = '{$strRecordNo}'  \n";
$query .= " AND    isrt_user = '{$rowMember["member_id"]}'  \n";

$rowZZim = db_select($query); 

if ($rowZZim["cnt"] <= 0) {
    $query  = " INSERT INTO tbl_coach_zzim SET  \n";
    $query .= "        co_id        = '{$strRecordNo}',  \n";
    $query .= "        co_member_id = '{$rowArtist["member_id"]}',  \n";
    $query .= "        co_uid       = '{$rowArtist["UID"]}',  \n";
    $query .= "        isrt_user    = '{$rowMember["member_id"]}',  \n";
    $query .= "        isrt_dt      = NOW()  \n";
    $result = db_query($query);

    if ($result) {
        echo "SUCCESSI@";
    }
} else {
    $query  = " DELETE FROM tbl_coach_zzim   \n";
	$query .= " WHERE  co_id = '{$strRecordNo}'  \n";
	$query .= " AND    isrt_user = '{$rowMember["member_id"]}'  \n";
    $result = db_query($query);

    if ($result) {
        echo "SUCCESSD@";
    }

}

?>

