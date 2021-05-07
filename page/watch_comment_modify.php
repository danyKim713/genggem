<?
include "./inc_program.php";

$strRecordNo = $_GET["txtRecordNo"];

$query  = " SELECT *   \n";
$query .= " FROM   tbl_watch_video_comment    \n";
$query .= " WHERE wvc_id ='{$strRecordNo}'";
$row = db_select($query);

?>

<!DOCTYPE HTML>
<html lang="en">

<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<body>

<? include "./inc_Top.php"; ?>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
				<article class="user-profile text-center mb-2">
					
					</article>
					<!--글쓰기-->
					<article>

							<div class="p-3">
								<div class="d-flex align-items-center">
									<img src="<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 0, 0, 0,"assets/images/user_img.jpg")?>" width="35" height="35" class="rounded-circle">
									<div class="ml-3 fw-600"><?=$rowMember['name']?></div>
								</div>
								<div class="my-2 border color-9">
									<textarea name="txtBigo" id="txtBigo" class="form-control" rows="5" placeholder="작성해주세요"><?=$row['comment']?></textarea>
								</div>
								<button id="btnModify" class="btn btn-primary btn-block fs-0 mt-3">수정</button>
							</div>

					</article>
					<!--//글쓰기-->
					
					
				</div>
			</div>
		</div>
	</section>



	<? include "./inc_Bottom.php"; ?>
</body>
<style type="text/css">
	#imageupload { width: 0; height: 0;}

	.thumbimage {
		float:left;
		width:33%;
		position:relative;
		padding:5px;
		height: 110px;
	}

</style>
<script>
	$(document).ready(function(){
        // 댓글삭제 클릭시
        $(document).on('click', '#btnModify', function(event) {
            if ($.trim($('#txtBigo').val()) == "") {
                alert("댓글을 입력하세요");
                $('#txtBigo').focus();
                return;
            }

            if (confirm("수정하시겠습니까?")) {
                $.ajax({
                    url: './watch_comment_modify_action.php',
                    type: 'post',
                    data: {
                        txtRecordNo: <?=$strRecordNo?>,
                        txtBigo: $('#txtBigo').val(),
                    },
                    datatype: 'text',
                    success: function(Data) {
                        Data = $.trim(Data);

                        if (Data == "SUCCESS") {
                            $(location).attr('href', './watch_view.php?txtRecordNo=<?=$row["wv_id"]?>');
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