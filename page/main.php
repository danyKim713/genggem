<? 
	$NO_LOGIN = "Y";
	include "./inc_program.php"; 
	
    // 추천영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= " AND    A.exposure_flg = 'EXPOSREC'  \n";   // 노출위치가 추천영상인 것만
    $query .= " AND    A.member_id = B.member_id   \n";   
    $query .= " ORDER BY RAND() LIMIT 4   \n";

    $resultRecom = db_query($query); 

    // 인기레슨
    $query  = " SELECT A.*, A.l_id, A.member_id, A.l_title, A.l_tag, A.l_price, A.l_area, A.l_intro, B.cat_nm, C.lesson_title   \n";
    $query .= " FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C   \n";
    $query .= " WHERE  A.sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
    $query .= " AND    A.popularity_flg = 'AD001001'   \n";    //  인기 레슨만
    $query .= " AND    A.cat_id = B.cat_id   \n";
    $query .= " AND    A.member_id = C.member_id   \n";
    $query .= " ORDER BY RAND() LIMIT 4  \n";
    $resultPopLesson = db_query($query);    

	// 추천코치
    $query  = " SELECT A.co_id, A.member_id, A.coach_career, A.career_memo, A.use_flg, A.recomm_flg, A.memo, B.member_uid, B.background_photo, B.profile_photo, B.lesson_title, lesson_greetings   \n";
    $query .= " FROM   tbl_coach A, tbl_lesson_setup B \n";
    $query .= " WHERE  A.use_flg = 'AD005001'   \n";    //  사용중인 코치만
    $query .= " AND    A.recomm_flg = 'AD001001'   \n";
    $query .= " AND    A.member_id = B.member_id   \n";
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultRecommCoach = db_query($query); 

    $query  = " SELECT A.co_id, A.member_id, A.coach_career, A.career_memo, A.use_flg, A.recomm_flg, A.memo, B.member_uid, B.background_photo, B.profile_photo, B.lesson_title, lesson_greetings   \n";
    $query .= " FROM   tbl_coach A, tbl_lesson_setup B \n";
    $query .= " WHERE  A.use_flg = 'AD005001'   \n";    //  사용중인 코치만
    $query .= " AND    A.member_id = B.member_id   \n";
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultCoach = db_query($query); 


    $strCurDt = date("Y-m-d H:i:s");  // 현재날짜시간

    // 진행중인 딜
    $query  = " SELECT K.dg_id, K.shop_id, K.deal_price, K.deal_sdt, K.deal_edt, \n";
    $query .= "        A.sg_id, A.shop_id, A.shop_uid, A.goods_cd, A.b_cat, A.m_cat, A.s_cat, A.goods_nm, A.goods_line_desc, \n";
    $query .= "        A.main_disp_seq, A.disp_seq, A.main_best_goods, A.main_new_goods, A.main_recomm_goods, A.main_catbest1_goods, \n";
    $query .= "        A.main_catbest2_goods, A.best_goods, A.new_goods, A.recomm_goods, A.brand, A.model, A.goods_color, A.sale_flg,  \n";
    $query .= "        A.coupon_flg, A.sale_price, A.retail_price, A.mileage_rate, A.inventory, A.min_purchase_amount,  \n";
    $query .= "        A.max_purchase_amount, A.goods_desc, A.delivery_term, A.delivery_policy, A.free_delivery_cost,  \n";
    $query .= "        A.delivery_cost, A.delivery_quantity, A.group_delivery, A.main_img, A.manufacturing_country,  \n";
    $query .= "        A.manufacturer, A.product_material, A.manufacture_date, A.children_safe_product, A.warranty,   \n";
    $query .= "        A.notice, A.kc_certification, A.service_info, A.certification_flg, A.view_cnt, B.shop_nick, B.mobile, B.counsel_tel  \n";
    $query .= " FROM   sysT_DealGoods K, sysT_SellerGoods A, sysT_Seller B \n";
    $query .= " WHERE  A.certification_flg = 'SAATHYAU'  \n"; // 상품 판매 인증여부(인증)
    $query .= " AND    A.sale_flg = 'GS346SAL'  \n";          // 상품 판매여부(판매중)
    $query .= " AND    B.use_flg = 'AD005001'  \n";   // 판매자 사용여부(예)
    $query .= " AND    B.sale_flg = 'GS730YSA'  \n";   // 판매자 상품판매여부(판매중)
    $query .= " AND    (K.deal_sdt  <= '{$strCurDt}' AND K.deal_edt  >= '{$strCurDt}') \n"; 
    $query .= " AND    K.sg_id  = A.sg_id \n"; 
    $query .= " AND    A.shop_uid = B.shop_uid  \n";
    $query .= " ORDER BY K.deal_sdt  \n";
    $resultDeal = db_query($query); 



