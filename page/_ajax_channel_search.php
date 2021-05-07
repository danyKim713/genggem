<?
require_once "include_save_header.php";

$필드배열 = array("CID","채널카테고리","시도","구군","채널이름","채널태그","채널연령대","채널설명");

$where = array();
for ($i=0; $i<sizeof($필드배열); $i++){
	$where[] = " {$필드배열[$i]} like '%$키워드%'";
}

$where = implode (" or ", $where);

$query = "select * from gf_channel where 1 and ({$where}) and 사용여부 = 'Y'";
$result = db_query($query);

if(db_num_rows($result)==0){

?>


	<!-- 채널 검색 결과 : 검색결과 채널이 없을때 -->
	<div class="text-center fs-005 color-6">해당 카페가 없습니다.</div>
	<!--//-->

	<?
	}else{
	?>

	<div class="col-12 col-md-12">'<?=$키워드?>' 검색 결과입니다.</div>
	<? 
	while($row = db_fetch($result)){
	?>
	<div class="col-12 col-md-6 col-lg-3 mb-3">
		<?= 채널리스트($row['pk_channel'])?>								
	</div>
	<?}?>
<?}?>
