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
            <h2>CAFE <font size="5px">in</font> Cafehands</h2>
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
							<h2><font color="#ff0066">Cafe</font> of interest</h2>
							<p>관심 카페로 설정한 카페입니다.</p>
						</div>
					</div>


					<div class="row">
						<?
						$query = "select * from gf_channel_interested where fk_member = '{$rowMember['member_id']}'";
						$result = db_query($query);

						while($row = db_fetch($result)){

							$rowC = db_select("select * from gf_channel where pk_channel = '{$row['fk_channel']}'");

							$rowCnt = db_select("select count(*) as cnt from gf_channel_member where fk_channel = '{$row['fk_channel']}' and 강퇴여부 = 'N'");
							$멤버수 = number_format($rowCnt['cnt']) + 1;
						?>
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-6 col-lg-4">
							<div class="single-blog-post mb-70">
								<div class="post-thumbnail mb-20">
									<a href="cafe.php?CID=<?=$rowC['CID']?>" title="클럽 바로가기" class="d-flex"><img src="<?=phpThumb("/_UPLOAD/".$rowC['채널배경사진'],265,199,"2","assets/images/ex_cafe.jpg")?>" width="100%" height="199" class="radius-5" /></a>

								</div>						
								<a href="cafe.php?CID=<?=$rowC['CID']?>" title="클럽 바로가기" class="d-flex">
								<div class="border-left" style="width:100%; padding-left:10px;">
									<dl class="mb-0">									
										<dt class="color-5 fs--1"><i class="biko-home fs--1 color-warning"></i> <?=$rowC['채널이름']?></dt>
										<dd class="color-4 fw-500 fs-005 ellipsis-2 mt-2"><?=$rowC['채널설명']?></dd>
										<span class="color-6 fs--1"><i class="fas fa-map-marker-alt opacity-50 mr-1"></i><?=$rowC['시도']?></span>
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
	$('.nav_bottom li[data-name="cafelike"]').addClass('active');
</script>
</html>