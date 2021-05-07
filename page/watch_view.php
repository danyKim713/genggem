<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<?
    $strRecordNo = $_GET["txtRecordNo"];

    // 영상 조회수 증가
    $query  = " UPDATE tbl_watch_video SET    \n";
    $query .= "        view_cnt = view_cnt + 1   \n";      
    $query .= " WHERE  wv_id='{$strRecordNo}'   \n";      

    $resultViewCnt = db_query($query); 


    // 영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.good_cnt,  A.view_cnt, DATE_FORMAT(A.isrt_dt, '%Y년% %m월 %d일 %H:%i') AS isrt_dt, B.creator_title, B.creator_explanation, C.페이지배경사진, C.페이지프로필사진   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B, tbl_member C   \n";
    $query .= " WHERE  A.wv_id='{$strRecordNo}'   \n";      
    $query .= " AND    A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= " AND    A.member_id = B.member_id   \n";      
    $query .= " AND    A.member_id = C.member_id   \n";      

    $resultInfo = db_select($query); 

    $strTag = "";
    if (trim($resultInfo["v_tag"]) != "") {
        $arrTag = explode(",", $resultInfo["v_tag"]);

        for ($i=0; $i<count($arrTag); $i++) {
            $arrTag[$i] = "<span class=\"mr-2\">#".trim($arrTag[$i])."</span>";
        }

        $strTag = implode(" ", $arrTag);
    }

    // 현재 회원이 영상 좋아요 클릭했는지 조회
    $query  = " SELECT COUNT(wva_id) AS cnt  \n";
    $query .= " FROM   tbl_watch_video_appraisal   \n";
    $query .= " WHERE  wv_id='{$strRecordNo}'   \n";      
    $query .= " AND    member_id='{$ck_login_member_pk}'   \n";      
    $resultMemberGoodCnt = db_select($query); 

    $nMemberGoodCnt = $resultMemberGoodCnt["cnt"];

    $strClass1 = "";
    $strClass2 = "";

    if ($nMemberGoodCnt > 0) {        // 현재의 회원이 영상의 좋아요를 선택했다면
        $strClass1 = "color-danger mb-0 fw-400 lblChkGood";
        $strClass2 = "far fa-thumbs-up fs-005 pr-1";
    } else {
        $strClass1 = "color-5 mb-0 fw-400 lblChkGood";
        $strClass2 = "far fa-thumbs-up fs-005 pr-1";
    }


    // 구독자 수 가져오기
    $query  = " SELECT COUNT(wvs_id) AS cnt  \n";
    $query .= " FROM   tbl_watch_video_subscription   \n";
    $query .= " WHERE  member_id = '{$resultInfo["member_id"]}'   \n";   // 영상등록자 ID   
    $resultSubCnt = db_select($query); 

    // 로긴한 회원의 구독 정보 가져오기
    $query  = " SELECT COUNT(wvs_id) AS cnt  \n";
    $query .= " FROM   tbl_watch_video_subscription   \n";
    $query .= " WHERE  member_id = '{$resultInfo["member_id"]}'   \n";   // 영상등록자 ID   
    $query .= " AND    isrt_user = '{$ck_login_member_pk}'   \n";        // 구독자가 현재 로긴한 회원
    $resultMemberSubCnt = db_select($query); 

    // 영상댓글 가져오기
    $query  = " SELECT A.*, B.name, B.닉네임, B.페이지배경사진, B.페이지프로필사진,   \n";
    $query .= "        TIMESTAMPDIFF(SECOND, A.isrt_dt, NOW()) AS diffSecond,   \n";
    $query .= "        TIMESTAMPDIFF(MINUTE, A.isrt_dt, NOW()) AS diffMinute,   \n";
    $query .= "        TIMESTAMPDIFF(HOUR, A.isrt_dt, NOW()) AS diffHour,   \n";
    $query .= "        TIMESTAMPDIFF(DAY, A.isrt_dt, NOW()) AS diffDay,   \n";
    $query .= "        TIMESTAMPDIFF(WEEK, A.isrt_dt, NOW()) AS diffWeek,   \n";
    $query .= "        TIMESTAMPDIFF(MONTH, A.isrt_dt, NOW()) AS diffMonth,   \n";
    $query .= "        TIMESTAMPDIFF(YEAR, A.isrt_dt, NOW()) AS diffYear   \n";
    $query .= " FROM   tbl_watch_video_comment A, tbl_member B  \n";
    $query .= " WHERE  A.wv_id = '{$strRecordNo}'   \n";      
    $query .= " AND    A.depth = '1'   \n";      
    $query .= " AND    A.isrt_user = B.member_id   \n";   
    $query .= " ORDER BY A.isrt_dt DESC   \n";   

    $oRs_Comment = db_query($query); 
    $nCommentCnt = mysqli_num_rows($oRs_Comment);