?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<? include_once "inc_main_popup.php"; ?>
	<!-- <div class="fixed-side-navbar">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="#home"><span>Intro</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#services"><span>Page</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#portfolio"><span>Club</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#our-story"><span>Lesson</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#contact-us"><span>Shopping</span></a></li>
        </ul>
    </div> -->

	<section class="hero-area">
        <div class="hero-post-slides owl-carousel">

            <!-- Single banner Post -->
            <div class="single-hero-post bg-overlay">
                <!-- Post Image -->
                <div class="slide-img bg-img" style="background-image: url(./assets/img/1st-section.jpg);"></div>
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12">
                            <!-- Post Content -->
                            <div class="hero-slides-content text-center">
								<h1 style="font-size: 60px; color: #fff; font-weight: 900;"><font color="#ff3333">G</font>EN<font color="#99ff66">GG</font>EM</h1>
								<p style="font-size: 36px; color: #fff; font-weight: 600; color: #ff7d27">Sport & Beauty Club</p>
								<div class="primary-button">
									<a href="#services">Discover More</a>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			<!-- Single banner Post -->
            <div class="single-hero-post bg-overlay">
                <!-- Post Image -->
                <div class="slide-img bg-img" style="background-image: url(./assets/img/1st-section-2.jpg);"></div>
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12">
                            <!-- Post Content -->
                            <div class="hero-slides-content text-center">
								<h1 style="font-size: 60px; color: #fff; font-weight: 900;"><font color="#ff3333">G</font>EN<font color="#99ff66">GG</font>EM</h1>
								<p style="font-size: 36px; color: #fff; font-weight: 600; color: #ff7d27">Sport & Beauty Club</p>
								<div class="primary-button">
									<a href="#services">Discover More</a>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			<!-- Single banner Post -->
            <div class="single-hero-post bg-overlay">
                <!-- Post Image -->
                <div class="slide-img bg-img" style="background-image: url(./assets/img/1st-section-3.jpg);"></div>
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12">
                            <!-- Post Content -->
                            <div class="hero-slides-content text-center">
								<h1 style="font-size: 60px; color: #fff; font-weight: 900;"><font color="#ff3333">G</font>EN<font color="#99ff66">GG</font>EM</h1>
								<p style="font-size: 36px; color: #fff; font-weight: 600; color: #ff7d27">Sport & Beauty Club</p>
								<div class="primary-button">
									<a href="#services">Discover More</a>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- <div class="parallax-content baner-content" id="home">
        <div class="container">
            <div class="first-content">
                <h1><font color="#ff3333">G</font>EN<font color="#99ff66">GG</font>EM</h1>
                <span><em>Sport & Beauty Club</em></span>
                <div class="primary-button">
                    <a href="#services">Discover More</a>
                </div>
            </div>
        </div>
    </div> -->


    <div class="service-content" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="left-text">
                        <h4>젠껨 페이지</h4>
                        <div class="line-dec"></div>
						<article class="mb-2">
							<div class="px-3 py-2 d-flex align-items-center position-r" style="border:1px solid #ddd;">
								<img src="assets/img/symbol.png" width="25" height="25" class="">
								<div class="w-100">
									<? if($rowMember['member_id']){?>
									<a href="page_write.php" title="글 작성하기" class="p-1 color-6 fs-005 d-block">내페이지에 글쓰기!</a>
									<?}else{?>
									<a href="login.php" title="글 작성하기" class="p-2 color-8 fs-005 d-block">로그인 후 이용할 수 있습니다</a>
									<?}?>
									<a href="page_write.php"><button class="btn-right position-ab btn btn-outline-secondary btn-xs mr-1" type="button"><i class="fas fa-image"></i> 사진</button></a>
								</div>
							</div>
						</article>
                        <ul>
							<? if($rowMember['member_id']){?>
							<div class="d-flex div-f">
								<a href="page_friends.php" title="팔로잉 전체보기" class="col">
									<span class="fs-005">친구</span><br>
									<span class="fs-05 color-primary fw-600"><?=number_format(페이지친구수($rowMember['member_id']))?></span>
								</a>
								<a href="page_following.php" title="팔로잉 전체보기" class="col">
									<span class="fs-005">팔로잉</span><br>
									<span class="fs-05 color-primary fw-600"><?=number_format($팔로잉수)?></span>
								</a>
								<a href="page_follower.php" title="팔로워 전체보기" class="col">
									<span class="fs-005">팔로워</span><br>
									<span class="fs-05 color-primary fw-600"><?=number_format($팔로워수)?></span>
								</a>
							</div>
							<?}else{?>
							<li>- 페이지를 공유해 보세요.</li>
                            <li>- 다양한 분야의 여러사람과 소통할 수 있습니다.</li>
							<?}?>
                        </ul>
                        <div class="primary-button">
                            <a href="page_me.php">내 페이지</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
					<div class="left-text hidden-xs">
						<h4>추천 페이지</h4>                        
						<div class="">
							<div class="list list-default mt-3">
								<ul>
								<?
								$query = "select * from tbl_member where 공개여부 = '전체공개' and 페이지이름 != '' and member_id != '{$rowMember['member_id']}' order by rand() LIMIT 0,5";
								$resultM = db_query($query);

								$fMember = array();
								while($rowM = db_fetch($resultM)){
									$fMember[] = " member_id != '{$rowM['member_id']}'";
								?>

									<?=페이지리스트용($rowM['member_id'])?>
								<?}?>
								</ul>
							</div>
						</div>
					</div>
					
					<div class="mobile-po">
					<section>
						<div class="mt-5">
							<div class="row align-items-center justify-content-center">
								<div class="col-sm-12 col-lg-12 col-xl-4 px-0">
									
									<div class="mb-2">
									<div class="list-tour tour-multi pt-2 pb-2">
										<ul>
											<?
											$query = "select * from tbl_member where 공개여부 = '전체공개' and 페이지이름 != '' and member_id != '{$rowMember['member_id']}' order by rand() LIMIT 0,10";
											$resultM = db_query($query);

											$fMember = array();
											while($rowM = db_fetch($resultM)){
												$fMember[] = " member_id != '{$rowM['member_id']}'";
											?>

												<?=페이지리스트용모바일($rowM['member_id'])?>
											<?}?>
										</ul>
									</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					</div>

					<div class="mobile-ho">
					<section>
						<div class="container header-top">
							<div class="row align-items-center justify-content-center">
								<div class="col-sm-11 col-lg-6 col-xl-4 px-0">
									
									<article class="mb-2">
									<div class="list-tour tour-multi pt-2 pb-2">
										<ul>
											<?
											$query = "select * from tbl_member where 공개여부 = '전체공개' and 페이지이름 != '' and member_id != '{$rowMember['member_id']}' order by rand() LIMIT 0,10";
											$resultM = db_query($query);

											$fMember = array();
											while($rowM = db_fetch($resultM)){
												$fMember[] = " member_id != '{$rowM['member_id']}'";
											?>

												<?=페이지리스트용모바일2($rowM['member_id'])?>
											<?}?>
										</ul>
									</div>
									</article>
								</div>
							</div>
						</div>
					</section>
					</div>

                </div>                
            </div>
        </div>
    </div>

    
    <div class="parallax-content2 projects-content" id="portfolio">
        <div class="container hidden-xs">
            <div class="row mb-3">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center">
                        <h2 class="color-8">HOT CLUB</h2>
						<p class="color-8">- 한주간 핫한 모임이에요 -</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
			<?
			$query = "select C.*, (select count(*) as cnt from gf_channel_member M where M.fk_channel = C.pk_channel) as MemberCnt from gf_channel C where C.사용여부 = 'Y' {$where} order by MemberCnt DESC LIMIT 0,4";
			$result = db_query($query);

			$list = array();
			while($row = db_fetch($result)){
				$list[] = $row;
			}

			shuffle($list);

			for ($i=0; $i<count($list); $i++){
				$row = $list[$i];
			?>	
                <!-- Single CAFE Post Area -->
				
                <div class="col-12 col-md-6 col-lg-3">
				<?= 채널리스트($row['pk_channel']);?>
                    
					
                </div><?}?>
            </div>

			<!-- <div id="owl-testimonials" class="owl-carousel owl-theme">
				<div class="item">
					<div class="testimonials-item">
						<a href="img/1st-big-item.jpg" data-lightbox="image-1"><img src="./assets/img/1st-item.jpg" alt=""></a>
						<div class="text-content">
							<h4>Awesome Note Book</h4>
							<span>$18.00</span>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="testimonials-item">
						<a href="img/2nd-big-item.jpg" data-lightbox="image-1"><img src="./assets/img/2nd-item.jpg" alt=""></a>
						<div class="text-content">
							<h4>Antique Decoration Photo</h4>
							<span>$27.00</span>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="testimonials-item">
						<a href="img/3rd-big-item.jpg" data-lightbox="image-1"><img src="./assets/img/3rd-item.jpg" alt=""></a>
						<div class="text-content">
							<h4>Work Hand Bag</h4>
							<span>$36.00</span>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="testimonials-item">
						<a href="img/3rd-big-item.jpg" data-lightbox="image-1"><img src="./assets/img/3rd-item.jpg" alt=""></a>
						<div class="text-content">
							<h4>Work Hand Bag</h4>
							<span>$36.00</span>
						</div>
					</div>
				</div>
			</div> -->
        
			<div style="margin:20px 0 50px 0;text-align:center;width:100%;">
				<a href="cafe_list.php" class="btn alazea-btn">전체카페 <i class="fas fa-arrow-right ml-1"></i></a>
			</div>
        </div>

		

		<div class="mobile-po">	
			<div class="row mb-3">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center">
                        <h2 class="color-8">HOT CLUB</h2>
						<p class="color-8">- 한주간 핫한 클럽이에요 -</p>
                    </div>
                </div>
            </div>

			<section class="col-sm-12">
				<div class="mt-3">
					<div class="row align-items-center justify-content-center">
						<div class="col-sm-12 col-lg-12 col-xl-4 px-0">
							
							<div class="mb-2">
							<div class="list-tour tour-multi pt-2 pb-2">
								<ul>
									<?
									$query = "select C.*, (select count(*) as cnt from gf_channel_member M where M.fk_channel = C.pk_channel) as MemberCnt from gf_channel C where C.사용여부 = 'Y' {$where} order by MemberCnt DESC LIMIT 0,4";
									$result = db_query($query);

									$list = array();
									while($row = db_fetch($result)){
										$list[] = $row;
									}

									shuffle($list);

									for ($i=0; $i<count($list); $i++){
										$row = $list[$i];
									?>	

										<?= 채널리스트메인($row['pk_channel']);?>
									<?}?>
								</ul>
							</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<div class="mobile-ho">
			<section>
				<div class="container header-top">
					<div class="row align-items-center justify-content-center">
						<div class="col-sm-11 col-lg-6 col-xl-4 px-0">
							
							<article class="mb-2">
							<div class="list-tour tour-multi pt-2 pb-2">
								<ul>
									<?
									$query = "select * from tbl_member where 공개여부 = '전체공개' and 페이지이름 != '' and member_id != '{$rowMember['member_id']}' order by rand() LIMIT 0,10";
									$resultM = db_query($query);

									$fMember = array();
									while($rowM = db_fetch($resultM)){
										$fMember[] = " member_id != '{$rowM['member_id']}'";
									?>

										<?=페이지리스트용모바일2($rowM['member_id'])?>
									<?}?>
								</ul>
							</div>
							</article>
						</div>
					</div>
				</div>
			</section>
		</div>
    </div>


    



