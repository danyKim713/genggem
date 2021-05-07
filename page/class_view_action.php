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
$strRecordNo = $_POST['txtRecordNo'];  // 문의글ID





if (trim($strAction) == "COACHZZIM") {  // '코치찜' 버튼 클릭시


    // 코치정보 가져오기 가져오기
    $query  = " SELECT A.co_id, A.member_id, B.UID   \n";
    $query .= " FROM   tbl_coach A, tbl_member B \n";
    $query .= " WHERE  A.co_id = '{$strRecordNo}'   \n";    
    $query .= " AND    A.use_flg = 'AD005001'   \n";    //  사용중인 코치만
    $query .= " AND    A.member_id = B.member_id   \n";

    $rowCoach = db_select($query); 

    // 찜정보 가져오기
    $query  = " SELECT COUNT(cz_id) AS cnt   \n";
    $query .= " FROM   tbl_coach_zzim   \n";
    $query .= " WHERE  co_id = '{$strRecordNo}'   \n";    // 코치아이디
    $query .= " AND    co_member_id = '{$rowCoach["member_id"]}'   \n";    // 코치(회원ID)
    $query .= " AND    isrt_user = '{$ck_login_member_pk}'   \n";     // 등록회원 ID

    $rowZZim = db_select($query); 



    if ($rowZZim["cnt"] > 0) {  // 좋아요 이면 삭제
        $query  = " DELETE FROM tbl_coach_zzim   \n";
        $query .= " WHERE  co_id = '{$strRecordNo}'   \n";    
        $query .= " AND    co_member_id = '{$rowCoach["member_id"]}'   \n";    
        $query .= " AND    isrt_user = '{$ck_login_member_pk}'   \n";    

        $result = db_query($query);

        if ($result) {
            echo "SUCCESSD";
        } 
    } else  {  // 좋아요 아니면 등록
        $query  = " INSERT INTO tbl_coach_zzim SET  \n";
        $query .= "        co_id     = '{$strRecordNo}',  \n";   // 영상등록자 ID
        $query .= "        co_member_id = '{$rowCoach["member_id"]}',  \n";  // 코치(회원 ID)
        $query .= "        co_uid  = '{$rowCoach["UID"]}',  \n";  // 코치 ID
        $query .= "        isrt_user = '{$ck_login_member_pk}',  \n";  // 등록회원 ID
        $query .= "        isrt_dt   = NOW()  \n";
        $result = db_query($query);

        if ($result) {
            echo "SUCCESSI";
        } 
    }

} else if (trim($strAction) == "QUESTIONDEL") {  // '문의글 삭제' 버튼 클릭시
	$query  = " SELECT A.lq_id, A.coach_id, A.member_id, A.member_uid, A.q_memo, A.q_img, A.isrt_dt, A.updt_dt, B.co_id   \n";
	$query .= " FROM   tbl_lesson_question A, tbl_coach B    \n";
	$query .= " WHERE  A.lq_id = '{$strRecordNo}' ";
	$query .= " AND     A.member_id = B.member_id ";
	$resultInfo = db_query($query); 

	// 첨부된 이미지 삭제
	if (trim($rowInfo['q_img']) != "" && is_file($uploadDirectory_ABS."/LessonQuestion/".trim($rowInfo['co_id'])."/".$rowInfo['q_img'])) { 
		@unlink($uploadDirectory_ABS."/LessonQuestion/".trim($rowInfo['co_id'])."/".$rowInfo['q_img']);     
	}

	// 문의글 삭제
	$query  = " DELETE FROM tbl_lesson_question   \n";
	$query .= " WHERE  lq_id = '{$strRecordNo}'   \n";    
	$result = db_query($query);

	// 문의 글 삭제되었다면
	if ($result) {
		// 현재 문의글에 해당하는 레슨문의평가테이블 삭제
		$query  = " DELETE FROM tbl_lesson_question_appraisal   \n";
		$query .= " WHERE  lq_id = '{$strRecordNo}'   \n";    
		$result_A = db_query($query);


		// 현재 문의글에 해당하는 레슨문의댓글평가테이블 삭제
		$query  = " DELETE FROM tbl_lesson_question_comment_appraisal   \n";
		$query .= " WHERE  lq_id = '{$strRecordNo}'   \n";    
		$result_CA = db_query($query);

		// 현재 문의글에 해당하는 레슨문의댓글(답글)
		$query  = " DELETE FROM tbl_lesson_question_comment   \n";
		$query .= " WHERE  lq_id = '{$strRecordNo}'   \n";    
		$result_C = db_query($query);

         echo "SUCCESS";
	} else {
         echo "문의글 삭제가 실패했습니다. 관리자에게 문의하세요.";
	}
}

        


?>
