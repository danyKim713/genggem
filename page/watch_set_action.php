<?php 
$NO_LOGIN = true;
include "./inc_program.php";

include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수


// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

// 영상정보
$strCat             = implode(", ", $_POST['chkCat']);   // 관심영상카테고리
$strMovieTitle      = trim($_POST['txtMovieTitle']);  // 내영상(크리에이터) 제목
$strOpen            = trim($_POST['selOpen']);  // 내영상(크리에이터) 공개여부
$strMovieBigo       = trim($_POST['txtMovieBigo']);  // 내영상(크리에이터) 설명


// 알림설정
if ($_POST['chkNotice'] == "NOTICE") { 
    $strNotification = "AD005001";  
} else {
    $strNotification = "AD005002";  
}


if (trim($strCat) == "") {
    echo "영상관심 카테고리를 선택해주세요."; 
    exit;
}

if (trim($strMovieTitle) == "") {
    echo "내영상(크리에이터) 제목을 입력하세요.";
    exit;
}

if (trim($strOpen) == "") {
    echo "내영상(크리에이터) 공개여부를 선택하세요.";
    exit;
}

if (trim($strMovieBigo) == "") {
    echo "내영상(크리에이터) 설명을 입력하세요.";
    exit;
}




$query = "SELECT * FROM tbl_watch_setup WHERE member_id='".$ck_login_member_pk."'";
$resultWatch = db_query($query); 
$cnt = mysqli_num_rows($resultWatch);

$rowWatch = db_select($query); 


$strGetImg1 = "";
$strGetImg2 = "";

// 정보가 존재하면 수정
if($cnt > 0) {

    $query  = " UPDATE tbl_watch_setup SET   \n";
    $query .= "        cat_id              ='{$strCat}',   \n";
    $query .= "        creator_title       ='{$strMovieTitle}',   \n";
    $query .= "        creator_open_flg    ='{$strOpen}',   \n";
    $query .= "        creator_explanation ='{$strMovieBigo}',   \n";
    $query .= "        notification_flg    ='{$strNotification}'   \n";
    $query .= " WHERE  member_id ='{$ck_login_member_pk}'    \n";

    $result = db_query($query);

} else {  // 정보가 없으면 삽입



    $query  = " INSERT INTO tbl_watch_setup SET  \n";
    $query .= "        member_id           = '{$rowMember["member_id"]}',  \n";
    $query .= "        member_uid          = '{$rowMember["UID"]}',  \n";
    $query .= "        cat_id              = '{$strCat}',  \n";
    $query .= "        creator_title       = '{$strMovieTitle}',  \n";
    $query .= "        creator_open_flg    = '{$strOpen}',  \n";
    $query .= "        creator_explanation = '{$strMovieBigo}',  \n";
    $query .= "        notification_flg    = '{$strNotification}'  ";

    $result = db_query($query);
}

if ($result) {
    echo "SUCCESS";
} else {
    echo "FAILED";
}

?>

