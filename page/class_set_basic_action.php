<?php 
$NO_LOGIN = true;
include "./inc_program.php";

include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수


// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

// 레슨정보
$strImg1             = $_FILES["txtBGPic"];   // 레슨배경사진
$strImg2             = $_FILES["txtProPic"];  // 프로필 사진
$strDelImg1          = $_POST["chkDelImg1"];
$strDelImg2          = $_POST["chkDelImg2"];
$strLessonTitle      = trim($_POST['txtLessonTitle']);  // 레슨제목
$strLessonSearchWord = trim($_POST['txtLessonSearchWord']);  // 레슨(코치) 검색어
$strLessonGreetings  = trim($_POST['txtLessonGreetings']);  // 레슨인사말

// 알림설정
if ($_POST['chkNotice'] == "NOTICE") { 
    $strNotification = "AD005001";  
} else {
    $strNotification = "AD005002";  
}


// 코치인지 조회
$cntCoach = db_count("tbl_coach", "member_id='".$ck_login_member_pk."' AND use_flg='AD005001'", "co_id");

if ($cntCoach == 0) {   // 코치가 아니면
    echo "코치가 아닙니다.";
    exit;    
}

$query = "SELECT * FROM tbl_lesson_setup WHERE member_id='".$ck_login_member_pk."'";
$resultWatch = db_query($query); 
$cnt = mysqli_num_rows($resultWatch);

$rowWatch = db_select($query); 


if (trim($rowWatch['background_photo']) != "") {  // 기존 레슨배경사진이 있다면
    if ($strDelImg1 == "DELIMG1") {  // 기존레슨배경사진 삭제가 체크되어 있다면
        if ($strImg1[tmp_name] == "") {
            echo "레슨(코치) 배경사진을 선택하세요.";
            exit;
        }
    }
} else {
        if ($strImg1[tmp_name] == "") {
            echo "레슨(코치) 배경사진을 선택하세요.";
            exit;
        }
}


if (trim($rowWatch['profile_photo']) != "") {  // 기존 프로필사진이 있다면
    if ($strDelImg2 == "DELIMG2") {  // 기존프로필사진 삭제가 체크되어 있다면
        if ($strImg2[tmp_name] == "") {
            echo "프로필(코치) 사진을 선택하세요.";
            exit;
        }
    }
} else {
        if ($strImg2[tmp_name] == "") {
            echo "프로필(코치) 사진을 선택하세요.";
            exit;
        }
}

if (trim($strLessonTitle) == "") {
    echo "레슨(코치) 제목을 입력하세요.";
    exit;
}


if (trim($strLessonGreetings) == "") {
    echo "레슨(코치) 인사말을 입력하세요.";
    exit;
}


$strGetImg1 = "";
$strGetImg2 = "";

// 정보가 존재하면 수정
if($cnt > 0) {

    if ($strImg1[tmp_name] != "") {    // 레슨배경사진 파일 업로드가 있다면(이미지 삭제 체크와 상관없이 무조건 이전의 이미지가 존재한다면 삭제)
        $strGetImg1 = $clsLib->fnGeneralUploadImg_NoThumb($strImg1, "WatchImg/".trim($rowMember['UID']), CONST_UPLOAD_FILESIZE_IMG);
        // 이전의 이미지가 존재한다면 삭제 
        if (trim($rowWatch['background_photo']) != "" && is_file($uploadDirectory_ABS."/WatchImg/".trim($rowMember['UID'])."/".$rowWatch['background_photo'])) { 
            @unlink($uploadDirectory_ABS."/WatchImg/".trim($rowMember['UID'])."/".$rowWatch["background_photo"]);     
        }
    }

    if ($strImg2[tmp_name] != "") {    // 프로필 사진 파일 업로드가 있다면(이미지 삭제 체크와 상관없이 무조건 이전의 이미지가 존재한다면 삭제)
        $strGetImg2 = $clsLib->fnGeneralUploadImg_NoThumb($strImg2, "WatchImg/".trim($rowMember['UID']), CONST_UPLOAD_FILESIZE_IMG);
        // 이전의 이미지가 존재한다면 삭제 
        if (trim($rowWatch['background_photo']) != "" && is_file($uploadDirectory_ABS."/WatchImg/".trim($rowMember['UID'])."/".$rowWatch['profile_photo'])) { 
            @unlink($uploadDirectory_ABS."/WatchImg/".trim($rowMember['UID'])."/".$rowWatch["profile_photo"]);     
        }
    }

    $query  = " UPDATE tbl_lesson_setup SET   \n";
    if (trim($strGetImg1) != "") $query .= "        background_photo    ='{$strGetImg1}',   \n";
    if (trim($strGetImg2) != "") $query .= "        profile_photo       ='{$strGetImg2}',   \n";
    $query .= "        lesson_title        ='{$strLessonTitle}',   \n";
    $query .= "        lesson_searchword   ='{$strLessonSearchWord}',   \n";
    $query .= "        lesson_greetings    ='{$strLessonGreetings}',   \n";
    $query .= "        notification_flg    = '{$strNotification}'  ";
    $query .= " WHERE  member_id ='{$ck_login_member_pk}'    \n";

    $result = db_query($query);

} else {  // 정보가 없으면 삽입

    // 레슨배경사진
    if ($strImg1[tmp_name] != "") {
        $strGetImg1 = $clsLib->fnGeneralUploadImg_NoThumb($strImg1, "WatchImg/".trim($rowMember['UID']), CONST_UPLOAD_FILESIZE_IMG);
    }

    // 프로필 사진
    if ($strImg2[tmp_name] != "") {
        $strGetImg2 = $clsLib->fnGeneralUploadImg_NoThumb($strImg2, "WatchImg/".trim($rowMember['UID']), CONST_UPLOAD_FILESIZE_IMG);
    }

    $query  = " INSERT INTO tbl_lesson_setup SET  \n";
    $query .= "        member_id           = '{$rowMember["member_id"]}',  \n";
    $query .= "        member_uid          = '{$rowMember["UID"]}',  \n";
    $query .= "        background_photo    = '{$strGetImg1}',  \n";
    $query .= "        profile_photo       = '{$strGetImg2}',  \n";
    $query .= "        lesson_title        = '{$strLessonTitle}',  \n";
    $query .= "        lesson_searchword   ='{$strLessonSearchWord}',   \n";
    $query .= "        lesson_greetings    = '{$strLessonGreetings}',  \n";
    $query .= "        notification_flg    = '{$strNotification}'  ";

    $result = db_query($query);
}

if ($result) {
    echo "SUCCESS";
} else {
    echo "FAILED";
}

?>