<!-- ##### banner Area Start ##### -->   


	<section class="new-arrivals-products-area section-padding-70-0">
		<div class="container">
			<div class="row mb-3">
				<div class="col-12">
					<!-- Section Heading -->
					<div class="section-heading text-center">
						<h2>Lesson</h2>
						<p>함께하는 즐거움! </p>
					</div>
				</div>
			</div>			
			
			<div class="row hidden-xs">
				<?
					while($rowPopLesson = mysqli_fetch_array($resultPopLesson)) {
				?>
                <!-- Single Product Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
						<div class="post-thumb">
							 <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowPopLesson['사진1'],500,365,"2","assets/images/ex_img6.jpg")?>" width="100%" height="365" class="radius-5" /></a>
						</div>

                        <!-- Product Info -->
                        <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>">
						<div class="product-info mt-15">
                                <p><font size="2em" color=""><i class="fas fa-book-open"></i> <?=$rowPopLesson["cat_nm"]?> &nbsp;&nbsp;<i class="fas fa-user-circle"></i> <?=$rowPopLesson["lesson_title"]?></font></p>
								<p class="ellipsis-2"><font color="#000"><?=$rowPopLesson["l_title"]?></font></p>
                            
							<h6 class="mt-2"><strong><font color="#cc0066"><?=number_format($rowPopLesson["l_price"])?></font></strong>원</h6>
							<p style="font-size:12px; line-height:20px; color:#000;" class=" mt-2">
							<i class="fas fa-calendar-check opacity-50"></i> 6월 9일(화)부터 수강가능<br>
							<i class="fas fa-map-marker-alt opacity-50"></i> <?=$rowPopLesson["클래스기본지역"]?></p>
                        </div></a>
                    </div>
                </div>

				<?
					}
				?>

            </div>

			<div class="row mobile-po">	
				ddd
			</div>

			<div class="row mobile-ho">	
			</div>
		</div>
	</section>


	

	
	<!-- ##### Shopping Area Start ##### -->
    <section class="new-arrivals-products-area bg-gray section-padding-100">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center">
                        <h2>Shopping Deal</h2>
                        <p>타임세일! 쇼핑딜 상품~</p>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- Single Product Area -->
