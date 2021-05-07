<?
    $NO_LOGIN = "Y";
	include "./inc_program.php"; 

    $strRecordNo = $_GET["txtRecordNo"];

	$query  = " SELECT PP.*, QQ.할인금액  \n";
    $query .= " FROM   (SELECT A.*, B.cat_nm, C.lesson_title, D.co_id   \n";
    $query .= "         FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C, tbl_coach D    \n";
    $query .= "         WHERE  A.l_id = '{$strRecordNo}'   \n";   
    $query .= "         AND    A.sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
    $query .= "         AND    A.cat_id = B.cat_id   \n";
    $query .= "         AND    A.member_id = C.member_id   \n";
    $query .= "         AND    A.member_id = D.member_id) PP LEFT OUTER JOIN  tbl_coupon QQ  ON PP.쿠폰 = QQ.c_id \n";
    $rowLesson = db_select($query);    
   

    $query  = " SELECT cat_nm  \n";
    $query .= " FROM   tbl_lesson_category    \n";
    $query .= " WHERE  cat_id = '{$rowLesson["catm_id"]}'   \n";   
    $rowCatM = db_select($query);    


	$query  = " SELECT A.co_id, A.member_id, A.coach_career, A.career_memo, A.use_flg, A.recomm_flg, A.memo, B.member_uid, B.background_photo, B.profile_photo, B.lesson_title, lesson_greetings   \n";
    $query .= " FROM   tbl_coach A, tbl_lesson_setup B \n";
    $query .= " WHERE  A.use_flg = 'AD005001'   \n";    //  사용중인 코치만
    $query .= " AND    A.recomm_flg = 'AD001001'   \n";
    $query .= " AND    A.member_id = B.member_id   \n";
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultCoach = db_query($query); 

    $strTag = "";
    if (trim($rowLesson["l_tag"]) != "") {
        $arrTag = explode(",", $rowLesson["l_tag"]);

        for ($i=0; $i<count($arrTag); $i++) {
            $arrTag[$i] = "<span class=\"mr-2\">#".trim($arrTag[$i])."</span>";
        }

        $strTag = implode(" ", $arrTag);
    }

    // 나의 찜정보 가져오기
    $query  = " SELECT COUNT(lz_id) AS cnt   \n";
    $query .= " FROM   tbl_lesson_zzim    \n";
    $query .= " WHERE  l_id = '{$strRecordNo}'  \n";
    $query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";
    $rowZZim = db_select($query);    

    $strZZim = "찜하기";
    if ($rowZZim["cnt"] > 0) {
        $strZZim = "찜해제";
    }


	// 전체 찜정보 가져오기
	$query  = " SELECT COUNT(lz_id) AS cnt   \n";
	$query .= " FROM   tbl_lesson_zzim    \n";
	$query .= " WHERE  l_id = '{$strRecordNo}'  \n";
	$rowTotalZZim = db_select($query); 
    $strTotalZZim = $rowTotalZZim["cnt"];


    // 후기수
    $query  = " SELECT COUNT(lr_id) AS cnt   \n";
    $query .= " FROM   tbl_lesson_review    \n";
	$query .= " WHERE  l_id = '{$strRecordNo}'  \n";
    $rowReview = db_select($query);   



?>
<!DOCTYPE HTML>
<html lang="en">


<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<script>
	$(function(){
		// Options
		var options = {
			max_value: 5,
			step_size: 0.5,
			selected_symbol_type: 'utf8_star', // Must be a key from symbols
			cursor: 'default',
			readonly: true,
			change_once: false, // Determines if the rating can only be set once
		}

		$(".rating-data").rate(options);			

		// Options
		var options = {
			max_value: 5,
			step_size: 0.5,
			initial_value: 3,
			selected_symbol_type: 'utf8_star', // Must be a key from symbols
			cursor: 'default',
			readonly: false,
			change_once: false, // Determines if the rating can only be set once
		}

		$(".rating").rate(options);		


	});
