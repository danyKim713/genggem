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
$strRecordNo = $_POST['txtRecordNo'];  // 리뷰ID


if (trim($strAction) == "REVIEWGOOD") {  // '리뷰 좋아요' 버튼 클릭시

    //  좋아요 가져오기
    $query  = " SELECT COUNT(lr_id) AS cnt   \n";
    $query .= " FROM   tbl_lesson_review_appraisal  \n";
    $query .= " WHERE  lr_id='{$strRecordNo}'   \n"; 
    $query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";

    $rowAppraisal = db_select($query); 

    if ($rowAppraisal["cnt"] > 0) {  // 좋아요 이면 삭제
        $query  = " DELETE FROM tbl_lesson_review_appraisal   \n";
        $query .= " WHERE  lr_id     = '{$strRecordNo}'  \n";   // 리뷰 ID
        $query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";  // 회원 ID

        $result = db_query($query);

        if ($result) {
            echo "SUCCESSD";
        } 
    } else  {  // 좋아요 아니면 등록
        // 리뷰 정보 가져오기
        $query  = " SELECT *  \n";
        $query .= " FROM   tbl_lesson_review   \n";
        $query .= " WHERE  lr_id='{$strRecordNo}'   \n"; 

        $rowReview = db_select($query); 

        $query  = " INSERT INTO tbl_lesson_review_appraisal SET  \n";
        $query .= "        lr_id         = '{$strRecordNo}',  \n";   // 리뷰 ID
        $query .= "        l_id          = '{$rowReview["l_id"]}',  \n";  // 레슨 ID
        $query .= "        member_id = '{$rowMember["member_id"]}',  \n";  // 회원 ID
        $query .= "        isrt_dt       = NOW()  \n";
        $result = db_query($query);

        if ($result) {
            echo "SUCCESSI";
        } 
    }
} else if (trim($strAction) == "REVIEWDEL") {  // 리뷰 삭제 버튼 클릭시
	$query  = " SELECT *  \n";
	$query .= " FROM   tbl_lesson_review_img   \n";
	$query .= " WHERE  lr_id = '{$strRecordNo}' ";

	$resultImg = db_query($query); 

    while ($rowImg = mysql_fetch_array($resultImg)) {
        // 첨부된 이미지 삭제
        if (trim($rowImg['img']) != "" && is_file($uploadDirectory_ABS."/LessonReview/".trim($rowImg['img']))) { 
            @unlink($uploadDirectory_ABS."/LessonReview/".$rowImg['img']);     
        }
    }

	// 리뷰 삭제
	$query  = " DELETE FROM tbl_lesson_review   \n";
	$query .= " WHERE  lr_id = '{$strRecordNo}'   \n";    
	$result = db_query($query);

	// 리뷰가 글 삭제되었다면
	if ($result) {
		// 현재 리뷰에 해당하는 리뷰평가 삭제
		$query  = " DELETE FROM tbl_lesson_review_appraisal   \n";
		$query .= " WHERE  lr_id = '{$strRecordNo}'   \n";    
		$result_A = db_query($query);


		// 현재 리뷰댓글 삭제
		$query  = " DELETE FROM tbl_lesson_review_comment   \n";
		$query .= " WHERE  lr_id = '{$strRecordNo}'   \n";    
		$result_C = db_query($query);

		// 현재 리뷰댓글에 해당하는 리뷰평가 삭제
		$query  = " DELETE FROM tbl_lesson_review_comment_appraisal   \n";
		$query .= " WHERE  lr_id = '{$strRecordNo}'   \n";    
		$result_CA = db_query($query);


		// 현재 리뷰에에 해당하는 이미지정보 삭제
		$query  = " DELETE FROM tbl_lesson_review_img   \n";
		$query .= " WHERE  lr_id = '{$strRecordNo}'   \n";    
		$result_C = db_query($query);

         echo "SUCCESS";
	} else {
         echo "리뷰 삭제가 실패했습니다. 관리자에게 문의하세요.";
	}
}


?>
