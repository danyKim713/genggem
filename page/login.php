<!DOCTYPE HTML>
<html lang="en">
<?php 
$NO_LOGIN = true;
include "./inc_program.php";?>
<?
if($_COOKIE['ck_login_member_pk']){
	header("Location: main.php");
	exit;
}

?>
<? include "./inc_Head.php"; ?>
<?
$rnd_ap = strtoupper(randomAlphabet(5));
$_SESSION['ss_verify'] = $rnd_ap;
?>

<script>
	$(function(){
		get_fcm_token();
	});

	function get_fcm_token(){
<? if( $detect->isAndroidOS() ) {?>
		window.AndroidApp.get_fcm_token();
<?}else if( $detect->isiOS() ){?>
		window.webkit.messageHandlers.get_fcm_token.postMessage(null);
<?}?>
	}

	function set_fcm_token(val){
		$("#app_id").val(val);
	}	
</script>

<script>
	$(document).ready(function() {
		$("#email").focus();

		// 아이디입력창에 Enter Key 입력시
		$("#email").keydown(function(event) {
			if (event.which == 13) {
				goLogin();
			}
		});

		// 비밀번호입력창에 Ener Key 입력시
		$("#passwd").keydown(function(event) {
			if (event.which == 13) {
				goLogin();
			}
		});

		// 로그인버튼 클릭시
		$('#btnLogin').bind('click', function(event) {
			goLogin();
		});
	})

	function goLogin() {

		if (!$.trim($("#이메일").val())) {
			alert("<?=$dic[Login_ID]?>");
			$("#이메일").focus();
			return;
		}

		if (!$.trim($("#비밀번호").val())) {
			alert("<?=$dic[Login_pw]?>");
			$("#비밀번호").focus();
			return;
		}
		if (!$.trim($("#verify").val())) {
			alert("<?=$dic[Login_pw2]?>");
			$("#verify").focus();
			return;
		}

		var params = $("#frmLogin").serialize();
		$.ajax({
			url: "_ajax_login_action.php",
			data: params,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			dataType: "html",
			success: function(data){
				if(data == "NO_CODE"){
					alert('<?=$dic[code_is_not_identical]?>');
				}else if(data == "MANDATORY_ERROR"){
					alert('<?=$dic['mandatory_data_required']?>');
				}else if(data == "NO_LOGIN"){
					alert('<?=$dic[No_login_guide]?>');
				}else if(data == "NO_MATCH"){
					alert('<?=$dic['login_not_identical']?>');
				}else if(data == "NO_ID"){
					alert('<?=$dic['id_not_exists']?>');
				}else if(data == "SUCCESS"){
<? if($next_url){?>
					top.location.href = "<?=$next_url?>";
<?}else{?>
					top.location.href = "main.php";
<?}?>
				}
			}
		});
	}
</script>

<body>
	<div class="cart-area clearfix">
        <div class="container">

            <div class="row align-items-center justify-content-center">
                <!-- Cart Totals -->

                <div class="col-12 col-lg-6 mt-5">
                    <div class="cart-totals-area mt-5">
						<div class="con-language clearfix">
						<img src="./assets/img/core-img/logo_b.png" width="140" alt="젠껨">
							<select class="form-control float-right" onChange="go_change_language_dic(this);">
								<option value="" selected>Language</option>
								<option value="ko" <?=$_COOKIE['dic_lang']=="ko"?"selected":""?>>한국어</option>
								<option value="en" <?=$_COOKIE['dic_lang']=="en"?"selected":""?>>English</option>
								<option value="cn" <?=$_COOKIE['dic_lang']=="cn"?"selected":""?>>中文简体</option>
							</select>
						</div>
                        <h5 class="title-- mt-4">Log-in<br></h5>

                        <form class="wrap-login" name="frmLogin" id="frmLogin" method="post">                        
						
						<input type="hidden" name="app_id" id="app_id" />
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="이메일" class="color-3 fw-400 mb-2"><?=$dic['ID_email']?></label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="hidden" name="txtAction" id="txtAction" value="">
								<input type="email" name="이메일" id="이메일" maxlength="100" class="form-control" placeholder="<?=$dic['Login_ID']?>" />
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="비밀번호" class="color-3 fw-400 mb-2"><?=$dic['Password']?></label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="password" name="비밀번호" id="비밀번호" maxlength="20" class="form-control" placeholder="<?=$dic['Login_pw']?>" />
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="verify" class="color-3 fw-400 mb-2"><?=$dic['Login_pwt']?></label></h5>
							<div class="shipping-address" style="width:70%;">							
								<input class="form-control" name="verify" id="verify" type="text" placeholder="<?=$dic['Login_pw2']?>">
								<p class="p-txt color-white"><?=$rnd_ap?></p>
							</div>
						</div>

						<div class="mt-4 mb-5 text-center">
							<button type="button" id="btnLogin" class="btn alazea-btn w-100 mb-3"><?=$dic['Login']?></button>
							<a href="user_id.php" title="<?=$dic['Login_fogot_ID']?>" class="link-gray"><?=$dic['Login_fogot_ID']?></a>
							<span class="bar"></span>
							<a href="user_pw.php" title="<?=$dic['Login_pwr']?>" class="link-gray"><?=$dic['Login_pwr']?></a>
							<span class="bar"></span>
							<a href="join.php" title="<?=$dic['Login_join']?>" class="link-gray"><?=$dic['Login_join']?></a>
						</div>

						</form>						

                    </div>
                </div>
            </div>

        </div>
    </div>


	<? if(false){// in_array($REMOTE_ADDR,  $dev_ips)){?>
 	<iframe name="_fra" width="500" height="500" align="right" frameborder="0"  scrolling="auto"></iframe>
<? }else{?>
	<iframe name="_fra" width="0" height="0" align="right" frameborder="0"  scrolling="auto" ></iframe>
<? }?>
	<form name="frmTmp" id="frmTmp" method="post" action="/"></form>
</body>

</html>