?>
<body class="mb-5">

<?/*<header class="header top_fixed">
	<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
	<h2 class="header-title text-center">영상 보기</h2>
</header>	
	<div class="mt-90"><? include "./inc_watch_nav.php"; ?></div>*/?>


<? include "./inc_nav.php"; ?>
    <div class="breadcrumb-area">
        <!-- Top background Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg10.jpg);">
            <h2>Craft Video</h2>
        </div>
    </div>

	<? include "./inc_watch_nav.php"; ?>



	<section class="alazea-blog-area">
        <div class="container">
			<div class="row">
				<div class="col-12 col-md-12">					
					<article class="con-watch mb-2">	

						<!--영상정보-->
						<div class="con-watch-view p-3">
							<div class="width"><iframe width="100%" height="600" src="https://www.youtube.com/embed/<?=getYoutubeIdFromUrl($resultInfo['v_link'])?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>

							<div class="width2"><iframe width="100%" height="200" src="https://www.youtube.com/embed/<?=getYoutubeIdFromUrl($resultInfo['v_link'])?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>

							<div class="info mt-2 pb-3">
								<h5 class="fw-500"><?=$resultInfo["v_title"]?></h5>
								<span class="txt">조회수 <?=number_format($resultInfo["view_cnt"])?>회 <span class="bar"></span><?=$resultInfo["isrt_dt"]?></span>
								<span class="bar"></span>
								<div class="checkbox d-inline">
                                    <input type="hidden" id="txtMemberGood" name="txtMemberGood"  value="<?=$nMemberGoodCnt?>">
									<input id="chkGood" name="chkGood" type="checkbox" class="invisible" value="<?=$resultInfo["wv_id"]?>">
									<label for="chkGood" id="lblChkGood" class="<?=$strClass1?> btn btn-info2 btn-xs"><i class="<?=$strClass2?>"></i>좋아요 <span id="spnGoodCnt"><?=$resultInfo["good_cnt"]?></span></label>
								</div>
								<div class="fs-005 mt-3 color-6">
                                    <?=$strTag?>
								</div>
								<div class="fs-005 mt-3 color-6">
									<a href="watch.php?txtRecordNo=<?=$resultInfo["member_uid"]?>" class="btn btn-outline-primary btn-sm btn-capsule"><i class="fas fa-play-circle fs--1 opacity-50"></i> 크리에이터 전체영상</a>
								</div>
							</div>
						</div>

						<!--작성자 코멘트-->
						<div class="con-watch-post p-3 d-flex align-items-start position-r" style="border-bottom:1px solid #ebebeb;">
							<div class="page-profile">
								<img src="<?=phpThumb("/_UPLOAD/".($resultInfo['페이지프로필사진']?$resultInfo['페이지프로필사진']:$resultInfo['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
							</div>
							<div class="page-write col lh-3 pr-0">
								<div class="d-flex align-items-start justify-content-between">
									<div>
										<h5 class="fs-005 mb-1"><?=$resultInfo["creator_title"]?></h5>
										<span class="txt">구독 <?=number_format($resultMemberSubCnt["cnt"])?>명</span>
									</div>
									<div id="divBtn"> 
<?  if ($resultMemberSubCnt["cnt"] > 0) {  // 구독중이면 ?>
									<button type="button" class="btn-add btn btn-info3 btn-sm btn-capsule" id="btnSubIng"><i class="fas fa-check fs--1 opacity-50"></i> 구독중</button>
<? } else {  ?>

									<button type="button" class="btn-add btn btn-info btn-sm btn-capsule" id="btnSub">+ 구독</button>
<? }  ?>
									</div>

								</div>
								<p class="description fs-005 fw-300 my-3"><?=$resultInfo["creator_explanation"]?></p>
								<button type="button" class="btn-more btn btn-gray color-7 p-1 fs-005">더보기</button>
							</div>
						</div>
						<!--//작성자 코멘트-->
					</article>

					<!--댓글-->
					<div class="col-sm-112 col-lg-12 col-xl-12 p-3 mb-4">
							<div class="d-flex">
								<textarea id="txtComment" class="form-control" placeholder="댓글 내용을 입력해주세요" rows="1"></textarea>
								<button type="button" id="btnCommentOK" class="btn btn-warning col-2 fs-005 px-3 ml-2">등록</button>
							</div>
						</div>
						<!--//댓글입력창-->
					<article class="p-3 mb-1">
						<h2 class="main-tlt display-inline">댓글 <span class="color-primary"><?=$nCommentCnt?></span>개</h2>
						<div class="list-comment mt-3">
							<ul class="ULC">