</script>



<body class="mb-5">

	<? include "./inc_nav.php"; ?>
	<div class="breadcrumb-area">
		<!-- Top Breadcrumb Area -->
		<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
			<h2>Open class<br>
			<font size="4px">누구나 함께하는 열린 강좌!</font></h2>
		</div>
	</div>
	<!-- Breadcrumb Area End -->

	<? include "./inc_class.php"; ?>


    <!-- ##### Single Product Details Area Start ##### -->
	<div class="page_title">
		<h1 class="sub_tit"><span class="fc_pointer">Class</span> Detail</h1>
	</div>
    <section class="single_product_details_area mb-50">
        <div class="produts-details--content mb-50">
            <div class="container">
                <div class="row justify-content-between">

                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">

<? if($rowLesson['사진1']){?>
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="/_UPLOAD/<?=$rowLesson['사진1']?>" alt="1">
                                    </div>
<?}?>
<? if($rowLesson['사진2']){?>
									<div class="carousel-item">
                                        <img class="d-block w-100" src="/_UPLOAD/<?=$rowLesson['사진2']?>" alt="1">
                                    </div>
<?}?>
<? if($rowLesson['사진3']){?>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="/_UPLOAD/<?=$rowLesson['사진3']?>" alt="1">
                                    </div>
<?}?>
<? if($rowLesson['사진4']){?>
									<div class="carousel-item">
                                        <img class="d-block w-100" src="/_UPLOAD/<?=$rowLesson['사진4']?>" alt="1">
                                    </div>
<?}?>
<? if($rowLesson['사진5']){?>
									<div class="carousel-item">
                                        <img class="d-block w-100" src="/_UPLOAD/<?=$rowLesson['사진5']?>" alt="1">
                                    </div>
<?}?>
<? if($rowLesson['사진6']){?>
									<div class="carousel-item">
                                        <img class="d-block w-100" src="/_UPLOAD/<?=$rowLesson['사진6']?>" alt="1">
                                    </div>
<?}?>
                                </div>
                                <ol class="carousel-indicators">
<? if($rowLesson['사진1']){?>
                                    <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(/_UPLOAD/<?=$rowLesson['사진1']?>);">
                                    </li>
<?}?>
<? if($rowLesson['사진2']){?>
                                    <li data-target="#product_details_slider" data-slide-to="1" style="background-image: url(/_UPLOAD/<?=$rowLesson['사진2']?>);">
                                    </li>
<?}?>
<? if($rowLesson['사진3']){?>
                                    <li data-target="#product_details_slider" data-slide-to="2" style="background-image: url(/_UPLOAD/<?=$rowLesson['사진3']?>);">
                                    </li>
<?}?>
<? if($rowLesson['사진4']){?>
									<li data-target="#product_details_slider" data-slide-to="3" style="background-image: url(/_UPLOAD/<?=$rowLesson['사진4']?>);">
                                    </li>
<?}?>
<? if($rowLesson['사진5']){?>
									<li data-target="#product_details_slider" data-slide-to="4" style="background-image: url(/_UPLOAD/<?=$rowLesson['사진5']?>);">
                                    </li>
<?}?>
<? if($rowLesson['사진6']){?>
									<li data-target="#product_details_slider" data-slide-to="5" style="background-image: url(/_UPLOAD/<?=$rowLesson['사진6']?>);">
                                    </li>
<?}?>
                                </ol>
								<ol class="mt-2 text-center">
                                    <li class="active"><!-- <button type="button" class="btn btn-outline-success btn-sm btn-capsule mt-1" ><li class="fas fa-list" id=""> 목록</li></button> -->
									<a href="/page/class_review.php?txtRecordNo=<?=$rowLesson["l_id"]?>"><button type="button" class="btn btn-outline-info btn-sm btn-capsule mt-1" ><li class="fas fa-edit" id=""> 후기(<?=$rowReview["cnt"]?>)</li></button></a>
									<a href="#qna"><button type="button" class="btn btn-outline-warning btn-sm btn-capsule mt-1"><li class="fas fa-sticky-note" id=""> 문의</li></button></a>
									</li>
                                </ol>
                            </div>
                        </div>
                    </div>
					
					
                    <div class="col-12 col-md-6">
                        <div class="single_product_desc">
                            <div class="short_overview" style="border-bottom:1px solid #ccc;">
                                <i class="fas fa-book-open color-warning"></i> 오픈클래스 >  <?=$rowLesson["cat_nm"]?> <?=($rowCatM["cat_nm"] != "") ? "> {$rowCatM["cat_nm"]}" : "";?>
                            </div>	
							<h4 class="title"><?=$rowLesson["l_title"]?></h4>
							<p><?=$strTag?></p>
							<h6 class="mt-1"><span><i class="fas fa-user-circle fs--5"></i> </span> <span><?=$rowLesson["lesson_title"]?> 
							&nbsp; <a href="artist.php?txtRecordNo=<?=$rowLesson["co_id"]?>" title=""><button type="button" class="btn btn-warning btn-sm"><li class="fas fa-comment"></li> 아티스트 블로그 보기</button></a></span></h6>

