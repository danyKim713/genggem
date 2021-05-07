<?
@session_start();

$_GET['CID'] = $_SESSION['S_CID'];

include "include_save_header.php";

$pageScale = 10;

$start = ($pageNo-1)*$pageScale;
$limit = " LIMIT ".$start.", ".$pageScale;

$query = "select * from  gf_gallery where fk_channel = '{$rowChannel['pk_channel']}' order by 등록일시 DESC {$limit} ";
$resultB = db_query($query);

while($rowB = db_fetch($resultB)){

	$rowM = get_member_row($rowB['fk_member']);

	$query = "select * from gf_gallery_img where fk_gallery = '{$rowB['pk_gallery']}'";
	$rowG = db_select($query);

	/**
	$query = "select count(*) as cnt from gf_channel_bbs_like where fk_channel_bbs = '{$rowB['pk_channel_bbs']}'";
	$rowL = db_select($query);
	$좋아요수 = number_format($rowL['cnt']);

	$query = "select count(*) as cnt from gf_channel_reply where fk_channel_bbs = '{$rowB['pk_channel_bbs']}' and fk_channel_reply in ('0', '')";
	$rowL = db_select($query);
	$댓글수 = number_format($rowL['cnt']);
	**/

?>
					<a href="cafe_gallery_view.php?CID=<?=$CID?>&pk_gallery=<?=$rowB['pk_gallery']?>" onClick="popct(this.href, '500', '700');return false" class="card">
						<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".($rowG['이미지파일명']),300,300,"2","assets/images/ex_img3.jpg")?>" alt="">
						 <figcaption class="figure-caption"><?=$rowM['닉네임']?></figcaption>
					</a>

<?}?>