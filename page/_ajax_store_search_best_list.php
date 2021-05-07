<?

$NO_LOGIN = "Y";
include "include_save_header.php";

if(!$pageNo){
    $pageNo = 1;
}
$pageScale = 9999;
$pageStartNo = ($pageNo -1)*$pageScale;

$where = " where 1 ";

////////////////////////////////////////////////////////////////////
if($search_key && $search_val) $searchSql[] = "$search_key like '%$search_val%'";

if($searchSql) $where .= " and ".implode(" and ",$searchSql);

if($txtSearchText) {
    $where .= " and A.store_name like '%$txtSearchText%'";
}


if($store_area0_id) {
    $where .= " and A.store_area0_id = '$store_area0_id'";
}

if($store_area1_id) {
    $where .= " and A.store_area1_id = '$store_area1_id'";
}

if($store_area2_id) {
    $where .= " and A.store_area2_id = '$store_area2_id'";
}

if($selCat) {
    $where .= " and A.store_cate_id = '$selCat'";
}

////////////////////////////////////////////////////////////////////


$query = "SELECT *, (6371*acos(cos(radians(".$lat."))*cos(radians(lat))*cos(radians(lng)-radians(".$lng."))+sin(radians(".$lat."))*sin(radians(lat)))) as distance, B.store_cate_name, C.store_area1_name ";
$from = 	"FROM  tbl_store A, tbl_store_cate B, tbl_store_area1 C ";
$where .= " and A.state = '가맹점 승인' and A.best_yn = 'Y' and A.use_yn = 'Y' ";
$where .= " and A.store_cate_id = B.store_cate_id ";
$where .= " and A.store_area1_id = C.store_area1_id ";

$orderby = " order by  distance ASC";
$start = ($pageNo-1)*$pageScale;

//$limit = " LIMIT ".$start.", ".$pageScale;

$result_all = db_query($query.$from .$where. $orderby.$limit);
$query_all ="select count(*)  ";
$num=db_result($query_all. $from .$where);

$display = $num - ($pageNo-1)*$pageScale;

//echo $query.$from .$where. $orderby.$limit;
?>

<?
while($rowStore = db_fetch($result_all)){

    $rowImage = db_select("select * from tbl_store_image where store_id='".$rowStore['store_id']."' order by store_image_id LIMIT 0,1");
    ?>
    <!-- Single Product Area -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
            <div class="post-thumb">
                <a href="store.php?store_id=<?=$rowStore['store_id']?>"><img src="<?=phpThumb("/_UPLOAD/".$rowImage['filename'],500,365,"2","assets/images/img_store.jpg")?>" class="radius-5" /></a>
            </div>

            <!-- Product Info -->
            <a href="store.php?store_id=<?=$rowStore['store_id']?>">
                <div class="product-info mt-15">
                    <p><font size="2em" color=""><i class="fas fa-book-open"></i>  <?=$rowStore["store_cate_name"]?> &nbsp; &nbsp; <i class="fas fa-map-marker-alt"></i> <?=$rowStore["store_area1_name"]?> </font></p>
                    <p class="ellipsis"><font color="#000"><?=$rowStore["store_name"]?></font></p>

                    <h6 class="ellipsis-2 color-6 fs--1 lh-4"><?=$rowStore["store_desc"]?></h6>
                    <p style="font-size:12px; line-height:20px; color:#000;" class="mt-2 mb-2">
                        <i class="fas fa-calendar-check opacity-50"></i> <?=number_format($rowStore['distance'])?> km &nbsp; | &nbsp; <?=$rowStore["store_addr"]?></p>
                </div></a>
        </div>
    </div>

    <?
}
?>