<?
			if (trim($rowLesson["쿠폰"]) != "" && trim($rowLesson["쿠폰사용여부"]) == "AD005001") { 
?>
							<!-- 쿠폰적용시 가격 -->
							<span class="fs-0"><del><?=number_format($rowLesson["l_price"])?></del>원 </span>
							<h4 class="price"><i class="fas fa-won-sign fs-0"></i> <?=number_format($rowLesson["l_price"] - $rowLesson["할인금액"])?> <font size=".88019rem" color="#330033">(쿠폰적용가)</font></h4>
<?			
			} else { 
?>
                            <!-- 쿠폰없을때 가격 -->
							<h4 class="price"><i class="fas fa-won-sign fs-0"></i> <?=number_format($rowLesson["l_price"])?></h4>
<?			
			} 
			if (trim($rowLesson["마일리지"]) > 0) { 
?>			

							<div class="short_overview" style="border-bottom:1px solid #ccc;">
                                <i class="fas fa-ruble color-warning"></i> 적립금 :  <?=number_format($rowLesson["마일리지"])?> Point
                            </div>
<?
			}	
?>
                            <div class="cart--area d-flex flex-wrap align-items-center">
                                <a href="class_payment.php?txtRecordNo=<?=$rowLesson["l_id"]?>"><button type="submit" name="addtocart" value="5" class="btn alazea-btn">클래스신청</button></a>
                                
                                <!-- Wishlist & Compare -->
                                <div class="wishlist-compare d-flex flex-wrap align-items-center">
									<a href="#" class="wishlist-btn ml-15" id="btnZZim"><li class="fa icon_heart_alt" id="lblZZim"> <?=$strZZim?></li> <span id="lblZZimCnt"><?=$strTotalZZim?></span></a>
                                    <span href="#" style="background-color: #e5eaec; display: inline-block; width: 100px; text-align: center; line-height: 46px; font-size: 14px;border-radius:2px;" class="ml-15"><i class="fa fa-users"></i> 인원: <?=number_format($rowLesson["수업인원"])?>명</span>
									<span href="#" style="background-color: #e5eaec; display: inline-block; width: 100px; text-align: center; line-height: 46px; font-size: 14px;border-radius:2px;" class="ml-15"><i class="fas fa-cookie"></i> <?=$rowLesson["소요시간"]?></span>
                                </div>
								
                            </div>
													
                            <div class="products--meta">
								<div class="txt02">
									
									<p><span><i class="fas fa-map-marker-alt opacity-50"></i> 수강지역</span> 
									<span><?=$rowLesson["클래스기본지역"]?></span></p>
									<p><span><i class="fas fa-calendar-check opacity-50"></i> 시작일</span> <span><?=$rowLesson["클래스시작일"]?></span></p>
									<p><span><i class="fas fa-crop-alt opacity-50"></i> 난이도</span> <span><?=$rowLesson["클래스난이도"]?></span></p>
									<p onclick="copyToAddress('#copyAddress')"><span><i class="fas fa-comment opacity-50"></i> 공유하기</span>
										<span>
										<span id="copyAddress" class="text-adddress"><?=$_SERVER['HTTP_HOST']?>/page/class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?></span>
										<span class="text-copy">복사</span>
									</span></p>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_details_tab clearfix">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="product-details-tab">
                            <h3>클래스 상세 설명</h3>
                        </ul>
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="description">
                                <div class="description_area">
                                    <article class="p-3 mb-2">
										<div class="page-write">
											<p class="fs-005 post"><?=$rowLesson["l_intro"]?>
											</p>
										</div>
									</article>
                                </div>
                            </div>  

                        </div>
						<span id="qqna"></span>
						<div class="my-3" id="daum_map" style="height: 300px;"></div>
                    </div>


					<div role="tabpadnel" class="tab-pane mt-5" id="qna">
						<div class="reviews_area">
							<div class="single-widget-area border-bottom" id="divQuestion">		