<?
    while($rowDeal = mysqli_fetch_array($resultDeal)) {
        $arrDeal = explode(" ",$rowDeal["deal_edt"]);
        $arrDealEDT = explode("-",$arrDeal[0]);
        $arrDealETM = explode(":",$arrDeal[1]);

        $nDCRate = 100 - (($rowDeal["deal_price"] * 100) / $rowDeal["retail_price"]);


        if ($rowDeal["dg_id"] != "") {
            $arrDateTmp = explode(" ", $rowDeal["deal_edt"]);
            $arrDayTmp = explode("-", $arrDateTmp[0]);
            $arrTimeTmp = explode(":", $arrDateTmp[1]);
            
            $arrYear[]  = $arrDayTmp[0];  
            $arrMonth[] = $arrDayTmp[1];  
            $arrDay[]   = $arrDayTmp[2];
            $arrHour[]  = $arrTimeTmp[0];
            $arrMin[]   = $arrTimeTmp[1];
            $arrSec[]   = $arrTimeTmp[2];                         
        }

?>
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
                        <div>
                            <a href="/shop/product/productDtl.php?txtRecordNo=<?=$rowDeal["sg_id"]?>"><img src="<?=phpThumb("/ImgData/SHOP/".$rowDeal['shop_uid']."/".$rowDeal["main_img"],500,365,"2","assets/images/ex_img6.jpg")?>" alt=""><!--<img src="./assets/img/bg-img/ex_img6.jpg" alt="">--></a>
                        </div>
						<div class="col-12 text-center alazea-btn mt-2" style="width:100%;"><i class="fa fa-clock-o mr-1"></i><span class="divDay"></span>일 <span class="divHour"></span>시 <span class="divMin"></span>분 <span class="divSec"></span>초</span></div>

                        <!-- Product Info -->
                        <div class="product-info mt-15 text-center">
                            <a href="/shop/product/productDtl.php?txtRecordNo=<?=$rowDeal["sg_id"]?>">
                                <p><?=cutstr($rowDeal["goods_nm"], 74)?></p>
                            </a>
							<h6><del><font size="2.3em" color="#9f9f9f"><?=number_format($rowDeal["retail_price"])?>원</font></del> <br>
							<strong><font color="#cc0066"><?=number_format(ceil($nDCRate))?>% <i class="fa fa-arrow-down mr-1"></i> <?=number_format($rowDeal["deal_price"])?></font></strong>원</h6>
                        </div>
                    </div>
                </div>
<?
        unset($arrDateTmp);
        unset($arrDayTmp);
        unset($arrTimeTmp);
    }
