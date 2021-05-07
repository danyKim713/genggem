<?
include "include_save_header.php";

$이미지파일명_array = uploadMultiFile($_FILES, "files", $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

error_log(print_r($이미지파일명_array, true));

if(!$내용){
	echo "MANDATORY_ERROR";
	exit;
}

$query = "update gf_page_article set ";
$query .= "내용='$내용' ";
$query .= "where pk_page_article = '$pk_page_article' and member_id='{$rowMember['member_id']}'";

$result = db_query($query);

if(count($이미지파일명_array) > 0){
	$query = "delete from gf_page_photo where fk_page_article = '{$pk_page_article}'";
	db_query($query);
}

for ($i=0; $i<count($이미지파일명_array); $i++){
	$query = "insert into gf_page_photo set ";
	$query .= "fk_page_article = '{$pk_page_article}',";
	$query .= "이미지파일명 = '{$이미지파일명_array[$i]}'";

	db_query($query);
}


if($result){
	echo "SUCCESS";
	exit;
}