<?
    $i = 0;

    while ($RS_Comment = mysqli_fetch_array($oRs_Comment)) {
        $strCommentTmp = str_replace("\n", "<br>", $RS_Comment['comment']);
        $strCommentTmp = str_replace(" ", "&nbsp;", $strCommentTmp);

        // 영상답글 가져오기
        $query  = " SELECT A.*, B.name, B.닉네임, B.페이지배경사진, B.페이지프로필사진,   \n";
        $query .= "        TIMESTAMPDIFF(SECOND, A.isrt_dt, NOW()) AS diffSecond,   \n";
        $query .= "        TIMESTAMPDIFF(MINUTE, A.isrt_dt, NOW()) AS diffMinute,   \n";
        $query .= "        TIMESTAMPDIFF(HOUR, A.isrt_dt, NOW()) AS diffHour,   \n";
        $query .= "        TIMESTAMPDIFF(DAY, A.isrt_dt, NOW()) AS diffDay,   \n";
        $query .= "        TIMESTAMPDIFF(WEEK, A.isrt_dt, NOW()) AS diffWeek,   \n";
        $query .= "        TIMESTAMPDIFF(MONTH, A.isrt_dt, NOW()) AS diffMonth,   \n";
        $query .= "        TIMESTAMPDIFF(YEAR, A.isrt_dt, NOW()) AS diffYear   \n";
        $query .= " FROM   tbl_watch_video_comment A, tbl_member B  \n";
        $query .= " WHERE  A.wv_id = '{$strRecordNo}'   \n";      
        $query .= " AND    A.depth = '2'   \n";      
        $query .= " AND    A.ref_1 = '{$RS_Comment['wvc_id']}'   \n";      
        $query .= " AND    A.isrt_user = B.member_id   \n";   
        $query .= " ORDER BY wvc_id DESC   \n";   
        $oRs_Reply = db_query($query); 
        $nReplyCnt = mysqli_num_rows($oRs_Reply);

        $strDiff = "";
        $strDiff = $RS_Comment["diffYear"]."년전";
        if ($RS_Comment["diffYear"] < 1) {
            $strDiff = $RS_Comment["diffMonth"]."달전";
            if ($RS_Comment["diffMonth"] < 1) {
                $strDiff = $RS_Comment["diffWeek"]."주전";
                if ($RS_Comment["diffWeek"] < 1) {
                    $strDiff = $RS_Comment["diffDay"]."일전";
                    if ($RS_Comment["diffDay"] < 1) {
                        $strDiff = $RS_Comment["diffHour"]."시간전";
                        if ($RS_Comment["diffHour"] < 1) {
                            $strDiff = $RS_Comment["diffMinute"]."분전";
                            if ($RS_Comment["diffMinute"] < 1) {
                                $strDiff = $RS_Comment["diffSecond"]."초전";
                            }
                        }

                    }
                }
            }
        }

        // 현재 댓글에 로긴한 회원이 댓글을 달았는지 여부를 조회
        $query  = " SELECT count(wvca_id) AS cnt  \n";
        $query .= " FROM   tbl_watch_video_comment_appraisal  \n";
        $query .= " WHERE  wvc_id = '{$RS_Comment["wvc_id"]}'   \n";      
        $query .= " AND    member_id = '{$rowMember["member_id"]}'   \n";   

        $RS_CommentFlg = db_select($query);

        $strClass1 = "";
        $strClass2 = "";
        $strClass3 = "";

        if ($RS_CommentFlg["cnt"] > 0) {        // 댓글을 달았다면
            $strClass1 = "color-primary mb-0 fw-400 lblChkComment";
            $strClass2 = "far fa-thumbs-up fs-005 pr-1";
            $strClass3 = "EXIT";
        } else {
            $strClass1 = "color-5 mb-0 fw-400 lblChkComment";
            $strClass2 = "far fa-thumbs-up fs-005 pr-1";
            $strClass3 = "NOEXIT";
        }

?>

									<li<?=($RS_Comment['isrt_user'] == $ck_login_member_pk) ? " class='liComment'" : ''; ?>>
										<div class="d-flex align-items-start position-r ">
											<div class="page-profile">
                                                <img src="<?=phpThumb("/_UPLOAD/".($RS_Comment['페이지프로필사진']?$RS_Comment['페이지프로필사진']:$RS_Comment['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle">
											</div>
											<div class="page-write col lh-3 pr-0">
<?
        if ($RS_Comment["isrt_user"] == $ck_login_member_pk) {
?>
												<!-- 작성글 삭제/수정 -->
												<div class="position-ab btn-right-top">
													<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit"></i></button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="watch_comment_modify.php?txtRecordNo=<?=$RS_Comment['wvc_id']?>" title="글 수정">글 수정</a>

														<input type="hidden" class="txtCommentID" value="<?=$RS_Comment['wvc_id']?>">
														<a class="dropdown-item" href="javascript:void()"><span class="lblCommentDel">글 삭제</span></a>
													</div>
												</div>
<?
        } else {
?>
														<input type="hidden" class="txtCommentID" value="<?=$RS_Comment['wvc_id']?>">
														<input type="hidden" class="lblCommentDel">
<?
        }
?>
                                                <!--// 작성글 삭제/수정 끝 -->
												<h5 class="fs-005 mb-0"><?=$RS_Comment["닉네임"]?></h5>
												<p class="post fs-005 fw-300 mb-2"><?=$strCommentTmp?>
												</p>
												<div class="d-flex lh-2">
													<div class="checkbox">
														<input type="hidden" id="txtChkComment<?=$RS_Comment["wvc_id"]?>" name="txtChkComment[]" class="txtChkComment" value="<?=$RS_Comment["wvc_id"]?>">

														<input id="chkComment<?=$RS_Comment["wvc_id"]?>" name="chkComment[]" type="checkbox" class="invisible <?=$strClass3?> chkComment" value="<?=$RS_Comment["wvc_id"]?>">

                                                        <label for="chkComment<?=$RS_Comment["wvc_id"]?>" class="<?=$strClass1?> btn btn-info2 btn-xs"><i class="<?=$strClass2?>"></i>좋아요 <span class="spnCommentGoodCnt"><?=$RS_Comment["good_cnt"]?><span></label>
													</div>
													<span class="px-1">·</span>
													<button type="button" class="btn-reply btn btn-info3 btn-xs">답글달기</button>
												</div>
												<!--답글입력창-->
												<div class="con-reply">
													<div class="d-flex mt-3">
                                                        <input type="hidden" name="txtParent" class="txtParent" value="<?=$RS_Comment["wvc_id"]?>">
														<textarea class="form-control txtReply" placeholder="답글 내용을 입력해주세요" rows="2"></textarea>
														<button type="button" class="btn btn-gray col-3 btnReplyOK">확인</button>
													</div>
												</div>
												<!--//답글입력창-->
											
												<!--답글-->

												<div class="list-reply">
													<ul class="ul_<?=$RS_Comment["wvc_id"]?>">
<?
        while ($RS_Reply = mysqli_fetch_array($oRs_Reply)) {
            $strReplyTmp = str_replace("\n", "<br>", $RS_Reply["comment"]);
            $strReplyTmp = str_replace(" ", "&nbsp;", $strReplyTmp);
?>
														<li class="li_<?=$RS_Comment["wvc_id"]?>">
															<div class="d-flex align-items-start position-r">
																<div class="page-profile">
                                                                    <img src="<?=phpThumb("/_UPLOAD/".($RS_Reply['페이지프로필사진']?$RS_Reply['페이지프로필사진']:$RS_Reply['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="30" height="30" class="rounded-circle">
																</div>
																<div class="col lh-3 pr-0">
																	<h5 class="fs-005 mb-1"><?=$RS_Reply["닉네임"]?></h5>
																	<p class="fs-005 fw-300"><?=$strReplyTmp?></p>
																</div>
															</div>
														</li>
<?
        }
?>
													</ul>
												</div>
												<!--//답글-->
											</div>
											<p class="date position-ab mb-0 fs--1"><?=$strDiff?></p>
										</div>
									</li>
<? 
        $i++;
    }
