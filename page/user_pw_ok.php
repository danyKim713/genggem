<!DOCTYPE HTML>
<html lang="en">
<?php 
$NO_LOGIN = true;
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>

<script>
	function passwd_reset(){

		if (check_password(frm.passwd, frm.passwd2, frm.email) === false) {
          return false;
        }


		var queryString = $("#frm").serialize() ;

          $.ajax({
			type: 'post',
			url: "_ajax_user_pw_reset_action.php", 
			data: queryString,
			error: function(xhr, status, error){
			  alert(error);
			},
			success: function (data){
				if(data == "MANDATORY_ERROR"){
					alert('필수 입력항목을 입력해주십시오.');
				}else if(data == "PASSWD_NOT_SAME"){
					alert('비밀번호가 일치하지 않습니다.');
				}else if(data == "SUCCESS"){
					alert('비밀번호가 재설정되었습니다.');
					top.location.href = "login.php";
				}else if(data == "FAIL"){
					alert('오류가 발생했습니다.');
				}
			}
          });
	}

	function check_password(input_pw1, input_pw2, input_id) {

      var pw1 = input_pw1.value;
      var match_c = 0;
      if (pw1.match(/([a-z])/)) match_c++;
      if (pw1.match(/([A-Z])/)) match_c++;
      if (pw1.match(/([0-9])/)) match_c++;
      if (pw1.match(/[^a-zA-Z0-9]/)) match_c++;

      if (match_c < 2) {
        alert('비밀번호는 영문 대소문자/숫자/특수문자를 2종류 이상 혼용하여\n10~16자 또는 3종류 이상 혼용하여 8~16자로 설정하셔야 합니다.');
        input_pw1.focus();
        return false;
      }
      if (match_c == 2 && (pw1.length < 10 || pw1.length > 16)) {
        alert('비밀번호는 영문 대소문자/숫자/특수문자를 2종류 이상 혼용하여\n10~16자 또는 3종류 이상 혼용하여 8~16자로 설정하셔야 합니다.');
        input_pw1.focus();
        return false;
      }

      if (match_c >= 3 && (pw1.length < 8 || pw1.length > 16)) {
        alert('비밀번호는 영문 대소문자/숫자/특수문자를 2종류 이상 혼용하여\n10~16자 또는 3종류 이상 혼용하여 8~16자로 설정하셔야 합니다.');
        input_pw1.focus();
        return false;
      }

      if (pw1.match(/([\\"'\s])/)) {
        alert('비밀번호에 \\(역슬래쉬), \'(작은따옴표), "(큰따옴표), 공백은 입력 하실 수 없습니다.');
        input_pw1.focus();
        return false;
      }

      if (typeof(input_id) != "undefined") {
        var id = input_id.value;
        for (var i = 0; i < id.length - 4; i++) {
          if (pw1.indexOf(id.substr(i, 4)) > -1) {
            alert('비밀번호는 아이디와 동일하게 사용하실 수 없습니다.');
            input_pw1.focus();
            return false;
          }
        }

        if (pw1.indexOf(id) > -1) {
          alert('비밀번호는 아이디와 동일하게 사용하실 수 없습니다.');
          input_pw1.focus();
          return false;
        }
      }

      var SamePass_0 = 0; //동일문자 카운트
      var SamePass_1 = 0; //연속성(+) 카운드
      var SamePass_2 = 0; //연속성(-) 카운드

      var chr_pass_0;
      var chr_pass_1;

      for (var i = 0; i < pw1.length; i++) {
        chr_pass_0 = pw1.charAt(i);
        chr_pass_1 = pw1.charAt(i + 1);

        //동일문자 카운트
        if (chr_pass_0 == chr_pass_1) {
          SamePass_0 = SamePass_0 + 1
          if (SamePass_0 > 2) {
            alert('동일한 문자, 숫자를 반복해서 입력하실 수 없습니다.');
            input_pw1.focus();
            return false;
          }
        } else {
          SamePass_0 = 0;
        }

        //연속성(+) 카운드
        if (chr_pass_0.charCodeAt(0) - chr_pass_1.charCodeAt(0) == 1) {
          SamePass_1 = SamePass_1 + 1
        } else {
          SamePass_1 = 0;
        }

        //연속성(-) 카운드
        if (chr_pass_0.charCodeAt(0) - chr_pass_1.charCodeAt(0) == -1) {
          SamePass_2 = SamePass_2 + 1
        } else {
          SamePass_2 = 0;
        }

        if (SamePass_1 > 2 || SamePass_2 > 2) {
          alert('연속적인 문자나 숫자를 입력하실 수 없습니다.');
          input_pw1.focus();
          return false;
        }
      }
      if (typeof(input_pw2) != "undefined") {
        var pw2 = input_pw2.value;

        if (pw2.length < 1) {
          alert('비밀번호 확인 항목을 입력해 주세요.');
          input_pw2.focus();
          return false;
        }
        if (pw1 != pw2) {
          alert('비밀번호가 서로 일치하지 않습니다.');
          input_pw2.focus();
          return false;
        }
      }

      return true;
    }

    function check_pwd_length(v) {
      if (v.value.length > 16) {
        v.value = v.value.substr(0, 16);

        alert('비밀번호를 16자 이하로 입력하세요.');
        v.focus();
        return false;
      }

      return;
    }

    function checkEmail(email) {
      var check1 = /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/;

      var check2 = /^[a-zA-Z0-9\-\.\_]+\@[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4})$/;

      if (!check1.test(email) && check2.test(email)) {
        return true; // 올바른 이메일   
      } else {
        return false; // 잘못된 이메일   
      }
    }
</script>

	<body>
		<header class="header top_fixed">
			<a href="javascript:history.back();" title="back" class="link-back"><span class="icon ic-left-arrow"></span></a>
			<h2 class="header-title text-center"><?=$dic['Login_pwr']?></h2>
		</header>
		<section class="py-0">
			<div class="container-fluid header-top">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-4 p-4">
						<form name="frm" id="frm">
							<input type="hidden" name="email" id="email" value="<?=$_SESSION['_reset_email']?>"/>
							<div class="form-group form-vertical">
								<label for=""><?=$dic['New_password']?></label>
								<input type="password" name="passwd" id="passwd" class="form-control mb-2" placeholder="<?=$dic['New_password_write']?>">
								<input type="password" name="passwd2" id="passwd2" class="form-control" placeholder="<?=$dic['New_passwrod_re']?>">
								<p class="color-info fs--1 mt-2 mb-0"><?=$dic['Password_guide']?></p>
							</div>
							<div class="mt-5">
								<button type="button" class="btn-block btn btn-secondary fs-005" onClick="passwd_reset();"><?=$dic['Password_reset']?></button>
							</div>
						</form>

						<!--일치하는 비밀번호가 없을때-->					
						<!-- <div class="text-center">
							<h3 class="fs-005 fw-300 lh-5"><strong>입력한 이메일 노출</strong><br><?=$dic['No_matching_input']?></h3>
						</div>
						<div class="mt-5">
							<a href="user_id.php" class="btn-block btn btn-secondary fs-005"><?=$dic['Login_pwr']?></a>
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