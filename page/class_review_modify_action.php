<?php 
$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();


$strRecordNo = $_POST['txtRecordNo'];  // 레슨ID
$nStarRate    = $_POST['txtStarRate'];  // 별점
$strReview    = $_POST['txtReview'];  // 레슨후기
$strImg        = $_FILES["txtImg"];       // 후기 이미지

$query  = " UPDATE  tbl_lesson_review SET  \n";
$query .= "        star_score = '{$nStarRate}',  \n";   
$query .= "        review      = '{$strReview}',  \n";  
$query .= "        isrt_dt      = NOW()  \n";
$query .= " WHERE lr_id  = {$strRecordNo}  \n";

$clsDBAgent->strSQL = $query;
$oRs = $clsDBAgent->fnQuery();
$strNextKey = mysqli_insert_id($clsDBAgent->rsDBConn);

/*
//  이미지 업로드
$arrImg = $clsLib->fnGeneralUploadMultiImg($strImg, "LessonReview/{$strRecordNo}", CONST_UPLOAD_FILESIZE_IMG, CONST_SHOP_IMG_WIDTH, CONST_SHOP_IMG_HEIGHT);
$nImgCnt = COUNT($arrImg[0]);

//  이미지 원본 삭제 및 SQL 생성
$arrSQLImg = array();
for ($i=0; $i<$nImgCnt; $i++) {
    if ($arrImg[0][$i] != "") {
//        @unlink($uploadDirectory_ABS."LessonReview/{$strRecordNo}/".$arrImg[0][$i]);  // 원본이미지 삭제
//        $arrSQLImg[] = "('{$strNextKey}', '{$strRecordNo}', '{$strRecordNo}/".trim($arrImg[1][$i])."', '{$rowMember["member_id"]}', NOW()) ";
        $arrSQLImg[] = "('{$strNextKey}', '{$strRecordNo}', '{$strRecordNo}/".trim($arrImg[0][$i])."', '{$rowMember["member_id"]}', NOW()) ";
    }
}

// 상품 이미지 등록
$strSQLImg = implode(",", $arrSQLImg);

if (trim($strSQLImg) != "") {
    // 상품이미지 DB 등록
    $strSQL  = " INSERT INTO tbl_lesson_review_img (lr_id, l_id, img, isrt_user, isrt_dt) VALUES {$strSQLImg}; \n";
    $clsDBAgent->strSQL = $strSQL;
    $oRsImg = $clsDBAgent->fnQuery();
}
*/


if ($oRs) {
    echo "SUCCESS";
} else {
	 echo "리뷰수정이 실패했습니다. 관리자에게 문의하세요.";
}



?>
