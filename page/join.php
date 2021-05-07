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

<script>

	$(function(){
		$("#label_all").click(function(){
			window.setTimeout(function(){
				$(".동의").prop("checked", $(".전체동의").prop("checked"));
			}, 100);
		});
	});	

	function go_join_ok(){

		var 동의 = true;
		$(".동의").each(function(){
			if(!$(this).prop("checked")){
				동의 = false;
			}
		});
		if(!동의){
			alert('<?=$dic[Agree_alert]?>');
			return false;
		}

		var params = $("#frm").serialize();
		$.ajax({
			url: "_ajax_join_action.php",
			data: params,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			dataType: "html",
			success: function(data){
				if(data == "SUCCESS"){
					alert('감사합니다. 회원가입이 성공적으로 이루어졌습니다.');
					top.location.href = "login.php";
				}else if(data == "MANDATORY_ERROR"){
					alert('필수 항목이 누락되었습니다.');
				}else if(data == "DUP_EMAIL"){
					alert('중복된 이메일입니다.');
					$("#이메일").val("");
					$("#이메일").focus();
				}else if(data == "ERROR_EMAIL"){
					alert('이메일 형식에 맞지 않습니다.');
					$("#이메일").val("");
					$("#이메일").focus();
				}else if(data == "DUP_HP"){
					alert('중복된 휴대폰번호입니다.');
					$("#휴대폰번호").val("");
					$("#휴대폰번호").focus();
				}else if(data == "DUP_NICKNAME"){
					alert('중복된 닉네임입니다.');
					$("#닉네임").val("");
					$("#닉네임").focus();
				}else if(data == "WRONG_PASSWD2"){
					alert('비밀번호 확인이 일치하지 않습니다.');
					$("#비밀번호2").focus();
				}else if(data == "NO_RECO_UID"){
					alert('존재하지 않는 추천인UID입니다.');
					$("#추천인UID").val("");
					$("#추천인UID").focus();
				}else if(data == "NO_CERT_NO"){
					alert('인증번호가 일치하지 않습니다.');
					$("#인증번호").val("");
					$("#인증번호").focus();
				}
			}
		});
	}
	function go_change_시도(){
		var 시도 = $("#시도 option:selected").val();
		if(시도 == ""){
			$("#구군").html('<option value="">구/군을 선택해주세요.</option>');
			return;
		}
		$.post("_ajax_gu_gun.php",{
			시도: 시도
		},function(data){
			$("#구군").html(data);
		});


	}

	function go_dup_email_chk(){
		var 이메일 = $("#이메일").val();
		console.log(이메일);
		if(이메일 == ""){
			alert('이메일 입력후 다시 중복확인해주시기 바랍니다.');
			return;
		}
		$.post("_ajax_email_dup_chk.php",{
			이메일: 이메일
		},function(data){
			console.log(data);
			data = $.trim(data);
			if(data == "SUCCESS"){
				alert('사용가능한 이메일입니다.');
			}else if(data == "ERROR_EMAIL"){
				alert('이메일 형식에 맞지 않습니다.');
			}else{
				alert('이미 가입된 이메일입니다.');
			}
		});
	}

        function go_sms_cert() {
			var 국가코드 = $("#국가코드 option:selected").val();
			var 휴대폰번호 = $("#휴대폰번호").val();

			if (휴대폰번호 == "") {
				alert('휴대폰번호를 입력후 다시 시도해주시기 바랍니다.');
				return false;
			}


			$.post("_ajax_sms_cert_send.php", {
			국가코드: 국가코드,
			휴대폰번호: 휴대폰번호
			}).done(function(data) {
			if(data != "DUP"){
				alert('입력하신 휴대폰번호로 인증번호를 발송하였습니다.');
			}else{
				alert('이미 가입된 휴대폰번호입니다.');
			}
			});
			start_timer();
        }

        var timerID; // 타이머를 핸들링하기 위한 전역 변수
        var time = 180; // 타이머 시작시의 시간
        /* 타이머를 시작하는 함수 */
        function start_timer() {
          timerID = setInterval("decrementTime()", 1000);
        }



        /* 남은 시간을 감소시키는 함수 */

        function decrementTime() {
          var x1 = document.getElementById("time1");
          //        var x2 = document.getElementById("time2");
          x1.innerHTML = toHourMinSec(time);
          //        x2.innerHTML = toHourMinSec(time);
          if (time > 0) time--;
          else {
            // 시간이 0이 되었으므로 타이머를 중지함
            clearInterval(timerID);
            // 시간이 만료되고 나서 할 작업을 여기에 작성
            //document.form.submit(); // 예: 강제로 form 실행
            alert('<?=$dic[Time_is_up_for_enter_Auth_Number]?>');
          }
        }



        /* 정수형 숫자(초 단위)를 "시:분:초" 형태로 표현하는 함수 */
        function toHourMinSec(t) {
          var hour;
          var min;
          var sec;
          // 정수로부터 남은 시, 분, 초 단위 계산
          hour = Math.floor(t / 3600);
          min = Math.floor((t - (hour * 3600)) / 60);
          sec = t - (hour * 3600) - (min * 60);
          // hh:mm:ss 형태를 유지하기 위해 한자리 수일 때 0 추가
          if (hour < 10) hour = "0" + hour;
          if (min < 10) min = "0" + min;
          if (sec < 10) sec = "0" + sec;
          //return(hour + ":" + min + ":" + sec);
          return (min + ":" + sec);
        }


	function go_next_3(){
          var email = $("#email").val();

          if (email == "") {
            alert('<?=$dic[Login_ID]?>');
            return false;
          }

          var email_cert_no = $("#email_cert_no").val();

          if (email_cert_no == "") {
            alert('<?=$dic[Authentication_wirte]?>');
            return false;
          }



          $.post("_ajax_join2_action.php", {
            email: email,
			email_cert_no: email_cert_no
          }).done(function(data) {
				if(data == "DUP"){
					alert('<?=$dic[Already_member]?>');
				}else if(data == "NOT_SAME"){
					alert("<?=$dic[Caution_email]?>");
				}else if(data == "NOT_CERT"){
					alert("<?=$dic[No_matching_aut]?>");
				}else if(data == "SUCCESS"){
					top.location.href = "join3.php";
				}
          });
	}
