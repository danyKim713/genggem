<!DOCTYPE HTML>
<html lang="en">
<?php 
extract($_GET);
if($go == "/saadmin/cloud_pay.php"){
	$NO_LOGIN = "Y";
}

include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<script>
	function go_exchange_login(){
		var username = $("#username").val();
		var password = $("#password").val();
		var otp = $("#otp").val();
		if(username == "" || password == ""){
			alert('<?=$dic['Please_enter_id_password']?>');
			return;
		}
		$.post("_ajax_exchange_login.php",{username: username, password: password, otp: otp},function(result){
			
			debug(result);

			if($.trim(result) != "FAIL"){
				top.location.href = "<?=$go?$go:"wallet.php"?>";
			}else{
				alert('<?=$dic['ID_password_does_not_match']?>');
			}
		});
	}
</script>

<body>
	<header class="header top_fixed">
		<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
		<h2 class="header-title text-center"><?=$dic['Service_exchange_login']?></h2>
	</header>
	<section class="py-0">
		<div class="container-fluid header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-3 pt-xs-3 p-4 mt-xl-6">
					<div class="position-r">
						<h3 class="mt-xs-3 my-4 fs-1 lh-3 fw-300 color-primary">
							<?=$dic['Service_bitkoex']?><br><strong class="fw-600"><?=$dic['Service_exchange_login']?></strong>
						</h3>
						<div class="position-ab btn-right-bottom">
							<img src="assets/images/logos/bitkoex_logo2.png" alt="bitkoex logo" width="60" />
						</div>
					</div>
					<form name="frm" id="frm" method="post">
						<div class="form-group">
							<label for="username" class="color-5 fw-400 mb-1"><?=$dic['Service_exchange_id']?></label>
							<input type="text" name="username" id="username" maxlength="100" class="form-control pl-2" value="<?=strpos($go,"bkp_send.php")!==false?$rowMember['bitkoex_email']:""?>" placeholder="<?=$dic['Service_exchange_id_write']?>"  <?=strpos($go,"bkp_send.php")!==false?"readonly":""?>/>
						</div>
						<div class="form-group">
							<label for="password" class="color-5 fw-400 mb-1"><?=$dic['Service_exchange_pw']?></label>
							<input type="password" name="password" id="password" maxlength="20" class="form-control pl-2" placeholder="<?=$dic['Service_exchange_pw_write']?>" />
						</div>
						<div class="form-group">
							<label for="otp" class="color-5 fw-400 mb-1"><?=$dic['Service_otp']?></label>
							<input class="form-control pl-2" type="number" placeholder="<?=$dic['Service_otp2']?>" name="otp" id="otp">
						</div>
						<div class="mt-4 mb-3 text-center">
							<a href="javascript:go_exchange_login();" id="btnLogin" class="btn-block btn btn-primary fs-005"><?=$dic['Service_exchange_login']?></a>
							<a href="https://bitkoex.com/register" target="_blank" class="btn-block btn btn-outline-secondary fs-005"><?=$dic['Service_exchange_join']?></a>
							
						</div>
						<p class="fs--1 color-7 mt-3"><?=$dic['Service_exchange_guide']?><br /><br /><?=$dic['Service_exchange_guide2']?></p>
					</form>
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
	<form name="frmTmp" id="frmTmp" method="post" action="/"></form>
</body>

</html>
