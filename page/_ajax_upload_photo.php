<?
@session_start();

extract($_POST);

include "include_save_header.php";

$photo = uploadFile($_FILES, "photo", $photo, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

if($photo){
	$query = "update tbl_member set ";
	$query .= "photo='$photo' ";
	$query .= " where member_id='$member_id'";

	$result = db_query($query);
}

echo mysqli_affected_rows($conn)==1?"SUCCESS":"FAIL";