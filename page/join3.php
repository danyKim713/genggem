<!DOCTYPE HTML>
<html lang="en">
<? $NO_LOGIN = "Y"; ?>
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<script>
	function go_sms_cert() {
		var hp_nation = $("#hp_nation option:selected").val();
		var hp = $("#hp").val();
		  if (hp_nation == "" || hp == "") {
			alert('<?=$dic[Caution_national]?>');
			return false;
		  }

		$.post("_ajax_sms_cert_send.php", {
			country_id: hp_nation,
			hp: hp
          }).done(function(data) {
				if(data != "DUP"){
					alert('<?=$dic[Mobile_guide]?> : ' + hp_nation+hp);
				}else{
					alert('<?=$dic[Already_mobile]?>');
				}
          });
//          start_timer();
        }

		function go_next_4(){
			var hp_nation = $("#hp_nation option:selected").val();
			var hp = $("#hp").val();
			  if (hp_nation == "" || hp == "") {
				alert('<?=$dic[Caution_national]?>');
				return false;
			  }

          var hp_cert_no = $("#hp_cert_no").val();

          if (hp_cert_no == "") {
            alert('<?=$dic[Authentication_wirte]?>');
            return false;
          }



          $.post("_ajax_join3_action.php", {
            country_id: hp_nation,
			hp: hp,
			hp_cert_no: hp_cert_no
          }).done(function(data) {
				if(data == "DUP"){
					alert('<?=$dic[Already_mobile]?>');
				}else if(data == "NOT_SAME"){
					alert("<?=$dic[Caution_mobile]?>");
				}else if(data == "NOT_CERT"){
					alert("<?=$dic[No_matching_aut]?>");
				}else if(data == "SUCCESS"){
					top.location.href = "join4.php";
				}
          });
		}

</script>

	<body>
		<section class="wrap-join py-0">
			<div class="container-fluid">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-3 pt-xs-3 p-4 mt-xl-6">
						<div class="position-r">
							<h3 class="mt-xs-3 my-4 fs-1 lh-3 fw-100"><?=$dic['Kyc_auth2']?><br><strong class="fw-600"><?=$dic['Mobile_ok']?></strong></h3>
							<div class="position-ab btn-right-bottom fs-05">
								<strong class="color-primary">3</strong> / <span>4</span>
							</div>
						</div>
						<form>
							<div class="form-group position-r">
								<label for=""><?=$dic['Mobile']?></label>
								<select class="form-control mb-1" size="1" id="hp_nation" name="hp_nation">
									<option value="국가코드"><?=$dic['National']?></option>
                      <?php
                    foreach($countryArray as $xkey=>$xval){ ?>
                        <option value="<?php echo $xkey?>">
                          <?php echo $xval . " (". $xkey .")"?>
                        </option>
                        <?php }
                    reset($countryArray);
                    ?>
									<!-- <option value="82">Republic of Korea (82)</option>
									<option value="1">Unite of America (1)</option>
									<option value="86">China (86)</option>
									<option value="852">Hong Kong (852)</option>
									<option value="81">Japan (81)</option>
									<option value="84">Vietnam (84)</option>
									<option value="886">Thailand (886)</option>
									<option value="63">Philippines (63)</option>
									<option value="7">Kazakhstan (7)</option>
									<option value="62">Indonesia (62)</option>
									<option value="65">Singapore (65)</option> -->
								</select>
								<input class="form-control" id="hp" name="hp" type="phone" placeholder="<?=$dic['Mobile_write']?>" />
								<button class="btn-right position-ab btn btn-outline-secondary btn-xs" type="button" onClick="go_sms_cert();"><?=$dic['Send_authentication_number']?></button>
								<!--발송 후 재발송 버튼으로 바뀜 <button class="btn-right position-ab btn btn-gray btn-xs" type="button"><?=$dic['Send_authentication_again']?></button>-->
							</div>
							<div class="form-group position-r">
								<label for="">인증번호</label>
								<input class="form-control" id="hp_cert_no" name="hp_cert_no" type="number" placeholder="<?=$dic['Authentication_wirte']?>" />
								<!-- <span class="btn-right position-ab color-6 pr-1"><i class="fas fa-clock color-8 fs-005"></i> <span>03:00</span></span> -->
							</div>
							<div class="mt-4">
								<a href="javascript:go_next_4();" class="btn-block btn btn-primary mb-3 fs-0"><?=$dic['Next']?></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<?// include "./inc_Bottom.php"; ?>
	</body>

</html>