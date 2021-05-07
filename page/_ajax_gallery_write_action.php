<?
$_GET['CID'] = $_SESSION['S_CID'];

include "include_save_header.php";

//$페이지배경사진 = uploadFile($_FILES, "페이지배경사진", $페이지배경사진, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

$이미지파일명_array = uploadMultiFile($_FILES, "files", $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

error_log(print_r($이미지파일명_array, true));

//if(!$내용){
//	echo "MANDATORY_ERROR";
//	exit;
//}

$query = "insert into gf_gallery set ";
$query .= "fk_channel='{$rowChannel['pk_channel']}',";
$query .= "fk_member='{$rowMember['member_id']}',";
$query .= "내용='$내용',";
$query .= "등록일시=NOW()";

$result = db_query($query);

$fk_gallery = mysqli_insert_id($conn);

for ($i=0; $i<count($이미지파일명_array); $i++){
	$query = "insert into gf_gallery_img set ";
	$query .= "fk_gallery = '{$fk_gallery}',";
	$query .= "이미지파일명 = '{$이미지파일명_array[$i]}'";

	db_query($query);
}

if($result){
	echo "SUCCESS";
	exit;
}