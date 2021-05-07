<!DOCTYPE HTML>
<html lang="en">
<?php 
$NO_LOGIN = true;
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>

<script>
	function security_passwd_reset(){

		var security_passwd = $("#security_passwd").val();
		var security_passwd2 = $("#security_passwd2").val();

        if (!isNumber(security_passwd) || security_passwd.length != 6) {
          alert("안전거래 비밀번호는 6자리의 숫자를 입력해주시기 바랍니다.");
          return false;
        }

		if(security_passwd != security_passwd2){
			alert('안전거래 비밀번호 확인이 일치하지 않습니다.');
			return false;
		}


		var queryString = $("#frm").serialize() ;

          $.ajax({
			type: 'post',
			url: "_ajax_user_security_pw_reset_action.php", 
			data: queryString,
			error: function(xhr, status, error){
			  alert(error);
			},
			success: function (data){
				if(data == "MANDATORY_ERROR"){
					alert('필수 입력항목을 입력해주십시오.');
				}else if(data == "PASSWD_NOT_SAME"){
					alert('안전거래 비밀번호 확인이 일치하지 않습니다.');
				}else if(data == "SUCCESS"){
					alert('안전거래 비밀번호가 재설정되었습니다.');
					top.location.href = "/";
				}else if(data == "FAIL"){
					alert('오류가 발생했습니다.');
				}

			}
          });
	}
</script>


	<body>
<textarea id="aa"></textarea>
		<header class="header top_fixed">
			<h2 class="header-title text-center"><?=$dic['Spassoword_reset']?></h2>
		</header>
		<section class="py-0">
			<div class="container-fluid header-top">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-4 p-4">
						<form name="frm" id="frm">
                            <input type="hidden" name="email1" id="email1" value="<?=$txtEmail?>">
							<div class="form-group form-vertical">
								<label for=""><?=$dic['New_spassowrd']?></label>
								<input type="password" name="security_passwd" id="security_passwd" class="form-control" placeholder="<?=$dic['New_spassword_write']?>">
								<input type="password" name="security_passwd2" id="security_passwd2" class="form-control" placeholder="<?=$dic['New_spassword_re']?>">
								<p class="color-info fs--1 mt-2 mb-0">6자리 숫자로만 입력</p>
							</div>
							<div class="mt-5">
								<button type="button" class="btn-block btn btn-secondary fs-005" onClick="security_passwd_reset();"><?=$dic['Spassoword_reset']?></button>
							</div>
						</form>

						<!--일치하는 비밀번호가 없을때-->
						<!-- <div class="text-center">
							<h3 class="fs-005 fw-300 lh-5"><strong>입력한 이메일 주소 노출</strong><br><?=$dic['No_matching_input']?></h3>
						</div>
						<div class="mt-5">
							<a href="user_pw.php" class="btn-block btn btn-secondary fs-005"><?=$dic['Login_pwr']?></a>
							<a href="join.php" class="btn-block btn btn-outline-secondary fs-005"><?=$dic['Login_join']?></a>
						</div> -->
						<!--일치하는 비밀번호가 없을때-->

					</div>
				</div>
			</div>
		</section>
		<? //include "./inc_Bottom.php"; ?>
	</body>
	

</html>