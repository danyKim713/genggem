<!DOCTYPE HTML>
<html lang="en">
<?
    $NO_LOGIN = "Y";
	include "./inc_program.php"; 
?>
<?
if($_GET['채널카테고리']){
	$where = " and 채널카테고리 = '{$채널카테고리}'";
}
if($_GET['시도']){
	$where = " and 시도 = '{$시도}'";
}
?>

<script>
	$(function(){
		$("#키워드").keyup(function(e){
			go_list_search();
		});
	});

	function go_list_search(){
		var 키워드 = $("#키워드").val();

		$.ajax({
			type: 'POST',
			url: "_ajax_channel_search.php",
			data: {
				키워드: 키워드
			},
			async: false,
			success: function(data){
				$("#search-result").html(data);
			}
		});
	}
</script>

<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg8.jpg);">
            <h2>CAFE <font size="5px">in</font> Cafehands</h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->


	<!-- ##### Blog Area Start ##### -->
    <section class="alazea-blog-area mt-30">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h2>cafe</h2>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='cafe_view.php' class="form-inline mb-2">
						
						<select name="selSearchCat" class="custom-select" onchange="javacript:frmSearch.submit();">
							<option value="">카페분류</option>
							<?
								for ($i=1; $i<=count($채널카테고리배열); $i++){
								$m = $i<10?"0".$i:$i;
							?>
							<option value="<?=$채널카테고리배열[$i-1]?>" title='<?=$채널카테고리배열[$i-1]?>'><?=$채널카테고리배열[$i-1]?></a></option>
							<?}?>
						</select>
						<select name="selSearchArea" class="custom-select" onchange="javacript:frmSearch.submit();">
							<option value="">지역별</option>
							<?
								for ($i=1; $i<=count($시도배열); $i++){
								$m = $i<10?"0".$i:$i;
							?>
							<option value="<?=$시도배열[$i-1]?>" title='<?=$시도배열[$i-1]?>'><?=$시도배열[$i-1]?></a></option>
							<?}?>
						</select>
						<!-- <input class="form-control" id="txtSearchText" name="txtSearchText" type="text" placeholder="search cafe.." style="width:170px;" /> -->
						<input class="form-control mr-2" id="txtSearchText" name="txtSearchText" type="text" placeholder="카페를 검색해 보세요." value="<?=$시도?><?=$키워드?>"/>
						<button class="btn btn-info"><i class="fas fa-comments color-warning"></i> 카페검색</button>

					</form>							
				</div>
				<!-- Search by Terms -->				
			</div>

            <div class="row">				
				<div class="col-12 col-md-4">
                    <div class="post-sidebar-area">

                        <!-- ##### Single Widget Area ##### -->
						<div class="single-widget-area">
							<div class="post-thumb mb-4">
								 <a href=""><img src="assets/img/bg-img/cafe_guide.jpg" width="100%" height="75" class="radius-5" /></a>
							</div>

							<div class="widget-title mt-5 shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
								<div class="section-heading">
									<h4><font color="#ff3399">HOT</font> cafe</h4>
									<p>요즘 많은 사랑받는 카페입니다.</p>
								</div>
							</div>


                            <!-- Single Latest Posts -->
							<?
								$query = "select C.*, (select count(*) as cnt from gf_channel_member M where M.fk_channel = C.pk_channel) as MemberCnt from gf_channel C where C.사용여부 = 'Y' {$where} order by MemberCnt DESC LIMIT 0,10";
								$result = db_query($query);

								$list = array();
								while($row = db_fetch($result)){
									$list[] = $row;
								}

								shuffle($list);

								for ($i=0; $i<count($list); $i++){
									$row = $list[$i];

//								$query = "select count(*) as cnt from gf_channel_member where fk_channel = '{$pk_channel}' and 강퇴여부 = 'N'";
								$query = "select count(*) as cnt from gf_channel_member where fk_channel = '{$row["pk_channel"]}' and 강퇴여부 = 'N'";

								$rowC = db_select($query);
								$멤버수 = $rowC['cnt'] + 1;

							?>
                            <div class="single-latest-post d-flex align-items-center">
                                <div class="post-thumb">
                                     <a href="cafe.php?CID=<?=$row['CID']?>"><img src="<?=phpThumb("/_UPLOAD/".$row['채널배경사진'],155,90,"2","assets/images/ex_img7.jpg")?>" width="100%" height="90" class="radius-5" /></a>
                                </div>
                                <div class="post-content">
									<a href="cafe.php?CID=<?=$row['CID']?>" class="ellipsis"><i class="fas fa-comments fs--1 color-warning mb-3"></i> <?=cutstr($row['채널이름'], 30)?></a><br>
                                    <a href="cafe.php?CID=<?=$row['CID']?>" class="post-title ellipsis-2"><?=cutstr($row['채널설명'], 66)?></a><br>
                                    <a href="cafe.php?CID=<?=$row['CID']?>" class="color-5 fs--1"><i class="fas fa-map-marker-alt color-5"></i> <?=$row['시도']?></a> ㅣ 
                                    <a href="cafe.php?CID=<?=$row['CID']?>" class="color-5 fs--1"><i class="fa fa-user" aria-hidden="true"></i> 멤버 <?=number_format($멤버수)?>명</a>
                                </div>
                            </div>
							<?}?>
                            
                        </div>

                        <!-- ##### Single Widget Area ##### -->
                        <div class="single-widget-area">
                            <!-- Title -->
                            <div class="widget-title">
                                <h4>cafe tag</h4>
                            </div>
                            <!-- Tags -->
                            <ol class="popular-tags d-flex flex-wrap">
                                <li><a href="#">PLANTS</a></li>
                                <li><a href="#">NEW PRODUCTS</a></li>
                                <li><a href="#">CACTUS</a></li>
                                <li><a href="#">DESIGN</a></li>
                                <li><a href="#">NEWS</a></li>
                                <li><a href="#">TRENDING</a></li>
                                <li><a href="#">VIDEO</a></li>
                                <li><a href="#">GARDEN DESIGN</a></li>
                            </ol>
                        </div>
                        
                    </div>
                </div>
				
				
				
				<div class="col-12 col-md-8">
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">									
							
						<!-- Shop Page Count -->
						<div class="section-heading">
							<h2><font color="#ff0066">My</font> Cafe</h2>
							<p>내가 가입한 카페 소식입니다.</p>
						</div>
						<div class="search_by_terms">
							<a href="cafe_my.php"><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-comments fs--1 color-warning"></i> 가입카페 전체보기</button></a>	
						</div>
					</div>


					<div class="row justify-content-center">
						<?
						$query = "
							select * from gf_channel where pk_channel in (select fk_channel from gf_channel_member where fk_member = '{$rowMember['member_id']}' and 강퇴여부 = 'N') and 사용여부 = 'Y'
								
								UNION 

							select * from gf_channel where member_id = '{$rowMember['member_id']}' and 사용여부 = 'Y'  order by member_id DESC LIMIT 0,3";
						$result = db_query($query);

						while($row = db_fetch($result)){

							$query = "select * from gf_moim where 모임날짜 >= '".date("Y-m-d")."' and fk_channel = '{$row['pk_channel']}'";
							$rowMoim = db_select($query);

							$모임일시 = $rowMoim['모임날짜']." ".$rowMoim['모임시간'].":00";

							$시간차 = time() - strtotime($모임일시);

							if($시간차 < 60*60*24*3 && $rowMoim['pk_moim']>0){
								$new = "new";
							}else{
								$new = "";
							}

							if(date("Ymd")!=date("Ymd", strtotime($모임일시))){
								$날짜 = date("n/j", strtotime($모임일시));
							}else{
								$날짜 = "오늘";
							}	

							if(date("A", strtotime($모임일시))=="AM"){$시간="오전 ".date("H:i", strtotime($모임일시));}
							if(date("A", strtotime($모임일시))=="PM"){$시간="오후 ".date("H:i", strtotime($모임일시));}

						?>

						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-6 col-lg-4">
							<div class="single-blog-post mb-70">
								<div class="post-thumbnail mb-20">
									<a href="cafe.php?CID=<?=$row['CID']?>" title="카페 바로가기" class="d-flex"><img src="<?=phpThumb("/_UPLOAD/".$row['채널배경사진'],265,154,"2","assets/images/ex_img7.jpg")?>" width="100%" height="154" class="radius-5" /></a>

								</div>						
								<a href="cafe.php?CID=<?=$row['CID']?>" title="카페 바로가기" class="d-flex">
								<div class="text-center" style="width:30%">
									<!--일정있을때-->
									<? if($rowMoim['pk_moim']){?>
									<!-- <li class="<?=$new?>"> -->
									<p class="color-6 fs--1 mb-0"><?=get_요일($모임일시)?>요일</p>
									<strong class="fs-05 color-1"><?=$날짜?></strong>
									<p class="color-6 fs--1 mb-0"><?=$시간?></p>
									<?}else{?>
									<i class="fas fa-calendar-minus color-9 fs-2"><br>
									<span style="font-size:11px; color:#ccc;">일정없음</span></i>
									<?}?>
									<!--//일정있을때-->
								</div>
								<div class="border-left" style="width:70%; padding-left:10px;">
									<dl class="mb-0">
									<? if($rowMoim['pk_moim']>0){?>
										<dt class="color-5 fs--1"><i class="biko-home fs--1 color-warning"></i> <?=$row['채널이름']?></dt>
										<dt class="color-4 fs--1"><i class="fas fa-medal fs--1 color-success"></i> <?=$rowMoim['모임제목']?></dt>
										<dt class="color-6 fw-500 fs--1 ellipsis"><i class="fa fa-sticky-note" aria-hidden="true"></i> <?=$rowMoim['모임설명']?></dd>
										<dt class="color-6 fs--1"><i class="fas fa-map-marker-alt"></i> <?=$rowMoim['모임장소']?></dd>
									<?}else{?>
										<dt class="color-5 fs--1"><i class="biko-home fs--1 color-warning"></i> <?=$row['채널이름']?></dt>
										<dd class="color-4 fw-500 fs-005 ellipsis-2"><?=$row['채널설명']?></dd>
										<span class="color-6 fs--1"><i class="fas fa-map-marker-alt opacity-50 mr-1"></i><?=$row['시도']?></span> <span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i> 멤버 <?=$멤버수?>명</span>
									<?}?>
									</dl>
								</div>
								</a>
							</div>
						</div>
						<?}?>
					</div>

					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">									
							
						<!-- Shop Page Count -->
						<div class="section-heading">
							<h2><font color="#0066ff">New</font> Cafe</h2>
							<p>새로 개설된 카페입니다.</p>
						</div>
						<div class="search_by_terms">
							<a href="cafe_view.php"><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-comments fs--1 color-warning"></i> 카페 전체보기</button></a>					
						</div>
					</div>

					<div class="row">
						
						<?
						$query = "select C.* from gf_channel C where C.사용여부 = 'Y' {$where} order by 생성일시 DESC LIMIT 0,12";
						$result = db_query($query);

						$list = array();
						while($row = db_fetch($result)){
							$list[] = $row;
						}

						shuffle($list);

						for ($i=0; ($i<count($list) && $i<9); $i++){
							$row = $list[$i];
						?>	
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-6 col-lg-4 mb-3">
								<?= 채널리스트($row['pk_channel']);?>							
						</div>
						<?}?>

					</div>

                </div>
            </div>
        </div>
    </section>
    <!-- ##### Blog Area End ##### -->



<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_cafe.php"; ?>

</body>

<script>
	$('.nav_category li[data-name="gnb-channel"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>

</html>
