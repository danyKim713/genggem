<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<script>
	function go_cert_sms_send(){
		$.get("_ajax_email_cert_myinfo_edit.php",{
			email: '<?=$rowMember['email']?>'
		},function(data){
			alert("고객님의 이메일로 인증번호가 발송되었습니다. 수신된 인증번호를 입력해 주세요.");
		});
	}

	function go_modify_myinfo(){
		//변수 설정
		var 은행명 = $("#bank_nm").val();
		var 계좌번호 = $("#bank_account").val();
		var 예금주 = $("#bank_yegeumju").val();
		var 닉네임 = $("닉네임").val();
		var 인증번호 = $("#cert_no").val();
		//var KYC인증사진_원래 = $("#KYC인증사진_원래").val();
		//var KYC인증사진 = $("#KYC인증사진").val();
		//var bitkoex_email = $("#bitkoex_email").val();
		//필수체크
		if($.trim(은행명)==""){
			alert('은행명을 입력해주세요.');
			return;
		}
		if($.trim(계좌번호)==""){
			alert('계좌번호를 입력해주세요.');
			return;
		}
		if($.trim(예금주)==""){
			alert('예금주를 입력해주세요.');
			return;
		}
		if($.trim(인증번호)==""){
			alert('인증번호를 입력해주세요.');
			return;
		}
		
		//if($.trim(KYC인증사진_원래)=="" && $.trim(KYC인증사진)==""){
		//	alert('KYC 인증사진을 선택해주세요.');
		//	return;
		//}
		//if($.trim(bitkoex_email)==""){
		//	alert('빗코엑스 이메일을 입력해주세요.');
		//	return;
		//}

		var form = $('#frm')[0];
		var formData = new FormData(form);
		formData.append("페이지프로필사진", $("#페이지프로필사진")[0].files[0]);
 
		$.ajax({
			url: '_ajax_myinfo_edit.php',
            processData: false,
            contentType: false,
            data: formData,
            type: 'POST',
            success: function(result){
				if(result == "MANDATORY_ERROR"){
					alert('모든 정보를 입력하셔야 합니다.');
				}else if(result == "CERT_NO_NOT_SAME"){
					alert('인증번호가 일치하지 않습니다.');
				}else if(result != "FAIL"){
					alert('성공적으로 등록하였습니다.');
					location.reload(true);
				}else{
					alert('오류가 발생했습니다. 관리자에게 문의바랍니다.');
				}
			}
		});
	}
	$(function(){
		$("#photo").change(function() {
			upload_photo();
		});
	});

      function upload_photo() {
        var form = $("#frm")[0];
        var formData = new FormData(form);

        $.ajax({
          type: "POST",
          enctype: "multipart/form-data",
          url: "_ajax_upload_photo.php",
          data: formData,
          processData: false,
          contentType: false,
          timeout: 600000,
          success: function(data) {
            alert('성공적으로 사진을 업로드하였습니다.');
            location.reload(true);
          },
          error: function(e) {
            alert("오류가 발생했습니다.");
          }
        });
      }


</script>

