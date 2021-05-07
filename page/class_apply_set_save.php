<?php 
$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

// 코치인지 조회
$query = "SELECT co_id FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";
$resultCoach = db_query($query);
$cntCoach = mysqli_num_rows($resultCoach); 

if ($cntCoach <= 0) {  // 코치이면  
    echo "비정상적인 접근입니다.";
    exit;
}

$strRecordNo   = trim($_POST['txtRecordNo']);   // 클래스 ID
$strStartDT   = trim($_POST['txtStartDT']);   // 클래스 시작일
$strEndDT    = trim($_POST['txtEndDT']);     // 클래스 종료일
$strStartTM   = trim($_POST['txtStartTM']);   // 클래스 시작시간
$strEndTM    = trim($_POST['txtEndTM']);     // 클래스 종료시간
$strPoint      = trim($_POST['모임장소']);       // 클래스 장소
$strStatus    = trim($_POST['rdoStatus']);   // 클래스 접수여부

if ($strRecordNo == "")  {
    echo "데이터가 넘어오지 않았습니다. 관리자에게 문의하세요.";
    exit;
}

// 클래스 주문정보
$query  = " SELECT A.lo_id, A.l_id, A.coach_id, A.member_id, A.member_uid, A.payment_flg, A.order_price, A.order_dt, A.l_point, A.status_flg, A.calc_flg,    \n";
$query .= "            A.start_dt, A.start_tm, A.end_dt, A.end_tm,   \n";
$query .= "            B.l_title, B.l_area,  B.cat_id, D.cat_nm, E.lesson_title,  F.name, F.hp     \n";
$query .= " FROM    tbl_lesson_order A, tbl_lesson B, tbl_lesson_category D, tbl_lesson_setup E, tbl_member F    \n";
$query .= " WHERE  A.lo_id = '{$strRecordNo}'   \n";  
$query .= " AND      A.coach_id = '{$ck_login_member_pk}'   \n";  
$query .= " AND      A.l_id = B.l_id   \n";  
$query .= " AND      A.coach_id = E.member_id   \n";  
$query .= " AND      B.cat_id = D.cat_id   \n";
$query .= " AND      A.member_id = F.member_id   \n";


$rowOrder = db_select($query);   


// 정산이 되지않았고, 상태가 '레슨결제완료' 또는 '레슨결제완(확인)' 또는 '레슨수강완료'이면 설정을 진행할 수 있음
if (!($rowOrder["calc_flg"] == "AD001002" && ($rowOrder["status_flg"] == "LOSTAPCM" || $rowOrder["status_flg"] == "LOSTAPCR" || $rowOrder["status_flg"] == "LOSTATCC"))) {   
        echo ("비정상적인 접근입니다.");
        exit;
} 

// 상태변경값이 '레슨결제취소요청(코치)' 가 아니면 값 체크
if ($strStatus != "LOSTACCR") {    

    if ($strStartDT == "") { 
        echo "클래스 시작일을 입력하세요.";
        exit;
    }

    if ($strEndDT == "") { 
        echo "클래스 종료일을 입력하세요.";
        exit;
    }

    if ($strStartTM == "") { 
        echo "클래스 시작시간을 입력하세요.";
        exit;
    }



    if ($strEndTM == "") { 
        echo "클래스 종료시간을 입력하세요.";
        exit;
    }

    if ($strPoint == "") { 
        echo "클래스 장소를 입력하세요.";
        exit;
    }
}

$strMemo  = "\n -- 레슨기간 : ".$strStartDT." ~ ".$strEndDT." \n";
$strMemo .= " -- 레슨시간 : ".$strStartTM." ~ ".$strEndTM." \n";
$strMemo .= " -- 레슨장소 : ".$strPoint." \n";
$strMemo .= ($strStatus == "") ? " -- 상태 : 변경없음":" -- 상태 : ".$clsDBAgent->fnGetCommonCodeNM($strStatus)." \n";

$query  = " UPDATE  tbl_lesson_order SET     \n";

$query  .= "        l_point   = '{$strPoint}',     \n";
$query  .= "        start_dt   = '{$strStartDT}',     \n";
$query  .= "        start_tm   = '{$strStartTM}',     \n";
$query  .= "        end_dt   = '{$strEndDT}',     \n";
$query  .= "        end_tm   = '{$strEndTM}',     \n";
if ($strStatus != "") {  
    $query  .= "        status_flg   = '{$strStatus}',     \n";
}
$query  .= "        memo = CONCAT(memo, '\n>> ', NOW(), ' {$strMemo} -- 수정자[코치]:{$rowMember["name"]} / {$rowMember["UID"]}')   \n";
$query  .= " WHERE lo_id  = '{$strRecordNo}'     \n";


$result = db_query($query);

if ($result) {
    echo "SUCCESS";
} else {
    echo "FAILED";
}
?>