</script>
<?
$_TITLE = 회원가입;
?>
<body>
<!-- ##### form Area Start ##### -->
<? include "./inc_Top.php"; ?>
    <div class="cart-area clearfix mt-5">
        <div class="container">

            <div class="row align-items-center justify-content-center">
                <!-- form Totals -->
                <div class="col-12 col-lg-8 mt-2 mb-5">
                    <div class="cart-totals-area mt-4">
                        <h5 class="title--"><img src="./assets/img/core-img/logo_b.png" alt="카페핸즈"></h5>
                        <form name="frm" id="frm" method="post">
						<div class="wrap-join">
							<ul>
								<li class="mb-3">
									<div class="con-article background-10 p-2">
										<? include "_terms".($_COOKIE['dic_lang']!="ko"?"_en":"").".php";?>
									</div>
									<div class="py-1 border-top color-10">
										<div class="checkbox check-square">
											<input id="chk1" name="agree" type="checkbox" class="invisible 동의" data-alert="<?=$dic['Agree_alert']?>">
											<label for="chk1" class="color-5 fs--1 mb-0 fw-400"><i class="biko-check color-5"></i><?=$dic['Agree_ok']?><span class="color-6">&#40;<?=$dic['Essential']?>&#41;</span></label>
										</div>
									</div>
								</li>
								<li class="mb-3">
									<div class="con-article background-10 p-2">
										<? include "_terms2".($_COOKIE['dic_lang']!="ko"?"_en":"").".php";?>
									</div>
									<div class="py-1 border-top color-10">
										<div class="checkbox check-square">
											<input id="chk2" name="agree" type="checkbox" class="invisible 동의" data-alert="<?=$dic['Privacy_alert']?>">
											<label for="chk2" class="color-5 fs--1 mb-0 fw-400"><i class="biko-check color-5"></i><?=$dic['Privacy_ok']?><span class="color-6">&#40;<?=$dic['Essential']?>&#41;</span></label>
										</div>
									</div>
								</li>
								<li class="mb-3">
									<div class="con-article background-10 p-2">
										<? include "_terms3".($_COOKIE['dic_lang']!="ko"?"_en":"").".php";?>
									</div>
									<div class="py-1 border-top color-10">
										<div class="checkbox check-square">
											<input id="chk3" name="agree" type="checkbox" class="invisible 동의" data-alert="<?=$dic['Platform_alert']?>">
											<label for="chk3" class="color-5 fs--1 mb-0 fw-400"><i class="biko-check color-5"></i>G-PAY 이용약관<span class="color-6">&#40;<?=$dic['Essential']?>&#41;</span></label>
										</div>
									</div>
								</li>
							</ul>
							<div class="checkbox check-square">
								<input id="chk_all" name="agree" type="checkbox" class="invisible 전체동의" data-alert="<?=$dic['Platform_alert']?>">
								<label id="label_all" for="chk_all" class="color-3 fs-005 mb-0 fw-400"><i class="biko-check color-5"></i><strong><?=$dic['All_agree']?></strong><span class="fs--1 color-6"></span></label>
							</div>
						</div>						

                        <div class="shipping d-flex justify-content-between"></div>


						
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><?=$dic['ID_email']?></h5>
							<div class="shipping-address" style="width:70%;">
								<input id="이메일" name="이메일" type="email" placeholder="<?=$dic['Login_ID']?>" />
								<button class="btn btn-outline-secondary btn-xs" type="button" onClick="go_dup_email_chk();" ><?=$dic['double_check']?></button>
							</div>
						</div>
							
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;">전화번호</h5>
							<div class="shipping-address" style="width:70%;"> 
								<select class="custom-select" id="국가코드" name="국가코드">
									<option value=""><?=$dic['National']?></option>
											<?php
										foreach($countryArray as $xkey=>$xval){ ?>
												<option value="<?php echo $xkey?>">
													<?php echo $xval . " (". $xkey .")"?>
												</option>
												<?php }
										reset($countryArray);
										?>
								</select>
								<input id="휴대폰번호" name="휴대폰번호" type="phone" placeholder="<?=$dic['Mobile_write']?>" />
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
                            <h5 style="width:30%;"><?=$dic['Name']?></h5>
                            <div class="shipping-address" style="width:70%;">
								<input type="text" name="이름" id="이름" placeholder="<?=$dic['Name_write']?>">
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><?=$dic['Nic']?></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="text" name="닉네임" id="닉네임" placeholder="<?=$dic['Nic_write']?>">
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><?=$dic['Password']?></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="password" name="비밀번호" id="비밀번호"  placeholder="<?=$dic['Password_write']?>">
								<input type="password" name="비밀번호확인" id="비밀번호확인" placeholder="<?=$dic['Password_write_re']?>">
								<p class="color-6 fs--1 mb-0"><?=$dic['Password_guide']?></p>
							</div>
						</div>

							
						<h4 class="fs-005 fw-400 mt-3 mb-4 color-5"><strong><?=$dic['More_info']?><span class="fs--1 color-6">&#40;<?=$dic['Select']?>&#41;</span></strong></h4>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;">지역</h5>
							<div class="shipping-address" style="width:70%;">
								<select class="mb-1" size="1" id="시도" name="시도" onChange="go_change_시도();">
									<option value="">시/도를 선택해주세요</option>
