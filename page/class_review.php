<?
$NO_LOGIN = "Y";
include "./inc_program.php";

$strRecordNo = $_GET["txtRecordNo"];

$strWHERE = "";
$strLink  = " WHERE   ";
if (trim($strRecordNo) != "" ) {
	$strWHERE = " WHERE A.l_id = '{$strRecordNo}'  \n";
	$strLink  = " AND   ";
}
// 리뷰목록
$query  = " SELECT A.lr_id, A.l_id, A.star_score, A.review, A.isrt_user, DATE_FORMAT(A.isrt_dt, '%Y.%m.%d %H:%i') AS isrt_dt,     \n";
$query .= "            B.l_title, B.l_price, B.cat_id, B.사진1, D.cat_nm, E.lesson_title, F.name, F.페이지배경사진, F.페이지프로필사진, G.co_id    \n";
$query .= " FROM    tbl_lesson_review A, tbl_lesson B, tbl_lesson_category D, tbl_lesson_setup E, tbl_member F, tbl_coach G    \n";
$query .= $strWHERE;
$query .= " {$strLink}    A.l_id = B.l_id   \n";  
$query .= " AND      B.cat_id = D.cat_id   \n";
$query .= " AND      B.member_id = E.member_id   \n";  
$query .= " AND      A.isrt_user = F.member_id   \n";  
$query .= " AND      B.member_id = G.member_id   \n";  
$query .= " ORDER BY A.lr_id DESC   \n";  

$resultReview = db_query($query);   

?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>

<body class="mb-5">

<? include "./inc_nav.php"; ?>
<!-- ##### img Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>Open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_class.php"; ?>

	<section class="new-arrivals-products-area">
        <div class="container">

			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading mt-3">
					<h4>후기보기</h4>
					<p>회원 여러분이 남겨 주신 후기입니다.</p>
				</div>

				<?
					$i = 0;
					while ($rowReview = mysqli_fetch_array($resultReview)) {
						// 리뷰 : 현재 회원의 '좋아요' 선택여부 가져오기
						$query  = " SELECT COUNT(lra_id) AS cnt    \n"; 
						$query .= " FROM   tbl_lesson_review_appraisal  \n";
						$query .= " WHERE  lr_id = '{$rowReview['lr_id']}'   \n"; 
						$query .= " AND      member_id = '{$ck_login_member_pk}'   \n"; 

						$rowAppraisal = db_select($query); 

						$strCheck = "";
						if ($rowAppraisal["cnt"] > 0) {
							$strCheck = "checked";
						}

						// 좋아요 수 가져오기
						$query  = " SELECT COUNT(lra_id) AS cnt   \n";
						$query .= " FROM   tbl_lesson_review_appraisal  \n";
						$query .= " WHERE  lr_id = '{$rowReview['lr_id']}'   \n"; 

						$rowAppraisalCnt = db_select($query); 



						// 리뷰이미지
						$query  = " SELECT lri_id, lr_id, l_id, img, isrt_user, isrt_dt    \n";
						$query .= " FROM    tbl_lesson_review_img    \n";
						$query .= " WHERE  lr_id = {$rowReview["lr_id"]}   \n";  
						$query .= " ORDER BY lri_id    \n";  

						$resultReviewImg = db_query($query);   
				?>

				<div class="col-sm-12 col-lg-12">
			
					<!-- 등록클래스 리스트 -->
					<article class="mb-2 mt-2">
						<div class="list list-schedule">
							<ul>
								<li>
									<div class="d-flex"></div>
								</li>

								<li>
									<div class="d-flex">

										<div class="col-4 list-tour tour-wide">
											<div class="post-thumb">
											 <a href="class_detail.php?txtRecordNo=<?=$rowReview["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['사진1'],500,365,"2","assets/images/ex_img6.jpg")?>" class="radius-5" /></a>
											</div>
											<div class="con-info text-center">
												<h4 class="tlt mt-1 text-center opacity-20">
												<i class="fas fa-book-open"></i> <?=$rowReview["cat_nm"]?> &nbsp; &nbsp; <i class="fas fa-user-circle"></i> <?=$rowReview["lesson_title"]?></span></h4>

												<dl class="txt-info d-flex mt-2">
													<span><i class="ellipsis-2 opacity-50"></i> <?=$rowReview["l_title"]?></span>
												</dl>

												<h6 class="mt-2"><strong><font color="#cc0066"><?=number_format($rowReview["l_price"])?></font></strong>원</h6>
												
												<dl><a href="class_payment.php?txtRecordNo=<?=$rowReview["l_id"]?>"  class="btn-o2 mt-2 mr-1"><li class="fas fa-check"></li> 강좌신청</a>
												<a href="class_detail.php?txtRecordNo=<?=$rowReview["l_id"]?>"  class="btn-o2 mt-2 mr-1"><li class="fas fa-search"></li> 상세보기</a></dl>
											</div>
										</div>
										<div class="col-8 border-left">
											<div>
												<!-- 작성자 정보-->
												<?     
														if ($rowReview['isrt_user'] == $ck_login_member_pk) {
												?>
												<div class="dropdown position-ab btn-right-top">
													<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="./class_review_modify.php?txtRecordNo=<?=$rowReview["lr_id"]?>" title="글 수정">글 수정</a>
														<a class="dropdown-item btnDelete" href="javascript:void(0)" title="글 삭제">글 삭제</a>
													</div>
												</div>
												<?
													}
												?>

												<div class="d-flex align-items-end mb-3">
													<div class="page-profile">
														<img src="<?=phpThumb("/_UPLOAD/".($rowReview['페이지배경사진']?$rowReview['페이지배경사진']:$rowReview['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
													</div>
													<div class="col page-write lh-3">
														<h3 class="fs-005 mb-0"><?=$rowReview["name"]?></h3>
														<span class="date fs--1"><?=$rowReview["isrt_dt"]?></span>
													</div>
												</div>
												<!-- //작성자 정보-->

												<a href="class_review_read.php?txtRecordNo=<?=$rowReview['lr_id']?>" title="" class="clearfix">
												<!--작성글-->
												<div class="page-write">
													<p class="post"><?=str_replace("\n", "<br>", $rowReview["review"])?></p>
												</div>
												<!--//작성글>

												<!--사진-->
												<div class="list-card my-3">
													<ul class="card-columns">
												<?
														$kk = 1;
														while ($rowReviewImg = mysqli_fetch_array($resultReviewImg)) {
												?>
														<li class="card border-none">
															<img class="card-img img-fluid" src="/ImgData/LessonReview/<?=$rowReviewImg["img"]?>" alt="" />
														</li>
												<?
															$kk++;
														}

														for ($pp=$kk; $pp<=3; $pp++) {
												?>

															<li class="card border-none">

															</li>
												<?
													}
												?>
													</ul>
												</div>
												<!--//사진-->
												</a>



												<ul>
													<li>
														<div class="single_user_review mb-15">
															
															<!-- <div class="post-thumb">
																 <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"><img src="assets/images/ex_img6.jpg" width="50%" height="80" class="radius-5" /></a>
															</div> -->

															<div class="page-box text-center mb-3">
																<div class="row m-0">
																	<div class="col p-0 ">
																		<div class="checkbox">
																			<input type="hidden" name="txtRID[]" class="txtRID" value="<?=$rowReview["lr_id"]?>">
																			<input id="chk<?=$i?>" name="chkGood[]" type="checkbox" <?=$strCheck?> class="invisible chkGood">
																			<label for="chk<?=$i++?>" class="color-5 mb-0 fw-400 lblGood"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary"><?=$rowAppraisalCnt["cnt"]?></span></label>
																		</div>
																	</div>
																	<div class="col p-0">
																		<a href="class_review_read.php?txtRecordNo=<?=$rowReview['lr_id']?>"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=$rowAppraisalCnt["cnt"]?></span></a>
																	</div>
																</div>
															</div>

														</div>
													</li>
												</ul>
											</div>
											
										</div>
									</div>
								</li>

							</ul>
						</div>
					</article>
					<!-- /// 등록클래스 리스트 -->	
				</div>
				<?
    }
