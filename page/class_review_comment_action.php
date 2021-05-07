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


if (trim($strAction) == "QUESTIONGOOD") {  // '문의 좋아요' 버튼 클릭시
    // 문의글 좋아요 가져오기
    $query  = " SELECT COUNT(lqa_id) AS cnt   \n";
    $query .= " FROM   tbl_lesson_question_appraisal  \n";
    $query .= " WHERE  lq_id='{$strRecordNo}'   \n"; 
    $query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";

    $rowAppraisal = db_select($query); 

    if ($rowAppraisal["cnt"] > 0) {  // 좋아요 이면 삭제
        $query  = " DELETE FROM tbl_lesson_question_appraisal   \n";
        $query .= " WHERE  lq_id     = '{$strRecordNo}'  \n";   // 영상등록자 ID
        $query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";  // 회원 ID

        $result = db_query($query);

        if ($result) {
            echo "SUCCESSD";
        } 
    } else  {  // 좋아요 아니면 등록
        // 문의글 정보 가져오기
        $query  = " SELECT lq_id, coach_id, member_id, member_uid  \n";
        $query .= " FROM   tbl_lesson_question   \n";
        $query .= " WHERE  lq_id='{$strRecordNo}'   \n"; 
        $rowQuestion = db_select($query); 

        $query  = " INSERT INTO tbl_lesson_question_appraisal SET  \n";
        $query .= "        lq_id     = '{$strRecordNo}',  \n";   // 영상등록자 ID
        $query .= "        member_id = '{$rowMember["member_id"]}',  \n";  // 회원 ID
        $query .= "        coach_id  = '{$rowQuestion["coach_id"]}',  \n";  // 코치 ID
        $query .= "        isrt_dt   = NOW()  \n";
        $result = db_query($query);

        if ($result) {
            echo "SUCCESSI";
        } 
    }
} else if (trim($strAction) == "COMMENTREG") {  // 댓글 작성시
    $strComment = $_POST["txtComment"];

    // 문의글 정보 가져오기
    $query  = " SELECT lq_id, coach_id, member_id, member_uid  \n";
    $query .= " FROM   tbl_lesson_question   \n";
    $query .= " WHERE  lq_id='{$strRecordNo}'   \n"; 
    $rowQuestion = db_select($query); 

    // 댓글정보 가져오기
    $query  = " SELECT MAX(lqc_id) AS id_val \n";
    $query .= " FROM   tbl_lesson_question_comment   \n";
    $resultInfo = db_select($query); 

    if (trim($resultInfo["id_val"]) == "") {
        $strID = "1";
    } else {
        $strID = $resultInfo["id_val"] + 1;
    }



    // 답글 저장
    $query  = " INSERT INTO tbl_lesson_question_comment SET  \n";
    $query .= "        lqc_id    = '{$strID}',  \n";
    $query .= "        lq_id     = '{$strRecordNo}',  \n";
    $query .= "        depth     = '1',  \n";
    $query .= "        comment   = '{$strComment}',  \n";
    $query .= "        ref_1     = '{$strID}',  \n";
    $query .= "        ref_2     = '0',  \n";
    $query .= "        coach_id  = '{$rowQuestion["coach_id"]}',  \n";
    $query .= "        isrt_user = '{$rowMember["member_id"]}',  \n";
    $query .= "        isrt_dt   = NOW()  \n";


    $result = db_query($query);

    if ($result) {

        $strCommentTmp = str_replace("\n", "<br>", $strComment);
        $strCommentTmp = str_replace(" ", "&nbsp;", $strCommentTmp);

        $strHTML  = "<li>    \n";
        $strHTML .= "    <div class=\"d-flex align-items-start position-r\">    \n";
        $strHTML .= "        <div class=\"page-profile\">    \n";
        $strHTML .= "            <img src=\"".phpThumb("/_UPLOAD/".($rowMember['페이지배경사진']?$rowMember['페이지배경사진']:$rowMember['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")."\" width=\"40\" height=\"40\" class=\"rounded-circle\">    \n";
        $strHTML .= "        </div>    \n";
        $strHTML .= "        <div class=\"page-write col lh-3 pr-0\">    \n";
        $strHTML .= "            <h5 class=\"fs-005 mb-0\">{$rowMember["닉네임"]}</h5>    \n";
        $strHTML .= "            <p class=\"post fs-005 fw-300 mb-2\">{$strCommentTmp} </p>    \n";
        $strHTML .= "            <div class=\"d-flex lh-2\">    \n";
        $strHTML .= "                <div class=\"checkbox check-primary\">    \n";
        $strHTML .= "                    <input id=\"chk2\" name=\"chk_good\" type=\"checkbox\" class=\"invisible\">    \n";
        $strHTML .= "                    <label for=\"chk2\" class=\"color-5 mb-0 fw-400\"><i class=\"far fa-thumbs-up fs-005 pr-1 color-5\"></i>좋아요 0</label>    \n";
        $strHTML .= "                </div>    \n";
        $strHTML .= "                <span class=\"px-1\">·</span>    \n";
        $strHTML .= "                <button type=\"button\" class=\"btn-reply btn btn-transparent color-primary p-0\">답글달기</button>    \n";
        $strHTML .= "            </div>    \n";
        $strHTML .= "            <!--답글입력창-->    \n";
        $strHTML .= "            <div class=\"con-reply\">    \n";
        $strHTML .= "                <div class=\"d-flex mt-3\">    \n";
        $strHTML .= "                    <input type=\"hidden\" name=\"txtCommentID\" class=\"txtCommentID\" value=\"{$strID}\">    \n";
        $strHTML .= "                    <textarea class=\"form-control txtReply\" name=\"txtReply\" placeholder=\"답글 내용을 입력해주세요\" rows=\"2\"></textarea>    \n";
        $strHTML .= "                        <button type=\"button\" class=\"btn btn-outline-secondary col-3 px-3 btnReply\">확인</button>    \n";
        $strHTML .= "                </div>    \n";
        $strHTML .= "            </div>    \n";
        $strHTML .= "            <!--//답글입력창-->    \n";
        $strHTML .= "            <!--답글-->    \n";
        $strHTML .= "            <div class=\"list-reply\">    \n";
        $strHTML .= "                <ul class=\"ULREPLY\">    \n";
        $strHTML .= "                </ul>    \n";
        $strHTML .= "            </div>    \n";
        $strHTML .= "            <!--//답글-->    \n";
        $strHTML .= "        </div>    \n";
        $strHTML .= "        <p class=\"date position-ab mb-0 fs--1\">0초전</p>    \n";
        $strHTML .= "    </div>    \n";
        $strHTML .= "</li>    \n";

        echo "SUCCESS@".$strHTML;
    } 
} else if (trim($strAction) == "REPLYREG") {  // 답글 작성시
    $strCommentID = $_POST["txtCommentID"];
    $strReply     = $_POST["txtReply"];

    // 문의글 정보 가져오기
    $query  = " SELECT lq_id, coach_id, member_id, member_uid  \n";
    $query .= " FROM   tbl_lesson_question   \n";
    $query .= " WHERE  lq_id='{$strRecordNo}'   \n"; 
    $rowQuestion = db_select($query); 

    // 댓글정보 가져오기
    $query  = " SELECT MAX(lqc_id) AS id_val \n";
    $query .= " FROM   tbl_lesson_question_comment   \n";
    $resultInfo = db_select($query); 

    $strID = $resultInfo["id_val"] + 1;


    // 답글 저장
    $query  = " INSERT INTO tbl_lesson_question_comment SET  \n";
    $query .= "        lqc_id    = '{$strID}',  \n";
    $query .= "        lq_id     = '{$strRecordNo}',  \n";
    $query .= "        depth     = '2',  \n";
    $query .= "        comment   = '{$strReply}',  \n";
    $query .= "        ref_1     = '{$strCommentID}',  \n";
    $query .= "        ref_2     = '{$strID}',  \n";
    $query .= "        coach_id  = '{$rowQuestion["coach_id"]}',  \n";
    $query .= "        isrt_user = '{$rowMember["member_id"]}',  \n";
    $query .= "        isrt_dt   = NOW()  \n";

    $result = db_query($query);


    if ($result) {
        $strReplyTmp = str_replace("\n", "<br>", $strReply);
        $strReplyTmp = str_replace(" ", "&nbsp;", $strReplyTmp);

        $strHTML  = "<li>    \n";
        $strHTML .= "    <div class=\"d-flex align-items-start position-r\">    \n";
        $strHTML .= "        <div class=\"page-profile\">    \n";
        $strHTML .= "            <img src=\"".phpThumb("/_UPLOAD/".($rowMember['페이지배경사진']?$rowMember['페이지배경사진']:$rowMember['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")."\" width=\"30\" height=\"30\" class=\"rounded-circle\">    \n";
        $strHTML .= "        </div>    \n";
        $strHTML .= "        <div class=\"col lh-3 pr-0\">    \n";
        $strHTML .= "            <h5 class=\"fs-005 mb-1\">{$rowMember['닉네임']}</h5>    \n";
        $strHTML .= "            <p class=\"fs-005 fw-300\">{$strReplyTmp}</p>    \n";
        $strHTML .= "        </div>    \n";
        $strHTML .= "    </div>    \n";
        $strHTML .= "</li>    \n";

        echo "SUCCESS@".$strHTML;
    } else {
        echo "bb";
    }
} else if (trim($strAction) == "COMMENTGOOD") {  // 댓글 좋아요 클릭시

    $strCommentID = $_POST["txtCommentID"];



    // 댓글 좋아요 가져오기
    $query  = " SELECT COUNT(lqca_id) AS cnt   \n";
    $query .= " FROM   tbl_lesson_question_comment_appraisal  \n";
    $query .= " WHERE  lqc_id='{$strCommentID}'   \n"; 
    $query .= " AND    lq_id='{$strRecordNo}'   \n"; 
    $query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";

    $rowAppraisal = db_select($query); 

    if ($rowAppraisal["cnt"] > 0) {  // 좋아요 이면 삭제
        $query  = " DELETE FROM tbl_lesson_question_comment_appraisal   \n";
        $query .= " WHERE  lqc_id='{$strCommentID}'   \n"; 
        $query .= " AND    lq_id='{$strRecordNo}'   \n"; 
        $query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";

        $result = db_query($query);

        if ($result) {
            echo "SUCCESSD";
        } 
    } else  {  // 좋아요 아니면 등록
        // 문의글 정보 가져오기
        $query  = " SELECT lq_id, coach_id, member_id, member_uid  \n";
        $query .= " FROM   tbl_lesson_question   \n";
        $query .= " WHERE  lq_id='{$strRecordNo}'   \n"; 
        $rowQuestion = db_select($query); 


        $query  = " INSERT INTO tbl_lesson_question_comment_appraisal SET  \n";
        $query .= "        lqc_id    = '{$strCommentID}',  \n";   
        $query .= "        lq_id     = '{$strRecordNo}',  \n";   
        $query .= "        member_id = '{$rowMember["member_id"]}',  \n";  // 회원 ID
        $query .= "        coach_id  = '{$rowQuestion["coach_id"]}',  \n";  // 코치 ID
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
