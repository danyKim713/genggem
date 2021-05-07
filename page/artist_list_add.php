<?php 
$NO_LOGIN = true;
include "./inc_program.php";

include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$nPageNo       = $_POST["txtPageNo"];    
$nPageListCnt  = $_POST["txtPageListCnt"];

$nStartNo = ($nPageNo-1)*$nPageListCnt;




$query  = " SELECT PP.c_id, PP.member_id, PP.coach_career, PP.career_memo, PP.use_flg, PP.recomm_flg, PP.memo, PP.isrt_dt, PP.member_uid, PP.background_photo, PP.profile_photo, PP.lesson_title, PP.lesson_greetings, QQ.*    \n";
$query .= " FROM   (SELECT A.co_id AS c_id, A.member_id, A.coach_career, A.career_memo, A.use_flg, A.recomm_flg, A.memo, A.isrt_dt, B.member_uid, B.background_photo, B.profile_photo, B.lesson_title, B.lesson_greetings   \n";
$query .= "         FROM   tbl_coach A, tbl_lesson_setup B \n";
$query .= "         WHERE  A.use_flg = 'AD005001'   \n";    //  사용중인 코치만
$query .= "         AND    A.member_id = B.member_id) PP LEFT OUTER JOIN   \n";
$query .= "         (SELECT DISTINCT(coach_id) AS co_id, COUNT(coach_id) AS c_cnt  FROM tbl_lesson_order) QQ ON  PP.member_id = QQ.co_id   \n";
$query .= " ORDER BY QQ.c_cnt DESC   \n";
$query .= " LIMIT {$nStartNo}, {$nPageListCnt} \n";
$resultCoach = db_query($query); 

$strReturn = "";

while ($rowCoach = mysqli_fetch_array($resultCoach)) {


	// 내영상정보 가져오기
	$query  = " SELECT COUNT(wv_id) AS cnt   \n";
	$query .= " FROM   tbl_watch_video   \n";
	$query .= " WHERE  member_id='{$rowCoach["member_id"]}'   \n"; 
	$query .= " AND    use_flg = 'AD005001'   \n"; 

	$resultWatch = db_select($query); 

	// 아티스트의 클래스 수
	$query  = " SELECT COUNT(l_id) AS cnt   \n";
	$query .= " FROM   tbl_lesson    \n";
	$query .= " WHERE  member_id = {$rowCoach["member_id"]}   \n";    //  현재 아티스트것만
	$query .= " AND    sale_flg = 'GS730YSA'   \n";    //  판매중인 클래스만 

	$rowClass = db_select($query); 

	$strImg = "";
	// 이미지 
	if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchImg/{$rowCoach['member_uid']}/{$rowCoach["profile_photo"]}")) { 
		$strImg = '<img src="'.phpThumb("/ImgData/WatchImg/{$rowCoach['member_uid']}/{$rowCoach["profile_photo"]}",500,365,"2","assets/images/ex_img6.jpg").'" class="radius-5" />';
	}

	$strReturn .= "                <div class=\"col-12 col-sm-6 col-lg-3\">   \n";
	$strReturn .= "                    <div class=\"single-product-area mb-50 wow fadeInUp\" data-wow-delay=\"100ms\">   \n";
	$strReturn .= "                        <div>   \n";
	$strReturn .= "                           <a href=\"artist.php?txtRecordNo={$rowCoach["c_id"]}\" title=\"\">{$strImg}</a>   \n";
	$strReturn .= "                        </div>   \n";
	$strReturn .= "						   <a href=\"artist.php?txtRecordNo={$rowCoach["c_id"]}\" title=\"\">  \n";
	$strReturn .= "                        <div class=\"product-info mt-15\">   \n";
	$strReturn .= "                         <p><font size=\"3em\" color=\"\"><i class=\"fas fa-user-circle\"></i> {$rowCoach["lesson_title"]}</font></p>   \n";
	$strReturn .= "							<p style=\"height:px;line-height:20px;\"><font color=\"#000\"></font></p>   \n";

	$strReturn .= "							<p style=\"height:40px;line-height:20px;\" class=\"ellipsis-2\"><font color=\"#000\">{$rowCoach["lesson_greetings"]}</font></p>   \n";
	$strReturn .= "							<p style=\"font-size:12px; line-height:20px; color:#000;\" class=\" mt-2\">   \n";
	$strReturn .= "							<i class=\"fas fa-list opacity-50 mr-1\"></i>클래스 ".number_format($rowClass["cnt"])." ea </p>   \n";
	$strReturn .= "                        </div></a>   \n";
	$strReturn .= "                    </div>   \n";
	$strReturn .= "                </div>   \n";


}



echo $strReturn;

?>