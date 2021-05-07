<!DOCTYPE HTML>
<html lang="en">
<? 
$NO_LOGIN = "Y";
include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<script>
	function go_join_ok(){
		var name = $("#name").val();
		var passwd = $("#passwd").val();
		var passwd2 = $("#passwd2").val();
		var security_passwd = $("#security_passwd").val();
		var security_passwd2 = $("#security_passwd2").val();


		if (input_omit_check()) {

		if (name == "" ) {
			alert('<?=$dic[Name_write]?>');
			return false;
		}

		if (passwd == "" || passwd2 == "") {
			alert('<?=$dic[Password_write]?>');
			return false;
		}

		if (security_passwd == "" || security_passwd2 == "") {
			alert('<?=$dic[S_password_write]?>');
			return false;
		}

		if (passwd != passwd2 ) {
			alert('<?=$dic[Password_nomatch]?>');
			return false;
		}

		if (security_passwd != security_passwd2 ) {
			alert('<?=$dic[S_password_nomatch]?>');
			return false;
		}

        if (check_password(frm.passwd, frm.passwd2, frm.email) === false) {
          return false;
        }


        if (!isNumber(security_passwd) || security_passwd.length != 6) {
          alert("<?=$dic[Spasswrod_guide]?>");
          return false;
        }


		var queryString = $("#frm").serialize() ;

          $.ajax({
			type: 'post',
			url: "_ajax_join4_action.php", 
			data: queryString,
			error: function(xhr, status, error){
			  alert(error);
			},
			success: function (data){
				if(data == "MANDATORY_ERROR"){
					alert('<?=$dic[Member_must]?>');
				}else if(data == "PASSWD_NOT_SAME"){
					alert('<?=$dic[Password_nomatch]?>');
				}else if(data == "SECURITY_PASSWD_NOT_SAME"){
					alert('<?=$dic[S_password_nomatch]?>');
				}else if(data == "HP_DUP_ERROR"){
					alert('<?=$dic[Already_mobile]?>');
				}else if(data == "EMAIL_DUP_ERROR"){
					alert('<?=$dic[Already_member]?>');
				}else if(data == "NO_RECOMMENDER"){
					alert('<?=$dic[No_uid]?>');
				}else if(data == "NO_AGENCY_UID"){
					alert('<?=$dic[No_agency_UID]?>');
				}else if(data == "SUCCESS"){
					top.location.href = "join_ok.php";
				}else if(data == "FAIL"){
					alert('<?=$dic[Member_error]?>');
				}
			}
          });

		}
	}


	function check_password(input_pw1, input_pw2, input_id) {

      var pw1 = input_pw1.value;
      var match_c = 0;
      if (pw1.match(/([a-z])/)) match_c++;
      if (pw1.match(/([A-Z])/)) match_c++;
      if (pw1.match(/([0-9])/)) match_c++;
      if (pw1.match(/[^a-zA-Z0-9]/)) match_c++;

      if (match_c < 2) {
        alert('<?=$dic[Password_guide]?>');
        input_pw1.focus();
        return false;
      }
      if (match_c == 2 && (pw1.length < 10 || pw1.length > 16)) {
        alert('<?=$dic[Password_guide]?>');
        input_pw1.focus();
        return false;
      }

      if (match_c >= 3 && (pw1.length < 8 || pw1.length > 16)) {
        alert('<?=$dic[Password_guide]?>');
        input_pw1.focus();
        return false;
      }

      if (pw1.match(/([\\"'\s])/)) {
        alert('<?=$dic[Password_not_space]?>');
        input_pw1.focus();
        return false;
      }

      if (typeof(input_id) != "undefined") {
        var id = input_id.value;
        for (var i = 0; i < id.length - 4; i++) {
          if (pw1.indexOf(id.substr(i, 4)) > -1) {
            alert('<?=$dic[Same_as_ID]?>');
            input_pw1.focus();
            return false;
          }
        }

        if (pw1.indexOf(id) > -1) {
          alert('<?=$dic[Same_as_ID]?>');
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
            alert('<?=$dic[Same_as_allowed]?>');
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
          alert('<?=$dic[Same_as_allowed]?>');
          input_pw1.focus();
          return false;
        }
      }
      if (typeof(input_pw2) != "undefined") {
        var pw2 = input_pw2.value;

        if (pw2.length < 1) {
          alert('<?=$dic[Password_write]?>');
          input_pw2.focus();
          return false;
        }
        if (pw1 != pw2) {
          alert('<?=$dic[Password_nomatch]?>');
          input_pw2.focus();
          return false;
        }
      }

      return true;
    }

    function check_pwd_length(v) {
      if (v.value.length > 16) {
        v.value = v.value.substr(0, 16);

        alert('<?=$dic[Password_16under]?>');
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
		<section class="wrap-join py-0">
			<div class="container-fluid">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-3 pt-xs-3 p-4 mt-xl-6">
						<div class="position-r">
							<h3 class="mt-xs-3 my-4 fs-1 lh-3 fw-100">GOLFEN<br><strong class="fw-600"><?=$dic['Input_member']?></strong></h3>
							<div class="position-ab btn-right-bottom fs-05">
								<strong class="color-primary">4</strong> / <span>4</span>
							</div>
						</div>
						<form name="frm" id="frm">
							<input type="hidden" name="email" id="email" value="<?=$_SESSION['_join_email']?>"/>
							<div class="form-group">
								<label for=""><?=$dic['Name']?></label>
								<input class="form-control" type="text" name="name" id="name" placeholder="<?=$dic['Name_write']?>">
							</div>
							<div class="form-group form-vertical">
								<label for=""><?=$dic['Password']?></label>
								<input type="password" name="passwd" id="passwd" class="form-control" placeholder="<?=$dic['Password_write']?>">
								<input type="password" name="passwd2" id="passwd2" class="form-control" placeholder="<?=$dic['Password_write_re']?>">
								<p class="color-6 fs--1 mt-2 mb-0"><?=$dic['Password_guide']?></p>
							</div>
							<div class="form-group form-vertical">
								<label for=""><?=$dic['S_password']?></label>
								<input class="form-control" id="security_passwd" name="security_passwd" type="password" placeholder="<?=$dic['S_password_write']?>">
								<input class="form-control" id="security_passwd2" name="security_passwd2" type="password" placeholder="<?=$dic['S_password_write_re']?>">
								<p class="color-6 fs--1 mt-2"><?=$dic['S_password_use']?></p>
							</div>
							<hr class="my-4 color-10" />
							<h4 class="fs-005 fw-400 mb-4 color-5"><?=$dic['More_info']?><span class="fs--1 color-6">&#40;<?=$dic['Select']?>&#41;</span></h4>
							<!-- <div class="form-group">
								<label for=""><?=$dic['Refer_UID']?></label>
								<input class="form-control" type="number" name="recommender" id="recommender" placeholder="<?=$dic['Refer_UID_guide']?>" maxlength="7">
							</div> -->
							<div class="form-group">
								<label for=""><?=$dic['Born_year']?></label>
								<input class="form-control" type="number" name="birthday" id="birthday" placeholder="YYMMDD">
							</div>
							<div class="form-group">
								<label for=""><?=$dic['Sex']?></label>
								<select class="form-control mb-1" size="1" id="gender" name="gender">
									<option value=""><?=$dic['Select']?></option>
									<option value="1"><?=$dic['Sex_male']?></option>
									<option value="2"><?=$dic['Sex_pemale']?></option>
								</select>
							</div>
							<div class="form-group">
								<label for="">에이전시 UID (추천 에이전시가 없는 경우 입력X)</label>
								<input class="form-control" type="number" name="agency_UID" id="agency_UID" placeholder="추천인(에이전시) UID 입력해 주세요.">
							</div>
							<div class="mt-6">
								<a href="javascript:go_join_ok();" class="btn-block btn btn-primary mb-3 fs-0"><?=$dic['Login_join']?></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<?// include "./inc_Bottom.php"; ?>
	</body>

</html>