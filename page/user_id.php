-<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<?php 
$NO_LOGIN = true;
include "./inc_program.php";
?>

<script>
	function go_sms_cert() {
		var hp_nation = $("#hp_nation option:selected").val();
		var hp = $("#hp").val();
		  if (hp_nation == "" || hp == "") {
			alert('<?=$dic[Caution_national]?>');
			return false;
		  }

		$.post("_ajax_sms_cert_send_find.php", {
			country_id: hp_nation,
			hp: hp,
			find_id: "Y"
          }).done(function(data) {
				if(data != "NOT_EXISTS"){
					alert('<?=$dic[Mobile_guide]?> : ' + hp_nation+hp);
				}else{
					alert('<?=$dic[No_mobile]?>');
				}
          });
//          start_timer();
        }
	function user_id_ok(){
		var queryString = $("#frm").serialize() ;

		$.ajax({
			type: 'post',
			url: "_ajax_user_id_action.php", 
			data: queryString,
			error: function(xhr, status, error){
			  alert(error);
			},
			success: function (data){
				if(data == "MANDATORY_ERROR"){
					alert('<?=$dic[All_info]?>');
				}else if(data == "CERT_ERROR"){
					alert('<?=$dic[No_matching_aut]?>');
				}else if(data == "NOT_EXISTS"){
					alert('<?=$dic[No_member_info]?>');
				}else if(data == "SUCCESS"){
					top.location.href = "user_id_ok.php";
				}else{
					alert('<?=$dic[Member_error]?>');
				}
			}
          });

	}
</script>

<body>
	<header class="header top_fixed">
		<a href="javascript:history.back();" title="back" class="link-back"><i class="biko-left-arrow-2"></i></a>
		<h2 class="header-title text-center"><?=$dic['ID_search_title']?></h2>
	</header>
	<section class="py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-4">
					<form name="frm" id="frm">
						<div class="form-group">
							<label for=""><?=$dic['Name']?></label>
							<input class="form-control" id="name" name="name" type="text" placeholder="<?=$dic['Name_write']?>" />
						</div>

						<div class="form-group">
							<label for="">이메일</label>
							<input class="form-control" id="email" name="email" type="text" placeholder="가입하신 이메일을 입력하세요." />
							<button class="btn-right mt-1 btn btn-info btn-xs" type="button" onClick="send_email_passwd_cert();">인증번호 발송</button>
						</div>
						
						<div class="form-group position-r">
							<label for=""><?=$dic['Authentication']?></label>
							<input class="form-control" id="cert_no" name="cert_no" type="number" placeholder="<?=$dic['Authentication_wirte']?>" />
							<!-- <span class="btn-right position-ab color-6 pr-1"><i class="fas fa-clock color-8 fs-005"></i> <span>03:00</span></span> -->
						</div>
						<div class="mt-5">
							<a href="javascript:user_id_ok();" class="btn-block btn btn-primary fs-005" title="ID_search"><?=$dic['Confirm']?></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!--완료-->
	<div class="remodal hidden" id="md-confirm">
		<div class="remodal-contents p-3">
			<p class="mt-2"><!--문자전송 alert:문자가 전송되었습니다--><?=$dic['Email_guide']?></p>
		</div>
		<div class="remodal-footer text-center">
			<button class="btn color-primary" onclick="hideModal()"><?=$dic['Confirm']?></button>
		</div>
	</div>
	<? // include "./inc_Bottom.php"; ?>
</body>

</html>
