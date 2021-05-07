<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<? $_SESSION['S_CID'] = $CID; ?>

<script>
	$(function(){
		$(window).scroll(function(){
			var scrollHeight = $(window).scrollTop() + $(window).height();
			var documentHeight = $(document).height();

			if(scrollHeight + 50 > documentHeight){
				go_list_bbs_list();
			}
		});



        $(document).on('click', '.btnBBS', function(event) {

            var idx = $('.btnBBS').index(this);
            var arrID = $('.btnBBS').eq(idx).attr("id").split("_");

            $.ajax({
                type: 'POST',
                url: "_ajax_bbs_list_delete.php",
                data: {
                    txtRecordNo: arrID[1],
                },
                async: false,
                success: function(data){
                    data = $.trim(data);
                    //console.log(data);
                    if (data == "SUCCESS") {
                        $("#divBBS_"+arrID[1]).remove();
                        alert("삭제되었습니다");
                    } else {
                        alert("삭제가 실패했습니다. 관리자에게 문의하세요.");
                    }

                }
            });

         });
	});

	var pageNo = 1;

	$(function(){
		go_list_bbs_list();
	});

	function go_list_bbs_list(){
		$.ajax({
			type: 'POST',
			url: "_ajax_bbs_list_list.php",
			data: {
				pageNo: pageNo
			},
			async: false,
			success: function(data){
				//console.log(data);
				$("#bbs-list").append(data);
				pageNo++;
			}
		});
	}		


</script>

<script type="text/javascript">
function popct(url, w, h) {
popw = (screen.width - w) / 2;
poph = (screen.height - h) / 2;
popft = 'height=' + h + ',width=' + w + ',top=' + poph + ',left=' + popw;
window.open(url, '', popft);
}
</script>

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg8.jpg);">
            <h2>CAFE <font size="5px">in</font>...<br>
			<font size="4px" color="">Open Community</font></h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

	<section id="m_nav2">
			<? 
			$nowMenu  = "게시판";
			include "inc_tab_menu_channel.php"; 
			?>
	</section>

	<!-- ##### Blog Content Area Start ##### -->
    <section class="blog-content-area">
        <div class="container">
			<!-- Post Details Area -->
			<div class="mt-3 mb-4">
				<div class="post-content text-center">
					<h4 class="post-title"><?if($rowMember['member_id'] == $rowChannel['member_id']){?>
					<i class="fas fa-crown color-warning mr-1"></i>
					<?}?><?=$rowChannel['채널이름']?></h4>
					<h5>[게시판]</h5>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-10 col-xl-10 px-0">

					<!--글작성-->
					<article class="mb-4">
						<div class="px-3 py-2 d-flex align-items-center position-r" style="border:2px solid #eeeeee;">
							<img src="<?=phpThumb("/_UPLOAD/".($rowMember['페이지프로필사진']?$rowMember['페이지프로필사진']:$rowMember['페이지배경사진']),50,50,"2","assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
							<a href="cafe_board_wirte.php?CID=<?=$_GET['CID']?>" onClick="popct(this.href, '500', '700');return false" title="글쓰기" class="position-ab btn btn-dark btn-xs btn-right-top" style="margin:21px 18px 0"><i class="fas fa-edit"></i> 글쓰기</a>
							<div class="w-100 ml-2 py-1" style="background: #eeeeee; height:30px;">
								<a href="cafe_board_wirte.php?CID=<?=$_GET['CID']?>" onClick="popct(this.href, '500', '700');return false" class="p-2 color-8 fs-005">안녕하세요, 게시글을 작성해주세요</a>
							</div>
						</div>
					</article>
					<!--//-->

					<!--글목록-->

					<div id="bbs-list" class="mb-5">
					</div>

					<!--//게시글-->
				
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_cafe.php"; ?>
</body>

<script>
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>