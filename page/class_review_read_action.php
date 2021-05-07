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


if (trim($strAction) == "COMMENTREG") {  // 댓글 작성시

    $strComment = $_POST["txtComment"];

    // 리뷰 정보 가져오기
    $query  = " SELECT lr_id, l_id   \n";
    $query .= " FROM   tbl_lesson_review   \n";
    $query .= " WHERE  lr_id='{$strRecordNo}'   \n"; 
    $rowReview = db_select($query); 

    // 댓글정보 가져오기
    $query  = " SELECT MAX(lrc_id) AS id_val \n";
    $query .= " FROM   tbl_lesson_review_comment   \n";
    $resultInfo = db_select($query); 

    if (trim($resultInfo["id_val"]) == "") {
        $strID = "1";
    } else {
        $strID = $resultInfo["id_val"] + 1;
    }

    // 댓글 저장
    $query  = " INSERT INTO tbl_lesson_review_comment SET  \n";
    $query .= "        lrc_id    = '{$strID}',  \n";
    $query .= "        lr_id     = '{$strRecordNo}',  \n";
    $query .= "        depth     = '1',  \n";
    $query .= "        comment   = '{$strComment}',  \n";
    $query .= "        ref_1     = '{$strID}',  \n";
    $query .= "        ref_2     = '0',  \n";
    $query .= "        isrt_user = '{$rowMember["member_id"]}',  \n";
    $query .= "        isrt_dt   = NOW()  \n";

    $result = db_query($query);

    if ($result) {

        $strCommentTmp = str_replace("\n", "<br>", $strComment);
        $strCommentTmp = str_replace(" ", "&nbsp;", $strCommentTmp);


        $strHTML  = "       <li>   \n";
        $strHTML .= "           <div class=\"d-flex align-items-start position-r\">   \n";
        $strHTML .= "               <div class=\"page-profile\">   \n";
        $strHTML .= "                   <img src=\"".phpThumb("/_UPLOAD/".($rowMember['페이지배경사진']?$rowMember['페이지배경사진']:$rowMember['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")."\" width=\"40\" height=\"40\" class=\"rounded-circle\">    \n";
        $strHTML .= "               </div>   \n";
        $strHTML .= "               <div class=\"page-write col lh-3 pr-0\">   \n";
        $strHTML .= "                   <h5 class=\"fs-005 mb-0\">{$rowMember["닉네임"]}</h5>   \n";
        $strHTML .= "                   <p class=\"post fs-005 fw-300 mb-2\">{$strCommentTmp}</p>   \n";
        $strHTML .= "                   <div class=\"d-flex lh-2\">   \n";

        $strHTML .= "                       <div class=\"checkbox check-primary\">   \n";
        $strHTML .= "                           <input type=\"hidden\" name=\"txtCommentID\" class=\"txtCommentID\" value=\"{$strID}\"> \n";

        $strHTML .= "                           <input id=\"chkCommentGood{$strID}\" name=\"chkCommentGood\" type=\"checkbox\" class=\"invisible\">   \n";
        $strHTML .= "                           <label for=\"chkCommentGood{$strID}\" class=\"color-5 mb-0 fw-400\"><i class=\"far fa-thumbs-up fs-005 pr-1 color-5\"></i>좋아요 0</label>   \n";
        $strHTML .= "                       </div>   \n";
        $strHTML .= "                   </div>   \n";
        $strHTML .= "                   <div class=\"con-reply\">   \n";
        $strHTML .= "                       <div class=\"d-flex mt-3\">   \n";
        $strHTML .= "                           <textarea class=\"form-control\" placeholder=\"답글 내용을 입력해주세요\" rows=\"2\"></textarea>   \n";
        $strHTML .= "                           <button type=\"button\" class=\"btn btn-outline-secondary col-3 px-3\">확인</button>   \n";
        $strHTML .= "                       </div>   \n";
        $strHTML .= "                   </div>   \n";
        $strHTML .= "               </div>   \n";
        $strHTML .= "               <p class=\"date position-ab mb-0 fs--1\">0초전</p>   \n";
        $strHTML .= "           </div>   \n";
        $strHTML .= "       </li>   \n";




        echo "SUCCESS@".$strHTML;
    } 
} else if (trim($strAction) == "COMMENTGOOD") {  // 댓글 좋아요 클릭시

    $strCommentID = $_POST["txtCommentID"];

    // 댓글 좋아요 가져오기
    $query  = " SELECT COUNT(lrca_id) AS cnt   \n";
    $query .= " FROM   tbl_lesson_review_comment_appraisal  \n";
    $query .= " WHERE  lrc_id='{$strCommentID}'   \n"; 
    $query .= " AND    lr_id='{$strRecordNo}'   \n"; 
    $query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";

    $rowAppraisal = db_select($query); 

    if ($rowAppraisal["cnt"] > 0) {  // 좋아요 이면 삭제
        $query  = " DELETE FROM tbl_lesson_review_comment_appraisal   \n";
        $query .= " WHERE  lrc_id='{$strCommentID}'   \n"; 
        $query .= " AND    lr_id='{$strRecordNo}'   \n"; 
        $query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";

        $result = db_query($query);

        if ($result) {
            echo "SUCCESSD";
        } 
    } else  {  // 좋아요 아니면 등록
        $query  = " INSERT INTO tbl_lesson_review_comment_appraisal SET  \n";
        $query .= "        lrc_id    = '{$strCommentID}',  \n";   
        $query .= "        lr_id     = '{$strRecordNo}',  \n";   
        $query .= "        member_id = '{$rowMember["member_id"]}',  \n";  // 회원 ID
        $query .= "        isrt_dt   = NOW()  \n";
        $result = db_query($query);

        if ($result) {
            echo "SUCCESSI";
        } 
    }

}


?>
