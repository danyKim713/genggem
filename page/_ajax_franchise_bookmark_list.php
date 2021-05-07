<?
/**
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); 
**/
include "include_save_header.php";

if(!$pageNo){
	$pageNo = 1;
}
 
$pageScale = 5;


$pageStartNo = ($pageNo -1)*$pageScale;

$where = " where 1 ";

////////////////////////////////////////////////////////////////////
	if($search_key && $search_val) $searchSql[] = "$search_key like '%$search_val%'";
	
	if($searchSql) $where .= " and ".implode(" and ",$searchSql);

	if($국가코드) {
		$where .= " and 국가코드 = '$국가코드'";
	}
	
	
	if($store_area0_id) {
		$where .= " and store_area0_id = '$store_area0_id'";
	}
	
	if($store_area1_id) {
		$where .= " and store_area1_id = '$store_area1_id'";
	}

	if($store_area2_id) {
		$where .= " and store_area2_id = '$store_area2_id'";
	}

	if($store_cate_id) {
		$where .= " and store_cate_id = '$store_cate_id'";
	}

////////////////////////////////////////////////////////////////////
	
$query = "SELECT *, (6371*acos(cos(radians(".$lat."))*cos(radians(lat))*cos(radians(lng)-radians(".$lng."))+sin(radians(".$lat."))*sin(radians(lat)))) as distance ";
$from = 	"FROM  tbl_store A, tbl_store_favorite B ";
$where .= "  and A.state = '가맹점 승인' and A.use_yn = 'Y' and A.store_id = B.fk_store_id and B.fk_member_id = '{$rowMember['member_id']}'";
$orderby = " order by  distance ASC";
$start = ($pageNo-1)*$pageScale;

$limit = " LIMIT ".$start.", ".$pageScale;

$result_all = db_query($query.$from .$where. $orderby.$limit);
$query_all ="select count(*)  ";
$num=db_result($query_all. $from .$where);

$display = $num - ($pageNo-1)*$pageScale;

//echo $query.$from .$where. $orderby.$limit;
?>

<?
while($row = db_fetch($result_all)){

	$rowImage = db_select("select * from tbl_store_image where store_id='".$row['store_id']."' order by store_image_id LIMIT 0,1");
?>

		  <div class="col-12 col-sm-6 col-lg-3">
			<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
				<!-- Product Image -->
				<div class="post-thumb">
					 <a href="store.php?store_id=<?=$row['store_id']?>" title="스토어바로가기"><img src="<?=phpThumb("/_UPLOAD/".$rowImage['filename'],500,365,"2","assets/images/img_store.jpg")?>" class="radius-5" /></a>
				</div>

				<!-- Product Info -->
				<a href="store.php?store_id=<?=$row['store_id']?>">
				<div class="product-info mt-15">
					<p class="fs--1"><i class="fas fa-book-open"></i> <?=$row["store_area1_id"]?>분류 &nbsp; &nbsp; <i class="fas fa-map-marker-alt"></i> <?=$row["store_area2_id"]?>도시</p>
					<p class="ellipsis color-3 fs-05"><?=$row["store_name"]?></p>
					
					<h6 class="ellipsis-2 color-6 fs-005 lh-4"><?=$row["store_desc"]?></h6>
					<p class="fs--1 color-6 mt-2 mb-2">
					<i class="fas fa-calendar-check opacity-50"></i> <?=number_format($row['distance'])?> km &nbsp; | &nbsp; <?=$row["store_addr"]?></p>
					<button type="button" class="float-right btn btn-info8 btn-sm radius-5"  onClick="go_즐겨찾기_제휴점_해제('<?=$row['store_id']?>');"><i class="fas fa-times opacity-75"></i> 즐겨찾기 해제</button>
				</div>
				</a>
			</div>
		</div>
						
						
				<?/*<li>
                  <a href='franchise_view.php?store_id=<?=$row['store_id']?>' title='가맹점명 바로가기'>
                    <div class=''>
                      <img src='<?=phpThumb("/_UPLOAD/".$rowImage['filename'],110,81,"2","assets/images/img_store.jpg")?>' alt='' />
                    </div>
                    <div class='con-info ml-2 pr-2'>
                      <h3 class='fs-0 color-4 my-1'><i class="fas fa-store align-text-top fs--1 color-warning mt-1"></i> <?=$row['store_name']?>
					  
					  <button type="button" class="float-right btn btn-outline-danger btn-sm radius-5"  onClick="go_즐겨찾기_제휴점_해제('<?=$row['store_id']?>');"><i class="fas fa-calendar-plus opacity-75"></i> 즐겨찾기 해제</button>
					  
					  </h3>
                      <span class='color-5 fs-005 mb-0 d-block ellipsis'><?=$row['store_desc']?></span>
                      <span class='color-7 fs-005'><span class='color-primary'><?=number_format($row['distance'])?> km</span> <span class="bar"></span><?=$row['store_addr']?></span>
                    </div>
                  </a>
                </li>*/?>
<?}?>

	<input type="hidden" name="num" id="num" value="<?=$num?>"/>
	<input type="hidden" name="pagingPageNo" id="pagingPageNo" value="<?=$pageNo?>"/>