?>
<? /*
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
                        <div>
                            <a href="/shop"><img src="./assets/img/bg-img/p-2.jpg" alt=""></a>
                        </div>
						<div class="col-12 text-center alazea-btn mt-2" style="width:100%;"><i class="fa fa-clock-o mr-1"></i><span class="divDay"></span>일 <span class="divHour"></span>시 <span class="divMin"></span>분 <span class="divSec"></span>초</span></div>

                        <!-- Product Info -->
                        <div class="product-info mt-15 text-center">
                            <a href="/shop">
                                <p>인디핑크 고급암막커튼- 프리미엄 암막커튼 인디핑크 (기본 140cm x 230cm)</p>
                            </a>
							<h6><del><font size="2.3em" color="#9f9f9f">250,900원</font></del> <br>
							<strong><font color="#cc0066">40% <i class="fa fa-arrow-down mr-1"></i> 198,000</font></strong>원</h6>
                        </div>
                    </div>
                </div>

				<div class="col-12 col-sm-12 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
                        <div>
                            <a href="/shop"><img src="./assets/img/bg-img/p-3.jpg" alt=""></a>
                        </div>
						<div class="col-12 text-center alazea-btn mt-2" style="width:100%;"><i class="fa fa-clock-o mr-1"></i><span class="divDay"></span>일 <span class="divHour"></span>시 <span class="divMin"></span>분 <span class="divSec"></span>초</span></div>

                        <!-- Product Info -->
                        <div class="product-info mt-15 text-center">
                            <a href="/shop">
                                <p>인디핑크 고급암막커튼- 프리미엄 암막커튼 인디핑크 (기본 140cm x 230cm)</p>
                            </a>
							<h6><del><font size="2.3em" color="#9f9f9f">250,900원</font></del> <br>
							<strong><font color="#cc0066">40% <i class="fa fa-arrow-down mr-1"></i> 198,000</font></strong>원</h6>
                        </div>
                    </div>
                </div>

				<div class="col-12 col-sm-12 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
                        <div>
                            <a href="/shop"><img src="./assets/img/bg-img/p-4.jpg" alt=""></a>
                        </div>
						<div class="col-12 text-center alazea-btn mt-2" style="width:100%;"><i class="fa fa-clock-o mr-1"></i><span class="divDay"></span>일 <span class="divHour"></span>시 <span class="divMin"></span>분 <span class="divSec"></span>초</span></div>

                        <!-- Product Info -->
                        <div class="product-info mt-15 text-center">
                            <a href="/shop">
                                <p>인디핑크 고급암막커튼- 프리미엄 암막커튼 인디핑크 (기본 140cm x 230cm)</p>
                            </a>
							<h6><del><font size="2.3em" color="#9f9f9f">250,900원</font></del> <br>
							<strong><font color="#cc0066">40% <i class="fa fa-arrow-down mr-1"></i> 198,000</font></strong>원</h6>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <a href="/shop" class="btn alazea-btn">Go to Shopping</a>
                </div>

            </div>
*/
?>
        </div>
    </section>
    <!-- ##### Product Area End ##### -->

	<!-- ##### store Area Start ##### -->
	<section class="new-arrivals-products-area section-padding-70-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
					<div class="col-12 mb-3">
						<!-- Section Heading -->
						<div class="section-heading text-center">
							<h2>Partner store</h2>
							<p>We have the best class, it must be enjoy for you</p>
						</div>
					</div>
                    <div class="row wow fadeInUp">
						<?php

						$query = "select * from tbl_store where best_yn = 'Y' order by rand()";
						$rStore = db_query($query);
						while($rowStore = db_fetch($rStore)){
						$rowImage = db_select("select * from tbl_store_image where store_id='".$rowStore['store_id']."'");

						?>

                        <div class="col-12 col-lg-3">
                            <div class="single-blog-post mb-50">
                                <div class="post-thumbnail mb-20">
                                    <a href="store.php?store_id=<?=$rowStore['store_id']?>"  title='<?=$dic['View_more']?>'><img src='<?=phpThumb("/_UPLOAD/".$rowImage['filename'],260,170,"2","assets/images/img_store.jpg")?>' alt='' /></a>
                                </div>
								<div class="post-content">
                                    <div class="fs-005 ellipsis">
                                        <a href='store.php?store_id=<?=$rowStore['store_id']?>' title='<?=$dic['View_more']?>'><i class="fas fa-store align-text-top fs--1 color-warning mt-1"></i> <?=$rowStore['store_name']?></a>
                                    </div>
                                    <p class="color-5 ellipsis-2 mt-1"><?=$rowStore['store_desc']?></p>
                                </div>
                            </div>
                        </div>
						<? } ?>
                    </div>
					<div class="col-12 text-center mb-5">
						<a href="store_list.php" class="btn alazea-btn">more view store</a>
					</div>
                </div>
                
                
            </div>
        </div>
    </section>
    <!-- ##### store Area End ##### -->


	<!-- ##### video Area Start ##### -->
    <section class="our-services-area bg-gray section-padding-100">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center">
                        <h2>추천영상</h2>
                        <p>We have the best class, it must be enjoy for you</p>
                    </div>
                </div>
            </div>

            <div class="row">	

                <?
					while ($rowRecom = db_fetch($resultRecom)) { 

						//유투브 썸네일 처리
						$v = getYoutubeIdFromUrl($rowRecom['v_link']);
						$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width=100%>';

						
				?>
				<!-- Single Product Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        
						<!-- Product Image -->
                        <div>
                            <a href="watch_view.php?txtRecordNo=<?=$rowRecom["wv_id"]?>" title=""><?=$strImg?></a>
                        </div>
                        <!-- Product Info -->
                        <div class="product-info mt-15">
                            <a href="watch_view.php?txtRecordNo=<?=$rowRecom["wv_id"]?>" >
								<p style="height:30px;"><font color="#000"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> <?=$rowRecom['creator_title']?></font></p>
                            
							<p style="font-size:12px; line-height:25px; color:#000"><i class="fas fa-calendar-check"></i> <?=cutstr($rowRecom['v_title'], 48)?></p>
							<i class="fas fa-eye opacity-50 mr-1"></i><?=number_format($rowRecom['view_cnt'])?></a>
                        </div>
                    </div>
                </div>
				<?
					}
				?>

                <div class="col-12 text-center">
                    <a href="watch_list.php" class="btn alazea-btn">more view video</a>
                </div>

            </div>
        </div>
    </section>
    <!-- ##### video End ##### -->



