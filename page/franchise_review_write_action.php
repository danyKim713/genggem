<? include  "include_save_header.php"; ?>
<?
/**
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); 
**/

//중복 작성 방지
$cnt = db_count("tbl_store_review", "store_id='$store_id' and member_id='$member_id'");
if($cnt > 0){
	msg_only('죄송합니다. 스토어 당 한개의 리뷰만 작성하실 수 있습니다.');
}

if (!$review_content) {
	msg_only('리뷰내용을 입력해주세요.');
 }
if($_FILES["img1"]["tmp_name"]){
	$img1 = file_upload($_FILES["img1"]["tmp_name"], $_FILES["img1"]["name"], $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
}
if($_FILES["img2"]["tmp_name"]){
	$img2 = file_upload($_FILES["img2"]["tmp_name"], $_FILES["img2"]["name"], $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
}
if($_FILES["img3"]["tmp_name"]){
	$img3 = file_upload($_FILES["img3"]["tmp_name"], $_FILES["img3"]["name"], $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");
}

$member_id = $rowMember['member_id'];

$query = "insert into tbl_store_review set ";
$query .= "store_id='$store_id',";
$query .= "member_id='$member_id',";
$query .= "star_rate='$star_rate',";
$query .= "review_content='$review_content',";
$query .= "img1='$img1',";
$query .= "img2='$img2',";
$query .= "img3='$img3',";
$query .= "regdate=NOW(),";
$query .= "ip='".$_SERVER['REMOTE_ADDR']."'";

$result = db_query($query);

msg_top_page("리뷰를 작성해주셔서 감사합니다.","store.php?store_id=".$store_id);