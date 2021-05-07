<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<?php 
$NO_LOGIN = true;
include "./inc_program.php";
?>

<script>
	function send_email_passwd_cert(){
		var name = $("#name").val();
		var email = $("#email").val();
		if(name == "" || email == ""){
			alert('이름과 아이디는 필수입력정보입니다.');
			return false;
		}

		$.post("_ajax_email_cert_send.php", {
			find_passwd: "Y",
			email: email,
			name: name
		}).done(function(data) {
			if(data != "NO_MEMBER"){
				alert('다음 이메일로  인증번호를 발송하였습니다.: ' + email);
			}else{
				alert('존재하지 않는 이름/이메일 정보입니다.');
			}
		});
	}
	function user_pw_ok(){
		var queryString = $("#frm_passwd").serialize() ;

		$.ajax({
			type: 'post',
			url: "_ajax_user_pw_find_action.php", 
			data: queryString,
			error: function(xhr, status, error){
			  alert(error);
			},
			success: function (data){
				if(data == "MANDATORY_ERROR"){
					alert('모든 정보를 입력하셔야 합니다.');
				}else if(data == "CERT_ERROR"){
					alert('인증번호가 일치하지 않습니다..');
				}else if(data == "NOT_EXISTS"){
					alert('존재하지 않는 회원정보입니다.');
				}else if(data == "SUCCESS"){
					top.location.href = "user_pw_ok.php";
				}else{
					alert('오류가 발생했습니다.');
				}
			}
          });		
	}
	function send_email_spw_cert(){

		var name1 = $("#name1").val();
		var email1 = $("#email1").val();
		var passwd1 = $("#passwd1").val();
		if(name1 == "" || email1 == "" || passwd1 == ""){
			alert('이름과 아이디, 비밀번호는 필수입력정보입니다.');
			return false;
		}

		$.post("_ajax_email_cert_send.php", {
			find_security_passwd: "Y",
			email: email1,
			name: name1,
			passwd: passwd1
		}).done(function(data) {
			if(data != "NO_MEMBER"){
				alert('다음 이메일로  인증번호를 발송하였습니다.: ' + email1);
			}else{
				alert('존재하지 않는 이름/이메일/비밀번호 정보입니다.');
			}
		});

	}
	function user_spw_ok(){
		var queryString = $("#frm_security").serialize() ;

		$.ajax({
			type: 'post',
			url: "_ajax_user_pw_reset_action.php", 
			data: queryString,
			error: function(xhr, status, error){
			  alert(error);
			},
			success: function (data){
				if(data == "MANDATORY_ERROR"){
					alert('모든 정보를 입력하셔야 합니다.');
				}else if(data == "CERT_ERROR"){
					alert('인증번호가 일치하지 않습니다..');
				}else if(data == "NOT_EXISTS"){
					alert('존재하지 않는 회원정보입니다.');
				}else if(data == "SUCCESS"){
					top.location.href = "user_pw_ok.php?txtEmail="+$('#email1').val();
				}else{
					alert('오류가 발생했습니다.');
				}
			}
          });	
	}
</script>

<body>
	<header class="header top_fixed">
		<a href="javascript:history.back();" title="back" class="link-back"><span class="icon ic-left-arrow"></span></a>
		<h2 class="header-title text-center"><?=$dic['Login_pwr']?></h2>
	</header>
	<section class="py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-4 pb-6">
					<form name="frm_passwd" id="frm_passwd">
					  <h3 class="fs-1 fw-100 color-primary mb-4"><?=$dic['Login_pwr2']?></h3>
						<div class="form-group">
							<label for=""><?=$dic['Name']?></label>
							<input class="form-control" id="name" name="name" type="text" placeholder="<?=$dic['Name_write']?>" />
						</div>
						<div class="form-group">
							<label for=""><?=$dic['ID_email']?></label>
							<input class="form-control" id="email" name="email" type="email" placeholder="<?=$dic['Login_ID']?>" />
						</div>

						<div class="form-group position-r">
							<label for=""><?=$dic['Authentication']?></label>
							<input class="form-control" id="cert_no" name="cert_no" type="number" placeholder="<?=$dic['Authentication_wirte_email']?>" />
							<button class="btn-right position-ab btn btn-info btn-xs" type="button" onClick="send_email_passwd_cert();">인증번호 발송</button>	
							<!--타이머는 보이지 않다가 인증번호 발송후 생깁니다-->
							<!-- <span class="btn-right position-ab color-6 pr-1"><i class="fas fa-clock color-8 fs-005"></i> <span>03:00</span></span> -->
						</div>
						<div class="mt-3">
							<a href="javascript:user_pw_ok();" class="btn-block btn btn-primary fs-005" title="<?=$dic['Confirm']?>"><?=$dic['Confirm']?></a>
						</div>
					</form>

					<!-- 안전거래 비번 찾기 

					<hr class="my-5 color-10" />
					<form name="frm_security" id="frm_security">
					  <h3 class="fs-1 fw-100 color-primary mb-4"><?=$dic['Security_title']?></h3>
						<div class="form-group">
							<label for=""><?=$dic['Name']?></label>
							<input class="form-control" id="name1" name="name1" type="text" placeholder="<?=$dic['Name_write']?>" />
						</div>
						<div class="form-group">
							<label for=""><?=$dic['ID_email']?></label>
							<input class="form-control" id="email1" name="email1" type="text" placeholder="<?=$dic['Login_ID']?>" />
						</div>
						<div class="form-group">
							<label for=""><?=$dic['Password']?></label>
							<input class="form-control" id="passwd1" name="passwd1" type="password" placeholder="<?=$dic['Login_pw']?>" />
						</div>

						<div class="form-group position-r">
							<label for=""><?=$dic['Authentication']?></label>
							<input class="form-control" id="cert_no1" name="cert_no1" type="number" placeholder="<?=$dic['Authentication_wirte_email']?>"/> 
							<button class="btn-right position-ab btn btn-outline-secondary btn-xs" type="button" onClick="send_email_spw_cert();">인증번호 발송</button>	
							<!--타이머는 보이지 않다가 인증번호 발송후 생깁니다-->
							<!-- <span class="btn-right position-ab color-6 pr-1"><i class="fas fa-clock color-8 fs-005"></i> <span>03:00</span></span>
						</div>
						<div class="mt-3">
							<a href="javascript:user_spw_ok();" class="btn-block btn btn-primary fs-005" title="<?=$dic['Confirm']?>"><?=$dic['Confirm']?></a>
						</div> -->
					</form>
					
				</div>
			</div>
		</div>
	</section>
	<!--완료-->
	<div class="remodal hidden" id="md-confirm">
		<div class="remodal-contents p-3">
			<p class="mt-2"><?=$dic['ID_search_title']?>메일이 발송되었습니다.</p>
		</div>
		<div class="remodal-footer text-center">
			<button class="btn color-primary" onclick="hideModal()"><?=$dic['ID_search_title']?>확인</button>
		</div>
	</div>
	<? // include "./inc_Bottom.php"; ?>
</body>

</html>