<?
for ($i=0; $i<sizeof($시도배열); $i++){
?>
									<option value="<?=$시도배열[$i]?>"><?=$시도배열[$i]?></option>
<?}?>

								</select>
								<select class="mb-1" size="1" id="구군" name="구군">
									<option value="">구/군을 선택해주세요</option>
								</select>
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><?=$dic['Born_year']?></h5>
							<div class="shipping-address" style="width:70%;">
								<input class="form-control" type="number" name="생년월일" id="생년월일" placeholder="YYYYMMDD">
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><?=$dic['Sex']?></h5>
							<div class="shipping-address" style="width:70%;">
								<select class="form-control mb-1" size="1" id="성별" name="성별">
									<option value=""><?=$dic['Select']?></option>
									<option value="남"><?=$dic['Sex_male']?></option>
									<option value="녀"><?=$dic['Sex_pemale']?></option>
								</select>
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;">추천인 UID</h5>
							<div class="shipping-address" style="width:70%;">
								<input class="form-control" id="agency_UID" name="agency_UID" type="text" placeholder="추천인이 있을경우 UID입력" />
							</div>
						</div>						

						<!-- <div class="mt-4">
							<a href="javascript:go_chk_동의();" class="btn-block btn btn-primary mb-3 fs-0"><?=$dic['Next']?></a>
						</div> -->
						<div class="checkout-btn mt-2 mb-5">
							<a href="javascript:go_join_ok();" class="btn alazea-btn w-100"><?=$dic['Login_join']?></a>
						</div>
							
						</form>

                    </div>
                </div>
            </div>

        </div>
    </div>


<? include "./inc_Bottom_main.php"; ?>
</body>

</html>