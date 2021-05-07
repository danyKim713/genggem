<?
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); 

include  "include_save_header.php"; 

//member_id 일치하는지 확인!
$rowReview = db_select("select * from tbl_store_review where review_id='".$review_id."'");

if($rowMember['member_id']!=$rowReview['member_id']){
	msg_only('타인의 리뷰는 삭제하실 수 없습니다.');
}

$query = "delete from tbl_store_review where review_id='".$review_id."'";
db_query($query);

msg_top_page("리뷰가 정상적으로 삭제되었습니다.","store.php?store_id=".$rowReview['store_id']);