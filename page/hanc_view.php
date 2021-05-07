<? 
	$NO_LOGIN = "Y";
	include "./inc_program.php"; 
	
	$query = "select * from tbl_lecture where pk_lecture = '{$pk_lecture}'";
	$resultL = db_query($query);
	$rowL = db_fetch($resultL);

    $query = "select count(*) as cnt from tbl_lecture_like where fk_lecture = '{$pk_lecture}' and member_id = '".MyPassDecrypt($_COOKIE["ck_login_member_pk"])."'";
	$resultCnt = db_query($query);
	$rowCnt = db_fetch($resultCnt);
?>


<!DOCTYPE HTML>
<html lang="en">
<script> 

//function go_like(pk_lecture){
//	$.post("/_ajax_go_like.php", {pk_lecture: pk_lecture}, function(data){
//		$("#like_num").html(data);
//	});
//}


function go_Cnt(pk_lecture){

	$.ajax({
		url: "_ajax_go_like.php",
		type: 'post',
		data: {
			pk_lecture: pk_lecture
		},
		datatype: 'text',
		success: function(Data) {
			Data = $.trim(Data);
			arrData = Data.split("@");

			if (arrData[0] == "INSERT") {
  			    $("#like_num").html(arrData[1]);
				return;
			} else if (arrData[0] == "DUP") {
				alert('이미 좋아요를 하셨습니다.');
			} else {
				alert('오류가 발생했습니다.');
			}

		} 
	});

}



function go_마우스오버(src){
	$("#big_img").attr("src", src);
}

