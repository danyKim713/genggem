<?
define('_INDEX_', true);

include "include_save_header.php";

$strName = $_POST["apply_name"];  // 신청자이름
$strTel = $_POST["apply_tel"];  // 전화번호
$strClass = $_POST["apply_class"];  // 수강강좌코드
$nClassCost = $_POST["class_cost"];  // 수강비용
$nYearCost = $_POST["year_cost"];  // 연회비
$strHanc =  $_POST["hanc"];   // 수강지부
$strMemo = $_POST["memo"];
$nTotalCost = $_POST["total_cost"];


// 로긴한 회원이 좋아요를 클릭한 내역 조회
$query = "select count(*) as cnt from tbl_lecture_like where fk_lecture = '{$pk_lecture}' and member_id = '".MyPassDecrypt($_COOKIE["ck_login_member_pk"])."'";
$resultCnt = db_query($query);
$rowCnt = db_fetch($resultCnt);


$좋아요수 = "@";



if ($rowCnt['cnt'] == 0) {  // 좋아요를 클릭한적이 없으면 좋아요 설정

	$query = "insert into tbl_lecture_like set ";
	$query .= "fk_lecture = '{$pk_lecture}',";
	$query .= "member_id = '".MyPassDecrypt($_COOKIE["ck_login_member_pk"])."'";
	$result = db_query($query);

	$query = "select count(*) as cnt from tbl_lecture_like where fk_lecture = '{$pk_lecture}'";
	
	$resultL = db_query($query);
	$rowL = db_fetch($resultL);
    $좋아요수 = "INSERT@".number_format($rowL['cnt']);

} else if ($rowCnt['cnt'] > 0) { // 좋아요를 클릭한 적이 있으면 좋아요수만 
    $좋아요수 = "DUP@";
} 

echo $좋아요수;