?>
								</ul>
							</div>
						</article>
						<!--//댓글-->
					    
						
				</div>
			</div>
		</div>
	</section>

	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_vod.php"; ?>

<script>
	$(document).ready(function(){
        $(document).on('click', '.btn-reply', function(event) {
			$(this).parent('div').next().toggleClass("active");
			console.log('text');
		});
		//더보기
		$('.btn-more').on("click",function(){

			$('.description').toggleClass('full');
			if($('.description').hasClass('full')){
        $(this).text('간략히');         
			} else {
					$(this).text('더보기');
			}
		});

        // 구독중 클릭시
        $(document).on('click', '#btnSubIng', function(event) {
            $.ajax({
                url: './watch_view_action.php',
                type: 'post',
                data: {
                    txtAction: "SUBING",
                    txtRecordNo: "<?=$strRecordNo?>",
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    if (Data == "SUCCESS") {
                        $('#divBtn').html("<button type='button' class='btn-add btn btn-info btn-sm btn-capsule' id='btnSub'>+ 구독</button>");
                        return;
                    } else {
                        alert(Data);

                    }
                } 

            });
        });

        // 구독 클릭시
        $(document).on('click', '#btnSub', function(event) {
            $.ajax({
                url: './watch_view_action.php',
                type: 'post',
                data: {
                    txtAction: "SUB",
                    txtRecordNo: "<?=$strRecordNo?>",
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);

                    if (Data == "SUCCESS") {
                        $('#divBtn').html("<button type='button' class='btn-add btn btn-info3 btn-sm btn-capsule' id='btnSubIng'><i class='fas fa-check fs--1 opacity-50'></i> 구독중</button>");
                    } else {
                        alert(Data);
                    }
                } 

            });
        });


        // 영상 좋아요 클릭시
        $(document).on('click', '#chkGood', function(event) {
            var nGood = parseInt($('#spnGoodCnt').text());
            var nMemberGood = parseInt($('#txtMemberGood').val());

            var strDtlAction = "";

            if (nMemberGood > 0) {
                strDtlAction = "EXIT";
            } else if (nMemberGood == 0) {
                strDtlAction = "NOEXIT";
            }

            $.ajax({
                url: './watch_view_action.php',
                type: 'post',
                data: {
                    txtAction: "GOOD",
                    txtActionDtl: strDtlAction,
                    txtRecordNo: "<?=$strRecordNo?>",
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    if (Data == "SUCCESS") {
                        if (nMemberGood > 0) {
                            $('#lblChkGood').removeClass('color-primary');
                            $('#lblChkGood').addClass('color-5');
                            $('#txtMemberGood').val(nMemberGood - 1)
                            $('#spnGoodCnt').text(nGood - 1);
                        } else if (nMemberGood == 0) {
                            $('#lblChkGood').removeClass('color-5');
                            $('#lblChkGood').addClass('color-primary');
                            $('#txtMemberGood').val(nMemberGood + 1)
                            $('#spnGoodCnt').text(nGood + 1);
                        }
                    } else {
                        alert(Data);
                    }
                } 

            });
        });

        // 댓글확인(등록) 클릭시
        $(document).on('click', '#btnCommentOK', function(event) {
            var strComment = $.trim($('#txtComment').val());

            if ($.trim($('#txtComment').val()) == "") {
                alert("댓글을 입력하세요");
                $('#txtComment').focus();
                return;
            }

            $.ajax({
                url: './watch_view_action.php',
                type: 'post',
                data: {
                    txtAction: "COMMENT",
                    txtRecordNo: "<?=$strRecordNo?>",
                    txtComment: strComment,
                },
                datatype: 'text',
                success: function(Data) {

                    Data = $.trim(Data);
                    arrData = Data.split("@");

                    if (arrData[0] == "SUCCESS") {
                        $('.ULC').prepend(arrData[1]);  // 해당 댓글을 처음에 삽입
						location.reload();
//						$('#txtComment').val('');
                    } else {
                        alert(arrData[0]);
                    }
                } 

            });
        });

        // 답글확인(등록) 클릭시
        $(document).on('click', '.btnReplyOK', function(event) {
            var idx = $('.btnReplyOK').index(this);
            var strReply = $.trim($('.txtReply').eq(idx).val());

            if (strReply == "") {
                alert("답글을 입력하세요.");
                $('.txtReply').eq(idx).focus();
                return;
            }

            $.ajax({
                url: './watch_view_action.php',
                type: 'post',
                data: {
                    txtAction: "REPLY",
                    txtRecordNo: "<?=$strRecordNo?>",
                    txtParent: $('.txtParent').eq(idx).val(),
                    txtReply: strReply,
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);

                    if (Data == "SUCCESS") {
                        strTmp = strReply.replace(/\n/g, '<br>');
                        strTmp = strTmp.replace(/ /g, '&nbsp;');

                        strUL = '.ul_'+$('.txtParent').eq(idx).val();

                        strHTML  = "<li>";
                        strHTML += "    <div class='d-flex align-items-start position-r'>";
                        strHTML += "        <div class='page-profile'>";
                        strHTML += "            <img src='<?=phpThumb("/_UPLOAD/".($rowMember['페이지프로필사진']?$rowMember['페이지프로필사진']:$rowMember['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>' width='30' height='30' class='rounded-circle'>";
                        strHTML += "        </div>";
                        strHTML += "        <div class='col lh-3 pr-0'>";
                        strHTML += "            <h5 class='fs-005 mb-1'><?=$rowMember["닉네임"]?></h5>";
                        strHTML += "            <p class='fs-005 fw-300'>"+strTmp+"</p>";
                        strHTML += "        </div>";
                        strHTML += "    </div>";
                        strHTML += "</li>";

                        $(strUL).prepend(strHTML);  // 해당 댓글의 답글 처음에 삽입
                        $('.txtReply').eq(idx).val('');
                        $('.con-reply').eq(idx).toggleClass("active");
                    } else {
                        alert(Data);
                    }
                } 

            });
        });


        // 댓글(좋아요) 클릭시
        $(document).on('click', '.chkComment', function(event) {
            var idx = $('.chkComment').index(this);
            var nCommentGood = parseInt($('.spnCommentGoodCnt').eq(idx).text());

            var strDtlAction = "";
            if ($(this).hasClass('EXIT')) {
                strDtlAction = "EXIT";
            } else if ($(this).hasClass('NOEXIT')) {
                strDtlAction = "NOEXIT";
            }


            $.ajax({
                url: './watch_view_action.php',
                type: 'post',
                data: {
                    txtAction: "COMMENTGOOD",
                    txtActionDtl: strDtlAction,
                    txtRecordNo: "<?=$strRecordNo?>",
                    txtComment: $('.txtChkComment').eq(idx).val(),
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    if (Data == "SUCCESS") {
                        if (strDtlAction == 'EXIT') {
                            $('.chkComment').eq(idx).removeClass('EXIT').addClass('NOEXIT');
                            $('.lblChkComment').eq(idx).removeClass('color-primary');
                            $('.lblChkComment').eq(idx).addClass('color-5');
                            $('.spnCommentGoodCnt').eq(idx).text(nCommentGood - 1);

                        } else if (strDtlAction == 'NOEXIT') {
                            $('.chkComment').eq(idx).removeClass('NOEXIT').addClass('EXIT');
                            $('.lblChkComment').eq(idx).removeClass('color-5');
                            $('.lblChkComment').eq(idx).addClass('color-primary');
                            $('.spnCommentGoodCnt').eq(idx).text(nCommentGood + 1);

                        }
                    } 
                } 

            });
        });


        // 댓글삭제 클릭시
        $(document).on('click', '.lblCommentDel', function(event) {
            var idx = $('.lblCommentDel').index(this);

            if (confirm("삭제하시겠습니까?")) {
                $.ajax({
                    url: './watch_view_action.php',
                    type: 'post',
                    data: {
                        txtAction: "DELETECOMMENT",
                        txtRecordNo: $('.txtCommentID').eq(idx).val(),
                    },
                    datatype: 'text',
                    success: function(Data) {
                        Data = $.trim(Data);
                        if (Data == "SUCCESS") {
							$('.liComment').eq(idx).remove();
                        } else {
                            alert(Data);
                        }
                    } 

                });
            }

        });


	});

    $('.nav_category li[data-name="gnb-watch"]').addClass('active');
	$('.nav_bottom li[data-name="lessonhome"]').addClass('active');



</script>
</body>
</html>

