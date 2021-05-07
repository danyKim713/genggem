<? 
	$NO_LOGIN = "Y";
	include "./inc_program.php";  
?>

<!DOCTYPE HTML>
<html lang="en">

<? include "./inc_Head.php"; ?>
<script>
	function go_change_2nd(id, src){
		$("#"+id).attr("src", src);
	}
	function go_org(id, src){
		$("#"+id).attr("src", src);
	}
</script>

<body class="mb-5">
<? include "./inc_nav.php"; ?>
    <div class="breadcrumb-area">
        <!-- Top background Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg1.jpg);">
            <h2>여러분과 함께하는 열린교육</h2>
        </div>
    </div>
    <!-- ##### background Area End ##### -->


	<section id="m_bnr2">
		<div>
			<ul>
				<li class="wow fadeInDown">
					<a href="hanc_lecture.php">
						<div><i class="fa fa-list" aria-hidden="true"></i></div>
						<p class="txt_tit">강좌안내</p>
					</a>
				</li>
				<li class="wow fadeInUp">
					<a href="hanc_apply.php">
						<div><i class="fa fa-user" aria-hidden="true"></i></div>
						<p class="txt_tit">수강신청</p>
					</a>
				</li>
				<li class="wow fadeInDown">
					<!-- <a href="hanc_online.php"> -->
					<a href='javascript:void(0)' title='온라인강좌' onClick="alert('서비스 준비중입니다')">
						<div><i class="fas fa-edit" aria-hidden="true"></i></div>
						<p class="txt_tit">온라인강좌</p>
					</a>
				</li>
				<li class="wow fadeInUp">
					<a href="hanc_my.php">
						<div><i class="fas fa-desktop" aria-hidden="true"></i></div>
						<p class="txt_tit">내강좌관리</p>
					</a>
				</li>
			</ul>
		</div>
	</section>

	<!-- ##### category Area Start ##### -->
    <section class="new-arrivals-products-area">
        <div class="container">
			<div class="category-area mt-3">
				<div class="row">

					<div class="col-12 col-sm-6 col-lg-12 text-center">
						<div class="single-footer-widget">
							<div class="social-info">
								
								<div class="social-info">	

								<? 
									$query = "SELECT * FROM tbl_category WHERE 사용유무='Y' order by 출력순서 ASC";
									$resultCategory = db_query($query); 

									while ($row = db_fetch($resultCategory)) {
										$strImg = "";
										// 이미지 
										if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/LessonCatImg/".$row['cat_img'])) { 
											$strImg = "<img src=\"/ImgData/LessonCatImg/{$row["cat_img"]}\" width=\"20\"  alt=\"{$row["cat_nm"]}\">";
										}
								?>
								<a href="hanc_lecture.php?분류명=<?=$row['분류명']?>" title='<?=$row["cat_nm"]?>'>
									<?=$strImg?> <?=$row["분류명"]?>
								</a>
								<? } ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<!-- 강좌 리스팅 전체 시작 -->
<?
if($_GET['분류명']){
	$where_c = " and 분류명 = '{$_GET['분류명']}'";
}

$query = "select * from tbl_category where 사용유무='Y' {$where_c} order by 출력순서 ASC";
$result = db_query($query);

$idx = 0;

while($row = db_fetch($result)){

	$query = "select * from tbl_lecture where 분류명='{$row['분류명']}' order by 출력순서 ASC";
	$resultL = db_query($query);


?>
			<!-- 강좌리스트 // 강좌대분류명 // 반복 -->
			<a name="lecture.php?분류명=<?=$row['분류명']?>"></a>
			<div id="subject<?=$idx?>" style="margin:20px 0 20px 0;"><h5><img src="./assets/img/core-img/hanc_logo2.png" alt="hanc"><?=$row['분류명']?> <small>(강좌과목수: <?=number_format(db_num_rows($resultL))?>ea)</small></h5>
			</div>
			<!-- 강좌대분류 끝 -->

			<div class="row">

			<? 
			for ($i=0; $i<db_num_rows($resultL); $i++){
				$rowL = db_fetch($resultL);

				$queryCnt = "select count(*) as cnt from tbl_lecture_like where fk_lecture = '{$rowL['pk_lecture']}'";
				$resultCnt = db_query($queryCnt);
				$rowCnt = db_fetch($resultCnt);

			?>
			<!-- 분류별 강좌 리스팅 -->
			<!-- Single Product Area -->
				<div class="col-12 col-sm-6 col-lg-3">
					<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
						<!-- Product Image -->
						<div>
							<a href="hanc_view.php?pk_lecture=<?=$rowL['pk_lecture']?>"><img src="/_UPLOAD/<?=rawurlencode($rowL['이미지1'])?>" id="img_<?=$i?><?=$idx?>" alt="" onMouseOver="go_change_2nd('img_<?=$i?><?=$idx?>', '/_UPLOAD/<?=rawurlencode($rowL['이미지2'])?>');" 
						onMouseOut="go_org('img_<?=$i?><?=$idx?>', '/_UPLOAD/<?=rawurlencode($rowL['이미지1'])?>');" onError="this.src.value='/_UPLOAD/<?=rawurlencode($rowL['이미지1'])?>'"/></a></a>
							<!-- Product Tag -->
						</div>
						<!-- Product Info -->
						<div class="product-info mt-15">
							<p style="height:20px;"><a href="hanc_view.php?pk_lecture=<?=$rowL['pk_lecture']?>"><i class="fas fa-calendar-plus"></i> <?=$rowL['강좌명']?></a></p>
							<h6><strong><font color="#cc0066"><?=number_format($rowL["강좌비용"])?></font></strong>원 (<?=$rowL['강좌등급']?>)</h6>
							<p style="font-size:12px; line-height:25px; color:#000;" class="ellipsis"><?=strip_tags($rowL['강좌소개'])?></p>
							<p><i class="far fa-thumbs-up"></i> <strong id="like_num"><?=number_format($rowCnt['cnt'])?></strong></p>
							<p><a href="hanc_apply.php?pk_lecture=<?=$rowL['pk_lecture']?>" style="background-color:#fff; border:1px solid #ff4b4b; border-radius:20px; padding:5px 12px 5px 12px; font-size:12px;"><i class="fas fa-check"></i> 수강신청</a>
							<a href="hanc_view.php?pk_lecture=<?=$rowL['pk_lecture']?>" style="background-color:#fff; border:1px solid #ff4b4b; border-radius:20px; padding:5px 12px 5px 12px; font-size:12px;"><i class="fas fa-calendar"></i> 커리큘럼</a>
							<a href="channel_view.php?CID=<?=$rowL['카페코드']?>" style="background-color:#fff; border:1px solid #ff4b4b; border-radius:20px; padding:5px 12px 5px 12px; font-size:12px;"><i class="fas fa-comments"></i> 카페보기</a></p>
						</div>
					</div>
				</div>

			<?}?>
			</div>

			<?
				$idx++;
			}?>

		</div>
	</section>
			

    
<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_hanc.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="coachapply"]').addClass('active');
</script>

</html>