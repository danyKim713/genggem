<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg8.jpg);">
            <h2>MY <font size="5px"></font> club</h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->


	<!-- ##### Blog Area Start ##### -->
    <section class="alazea-blog-area mt-30">
        <div class="container">
			
            <div class="row">
								
				<div class="col-12 col-md-12">
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">									
							
						<!-- Shop Page Count -->
						<div class="section-heading">
							<h2><font color="#ff0066">My</font> Club</h2>
							<p>내가 가입한 클럽입니다.</p>
						</div>
					</div>


					<div class="row">
						<?
							$query = "
							select * from gf_channel where pk_channel in (select fk_channel from gf_channel_member where fk_member = '{$rowMember['member_id']}' and 강퇴여부 = 'N') and 사용여부 = 'Y'
								
								UNION 

							select * from gf_channel where member_id = '{$rowMember['member_id']}' and 사용여부 = 'Y'";

							$result = db_query($query);				
							

							while($row = db_fetch($result)){

							$rowC = db_select("select * from gf_channel where pk_channel = '{$row['fk_channel']}'");
							$rowCnt = db_select("select count(*) as cnt from gf_channel_member where fk_channel = '{$row['pk_channel']}' and 강퇴여부 = 'N'");

							$멤버수 = number_format($rowCnt['cnt']);

							$query = "select * from gf_moim where 모임날짜 >= '".date("Y-m-d")."' and fk_channel = '{$row['pk_channel']}' order by 모임날짜 ASC";
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
									<a href="cafe.php?CID=<?=$row['CID']?>" title="클럽 바로가기" class="d-flex"><img src="<?=phpThumb("/_UPLOAD/".$row['채널배경사진'],265,199,"2","assets/images/ex_cafe.jpg")?>" width="100%" height="199" class="radius-5" /></a>

								</div>						
								<a href="cafe.php?CID=<?=$row['CID']?>" title="클럽 바로가기" class="d-flex">
								<div class="text-center <?=$new?>" style="width:30%">
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
										<dt class="color-5 fs--1"><i class="biko-home fs--1 color-warning"></i> <?=$row['채널이름']?></dt>
										<dd class="color-4 fw-500 fs-005 ellipsis-2"><?=$row['채널설명']?></dd>
										<span class="color-6 fs--1"><i class="fas fa-map-marker-alt opacity-50 mr-1"></i><?=$row['시도']?></span>
										<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i> 멤버 <?=$멤버수?>명</span>
									
									</dl>
								</div>
								
								</a>
							</div>
						</div>
						<?}?>						

					</div>


                </div>
            </div>
        </div>
    </section>
    <!-- ##### Blog Area End ##### -->



</body>
<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_cafe.php"; ?>
<script>
	$('.nav_bottom li[data-name="mycafe"]').addClass('active');
</script>
</html>