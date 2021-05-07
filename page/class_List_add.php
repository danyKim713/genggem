<?php 
$NO_LOGIN = true;
include "./inc_program.php";

include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();
$strBCat       = $_POST["txtBCat"];        
$strSearchCat  = $_POST["txtSearchCat"];        
$strSearchArea = $_POST["selSearchArea"];
$strSearchText = $_POST["txtSearchText"];
$strSearchPop  = $_POST["txtSearchPop"];        	
$strSearchRecomm  = $_POST["txtSearchRecomm"];        	
$nPageNo       = $_POST["txtPageNo"];    
$nPageListCnt  = $_POST["txtPageListCnt"];

$nStartNo = ($nPageNo-1)*$nPageListCnt;
$arrWhere = array();

if (trim($strSearchPop) == "Y") {	    
	$arrWhere[] = "    A.popularity_flg = 'AD001001'   \n";    //  인기 클래스
}
if (trim($strSearchRecomm) == "Y") {	    
	$arrWhere[] = "    A.show_flg = 'AD001001'   \n";    //  추천 클래스
}

if (trim($strBCat) != "") {	
	$arrWhere[] = "    A.cat_id = '{$strBCat}'  \n";	// 카테고리
}
if (trim($strSearchCat) != "") {	

	$arrWhere[] = "    A.catm_id = '{$strSearchCat}'  \n";	// 카테고리
}

if (trim($strSearchArea) != "") { 
	$arrWhere[] = "    A.클래스기본지역 = '{$strSearchArea}'   \n";    //  클래스기본지역
}
if (trim($strSearchText) != "") { 
	$arrWhere[] = "    (A.l_title LIKE '%{$strSearchText}%' OR C.lesson_title LIKE '%{$strSearchText}%')  \n";    //  클래스명이나 레슨 타이틀
}

$strWhere = implode(" AND ", $arrWhere);


$query  = " SELECT PP.*, QQ.할인금액  \n";
$query .= " FROM   (SELECT A.*, B.cat_nm, C.lesson_title  \n";
$query .= "         FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C, tbl_coach D   \n";
$query .= "         WHERE  A.sale_flg = 'GS730YSA'   \n";    // 판매중인것만
//$query .= "         AND    A.show_flg = 'AD001001'   \n";    // 노출중인것만
$query .= "         AND    D.use_flg = 'AD005001'   \n";    // 코치(사용중)
if (trim($strWhere) != "") $query .= "          AND " . $strWhere;
$query .= "         AND    A.cat_id = B.cat_id   \n"; 
$query .= "         AND    A.member_id = C.member_id   \n";
$query .= "         AND    A.member_id = D.member_id) PP LEFT OUTER JOIN  tbl_coupon QQ  ON PP.쿠폰 = QQ.c_id   \n";
$query .= " ORDER BY PP.l_id DESC   \n";
$query .= " LIMIT {$nStartNo}, {$nPageListCnt} \n";


$resultLesson = db_query($query); 



$strReturn = "";

while ($rowLesson = mysqli_fetch_array($resultLesson)) {
	// 나의 찜정보 가져오기
	$query  = " SELECT COUNT(lz_id) AS cnt   \n";
	$query .= " FROM   tbl_lesson_zzim    \n";
	$query .= " WHERE  l_id = '{$rowLesson["l_id"]}'  \n";
	$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";

	$rowZZim = db_select($query);    

	// 전체 찜정보 가져오기
	$query  = " SELECT COUNT(lz_id) AS cnt   \n";
	$query .= " FROM   tbl_lesson_zzim    \n";
	$query .= " WHERE  l_id = '{$rowLesson["l_id"]}'  \n";

	$rowTotalZZim = db_select($query); 
	$strTotalZZim = $rowTotalZZim["cnt"];

	$strCls = ($rowZZim["cnt"] > 0) ? "btn-warning" : "";

    $nPrice = (trim($rowLesson["쿠폰"]) != "" && trim($rowLesson["쿠폰사용여부"]) == "AD005001") ? number_format($rowLesson["l_price"] - $rowLesson["할인금액"]) : number_format($rowLesson["l_price"]);
	
    $strReturn .= "	                <div class=\"col-12 col-sm-6 col-lg-3\"> \n";
	$strReturn .= "                     <div class=\"single-product-area mb-50 wow fadeInUp\" data-wow-delay=\"100ms\"> \n";
	$strReturn .= "                			<div class=\"post-thumb\"> \n";
	$strReturn .= "                				<a href=\"class_detail.php?txtRecordNo={$rowLesson["l_id"]}\"><img src=\"".phpThumb("/_UPLOAD/".$rowLesson['사진1'],500,365,"2","assets/images/ex_img6.jpg")."\" width=\"100%\" height=\"365\" class=\"radius-5\" /></a> \n";
	$strReturn .= "                			</div> \n";
	$strReturn .= "                         <a href=\"class_detail.php?txtRecordNo={$rowLesson["l_id"]}\"> \n";
	$strReturn .= "                			<div class=\"product-info mt-15\"> \n";
	$strReturn .= "								<p><font size=\"2em\" color=\"\"><i class=\"fas fa-book-open\"></i> {$rowLesson["cat_nm"]} &nbsp;&nbsp;<i class=\"fas fa-user-circle\"></i> {$rowLesson["lesson_title"]}</font></p> \n";
	$strReturn .= "                				<p class=\"mt-1 ellipsis-2\"><font color=\"#000\">{$rowLesson["l_title"]}</font></p> \n";
	$strReturn .= "                				<h6 class=\"mt-1\"><del><font color=\"#000\" class=\"fs--1\">".number_format($rowLesson["l_price"])."원</font></del> &nbsp;&nbsp; <strong><font color=\"#cc0066\">".$nPrice."</font></strong>원</h6> \n";
	//$strReturn .= "                				<h6 class=\"mt-2\"><strong><font color=\"#cc0066\">".$nPrice."</font></strong>원</h6> \n";
	$strReturn .= "                				<p style=\"font-size:12px; line-height:20px; color:#000;\" class=\"mt-2 mb-2\"> \n";
	$strReturn .= "                				<i class=\"fas fa-calendar-check opacity-50\"></i> {$rowLesson["클래스시작일"]} &nbsp; | &nbsp; <i class=\"fas fa-map-marker-alt opacity-50\"></i> {$rowLesson["클래스기본지역"]}</p></a> \n";
	$strReturn .= "                				<a href=\"class_payment.php?txtRecordNo={$rowLesson["l_id"]}\"  class=\"btn-o2 mt-2 mr-2\"><li class=\"fas fa-check\"></li> 강좌신청</a> \n";
	//$strReturn .= "                				<a href=\"class_detail.php?txtRecordNo={$rowLesson["l_id"]}\"  class=\"btn-o2 mt-2 mr-2\"><li class=\"fas fa-search\"></li> 상세보기</a> \n";
	$strReturn .= "                				<a href=\"javascript:void()\" class=\"btn-o2 {$strCls} mt-2 mr-2 btnZZim\" data-val=\"{$rowLesson["l_id"]}\"><li class=\"fas icon_heart_alt lblZZim\"> </li> <span class=\"lblZZimCnt\">{$strTotalZZim}</span></a> \n";
	$strReturn .= "                        </div></a> \n";
	$strReturn .= "                    </div> \n";
	$strReturn .= "                </div> \n";
}

echo $strReturn;

?>