var num = window.localStorage.getItem('num') ?  
parseInt(window.localStorage.getItem('num')) : 
0; 
window.onload = putString; 
function add() { 
   num += 1; 
   window.localStorage.setItem('num', num); 
   putString(); 
} 
function mis() { 
   num -= 1; 
   window.localStorage.setItem('num', num); 
   putString(); 
} 
function putString() { 
   document.getElementById('numberContainer').innerText = num; 
} 
</script> 
<style>
	.business_type2{ width:100%; max-width:1200px; margin:0 auto;}
	.business_type2:after{content:""; display:block; clear:both;}
	.business_type2 .business_info { width:100%; background:#fff; margin-bottom:80px; }
	.business_type2 .business_info:after{content:""; display:block; clear:both;}
	.business_type2 .business_info ul{ padding:0; margin:0;}
	.business_type2 .business_info ul li{ padding:0; margin:0;}
	.business_type2 .business_info ul li.left_box { float:left; width:45%; overflow:hidden; }
	.business_type2 .business_info ul li.left_box img{ width:100%; height:100%; padding:10px;border:1px solid #ddd;}
	.business_type2 .business_info ul li.right_box{position:relative; float:right; width:50%; height:500px;}
	.business_type2 .business_info ul li.right_box .txt03{ position:relative; left:0; bottom:0; width:100%; border-top:1px solid #ddd; font-size:0.9em; color:#555; line-height:1.5em; text-transform: uppercase; background:#f8f8f8; overflow:hidden; padding:20px;}
	.business_type2 .business_info ul li.right_box .txt03 span {display:block; padding:20px 25px; }

	.business_type2 .txt_area { width:100%; padding-top:10px; border-top:2px solid #000; }
	.business_type2 .txt_area:after{content:""; display:block; clear:both;}
	.business_type2 .txt_area .txt01 { float:left; width:100%; word-break: keep-all; }
	.business_type2 .txt_area .txt01 p { padding:0; margin:0; margin-bottom:15px; padding:0;}
	.business_type2 .txt_area .txt01 span.tit { font-size:2.0em; color:#000; font-weight:700; line-height:1.2em;  }
	.business_type2 .txt_area .txt01 span.txt { display:block; font-size:1.15em; color:#333; font-weight:400; line-height:1.4em; }
	.business_type2 .txt_area .txt02 { float:left; width:100%; margin-top:20px; padding:20px; border-top:1px solid #000; border-bottom:1px solid #ccc; }
	.business_type2 .txt_area .txt02 ul {margin:0; padding:0; }
	.business_type2 .txt_area .txt02 ul li { position:relative; color:#555; font-weight:400; line-height:1.5em; list-style:none; padding-left:3%; margin-bottom:5px;}
	.business_type2 .txt_area .txt02 ul li:before {position:absolute; top:8px; left:0; content:""; display:inline-block; width:4px; height:4px; background:#555; margin-right:10px; vertical-align:middle;}

	.business_type2 .con_arrow{ width:100%; max-width:1200px;  padding-bottom:20px;  margin:0 auto;}
	.business_type2 .con_arrow p{position:relative; font-size:24px; color:#000; padding-left:30px; }
	.business_type2 .con_arrow span{  position:absolute; right:0; display:inline-block; font-size: 1em;  padding-left: 10px;  color: #555;}
	.business_type2 .con_arrow > p:before{position:absolute; top:4px; left:10px; display:inline-block; content:""; width:3px; height:23px; background-color:#1F88E5; -ms-transform:rotate(45deg); -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -o-transform:rotate(45deg); transform:rotate(45deg);}

	.business_type2 .con_box{ width:100%; padding:20px 0; border-top:1px solid #000; border-bottom:1px solid #000;}
	.business_type2 .con_box:after{content:""; display:block; clear:both;}
	.business_type2 .con_box ul { padding:0; margin:0; }
	.business_type2 .con_box ul li {float:left; width:100%; list-style:none; margin:10px 0; }
	.business_type2 .con_box ul li p{display:table; width:100%; }
	.business_type2 .con_box ul li p > em, .business_type2 .con_box p > span{display:table-cell; vertical-align:top; }
	.business_type2 .con_box ul li p > em{ width:30px; }
	.business_type2 .con_box ul li p > em > strong{display:inline-block; width:30px; height:30px;  line-height:30px; color:#fff; background-color:#000; text-align:center; font-size:1em;  border-radius:100%; -moz-border-radius:100%; -webkit-border-radius:100%; -o-border-radius:100%; font-weight:500;}
	.business_type2 .con_box ul li p > span{font-size:1em; line-height:30px; color:#555; letter-spacing:-0.75px;  padding:0 15px;}

	.business_type2 .business_info ul li .btn1 { display:inline-block; height:40px; line-height:38px; padding:0 20px; background:#ff0054; color:#fff; font-size:1em; margin-top:20px; text-decoration:none; transition:0.3s;}
	.business_type2 .business_info ul li .btn1:hover {background:#000; color:#fff; border:0;}

	.business_type2.btdn1 { display:inline-block; height:40px; line-height:38px; padding:0 20px; background:#ff0054; color:#fff; font-size:1em; margin-top:20px; text-decoration:none; transition:0.3s;}
	.business_type2 .guide_box1 .con_wrap ul li .btn1:hover {background:#000; color:#fff; border:0;} 

	.business_type2 .business_info ul li .btn2 { display:inline-block; height:40px; line-height:40px; padding:0 20px; background:#000; color:#fff; font-size:1em; margin-top:20px; text-decoration:none; transition:0.3s;}
	.business_type2 .business_info ul li .btn2:hover {background:#000; color:#fff; border:0;}

	.business_type2.btdn2 { display:inline-block; height:40px; line-height:38px; padding:0 20px; background:#ff0054; color:#fff; font-size:1em; margin-top:20px; text-decoration:none; transition:0.3s;}
	.business_type2 .guide_box1 .con_wrap ul li .btn2:hover {background:#000; color:#fff; border:0;} 

	.company_type4_tbl {width:100%; max-width:700px; margin:0 auto; overflow:hidden; border:0px solid #ddd; margin:20px 0; padding:5px;}
	.company_type4_tbl li {float:left; display:inline-block; width:25%; height:90px; text-align:center;  border:0px solid #ddd;}
	.company_type4_tbl li:nth-child(4) {border-right:0; }
	.company_type4_tbl li .icon {display:block; width:100px; height:100px; margin:0 auto; overflow:hidden; background-color:#f7f7f7; border-top-left-radius:20px; border:1px solid #ddd;}
	.company_type4_tbl li .icon i {display:inline-block; font-size:3em; line-height:100px; }
	.company_type4_tbl li p {display:block; font-size:1.6em; color:#0078D7; margin-top:10px;}
	.company_type4_tbl li span { display:block; font-size:1.1em; color:#555; margin-top:10px; line-height:1.5em;}

	#bo_v_act {margin-top:30px; margin-bottom:30px;text-align:center}
	#bo_v_act .bo_v_act_gng {position:relative}
	#bo_v_act a {margin-right:5px;vertical-align:middle;color:#4a5158}
	#bo_v_act a:hover {background-color:#fff;color:#ff484f;border-color:#ff484f}
	#bo_v_act i {font-size:1.4em;margin-right:5px}
	#bo_v_act_good, #bo_v_act_nogood {display:none;position:absolute;top:30px;left:0;z-index:9999;padding:10px 0;width:165px;background:#ff3061;color:#fff;text-align:center}
	#bo_v_act .bo_v_good {display:inline-block;border:1px solid #dedede;width:110px;line-height:46px;border-radius:30px}
	#bo_v_act .bo_v_nogood {display:inline-block;border:1px solid #dedede;width:70px;line-height:46px;border-radius:30px}


	@media screen and (max-width:992px){
		
		.content_wrap{width:100%;}
		.page_title{margin-bottom:50px;}	
		.page_title h1{font-size:2em;}
		.page_title h2{font-size:1em;}
		.s_tit{font-size:1.2em;}
		
		.business_type2 .business_info{margin-bottom:0px;}
		.business_type2 .business_info ul li.left_box { width:100%; height:300px;  }
		.business_type2 .business_info ul li.right_box{ width:100%; }
		.business_type2 .business_info ul li.right_box .txt03 {position:relative !important; margin-top:40px;}
		.business_type2 .business_info ul li.right_box .txt03 span {height:auto;}
		.business_type2 .txt_area { width:90%; margin:0 auto; border-top:0;}
		.business_type2 .txt_area .txt01 span.tit {font-size:1.85em;}
		.business_type2 .con_arrow{width:95%; margin:0 auto;}
		.business_type2 .con_box{width:95%; margin:0 auto;}

		.company_type4_tbl{width:95%;}
		.company_type4_tbl li{width:49%;}
		.company_type4_tbl li:nth-child(2n){border-right:0; padding-bottom:15px;}
		.company_type4_tbl li:nth-child(3), .company_type4_tbl li:nth-child(4){border-top:1px solid #f7f7f7; padding-top:30px;}
		.company_type4_tbl li p{font-size:1.4em;}
		.company_type4_tbl li span{font-size:1em;}

	}

	@media screen and (max-width:480px){

	
		.business_type2 .con_arrow p{ font-size:0.85em; margin-top:30px;}
		.business_type2 .con_box ul li { width:100%; }

	}
</style>
<? include "./inc_Head.php"; ?>

<body>
<? include "./inc_nav.php"; ?>
	<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg1.jpg);">
            <h2>여러분과 함께하는 열린교육</h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

	<section id="m_bnr">
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

	
	<!-- /* 내용출력 */ -->
	<div class="content_wrap">
		<div class="page_title">
			<h1 class="sub_tit"><span class="fc_pointer">강좌</span> 안내</h1>
		</div>

		<div class="business_type2">
			<div class="business_info">
				<ul>
					<li class="left_box">
					<!-- 큰/대표이미지 -->
					<? for ($a=1; $a<=1; $a++){?>
						<? if($rowL['이미지'.$a]){?>
						<img src="/_UPLOAD/<?=rawurlencode($rowL['이미지'.$a])?>" alt="" id="big_img" data-org="/_UPLOAD/<?=rawurlencode($rowL['이미지'.$a])?>"/>
						<?}?>
					<?}?>
					<!-- 큰/대표이미지 끝 -->

					<!-- 썸네일이미지 -->
					<div class="company_type4_tbl">
					<? for ($a=1; $a<=5; $a++){?>
						<? if($rowL['이미지'.$a]){?>
						<ul class="">
							<li><img src="/_UPLOAD/<?=rawurlencode($rowL['이미지'.$a])?>" alt="" onMouseOver="go_마우스오버('/_UPLOAD/<?=rawurlencode($rowL['이미지'.$a])?>');"/></li>
						</ul>
						<?}?>
					<?}?>
					</div>
				<!-- //썸네일이미지 끝 -->
				</li>
				<li class="right_box">
					<div class="txt_area">
						<div class="txt01">
							<p><span href="#none" class="btn1"><?=$rowL['분류명']?></span> &nbsp;  <span class="tit"><?=$rowL['강좌명']?></span></p>
						<!-- <p><span class="txt"></span></p> -->
						</div>
						<div class="txt03">
							<ul>
								<strong># 강좌비용</strong><br>
								<?=$rowL['강좌등급']?> - <font color="#cc0033" class="fs-05"><?=$rowL['강좌비용']?></font> 원
							</ul><br>
							<ul>
								<strong># 강좌소개</strong><br>
								<?=$rowL['강좌소개']?>
							</ul>
						</div>
						<div style="padding-top:0px;">
							<a href="hanc_lecture.php" class="btn2"><i class="fa fa-list" aria-hidden="true"></i> 목록으로</a>
							<a href="cafe.php?CID=<?=$rowL['카페코드']?>" class="btn2"><i class="fa fa-caret-square-down" aria-hidden="true"></i> 카페둘러보기</a>
							<a href="hanc_apply.php?pk_lecture=<?=$rowL['pk_lecture']?>" class="btn2"><i class="fa fa-check" aria-hidden="true"></i> 수강신청</a>
						</div>
					</div>
				</li>
			</ul>
		</div>


		<h3 class="con_arrow">
			<p>강좌안내 / 커리큘럼</p>
		</h3>
		<div class="con_box">
			<ul>
				<li><p><span><?=$rowL['커리큘럼진도표']?></span></p></li>
			</ul>
		</div>



		<div id="bo_v_act">
            <span class="bo_v_act_gng">
                <a href="javascript:go_Cnt('<?=$pk_lecture?>');" id="good_button" class="bo_v_good"><i class="far fa-thumbs-up"></i><span class="sound_only">추천</span><strong id="like_num"><?=$rowCnt['cnt']?></strong></a>
            </span>
        </div>
		<div id="bo_v_share">
        	
	    </div>
	</div>
</div>

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
							<h6><strong><font color="#cc0066"><?=$rowL['강좌비용']?></font></strong>원 (<?=$rowL['강좌등급']?>)</h6>
							<p style="font-size:12px; line-height:25px; color:#000;" class="ellipsis"><?=strip_tags($rowL['강좌소개'])?></p>
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