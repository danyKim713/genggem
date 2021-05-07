<?php 
$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strRecordNo     = $_POST['txtRecordNo'];   // 수정할 영상ID
$strCat          = $_POST['rdoCat'];   // 영상카테고리
$strTitle        = trim($_POST['txtTitle']);          // 영상 제목
$strTag          = trim($_POST['txtTag']);            // 영상태그
$strLink         = trim($_POST['txtLink']);           // 영상링크주소
$strImg          = $_FILES["txtImg"];                 // 썸네일이미지
$strOpen         = trim($_POST['selOpen']);           // 공개여부
$strExplantation = trim($_POST['txtExplanation']);    // 영상설명


if (trim($strRecordNo) == "") {
    echo "잘못된 접근입니다. 관리자에게 문의하세요."; 
    exit;
}


if (trim($strCat) == "") {
    echo "영상관심 카테고리를 선택해주세요."; 
    exit;
}

if ($strTitle == "") {
    echo "영상 제목을 입력하세요.";
    exit;
}

if ($strTag == "") {
    echo "영상태그를 입력하세요.";
    exit;
}

if ($strLink == "") {
    echo "영상링크를 입력하세요.";
    exit;
}

/*
if ($strImg[tmp_name] == "") {
    echo "썸네일이미지를 선택하세요.";
    exit;
}
*/

if ($strOpen == "") {
    echo "공개여부를 선택하세요.";
    exit;
}

if ($strExplantation == "") {
    echo "영상설명을 입력하세요.";
    exit;
}
// 수정할 영상정보 가져오기
$query  = " SELECT wv_id, member_id, member_uid, cat_id, v_title, v_tag, v_link, v_thumbnail,  \n";
$query .= "        v_open_flg, approval_flg, exposure_flg, v_explanation, view_cnt, isrt_dt   \n";
$query .= " FROM   tbl_watch_video    \n";
$query .= " WHERE  wv_id='{$strRecordNo}'   \n";  
$rowWatch = db_select($query); 


$strGetImg = "";
if ($strImg[tmp_name] != "") {
    $strGetImg = $clsLib->fnGeneralUploadImg_Thumb($strImg, "WatchVideo/".trim($rowMember['UID']), CONST_UPLOAD_FILESIZE_IMG, 700, 10);
exit;
    // 이전이미지 삭제 
    if (is_file($uploadDirectory_ABS."/WatchVideo/{$rowMember['UID']}/{$rowWatch['v_thumbnail']}")) { 
        @unlink($uploadDirectory_ABS."/WatchVideo/{$rowMember['UID']}/{$rowWatch['v_thumbnail']}");     
    }
}

$query  = " UPDATE tbl_watch_video SET  \n";
$query .= "        member_id     = '{$rowMember["member_id"]}',  \n";
$query .= "        member_uid    = '{$rowMember["UID"]}',  \n";
$query .= "        cat_id        = '{$strCat}',  \n";
$query .= "        v_title       = '{$strTitle}',  \n";
$query .= "        v_tag         = '{$strTag}',  \n";
$query .= "        v_link        = '{$strLink}',  \n";
if ($strGetImg != "") { 
    $query .= "        v_thumbnail   = '{$strGetImg}',  \n";
}
$query .= "        v_open_flg    = '{$strOpen}',  \n";
$query .= "        v_explanation = '{$strExplantation}',  \n";
$query .= "        isrt_user     = '{$rowMember["UID"]}',  \n";
$query .= "        isrt_dt       = NOW(),  \n";
$query .= "        updt_user     = '{$rowMember["UID"]}',  \n";
$query .= "        updt_dt       = NOW()  \n";
$query .= " WHERE  wv_id = '{$strRecordNo}'  \n";

$result = db_query($query);

if ($result) {
    echo "SUCCESS";
} else {
    echo "FAILED";
}

?>

