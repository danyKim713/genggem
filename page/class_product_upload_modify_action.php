<?php 
$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strRecordNo     = trim($_POST['txtRecordNo']);       // 클래스상품명
$strLessonTitle     = trim($_POST['txtLessonTitle']);       // 클래스상품명
$strTag             = trim($_POST['txtTag']);               // 클래스태그
$nPrice             = trim($_POST['txtPrice']);             // 클래스상품가격(원)
$strCoupon          = trim($_POST['selcoupon']);             // 쿠폰
$strCat             = trim($_POST["selCat"]);               // 클래스종류
$strCatM            = trim($_POST["selCatM"]);              // 중분류

$우편번호            = trim($_POST['우편번호']);              // 클래스가능지역
$클래스주소            = trim($_POST['클래스주소']);              // 클래스가능지역
$strArea            = trim($_POST['txtArea']);              // 클래스가능지역
//trim($_POST['txtLessonGreetings']);   // 클래스상품소개
$strSaleTmp         = trim($_POST['chkSale']);              // 판매여부
$strShowTmp         = trim($_POST['chkShow']);              // 노출여부


// 쿠폰 수량 체크(2개)
$query  = " SELECT COUNT(l_id) AS cnt   \n";
$query .= " FROM   tbl_lesson  \n";
$query .= " WHERE  l_id <> '{$strRecordNo}'   \n";
$query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";
$query .= " AND    쿠폰 IS NOT NULL   \n";    //  쿠폰 있는 것만
$rowCouponLesson = db_select($query);   

if (trim($strCoupon) != "" && $rowCouponLesson["cnt"] > 1) {
    echo "쿠폰 등록 가능한 클래스는 최대 2개까지 입니다.(현재 쿠폰등록 클래스는 2개입니다.)";
    exit;
}



// 노출클래스 수량 체크(2개)
$query  = " SELECT COUNT(l_id) AS cnt   \n";
$query .= " FROM   tbl_lesson  \n";
$query .= " WHERE  l_id <> '{$strRecordNo}'   \n";
$query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";
$query .= " AND    show_flg = 'AD001001'   \n";    //  노출 클래스만 
$rowShowLesson = db_select($query);   

if ($strShowTmp == "AD001001" && $rowShowLesson["cnt"] > 1) {
    echo "노출할 수 있는 클래스는 2개까지 입니다.(현재 노출클래스 설정이 2개입니다.)";
    exit;
}

if (trim($strLessonTitle) == "") {
    echo "클래스 상품명을 입력하세요."; 
    exit;
}

if ($strTag == "") {
    echo "클래스 검색어을 입력하세요.";
    exit;
}

if ($nPrice == "") {
    echo "클래스 상품가격을 입력하세요.";
    exit;
}

if ($strCat == "") {
    echo "클래스종류를 선택하세요.";
    exit;
}


if (trim($_POST['txtLessonGreetings']) == "") {
    echo "클래스 상품소개를 입력하세요.";
    exit;
}

$strSale = $strSaleTmp;

if ($strSaleTmp == "") {
    $strSale = 'GS730NSA';
}

$strShow = $strShowTmp;

if ($strShowTmp == "") {
    $strShow = 'AD001002';
}

$사진1 = uploadFile($_FILES, "사진1", $사진1, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
$사진2 = uploadFile($_FILES, "사진2", $사진1, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
$사진3 = uploadFile($_FILES, "사진3", $사진1, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
$사진4 = uploadFile($_FILES, "사진4", $사진1, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
$사진5 = uploadFile($_FILES, "사진5", $사진1, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
$사진6 = uploadFile($_FILES, "사진6", $사진1, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");


$query  = " UPDATE tbl_lesson SET  \n";
$query .= "        member_id  = '{$rowMember["member_id"]}',  \n";
$query .= "        member_uid = '{$rowMember["UID"]}',  \n";
$query .= "        l_title    = '{$strLessonTitle}',  \n";
$query .= "        우편번호    = '{$우편번호}',  \n";
$query .= "        클래스주소    = '{$클래스주소}',  \n";
$query .= "        클래스상세주소    = '{$클래스상세주소}',  \n";
$query .= "        l_tag      = '{$strTag}',  \n";
$query .= "        l_price    = '{$nPrice}',  \n";
if (trim($strCoupon) != "") {
	$query .= "        쿠폰        = '{$strCoupon}',  \n";
} else {
	$query .= "        쿠폰        = NULL,  \n";
}
$query .= "        cat_id     = '{$strCat}',  \n";
$query .= "        catm_id    = '{$strCatM}',  \n";
$query .= "        l_area     = '{$strArea}',  \n";
$query .= "        l_intro    = '".$_POST['txtLessonGreetings']."',  \n";
$query .= "        sale_flg   = '{$strSale}',  \n";
$query .= "        show_flg   = '{$strShow}',  \n";
if($사진1){
	$query .= "        사진1   = '{$사진1}',  \n";
}
if($사진2){
	$query .= "        사진2   = '{$사진2}',  \n";
}
if($사진3){
	$query .= "        사진3   = '{$사진3}',  \n";
}
if($사진4){
	$query .= "        사진4   = '{$사진4}',  \n";
}
if($사진5){
	$query .= "        사진5   = '{$사진5}',  \n";
}
if($사진6){
	$query .= "        사진6   = '{$사진6}',  \n";
}
$query .= "        클래스기본지역   = '{$클래스기본지역}',  \n";
$query .= "        클래스시작일   = '{$클래스시작일}',  \n";
$query .= "        클래스난이도   = '{$클래스난이도}',  \n";
$query .= "        소요시간   = '{$소요시간}',  \n";
$query .= "        수업인원   = '{$수업인원}',  \n";
$query .= "        updt_dt    = NOW()  \n";
$query .= " WHERE  l_id = '{$strRecordNo}'  \n";
//echo $query;
//exit;
$result = db_query($query);

if ($result) {
    echo "SUCCESS";
} else {
    echo "FAILED";
}