?>
			</div>
		</div>
	</section>
   

	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$('.nav_bottom li[data-name="review"]').addClass('active');

    $(document).ready(function(){

        // 좋아요 클릭시
        $(document).on('click', '.chkGood', function(event) {
            var idx = $(".chkGood").index(this);
            var nCnt = parseInt($('.lblGood > span').eq(idx).text());

            $.ajax({
                url: './class_review_action.php',
                type: 'post',
                data: {
                    txtAction: "REVIEWGOOD",
                    txtRecordNo: $('.txtRID').eq(idx).val(),
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);

                    if (Data == "SUCCESSD") {
                        $('.chkGood').eq(idx).attr("checked", false);
                        $('.lblGood > span').eq(idx).text(nCnt - 1);
                    } else if (Data == "SUCCESSI") {
                        $('.chkGood').eq(idx).attr("checked", true);
                        $('.lblGood > span').eq(idx).text(nCnt + 1);
                    } 
                } 
            });


        });


        // 삭제 클릭시
        $(document).on('click', '.btnDelete', function(event) {
            var idx = $('.btnDelete').index(this);

			if (confirm("리뷰를 삭제하시겠습니까?")) {

				$.ajax({
					url: './class_review_action.php',
					type: 'post',
					data: {
						txtAction: "REVIEWDEL",
						txtRecordNo: $('.txtRID').eq(idx).val(),
					},
					datatype: 'text',
					success: function(Data) {
						Data = $.trim(Data);
						if (Data == "SUCCESS") {
							$('.liReview').eq(idx).remove();
							alert("리뷰가 삭제되었습니다.");
						} else {
							alert(Data);
						}
					} 
				});

			}
        });

    });
</script>
</html>