<!DOCTYPE HTML>
<html lang="en">
<? 
$NO_LOGIN = "Y";
include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">

<body class="mb-5">
<? include "./inc_nav.php"; ?>
	<!-- <div class="breadcrumb-area2 hidden-xs">
        <div class="top-breadcrumb-area bg-img d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_pagde.jpg);">
        </div>
    </div> -->
	<div class="breadcrumb-area hidden-xs">
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_page.jpg);" >
            <h2>SNS<font size="5px">_</font><strong>PAGE</strong></h2>
        </div>
    </div>

	<div class="mobile-po">
        <div style="height:70px;"></div>
    </div>

	<div class="mobile-ho">
        <div style="height:70px;"></div>
    </div>


	<!-- ##### Blog Area Start ##### -->
    <section class="alazea-blog-area mt-30">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap hidden-xs">
				<div class="section-heading hidden-xs">
					<h2>PAGE</h2>
				</div>		
			</div>

            <div class="row">				
				<div class="col-12 col-md-4">
                    <div class="post-sidebar-area">

						<div class="single-widget-area">
							<div class="post-thumb">
								 <div class="px-2 py-2 d-flex align-items-center position-r" style="background:#fff; border:1px solid #eee;">
									<img src="assets/images/symbol.png" width="30" height="30" class="rounded-circle">
									<div class="w-100 ml-1">

									<? if($rowMember['member_id']){?>
										<a href="page_write.php" title="글작성하기" class="p-2 color-5 fs-005 d-block"><i class="fa fa-edit" aria-hidden="true"></i> 내 페이지에 글쓰기</a>
									<?}else{?>
										<a href="login.php" title="글작성하기" class="p-2 color-5 fs-005 d-block">로그인 후 이용할 수 있습니다</a>
									<?}?>
										<a href="page_write.php"><button class="btn-right position-ab btn btn-outline-secondary btn-sm mr-1" type="button"><i class="fas fa-image"></i> 사진</button></a>
									</div>
								</div>
							</div>							

							<!-- 인기페이지 5개 추출 -->
							<article class="p-2 mt-2 mb-2">
								<div class="section-heading">
									<p class="fw-500">회원님을 위한 <font color="#ff3399">추천</font> 페이지</p>
								</div>
								<!-- <a href="page_best.php" title="모두보기" class="float-right color-6 fs-005">모두보기 <span class="icon ic-right-arrow fs--1"></span> </a> -->
								<div class="list list-default mt-3 wow fadeInUp" data-wow-delay="100ms">
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
							</article>
							<!-- //끝 -->
                            
                        </div>
                    </div>
                </div>



				<div class="col-12 col-md-8">
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">							
						<!-- Page -->
						<div class="section-heading">
							<h2><font color="#0066ff">Page</font> 새소식</h2>
							<p>친구들의 새로운 이야기!</p>
						</div>
						<div class="search_by_terms">
							<a href="page_search.php"><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-comments fs--1 color-warning"></i> 페이지 찾기</button></a>					
						</div>
					</div>

					<div class="row">
                        <?
                        $pageScale = 10;
                        $pageNo = 1;

                        $start = ($pageNo-1)*$pageScale;
                        $limit = " LIMIT ".$start.", ".$pageScale;

                        $query = "select * from 
						gf_page_article A, tbl_member M 
						
						where 
							A.member_id = M.member_id 
							and (M.member_id in 
								(
									select parent_member_id from gf_follower F1, tbl_member M1 where F1.parent_member_id = M1.member_id and M1.공개여부 != '미공개' and F1.child_member_id = '{$rowMember['member_id']}'
										UNION
									select origin_member_id from gf_friends F2, tbl_member M2 where F2.origin_member_id = M.member_id and M2.공개여부 != '미공개' and F2.friend_member_id = '{$rowMember['member_id']}' and F2.진행상태 = '친구수락'
										UNION
									select friend_member_id from gf_friends F3, tbl_member M3 where F3.friend_member_id  = M3.member_id and M3.공개여부 != '미공개' and F3.origin_member_id = '{$rowMember['member_id']}' and F3.진행상태 = '친구수락'
								)
								)
							
						order by 
						pk_page_article DESC {$limit}";

                        //echo $query;

                        $result = mysqli_query($conn, $query);

                        while($row = db_fetch($result)){

                            $query = "select * from tbl_member where member_id = '{$row['member_id']}'";
                            $rowM = db_select($query);

                            $query = "select * from gf_page_photo where fk_page_article = '{$row[pk_page_article]}'";
                            $rowPHOTO = db_select($query);


                            ?>
						<div class="col-12 col-md-6 col-lg-6 mb-3">
							<!--게시글-->
							<article class="p-3 mb-2 position-r">
                                <? if($row['member_id'] == $rowMember['member_id']){?>
								<div class="dropdown position-ab btn-right-top">
									<button class="btn btn-transparent color-6 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="javascript:go_modify_page('<?=$row['pk_page_article']?>');" title="글 수정">글 수정</a>
										<a class="dropdown-item" href="javascript:go_delete_page('<?=$row['pk_page_article']?>');" title="글 삭제">글 삭제</a>
										<a class="dropdown-item" href="javascript:void(0);" title="">팔로우 취소</a>
									</div>
								</div>
                                <?}?>

								<!-- 작성자 정보-->
								<div class="d-flex align-items-end mb-3">

									<div class="page-profile">
										<a href="page.php?UID=<?=$rowM['UID']?>" title=""><img src="<?=phpThumb("/_UPLOAD/".$rowM['페이지프로필사진'], 0, 0, 0,  "assets/images/user_img1.jpg")?>" width="40" height="40" class="rounded-circle"></a>
									</div>
									<div class="col page-write lh-3">
										<h3 class="fs-005 mb-0"><?=$row['닉네임']?></h3>
										<span class="date fs--1"><?=date("Y년 m월 d일 H:i", strtotime($row['등록일시']))?></span>
									</div>
								</div>
								<!-- //작성자 정보-->

								<!--사진-->
								<div class="my-3">
									<ul class="d">
										<div class="single-product-area">								
											<div class="post-thumb">												
												<a href="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","")?>" data-lightbox="menu">
												<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","assets/images/page_p1.jpg")?>" width="500" height="500" class="radius-5" />
												</a>
												<!-- 퍼블참조
												<a href="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","")?>" data-lightbox="menu">
												<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","assets/images/ex_img3.jpg")?>" width="500" height="500" class="radius-5" />
												</a> -->
											</div>
										</div>
									</ul>
								</div>
								<!--//사진-->

								<!--버튼-->
								<div class="page-box text-center">
									<div class="row m-0">
										<div class="col p-0 ">
											<div class="checkbox">
												<input id="chk1" name="chk_good" type="checkbox" class="invisible good_<?=$row['pk_page_article']?>" <?=좋아요카운트($row['pk_page_article'])>0?"checked":""?> onChange="go_like('<?=$row['pk_page_article']?>','like_id_<?=$row['pk_page_article']?>');">
												<label for="chk1" class="color-5 mb-0 fw-400"><i class="fa fa-heart-o fs-005 pr-1 color-5" ></i>좋아요 <span class="color-primary" id="like_id_<?=$row['pk_page_article']?>"><?=좋아요카운트($row['pk_page_article'])?></span></label>
											</div>
										</div>
										<div class="col p-0">
											<a href="page_boardview.php?pk_page_article=<?=$row['pk_page_article']?>"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=number_format($댓글수)?></span></a>
										</div>
										 <!-- <div class="col p-0">
											<a href="javascript:void(0)"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유</a>
										</div> -->
									</div>
								</div>
								<!--//버튼-->

								<!--작성글-->
								<div class="page-write mt-2">
									<span class="date fs--1"><?=date("Y년 m월 d일 H:i", strtotime($row['등록일시']))?></span>
									<p class="post ellipsis-2 mb-2"><a href="page_boardview.php?pk_page_article=<?=$row['pk_page_article']?>"><?=$row['내용']?></a></p>
								</div>
								<!--//작성글-->
								
							</article>
							<!--//게시글-->
						</div>
                        <?}?>

                        <?

                        if($rowMember['member_id'] == ""){

                        $pageScale = 10;
                        $pageNo = 1;

                        $start = ($pageNo-1)*$pageScale;
                        $limit = " LIMIT ".$start.", ".$pageScale;

                        $query = "select * from gf_page_article A 
	 
	where 
        1		
	order by 
		pk_page_article DESC {$limit}";

                        //echo $query;

                        $result = mysqli_query($conn, $query);

                        while($row = db_fetch($result)){

                            $query = "select * from tbl_member where member_id = '{$row['member_id']}'";
                            $rowM = db_select($query);

                            $query = "select * from gf_page_photo where fk_page_article = '{$row[pk_page_article]}'";
                            $rowPHOTO = db_select($query);
                            ?>
                            <div class="col-12 col-md-6 col-lg-6 mb-3">
                                <!--게시글-->
                                <article class="p-3 mb-2 position-r">
                                    <? if($row['member_id'] == $rowMember['member_id']){?>
                                        <div class="dropdown position-ab btn-right-top">
                                            <button class="btn btn-transparent color-6 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:go_modify_page('<?=$row['pk_page_article']?>');" title="글 수정">글 수정</a>
                                                <a class="dropdown-item" href="javascript:go_delete_page('<?=$row['pk_page_article']?>');" title="글 삭제">글 삭제</a>
                                                <a class="dropdown-item" href="javascript:void(0);" title="">팔로우 취소</a>
                                            </div>
                                        </div>
                                    <?}?>

                                    <!-- 작성자 정보-->
                                    <div class="d-flex align-items-end mb-3">

                                        <div class="page-profile">
                                            <img src="<?=phpThumb("/_UPLOAD/".$rowM['페이지프로필사진'], 0, 0, 0,  "assets/images/user_img1.jpg")?>" width="40" height="40" class="rounded-circle">
                                            <!-- 퍼블참조
										<img src="<?=phpThumb("/_UPLOAD/".$rowM['페이지프로필사진'], 0, 0, 0,  "assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle"> -->
                                        </div>
                                        <div class="col page-write lh-3">
                                            <h3 class="fs-005 mb-0"><!-- 페이지이름노출 --><?=$row['name']?></h3>
                                            <span class="date fs--1"><!-- 닉네임 -->><?=date("Y년 m월 d일 H:i", strtotime($row['등록일시']))?></span>
                                        </div>
                                    </div>
                                    <!-- //작성자 정보-->

                                    <!--사진-->
                                    <div class="my-3">
                                        <ul class="d">
                                            <div class="single-product-area">
                                                <div class="post-thumb">
                                                    <a href="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","")?>" data-lightbox="menu">
                                                        <img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","assets/images/page_p1.jpg")?>" width="500" height="500" class="radius-5" />
                                                    </a>
                                                    <!-- 퍼블참조
												<a href="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","")?>" data-lightbox="menu">
												<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","assets/images/ex_img3.jpg")?>" width="500" height="500" class="radius-5" />
												</a> -->
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                    <!--//사진-->

                                    <!--버튼-->
                                    <div class="page-box text-center">
                                        <div class="row m-0">
                                            <div class="col p-0 ">
                                                <div class="checkbox">
                                                    <input id="chk1" name="chk_good" type="checkbox" class="invisible good_<?=$row['pk_page_article']?>" <?=좋아요카운트($row['pk_page_article'])>0?"checked":""?> onChange="go_like('<?=$row['pk_page_article']?>','like_id_<?=$row['pk_page_article']?>');">
                                                    <label for="chk1" class="color-5 mb-0 fw-400"><i class="fa fa-heart-o fs-005 pr-1 color-5" ></i>좋아요 <span class="color-primary" id="like_id_<?=$row['pk_page_article']?>"><?=좋아요카운트($row['pk_page_article'])?></span></label>
                                                </div>
                                            </div>
                                            <div class="col p-0">
                                                <a href="javascript:void(0)"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=number_format($댓글수)?></span></a>
                                            </div>
                                            <!-- <div class="col p-0">
                                               <a href="javascript:void(0)"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유</a>
                                           </div> -->
                                        </div>
                                    </div>
                                    <!--//버튼-->

                                    <!--작성글-->
                                    <div class="page-write mt-2">
                                        <span class="date fs--1"><?=date("Y년 m월 d일 H:i", strtotime($row['등록일시']))?></span>
                                        <p class="post ellipsis-2 mb-2"><?=$row['내용']?></p>
                                    </div>
                                    <!--//작성글-->

                                </article>
                                <!--//게시글-->
                            </div>
                        <?}?>
                        <?}?>


					</div>
                </div>


				
				
				
				<?/*<div class="col-12 col-md-8">
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">									
							
						<!-- Shop Page Count -->
						<div class="section-heading">
							<h2><font color="#0066ff">New</font> Page</h2>
							<p>새로 개설된 페이지입니다.</p>
						</div>
						<div class="search_by_terms">
							<a href="cafe_view.php"><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-comments fs--1 color-warning"></i> 페이지 더보기</button></a>					
						</div>
					</div>

					<div class="row">
						
						<?
						$fMemberWhere = implode(" or ", $fMember);

						$query = "select * from tbl_member where 공개여부 = '전체공개' and member_id != '{$rowMember['member_id']}' and ({$fMemberWhere}) order by rand() LIMIT 0,32";

						$resultM = db_query($query);

						while($rowM = db_fetch($resultM)){
						?>
						<div class="col-12 col-md-6 col-lg-3 mb-3">
							<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
								
								<div class="post-thumb">
									<a href="page_user.php?UID=<?=$rowM['UID']?>" title="" class="card">
										<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".($rowM['페이지배경사진']?$rowM['페이지배경사진']:$rowM['페이지프로필사진']),500,500,"2","assets/images/ex_img3.jpg")?>" width="500" height="500" class="radius-5">
										 <div class="figure-caption text-center" style="padding:10px;"><?=$rowM['닉네임']?></div>
									</a>
								</div>
							</div>
						</div>
						<?}?>	
					</div>
                </div>*/?>

            </div>
        </div>
    </section>


	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_page.php"; ?>
</body>
<script>
	$('.nav_category li[data-name="gnb-page"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>