<script>
	<? 
    if (COUNT($arrYear) > 0) {
	?>


        function timeCount() { 
	<? 
        $iCnt = COUNT($arrYear);
        for ($i=0; $i<$iCnt;$i++) {
	?>
            nEndTime = new Date(<?=$arrYear[$i]?>,<?=$arrMonth[$i] - 1?>,<?=$arrDay[$i]?>,<?=$arrHour[$i]?>,<?=$arrMin[$i]?>,<?=$arrSec[$i]?>); 
            objNow = new Date(); 

            if (objNow > nEndTime) {
                clearTimeout(newtime);
                location.reload();
                return;
            } else {

                objTime = (nEndTime - objNow) / 1000;

    //            months = objTime / 60 / 60; 
    //            monthsRound = Math.floor(months); 
                days = objTime / 60 / 60 / 24; 
                daysRound = Math.floor(days); 
                hours = objTime / 60 / 60 - (24 * daysRound); 
                hoursRound = "0"+Math.floor(hours); 
                minutes = objTime / 60 - (24 * 60 * daysRound) - (60 * hoursRound); 
                minutesRound = "0"+Math.floor(minutes); 
                seconds = objTime - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) - (60 * minutesRound); 
                secondsRound = "0"+Math.round(seconds); 

                //$('.divMonth').eq(<?=$i?>).html(monthsRound)
                $('.divDay').eq(<?=$i?>).html(daysRound)
                $('.divHour').eq(<?=$i?>).html(hoursRound.substr(-2, 2))
                $('.divMin').eq(<?=$i?>).html(minutesRound.substr(-2, 2))
                $('.divSec').eq(<?=$i?>).html(secondsRound.substr(-2, 2))
            }


	<?  
        }  // end - for
	?>
            newtime = setTimeout("timeCount();", 1000); 

        } // end - javacript function timeCount

        timeCount();
	<?
    } // end - if
	?>

</script>

<? include "./inc_Bottom_main.php"; ?>

<script>
	$('.slider-banner').slick({
		dots: false,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 2500
	});
	$('.tour-multi ul').slick({
			slidesToShow:2,
			dots: false,
			arrows: false,
			infinite: false,
			centerMode: false
	});
		$('.tour-single ul').slick({
			slidesToShow:1,
			dots: true,
			arrows: false,
			infinite: false,
		 	centerMode: false
	});
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>


<? include "./inc_Bottom.php"; ?>
