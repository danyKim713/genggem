<?php 
$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strAction          = $_POST['txtAction'];   // 영상카테고리
$strRecordNo        = $_POST['txtRecordNo'];

if (trim($strAction) == "SUB") {  // '구독' 버튼 클릭시 '구독중'으로 변경
    // 영상정보 가져오기
    $query  = " SELECT wv_id, member_id \n";
    $query .= " FROM   tbl_watch_video   \n";
    $query .= " WHERE  wv_id='{$strRecordNo}'   \n";      
    $query .= " AND    approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $rowInfo = db_select($query); 

    // 현재 구독중인지 여부 검사
    $query  = " SELECT COUNT(wvs_id) AS cnt \n";
    $query .= " FROM   tbl_watch_video_subscription   \n";
    $query .= " WHERE  member_id = '{$rowInfo["member_id"]}'  \n";    // 영상등록자 ID
    $query .= " AND    isrt_user = '{$rowMember["member_id"]}'  \n";  // 구독자 ID
    $resultSubscript = db_select($query); 

    if ($resultSubscript["cnt"] == 0) {  // 구독하지 않는다면
        $query  = " INSERT INTO tbl_watch_video_subscription SET  \n";
        $query .= "        member_id = '{$rowInfo["member_id"]}',  \n";   // 영상등록자 ID
        $query .= "        isrt_user = '{$rowMember["member_id"]}',  \n";  // 구독자 ID
        $query .= "        isrt_dt   = NOW()  \n";

        $result = db_query($query);

        if ($result) {
            echo "SUCCESS";
        } 
    }
} else if (trim($strAction) == "SUBING") {  // '구독중' 버튼 클릭시 '구독'으로 변경

    // 영상정보 가져오기
    $query  = " SELECT wv_id, member_id \n";
    $query .= " FROM   tbl_watch_video   \n";
    $query .= " WHERE  wv_id='{$strRecordNo}'   \n";      
    $query .= " AND    approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $rowInfo = db_select($query); 

    // 현재 구독중인지 여부 검사
    $query  = " SELECT COUNT(wvs_id) AS cnt \n";
    $query .= " FROM   tbl_watch_video_subscription   \n";
    $query .= " WHERE  member_id = '{$rowInfo["member_id"]}'  \n";    // 영상등록자 ID
    $query .= " AND    isrt_user = '{$rowMember["member_id"]}'  \n";  // 구독자 ID
    $resultSubscript = db_select($query); 

    if ($resultSubscript["cnt"] > 0) {  // 구독중이면
        $query  = " DELETE FROM tbl_watch_video_subscription   \n";
        $query .= " WHERE  member_id = '{$rowInfo["member_id"]}'  \n";
        $query .= " AND    isrt_user = '{$rowMember["member_id"]}'  \n";
        $result = db_query($query);

        if ($result) {
            echo "SUCCESS";
        } 
    }

} else if (trim($strAction) == "GOOD") {    // '좋아요' 클릭시
    // 영상댓글정보 가져오기(현재 영상의 자신이 좋아요를 누른 정보를 조회)
    $query  = " SELECT COUNT(wva_id) AS cnt \n";
    $query .= " FROM   tbl_watch_video_appraisal   \n";
    $query .= " WHERE  wv_id='{$strRecordNo}'   \n";      // 영상 ID
    $query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";  // 회원 ID
    $rowInfo = db_select($query); 

    $strActionDtl = $_POST['txtActionDtl'];

    if ($strActionDtl == "NOEXIT")  {

        if ($rowInfo["cnt"] == 0) {        
            $query  = " INSERT INTO tbl_watch_video_appraisal SET  \n";
            $query .= "        wv_id = '{$strRecordNo}',  \n";   // 동영상 ID
            $query .= "        member_id = '{$rowMember["member_id"]}',  \n";  // 구독자 ID
            $query .= "        isrt_dt   = NOW()  \n";

            $result = db_query($query);

            $query  = " UPDATE tbl_watch_video SET  \n";
            $query .= "        good_cnt = good_cnt + 1  \n";   // 좋아요수 추가
            $query .= " WHERE  wv_id = '{$strRecordNo}'  \n";   // 동영상 ID

            $result = db_query($query);

            echo "SUCCESS";
        }

    } else if ($strActionDtl == "EXIT")  {

        if ($rowInfo["cnt"] > 0) {        
            $query  = " DELETE FROM tbl_watch_video_appraisal   \n";
            $query .= " WHERE  wv_id = '{$strRecordNo}'  \n";                 // 동영상 ID
            $query .= " AND    member_id = '{$rowMember["member_id"]}' \n";  // 구독자 ID
            $result = db_query($query);

            $query  = " UPDATE tbl_watch_video SET  \n";
            $query .= "        good_cnt = good_cnt - 1  \n";   // 좋아요수 감소
            $query .= " WHERE  wv_id = '{$strRecordNo}'  \n";   // 동영상 ID

            $result = db_query($query);

            echo "SUCCESS";
        }
    }
} else if (trim($strAction) == "COMMENT") {  // 댓글등록시
    $strComment = $_POST['txtComment'];

    if ($strComment == "") {
        echo "댓글을 입력하세요.";
        exit;
    }

    // 영상댓글정보 가져오기
    $query  = " SELECT MAX(wvc_id) AS id_val \n";
    $query .= " FROM   tbl_watch_video_comment   \n";
    $resultInfo = db_select($query); 

    if (trim($resultInfo["id_val"]) == "") {
        $strID = "1";
    } else {
        $strID = $resultInfo["id_val"] + 1;
    }

    $query  = " INSERT INTO tbl_watch_video_comment SET  \n";
    $query .= "        wvc_id    = '{$strID}',  \n";   // 동영상댓글 ID
    $query .= "        wv_id     = '{$strRecordNo}',  \n";   // 동영상 ID
    $query .= "        depth     = '1',  \n";  
    $query .= "        comment   = '{$strComment}',  \n";   
    $query .= "        ref_1     = '{$strID}',  \n"; 
    $query .= "        ref_2     = 0,  \n";  
    $query .= "        isrt_user = '{$rowMember["member_id"]}',  \n";  // 구독자 ID
    $query .= "        isrt_dt   = NOW()  \n";

    $result = db_query($query);

    if ($result) {
        $query  = " SELECT A.*, B.name, B.닉네임, B.페이지배경사진, B.페이지프로필사진, \n";
        $query .= "        TIMESTAMPDIFF(SECOND, A.isrt_dt, NOW()) AS diffSecond,   \n";
        $query .= "        TIMESTAMPDIFF(MINUTE, A.isrt_dt, NOW()) AS diffMinute,   \n";
        $query .= "        TIMESTAMPDIFF(HOUR, A.isrt_dt, NOW()) AS diffHour,   \n";
        $query .= "        TIMESTAMPDIFF(DAY, A.isrt_dt, NOW()) AS diffDay,   \n";
        $query .= "        TIMESTAMPDIFF(WEEK, A.isrt_dt, NOW()) AS diffWeek,   \n";
        $query .= "        TIMESTAMPDIFF(MONTH, A.isrt_dt, NOW()) AS diffMonth,   \n";
        $query .= "        TIMESTAMPDIFF(YEAR, A.isrt_dt, NOW()) AS diffYear   \n";
        $query .= " FROM   tbl_watch_video_comment A, tbl_member B  \n";
        $query .= " WHERE  A.wvc_id = '{$strID}'   \n";      
        $query .= " AND    A.isrt_user = B.member_id   \n";  



        $rowInfo = db_select($query);

        $strDiff = "";
        $strDiff = $rowInfo["diffYear"]."년전";
        if ($rowInfo["diffYear"] < 1) {
            $strDiff = $rowInfo["diffMonth"]."달전";
            if ($rowInfo["diffMonth"] < 1) {
                $strDiff = $rowInfo["diffWeek"]."주전";
                if ($rowInfo["diffWeek"] < 1) {
                    $strDiff = $rowInfo["diffDay"]."일전";
                    if ($rowInfo["diffDay"] < 1) {
                        $strDiff = $rowInfo["diffHour"]."시간전";
                        if ($rowInfo["diffHour"] < 1) {
                            $strDiff = $rowInfo["diffMinute"]."분전";
                            if ($rowInfo["diffMinute"] < 1) {
                                $strDiff = $rowInfo["diffSecond"]."초전";
                            }
                        }

                    }
                }
            }
        }

        // 현재 댓글에 로긴한 회원이 댓글을 달았는지 여부를 조회
        $query  = " SELECT count(wvca_id) AS cnt  \n";
        $query .= " FROM   tbl_watch_video_comment_appraisal  \n";
        $query .= " WHERE  wvc_id = '{$strID}'   \n";      
        $query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";   

        $rowInfoFlg = db_select($query);

        $strClass1 = "";
        $strClass2 = "";
        $strClass3 = "";

        if ($rowInfoFlg["cnt"] > 0) {        // 댓글을 달았다면
            $strClass1 = "color-primary mb-0 fw-400 lblChkComment";
            $strClass2 = "far fa-thumbs-up fs-005 pr-1";
            $strClass3 = "EXIT";
        } else {
            $strClass1 = "color-5 mb-0 fw-400 lblChkComment";
            $strClass2 = "far fa-thumbs-up fs-005 pr-1";
            $strClass3 = "NOEXIT";
        }



        $strCommentTmp = str_replace("\n", "<br>", $rowInfo['comment']);
        $strCommentTmp = str_replace(" ", "&nbsp;", $strCommentTmp);


        $strHTML  = "<li>  \n";
        $strHTML .= "    <div class='d-flex align-items-start position-r'>  \n";
        $strHTML .= "        <div class='page-profile'>  \n";
        $strHTML .= "            <img src=\"".phpThumb("/_UPLOAD/".($rowInfo['페이지배경사진']?$rowInfo['페이지배경사진']:$rowInfo['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")."\" width=\"40\" height=\"40\" class=\"rounded-circle\">    \n";
        $strHTML .= "        </div>  \n";

        if ($rowInfo["isrt_user"] == $ck_login_member_pk) {
            $strHTML .= "        <div class=\"dropdown position-ab btn-right-top\">  \n";
            $strHTML .= "            <button class=\"btn btn-transparent color-6 p-3 dropdown-toggle fs-0\"  type=\"button\"  data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><i class=\"fas fa-ellipsis-h\"></i></button>  \n";
            $strHTML .= "            <div class=\"dropdown-menu\">  \n";
            $strHTML .= "                <a class=\"dropdown-item\" href=\"watch_comment_modify.php?txtRecordNo={$rowInfo['wvc_id']}\" title=\"글 수정\">글 수정</a>  \n";

            $strHTML .= "                <input type=\"hidden\" class=\"txtCommentID\" value=\"{$rowInfo['wvc_id']}\">  \n";
            $strHTML .= "                <a class=\"dropdown-item\" href=\"javascript:void()\"><span class=\"lblCommentDel\">글 삭제</span></a>  \n";
            $strHTML .= "            </div>   \n";
            $strHTML .= "        </div>   \n";
        } else {
            $strHTML .= "        <input type=\"hidden\" class=\"txtCommentID\" value=\"{$rowInfo['wvc_id']}\">   \n";
            $strHTML .= "        <input type=\"hidden\" class=\"lblCommentDel\">   \n";
        }
        $strHTML .= "        <div class='page-write col lh-3 pr-0'>  \n";
        $strHTML .= "            <h5 class='fs-005 mb-0'>{$rowInfo['닉네임']}</h5>  \n";
        $strHTML .= "            <p class='post fs-005 fw-300 mb-2'>{$strCommentTmp}  \n";
        $strHTML .= "            </p>  \n";
        $strHTML .= "            <div class='d-flex lh-2'>  \n";
        $strHTML .= "                <div class='checkbox'>  \n";
        $strHTML .= "                    <input type='hidden' id='txtChkComment{$strID}' name='txtChkComment[]' class='txtChkComment' value='{$strID}'>  \n";
        $strHTML .= "                    <input id='chkComment{$strID}' name='chkComment[]' type='checkbox' class='invisible {$strClass3} chkComment' value='{$strID}'>  \n";
        $strHTML .= "                    <label for='chkComment{$strID}' class='{$strClass1}'><i class='{$strClass2}'></i>좋아요 <span class='spnCommentGoodCnt'>{$rowInfo["good_cnt"]}<span></label>  \n";
        $strHTML .= "                </div>  \n";
        $strHTML .= "                <span class='px-1'>·</span>  \n";
        $strHTML .= "                <button type='button' class='btn-reply btn btn-transparent color-primary p-0'>답글달기</button>  \n";
        $strHTML .= "            </div>  \n";
        $strHTML .= "            <div class='con-reply'>  \n";
        $strHTML .= "                <div class='d-flex mt-3'>  \n";
        $strHTML .= "                    <input type='hidden' name='txtParent' class='txtParent' value='{$strID}'>  \n";
        $strHTML .= "                    <textarea class='form-control txtReply' placeholder='답글 내용을 입력해주세요' rows='2'></textarea>  \n";
        $strHTML .= "                    <button type='button' class='btn btn-outline-secondary col-3 px-3 btnReplyOK'>확인</button>  \n";
        $strHTML .= "                </div>  \n";
        $strHTML .= "            </div>  \n";
        $strHTML .= "            <div class='list-reply'>  \n";
        $strHTML .= "                <ul class='ul_{$strID}'>  \n";
        $strHTML .= "                </ul>  \n";
        $strHTML .= "            </div>  \n";
        $strHTML .= "        </div>  \n";
        $strHTML .= "        <p class='date position-ab mb-0 fs--1'>{$strDiff}</p>  \n";
        $strHTML .= "    </div>  \n";
        $strHTML .= "</li>  \n";



        echo "SUCCESS@".$strHTML;
    } else {
        echo "댓글등록이 실패했습니다. 관리자에게 문의하세요.";
        exit;        
    }
} else if (trim($strAction) == "REPLY") {    // 답글 등록시
    $strParent = $_POST['txtParent'];
    $strReply = $_POST['txtReply'];

    if ($strReply == "") {
        echo "답글을 입력하세요.";
        exit;
    }

    // 영상댓글정보 가져오기
    $query  = " SELECT MAX(wvc_id) AS id_val \n";
    $query .= " FROM   tbl_watch_video_comment   \n";
    $resultInfo = db_select($query); 

    $strID = $resultInfo["id_val"] + 1;

    $query  = " INSERT INTO tbl_watch_video_comment SET  \n";
    $query .= "        wvc_id    = '{$strID}',  \n";   // 동영상댓글 ID
    $query .= "        wv_id     = '{$strRecordNo}',  \n";   // 동영상 ID
    $query .= "        depth     = '2',  \n";  
    $query .= "        comment   = '{$strReply}',  \n";   
    $query .= "        ref_1     = '{$strParent}',  \n"; 
    $query .= "        ref_2     = '{$strID}',  \n";  
    $query .= "        isrt_user = '{$rowMember["member_id"]}',  \n";  // 구독자 ID
    $query .= "        isrt_dt   = NOW()  \n";

    $result = db_query($query);

    if ($result) {
        echo "SUCCESS";
    } else {
        echo "답글등록이 실패했습니다. 관리자에게 문의하세요.";
        exit;        
    }
} else if (trim($strAction) == "COMMENTGOOD") {  // 댓글 '좋아요' 클릭시 '흑백좋아요(안좋아요)'로 변경
    $strActionDtl = $_POST['txtActionDtl'];
    $strCommentID = $_POST['txtComment'];

    // 현재회원이 등록한 좋아요 정보 가져오기
    $query  = " SELECT COUNT(wvca_id) AS cnt \n";
    $query .= " FROM   tbl_watch_video_comment_appraisal   \n";
    $query .= " WHERE  wvc_id = '{$strCommentID}'  \n";   // 동영상댓글 ID
    $query .= " AND    wv_id='{$strRecordNo}'   \n";      
    $query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";  // 회원 ID
    $rowInfo = db_select($query); 

    if ($strActionDtl == "NOEXIT")  {

        if ($rowInfo["cnt"] == 0) {        
            $query  = " INSERT INTO tbl_watch_video_comment_appraisal SET  \n";
            $query .= "        wvc_id = '{$strCommentID}',  \n";   // 동영상댓글 ID
            $query .= "        wv_id = '{$strRecordNo}',  \n";   // 동영상 ID
            $query .= "        member_id = '{$rowMember["member_id"]}',  \n";  // 회원 ID
            $query .= "        isrt_dt   = NOW()  \n";

            $result = db_query($query);

            $query  = " UPDATE tbl_watch_video_comment SET  \n";
            $query .= "        good_cnt = good_cnt + 1  \n";  // 좋아요 수 추가
            $query .= " WHERE  wvc_id = '{$strCommentID}'  \n";   // 동영상댓글 ID
            $query .= " AND    wv_id = '{$strRecordNo}'  \n";   // 동영상 ID

            $result = db_query($query);

            echo "SUCCESS";
        }
    } else if ($strActionDtl == "EXIT")  {

        if ($rowInfo["cnt"] > 0) {        
            $query  = " DELETE FROM tbl_watch_video_comment_appraisal   \n";
            $query .= " WHERE  wvc_id = '{$strCommentID}'  \n";   // 동영상댓글 ID
            $query .= " AND    wv_id = '{$strRecordNo}'  \n";   // 동영상 ID
            $query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";  // 회원 ID
            $result = db_query($query);

            $query  = " UPDATE tbl_watch_video_comment SET  \n";
            $query .= "        good_cnt = good_cnt - 1  \n";  // 좋아요 수 감소
            $query .= " WHERE  wvc_id = '{$strCommentID}'  \n";   // 동영상댓글 ID
            $query .= " AND    wv_id = '{$strRecordNo}'  \n";   // 동영상 ID

            $result = db_query($query);

            echo "SUCCESS";

        }
    }

}  else if (trim($strAction) == "DELETECOMMENT") {  // 댓글 삭제
    // 댓글 삭제
    $query  = " DELETE FROM tbl_watch_video_comment   \n";
    $query .= " WHERE  wvc_id    = '{$strRecordNo}'  \n";   // 동영상댓글 ID
    $result = db_query($query);

    if ($result) {
        // 댓글하위의  답글 삭제
        $query  = " DELETE FROM tbl_watch_video_comment  \n";
        $query .= " WHERE  depth = '2'   \n";      
        $query .= " AND    ref_1 = '{$strRecordNo}'   \n";      
        $result2 = db_query($query);

        // 댓글에 관련된 좋아요 삭제
        $query  = " DELETE FROM tbl_watch_video_comment_appraisal   \n";
        $query .= " WHERE  wvc_id    = '{$strRecordNo}'  \n";   // 동영상댓글 ID
        $result3 = db_query($query);

        echo "SUCCESS";
    } else {
        echo "삭제가 실패했습니다. 관리자에게 문의하세요.";
    }

}
?>
