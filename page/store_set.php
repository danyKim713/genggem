<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body>
<?
$_TITLE = $dic[Franchise_title4];
?>

<body class="mb-5">

<? include "./inc_nav.php"; ?>
<!-- ##### img Area Start ##### -->
	<div class="breadcrumb-area">
        <!-- Top background Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg9.jpg);">
            <h2>Store</h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_store_navi.php"; ?>

	<!-- ##### Blog Area Start ##### -->
    <section class="alazea-blog-area mt-3">
        <div class="container">		

            <div class="row">				
				<div class="col-12 col-md-12">
					
					<!-- best class // 정열 가로 3개 3줄 총 9개 // 아티스트 추천 설정 상품 랜덤 노출 -->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<h2><font color="#ff0066"></font> 스토어 관리</h2>
							<p>회원님이 등록하신 스토어입니다.</p>
							
						</div>
						<div class="search_by_terms">
							 <a href="store_add.php" title="Apply franchise" class="btn-block btn btn-info fs-005">스토어 추가/등록</a>
						</div>
					</div>
					<div class="row">
						
					<?
					if(!$pageNo){
						$pageNo = 1;
					}
					 
					$pageScale = 99999;


					$pageStartNo = ($pageNo -1)*$pageScale;

					$where = " where 1 ";

					////////////////////////////////////////////////////////////////////
						if($search_key && $search_val) $searchSql[] = "$search_key like '%$search_val%'";
						
						if($searchSql) $where .= " and ".implode(" and ",$searchSql);
					////////////////////////////////////////////////////////////////////
						
					$query = "SELECT * ";
					$from = 	"FROM  tbl_store A ";
					$where .= "  and A.reg_member_id = '".$rowMember['member_id']."' ";
					$orderby = " order by  store_id DESC";
					$start = ($pageNo-1)*$pageScale;

					$limit = " LIMIT ".$start.", ".$pageScale;

					$result_all = db_query($query.$from .$where. $orderby.$limit);
					$query_all ="select count(*)  ";
					$num=db_result($query_all. $from .$where);

					$display = $num - ($pageNo-1)*$pageScale;

					while($rowStore = db_fetch($result_all)){

						$rowStoreImage = db_select("select * from tbl_store_image where store_id = '".$rowStore['store_id']."' LIMIT 0,1");
					?>
						<!-- Single Product Area -->
						<div class="col-12 col-sm-6 col-lg-3">
							<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
								<div class="post-thumb">
									 <a href="store.php?store_id=<?=$rowStore['store_id']?>"><img src="<?=phpThumb("/_UPLOAD/".$rowStoreImage['filename'],500,365,"2","assets/images/img_store.jpg")?>" class="radius-5" /></a>
								</div>

								<!-- Product Info -->
								<div class="product-info mt-15">									
									<a href="store.php?store_id=<?=$rowStore['store_id']?>"><p class="ellipsis color-3 fs-05"><?=$rowStore["store_name"]?></p>
									<h6 class="ellipsis-2 color-6 fs-005 lh-4"><?=$rowStore["store_desc"]?></h6></a>
									<p class="fs--1 color-6 mt-2 mb-2">
									<i class="fas fa-calendar-check opacity-60 fw-400"></i> <?=$rowStore["store_addr"]?></p>
								</div></a>
								<div class='d-flex'>
									<a href="store.php?store_id=<?=$rowStore['store_id']?>" title="view" class="btn btn-sm btn-info">상세보기</a>
									<a href="store_edit.php?store_id=<?=$rowStore['store_id']?>" title="modify" class="mx-2 btn btn-sm btn-info5">수정</a>
									<!-- <a href="store_edit.php?store_id=<?=$rowStore['store_id']?>" title="modify" class="btn btn-sm btn-info6">관리자</a> -->
								</div>
							</div>

						</div>

						<?
							}
						?>

					</div>
				</div>
			</div>
		</div>
	</section>



	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_store.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="storeset"]').addClass('active');
</script>

</html>