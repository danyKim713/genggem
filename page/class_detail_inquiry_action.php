<?php 
$NO_LOGIN = true;
include "./inc_program.php";

include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strAction   = trim($_POST['txtAction']);
$strRecordNo = trim($_POST['txtRecordNo']);
$strQNo      = trim($_POST['txtQNo']);
$strQuestion = trim($_POST['txtQuestion']);
$strAnswer   = trim($_POST['txtAnswer']);

if ($strAction == "Q") {

	$query  = " INSERT INTO tbl_lesson_inquiry SET    \n";
	$query .= "        l_id      = '{$strRecordNo}',  \n";
	$query .= "        question  = '{$txtQuestion}',  \n";
	$query .= "        isrt_user = '{$rowMember["member_id"]}',  \n";
	$query .= "        isrt_dt   = NOW(),  \n";
	$query .= "        updt_user = '{$rowMember["member_id"]}',  \n";
	$query .= "        updt_dt   = NOW()  \n";

	$result = db_query($query);

	$strQNo = mysqli_insert_id($conn);


	if ($result) {        
		// 문의내용
		$query  = " SELECT A.li_id, A.l_id, A.question, A.answer, A.isrt_user, DATE_FORMAT(A.isrt_dt, '%Y-%m-%d %H:%i:%s') AS isrt_dt, A.updt_user, A.updt_dt, B.name, B.페이지프로필사진, B.닉네임    \n";
		$query .= " FROM    tbl_lesson_inquiry A, tbl_member B    \n";
		$query .= " WHERE  A.li_id = {$strQNo}    \n";
		$query .= " AND    A.isrt_user = B.member_id   \n";  
		$rowInquiry = db_select($query);   

		$strHTML  = "								<ul>  \n";
		$strHTML .= "									<li>  \n";
		$strHTML .= "										<div class=\"single_user_review mb-15\">  \n";
		$strHTML .= "											<div class=\"review-rating\">  \n";

		if (trim($rowInquiry['페이지프로필사진']) != "") {
			$strHTML .= "												<img src=\"".phpThumb("/_UPLOAD/".$rowInquiry['페이지프로필사진'], 100, 100, 2)."\" style=\"border-radius:50px; height:40px; width:40px;\" class=\"author-thumb js-image-preview\">  \n";

		} else {
			$strHTML .= "												<img src=\"./assets/img/bg-img/1.jpg\" style=\"border-radius:50px; height:40px; width:40px;\" class=\"author-thumb js-image-preview\">  \n";
		}


		$strHTML .= "												<span><a href=\"#\">".(trim($rowInquiry["닉네임"]) != "" ? $rowInquiry["닉네임"] : $rowInquiry["name"])."</a> on <span>{$rowInquiry["isrt_dt"]}</span></span>  \n";
		$strHTML .= "											</div>  \n";
		$strHTML .= "											<div class=\"review-details\">  \n";
		$strHTML .= "												<p class=\"ml-5\">".str_replace("\n", "<br>", $rowInquiry["question"])."</p>  \n";


		if ($rowInquiry["answer"] != "") {
			$strHTML .= "												<p class=\"ml-6 divAnswer\">ㄴRe: ".str_replace("\n", "<br>", $rowInquiry["answer"])."  \n";
			$strHTML .= "												    <input type=\"hidden\" class=\"txtQNo\">  \n";
			$strHTML .= "												    <input type=\"hidden\" class=\"txtAnswer\">  \n";
			$strHTML .= "												    <span class=\"btnAnswer\" style=\"display:none\"></span>  \n";
			$strHTML .= "												</p>  \n";
		} else {
			if ($ck_login_member_pk == $rowLesson["member_id"]) {
				$strHTML .= "												<p class=\"ml-6 divAnswer\">  \n";
				$strHTML .= "													<label for=\"comments\">댓글달기</label>  \n";
				$strHTML .= "                                                   <input type=\"hidden\" class=\"txtQNo\" value=\"{$rowInquiry["li_id"]}\">    \n";
				$strHTML .= "													<textarea class=\"form-control txtAnswer\" rows=\"3\" data-max-length=\"150\"></textarea>  \n";
				$strHTML .= "													<span class=\"btn btn-outline-info btn-sm ml-5 btnAnswer\">등록</span>  \n";
				$strHTML .= "												</p>  \n";
			}
		}



		$strHTML .= "											</div>  \n";
		$strHTML .= "										</div>  \n";
		$strHTML .= "									</li>  \n";
		$strHTML .= "								</ul>  \n";



		echo "SUCCESS@{$strHTML}";
	} else {
		echo "FAIL@문의등록이 실패했습니다. 관리자에게 문의하세요.";
	} 

} else if ($strAction == "A") {

	$query  = " UPDATE tbl_lesson_inquiry SET    \n";
	$query .= "        answer    = '{$strAnswer}',  \n";
	$query .= "        updt_user = '{$rowMember["member_id"]}',  \n";
	$query .= "        updt_dt   = NOW()  \n";
	$query .= " WHERE  li_id = {$strQNo}  ";
	$result = db_query($query);

	if ($result) {        
		$query  = " SELECT A.li_id, A.l_id, A.question, A.answer, A.isrt_user, DATE_FORMAT(A.isrt_dt, '%Y-%m-%d %H:%i:%s') AS isrt_dt, A.updt_user, A.updt_dt, B.name, B.페이지프로필사진, B.닉네임    \n";
		$query .= " FROM    tbl_lesson_inquiry A, tbl_member B    \n";
		$query .= " WHERE  A.li_id = {$strQNo}    \n";
		$query .= " AND    A.isrt_user = B.member_id   \n";  
		$rowInquiry = db_select($query);   


		$query  = " SELECT A.li_id, A.l_id, A.question, A.answer, A.isrt_user, DATE_FORMAT(A.isrt_dt, '%Y-%m-%d %H:%i:%s') AS isrt_dt, A.updt_user, A.updt_dt, B.name, B.페이지프로필사진, B.닉네임    \n";
		$query .= " FROM    tbl_lesson_inquiry A, tbl_member B    \n";
		$query .= " WHERE  A.li_id = {$strQNo}    \n";
		$query .= " AND    A.isrt_user = B.member_id   \n";  
		$rowInquiry = db_select($query);   

		$strHTML = "";
		$strHTML .= "												ㄴRe: ".str_replace("\n", "<br>", $rowInquiry["answer"])."  \n";
		$strHTML .= "												<input type=\"hidden\" class=\"txtQNo\">  \n";
		$strHTML .= "												<input type=\"hidden\" class=\"txtAnswer\">  \n";
		$strHTML .= "												<span class=\"btnAnswer\" style=\"display:none\"></span>";
		echo "SUCCESS@{$strHTML}";
	} else {
		echo "FAIL@문의등록이 실패했습니다. 관리자에게 문의하세요.";
	} 

}
?>