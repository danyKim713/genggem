<?php 
$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strAction   = $_POST['txtAction']; 
$strRecordNo = $_POST['txtRecordNo'];  // 레슨주문ID

// 레슨주문 유무 확인
$query  = " SELECT COUNT(lo_id) AS cnt   \n";
$query .= " FROM   tbl_lesson_order  \n";
$query .= " WHERE  lo_id='{$strRecordNo}'   \n"; 
$query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";

$rowInfo = db_select($query); 

if ($rowInfo["cnt"] <= 0) {  // 레슨주문이 존재하지 않으면
    echo "레슨신청정보가 존재하지 않습니다. 관리자에게 문의하세요";
	exit;
}

if ($strAction == "LESSONCANCELOK") {  // '레슨접수(결제대기)' 에서 '레슨취소요청' 할때  =>  '레슨취소완료'로 변경
	$query  = " UPDATE tbl_lesson_order SET   \n";
	$query .= "            status_flg  = 'LOSTACCM',  \n";    // 레슨취소완료로
	$query .= "            memo = CONCAT(memo, '\n', '>> ', NOW(), ' 레슨취소완료'),    \n";
	$query .= "            updt_dt = NOW()   \n";
	$query .= " WHERE  lo_id     = '{$strRecordNo}'  \n";   // 레슨주문 ID
	$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";  // 주문회원 ID

	$result = db_query($query);

	if ($result) {
		echo "SUCCESS";
	} else {
		echo "레슨취소요청이 실패했습니다. 관리자에게 문의하세요.";
	}

} else if ($strAction == "LESSONCANCELREQUEST") {  // '레슨결제완료' 에서 '레슨취소요청' 할때  =>  '레슨취소요청'로 변경

	$query  = " UPDATE tbl_lesson_order SET   \n";
	$query .= "            status_flg  = 'LOSTACAN',  \n";    // 레슨취소요청으로
	$query .= "            memo = CONCAT(memo, '\n', '>> ', NOW(), ' 레슨취소요청'),    \n";
	$query .= "            updt_dt = NOW()   \n";
	$query .= " WHERE  lo_id     = '{$strRecordNo}'  \n";   // 레슨주문 ID
	$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";  // 주문회원 ID

	$result = db_query($query);

	if ($result) {
		echo "SUCCESS";
	} else {
		echo "레슨취소요청이 실패했습니다. 관리자에게 문의하세요.";
	}

}


?>