<?
	// 문의내용
	$query  = " SELECT A.li_id, A.l_id, A.question, A.answer, A.isrt_user, DATE_FORMAT(A.isrt_dt, '%Y-%m-%d %H:%i:%s') AS isrt_dt, A.updt_user, A.updt_dt, B.name, B.페이지프로필사진, B.닉네임    \n";
	$query .= " FROM    tbl_lesson_inquiry A, tbl_member B    \n";
	$query .= " WHERE  A.l_id = {$strRecordNo}    \n";
	$query .= " AND    A.isrt_user = B.member_id   \n";  
	$query .= " ORDER BY A.li_id DESC   \n";  
	$resultInquiry = db_query($query);   

	while ($rowInquiry = mysqli_fetch_array($resultInquiry)) {				
?>							
								<ul>
									<li>
										<div class="single_user_review mb-15">
											<div class="review-rating">
<?
		if (trim($rowInquiry['페이지프로필사진']) != "") {
?>
			  
												<img src="<?=phpThumb("/_UPLOAD/".$rowInquiry['페이지프로필사진'], 100, 100, 2)?>" style="border-radius:50px; height:40px; width:40px;" class="author-thumb js-image-preview">
<?
        } else {
?>
												<img src="./assets/img/bg-img/1.jpg" style="border-radius:50px; height:40px; width:40px;" class="author-thumb js-image-preview">
<?	
		}
?>
												<!-- 회원닉네임 / 이름 --><span><a href="#"><?=(trim($rowInquiry["닉네임"]) != "") ? $rowInquiry["닉네임"] : $rowInquiry["name"];?></a> on <span><?=$rowInquiry["isrt_dt"]?></span></span>
											</div>
											<div class="review-details">
												<p class="ml-5"><?=str_replace("\n", "<br>", $rowInquiry["question"])?></p>
<?
	    if ($rowInquiry["answer"] != "") {
?>
												<p class="ml-6 divAnswer">ㄴRe: <?=str_replace("\n", "<br>", $rowInquiry["answer"])?>
														<input type="hidden" class="txtQNo">
														<input type="hidden" class="txtAnswer">
														<span class="btnAnswer" style="display:none"></span>
												</p>
<?
		} else {
			// 로그인한 회원이 현재 레슨의 아티스트라면 댓글 달기 가능
			if ($ck_login_member_pk == $rowLesson["member_id"]) {
?>
												<p class="ml-6 divAnswer ">													
													<label for="comments">댓글달기</label>
													<input type="hidden" class="txtQNo" value="<?=$rowInquiry["li_id"]?>">
													<textarea class="form-control txtAnswer" rows="3" data-max-length="150"></textarea>
													<span class="btn btn-outline-info btn-sm mt-1 btnAnswer">등록</span>
												</p>

<?
			}
		}
?>
											</div>
										</div>
									</li>
								</ul>
<?
	}
