<?php 
$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strCat          = $_POST['rdoCat'];   // 영상카테고리
$strTitle        = trim($_POST['txtTitle']);          // 영상 제목
$strTag          = trim($_POST['txtTag']);            // 영상태그
$strLink         = trim($_POST['txtLink']);           // 영상링크주소
$strImg          = $_FILES["txtImg"];                 // 썸네일이미지
$strOpen         = trim($_POST['selOpen']);           // 공개여부
$strExplantation = trim($_POST['txtExplanation']);    // 영상설명

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


$strGetImg = "";
if ($strImg[tmp_name] != "") {
    $strGetImg = $clsLib->fnGeneralUploadImg_Thumb($strImg, "WatchVideo/".trim($rowMember['UID']), CONST_UPLOAD_FILESIZE_IMG, 700, 10);
}

$query  = " INSERT INTO tbl_watch_video SET  \n";
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


$result = db_query($query);

if ($result) {
    echo "SUCCESS";
} else {
    echo "FAILED";
}

?>

