<?php 
$NO_LOGIN = true;
include "./inc_program.php";


$strCareerNM = trim($_POST['selCareer']);   // 커리어
$strName     = trim($_POST['txtname']);     // 이름
$strHP       = trim($_POST['txthp']);       // 연락처
$strCareer   = trim($_POST['txtCareer']);   // 주요경력/활동사항

// 현재회원의 대기중인 코치등록 신청이 있는지 조회
$cnt = db_count("tbl_lesson_apply","member_id = '".$ck_login_member_pk."' and status_flg='COAPYAPY' ","member_id");



if($cnt > 0) {   
    echo  "ALREADY";
} else {  
    // 현재회원의 코치인지 조회
    if ($rowMember['is_coach'] == "AD001001") {
        echo "COACH";
        exit;
    }

    $query  = " INSERT INTO tbl_lesson_apply SET ";
    $query .= "        member_id  = '".$ck_login_member_pk."',";
    $query .= "        ap_dt      = NOW(),";
    $query .= "        coach_career ='{$strCareerNM}',";  // 커리어
    $query .= "        career_memo ='{$strCareer}',";  // 주요경력/활동사항
    $query .= "        status_flg ='COAPYAPY',";  // 신청
    $query .= "        updt_dt      = NOW()";
    $result = db_query($query);

    if ($result) {
        echo "SUCCESS";
    } else {
        echo "FAILED";
    }
}

?>