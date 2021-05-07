<? 
	$NO_LOGIN = "Y";
	include "./inc_program.php";  
?>

<!DOCTYPE HTML>
<html lang="en">

<? include "./inc_Head.php"; ?>
<!-- 레이어창 관련 -->
<script src="./assets/js/jquery/jquery-1.7.2.min.js"></script>
<style>
.layer {display:none; position:fixed; _position:absolute; top:0; left:0; width:100%; height:100%; z-index:555;}
.layer .bg {position:absolute; top:0; left:0; width:100%; height:100%; background:#000; opacity:.5; filter:alpha(opacity=50);}
.layer .pop-layer {display:block;}

.pop-layer {display:none; position: absolute; top: 50%; left: 50%; width: 80%; height:auto;  background-color:#f7f7f7; z-index: 10;}	
.pop-layer .pop-container {padding: 20px 25px 40px; overflow:hidden;}
.pop-layer p.ctxt {color: #666; line-height:25px; text-align:center;}
.pop-layer p.ctxt img{max-width:139px;}
.pop-layer .login-input{background-color:#fff; border:1px solid #ddd; width:100%; padding:10px; box-sizing:border-box; margin:4px 0px}
.pop-layer .login-input[type="password"]{font-family:'dotum'}
.pop-layer .btn-r {text-align:right;}
</style>
<!-- // 레이어창 관련 -->
<body>
<!-- 지도 -->
<div class="layer">
	<div class="bg"></div>
	<div id="layer2" class="pop-layer">
		<div class="pop-container">
			<div class="pop-conts">
				<div class="btn-r">
					<a href="#" class="cbtn">닫기</a>
				</div>
				지도 들어갑니다			
			</div>
		</div>
	</div>
</div>
<!-- end -->

<? include "./inc_nav.php"; ?>
	<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg1.jpg);">
            <h2>Branch Information</h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

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

	<!-- ##### open class Area Start ##### -->
    <section class="new-arrivals-products-area mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center mt-3">
                        <h2>문화센터 지부안내</h2>
                        <p>- 여러분의 생활속 가까이 다가갑니다. -</p>
                    </div>
                </div>
            </div>

			<div class="category-area">
				<!-- Main Footer Area -->
				<div class="main-footer-area">
					<div class="container">
						<div class="row">

							<!-- Single Footer Widget -->
							<div class="col-12 col-sm-6 col-lg-12 text-center">
								<div class="single-footer-widget">
									<div class="social-info">
									<!-- <button class="btn btn-outline-info btn-sm2 radius-2 ml-auto mt-1"> <i class="fas fa-map-marker-alt"></i> 내주변검색</button> -->
									<? 
										$query = "SELECT * FROM tbl_hanc_area WHERE 사용유무='Y' order by 출력순서 ASC";
										$resultCategory = db_query($query); 

										while ($row = db_fetch($resultCategory)) {
									?>
									<a href="hanc_center.php?권역명=<?=$row['권역명']?>" title='<?=$row["권역명"]?>'>
										<?=$strImg?> <?=$row["권역명"]?>
									</a>
									<? } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<?
if($_GET['권역명']){
	$where_c = " and 권역명 = '{$_GET['권역명']}'";
}

$query = "select * from tbl_hanc_area where 사용유무='Y' {$where_c} order by 출력순서 ASC";
$result = db_query($query);

$idx = 0;

while($row = db_fetch($result)){

	$query = "select * from tbl_jiboo where 권역명='{$row['권역명']}' order by 출력순서 ASC" ;
	$resultL = db_query($query);
?>
			<!-- 권역리스트 // 반복 -->
			<a name="hanc_center.php?권역명=<?=$row['권역명']?>"></a>
			<div id="subject<?=$idx?>" style="margin-bottom:0px; border-bottom:2px solid #cccccc;" class="mt-5">
				<h5><i class="fas fa-map-marker-alt fs-1"></i> <strong><?=$row['권역명']?></strong> 
				<small>(지부수: <?=number_format(db_num_rows($resultL))?>ea)</small></h5>
			</div>
			<!-- 권역리스트 끝 -->

			<div class="row">

			<? 
			for ($i=0; $i<db_num_rows($resultL); $i++){
				$rowL = db_fetch($resultL);
			?>

			<!-- 지부 리스팅 -->
			<!-- Single Product Area -->
				<div class="col-12 col-sm-6 col-lg-4 border-bottom">
                    <div class="single-product-area wow fadeInUp" data-wow-delay="100ms">
                        <!-- Info -->
                        <div class="product-info mt-3 mb-3">
							<p class="fw-600 fs-05"><!-- <small><?=$row['권역명']?></small> ㅣ  --><?=$rowL['지부명']?> 
							<button onclick="layer_open('layer2');return false;" class="btn btn-info4 btn-xs">지도보기</button></p>
							<h6><font><i class="fas fa-map-marker-alt fs--1"></i></font> <?=$rowL['주소']?></h6>

							<p class="fs--1" style="line-height:20px; padding-top:5px;">
							<font color="#d42e2e"><i class="fas fa-phone fs--1"></i> <a href="tel:<?=$rowL['전화번호']?>"><font color="#d42e2e"><?=$rowL['전화번호']?></font></a></font><br>
							<font color="#6fb40d"><i class="fas fa-home"></font></i> <a href="http://<?=$rowL['홈페이지']?>" target="_blank"><font color="#6fb40d">www.<?=$rowL['홈페이지']?></font></a></p>
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
    <!-- ##### open class End ##### -->

    
<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_hanc.php"; ?>
</body>


<!-- 레이어 팝업 -->
<script type="text/javascript">
	function layer_open(el){
		var temp = $('#' + el);
		var bg = temp.prev().hasClass('bg');	//dimmed 레이어를 감지하기 위한 boolean 변수
		if(bg){
			$('.layer').fadeIn();	//'bg' 클래스가 존재하면 레이어가 나타나고 배경은 dimmed 된다. 
		}else{
			temp.fadeIn();
		}

		// 화면의 중앙에 레이어를 띄운다.
		if (temp.outerHeight() < $(document).height() ) temp.css('margin-top', '-'+temp.outerHeight()/2+'px');
		else temp.css('top', '0px');
		if (temp.outerWidth() < $(document).width() ) temp.css('margin-left', '-'+temp.outerWidth()/2+'px');
		else temp.css('left', '0px');

		temp.find('a.cbtn').click(function(e){
			if(bg){
				$('.layer').fadeOut(); //'bg' 클래스가 존재하면 레이어를 사라지게 한다. 
			}else{
				temp.fadeOut();
			}
			e.preventDefault();
		});

		$('.layer .bg').click(function(e){	//배경을 클릭하면 레이어를 사라지게 하는 이벤트 핸들러
			$('.layer').fadeOut();
			e.preventDefault();
		});

	}			
</script>

</html>