?>
							</div>
<?
			if ($ck_login_member_pk) {
?>
							<div class="submit_a_review_area mt-50">
								<h4>아티스트에게 문의하기</h4>
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label for="comments">문의내용</label>
												<textarea class="form-control" id="txtQuestion" rows="5" data-max-length="150"></textarea>
											</div>
										</div>
										<div class="col-12">
											<span id="btnQuestion" class="btn alazea-btn">문의등록</span>
										</div>
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
    <!-- ##### Single Product Details Area End ##### -->


 <? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$(document).ready(function(){
        
        $(document).on('click', '#btnZZim', function(event) {
            $.ajax({
                url: './class_detail_action.php',
                type: 'post',
                data: {
                    txtRecordNo: "<?=$strRecordNo?>",
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    arrData = Data.split("@");

                    if (arrData[0] == "SUCCESSI") {
                        $('#lblZZim').text(" 찜해제");
                        $('#lblZZimCnt').html(arrData[1]);
                    } else if (arrData[0] == "SUCCESSD") {
                        $('#lblZZim').text(" 찜하기");
                        $('#lblZZimCnt').html(arrData[1]);
                    } else {
						alert(arrData[1]);
					}

                } 

            });
        });

        // 문의등록 클릭시
        $(document).on('click', '#btnQuestion', function(event) {
			if ($.trim($('#txtQuestion').val()) == "") {
				alert("문의내용을 입력하세요.");
				$('#txtQuestion').focus();
				return;
			}

			if (confirm("문의하시겠습니까?")) {
				$.ajax({
					url: './class_detail_inquiry_action.php',
					type: 'post',
					data: {
						txtAction: 'Q',
						txtRecordNo: "<?=$strRecordNo?>",
						txtQuestion: $('#txtQuestion').val(),
					},
					datatype: 'text',
					success: function(Data) {
						Data = $.trim(Data);
						arrData = Data.split("@");
//$('#aa').val(Data);
//alert(Data)
//return
						if (arrData[0] == "SUCCESS") {
							alert('문의가 등록되었습니다');
						    $('#divQuestion').prepend(arrData[1]);
							$('#txtQuestion').val('');
							location.href="#qqna";
						} else {
							alert(arrData[1]);
						}
					} 
				});
			}
        });

        // 답변등록 클릭시
        $(document).on('click', '.btnAnswer', function(event) {
			var idx = $('.btnAnswer').index(this);
			if ($.trim($('.txtAnswer').eq(idx).val()) == "") {
				alert("답변을 입력하세요.");
				$('.txtAnswer').eq(idx).focus();
				return;
			}

			if (confirm("답변을 작성하시겠습니까?")) {
				$.ajax({
					url: './class_detail_inquiry_action.php',
					type: 'post',
					data: {
						txtAction: 'A',
						txtRecordNo: "<?=$strRecordNo?>",
						txtQNo: $('.txtQNo').eq(idx).val(),
						txtAnswer: $('.txtAnswer').eq(idx).val(),
					},
					datatype: 'text',
					success: function(Data) {
						Data = $.trim(Data);

						arrData = Data.split("@");
						if (arrData[0] == "SUCCESS") {
						    $('.divAnswer').eq(idx).html(arrData[1]);
							alert('답변이 등록되었습니다');
						} else {
							alert(arrData[1]);
						}
					} 
				});
			}

        });
	});


	$('.nav_bottom li[data-name="classlist"]').addClass('active');

</script>

<? 

$rowS['store_addr'] = $rowLesson['클래스주소'];
$rowS['store_name'] = $rowLesson['l_title'];
include "_kakao_map.php"; 

?>

</html>