<body class="mb-5">
  <header class="header top_fixed">
    <a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
    <h2 class="header-title text-center">내정보 수정</h2>
  </header>
  <form name="frm" id="frm" method="post" encType="multipart/form-data">
  <section id="wrap-join" class="py-0">
    <div class="container-fluid header-top">
      <div class="row align-items-center justify-content-center">
        <div class="col-sm-8 col-lg-6 col-xl-6 p-0">
          <div class="pt-1 pb-3 text-center">
            <div class="user-profile m-0-auto position-r mx-0">
			<label for="">프로필 사진</label><br>
              <img src="<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 100, 100, 2)?>" alt="나의 프로필 사진" /> 
              <input name="photo" id="photo" type="file" class="image-upload" />

					<div class="box col-12 mt-2">
					 <!-- <label for="">프로필 사진</label> -->
						<div class="js-image-preview" style="background-image: url('<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 900, 900, "2")?>');">
							<input type="file" id="페이지프로필사진" name="페이지프로필사진" class="image-upload" accept="image/*">
						</div>
					</div>

            </div>
          </div>

          <div class="p-3">
            <div class="mt-2">
              <h3 class="fs--1">기본정보</h3>
            </div>
            <div class="border-box p-3 mb-4">
              <div class="basic-info">
                <ul class="no-style pl-0 mb-0">
                  <li>
                    <strong class="">Cafehand ID</strong>
                    <span><?=$rowMember['email']?></span>
                  </li>
				  <li>
                    <strong class="">UID</strong>
                    <span><?=$rowMember['UID']?></span>
                  </li>
                  <li>
                    <strong class="">이름</strong>
                    <span><?=$rowMember['name']?></span>
                  </li>
                  <li>
                    <strong class="">핸드폰번호</strong>
                    <span>+<?=$rowMember['country_id']?>-0<?=$rowMember['hp']?></span>
                  </li>
                  <li>
                    <strong class="">계좌인증</strong>
                    <span class="badge badge-gray fs--1"><?=showNameCommonCode($rowMember['bank_flg'])?></span>
                  </li>

                  <?/* <li>
                    <strong class="">GEN 지갑</strong>
                    <span class="badge badge-gray fs--1"><?=$rowMember['bitkoex_email_status']?></span>
                  </li> 
                  <li>
                    <strong class="">종합인증</strong>
                    <span class="badge badge-gray fs--1"><?=showNameCommonCode($rowMember['total_auth'])?></span>
                  </li> */?>
                </ul>
              </div>
            </div>


            <div class="form-group">
              <label for="">닉네임</label>
              <input class="form-control" name="닉네임" id="닉네임" type="text" placeholder="닉네임을 입력해주세요." value="<?=$rowMember['닉네임']?>">
            </div>
            <div class="form-group">
              <label for="">고객계좌정보 <br>(환불 또는 정산계좌 정보로 반드시 본인 이름의 계좌여야 합니다)</label>
              <input class="form-control" name="bank_nm" id="bank_nm" type="text" placeholder="은행명을 입력해 주세요." value="<?=$rowMember['bank_nm']?>">
              <input class="form-control mt-1" name="bank_account" id="bank_account" type="number" pattern="\d*" placeholder="계좌번호를 입력해 주세요."  value="<?=$rowMember['bank_account']?>">
            </div>
            <div class="form-group">
              <label for="">예금주</label>
              <input class="form-control" id="bank_yegeumju"  name="bank_yegeumju" type="text" placeholder="본인명의의 예금주를 입력해 주세요." value="<?=$rowMember['bank_yegeumju']?>">
            </div>

			<?/* <div class="form-group">
              <label for="">GEN지갑주소</label>
              <input class="form-control" id="GEN지갑주소"  name="GEN지갑주소" type="text" placeholder="회원님의 GEN 지갑주소를 입력해 주세요." value="<?=$rowMember['GEN지갑주소']?>">
            </div> */?>


            <div class="form-group mt-4">
              <label for="">인증번호</label>
              <button class="float-right btn btn-outline-secondary btn-xs radius-2" type="button" onClick="go_cert_sms_send();">인증번호 요청</button>
              <div class="position-r">
                <input class="form-control pr-6" name="cert_no" id="cert_no" type="number" pattern="\d*" placeholder="이메일로 전송된 인증번호를 입력하세요" />
              </div>
            </div>
            <div class="mt-5 mb-3">
              <button class="btn-block btn btn-primary fs-0" type="button" onClick="go_modify_myinfo();">정보 수정하기</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  </form>


  <!--  인증확인-->
  <div class="remodal hidden" id="md-certify">
    <div class="remodal-contents p-3">
      <p>인증 되었습니다.</p>
    </div>
    <div class="remodal-footer text-center">
      <button class="btn color-primary" onclick="hideModal()">확인</button>
    </div>
  </div>
  <!--  KYC 예시사진-->
  <div class="remodal hidden" id="md-kycphoto">
    <div class="remodal-contents" onclick="hideModal()">
      <div class="h-100">
        <img src="assets/images/photo2.jpg" alt="KYC 인증 안내" />
      </div>
    </div>
  </div>
  <? include "./inc_Bottom_main.php"; ?>
</body>

<script>
$('.nav_bottom li[data-name="myinfo"]').addClass('active');
</script>
</html>