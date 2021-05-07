				 <div class="box-round mt-3 mb-2">
					<div class="box-change display-table text-center" style="border: 5px solid #f0f1f4;">
						<div class="display-table-cell p-3">
							<label for="" class="fs-005 fw-600 mb-0">G-PAY / G-Point 총보유금액</label>
							<p class="fs-05 mb-0 fw-600"><?=number_format($rowMember['gpay']+$rowMember['gpoint'])?> <small></small></span></p>
						</div>
					</div>
				</div>
				
				<div class="form-group mt-4 mb-4">
					<ul class="list-wallet">
					<li class="box-ver2 py-3 mb-2">
						<div class="row  align-items-center justify-content-center m-0">
							<div class="col-3 text-center p-0">
								<img src="assets/images/logos/symbol_gep.png" width="50" />
								<h3 class="coin-name">G-PAY</h3>
							</div>
							<div class="col-5 p-0">
								<span class="fs-0 fw-600"><?=number_format($rowMember['gpay'])?> <small>GP</small></span>
								<p class="address fs--1 mt-2">
									<span class="fw-600">G-PAY</span> 란, 충전하여 사용하는 결제수단으로 온/오프라인 모든 상품을 구매할 수 있습니다.<br>
									<span class="fw-600">G-PAY</span>는 G-POINT, GEN COIN, 현금으로 충전 가능합니다.<br>
									<span class="fw-600">G-PAY</span> 단위는 'GP' 이며, <span class="fw-600">1GP = 1원</span>입니다.<br>
									<span class="fw-600">G-PAY로 결제시 구매금액의 <font color="#ff0033">3%</font>만큼 <font color="#ff0033">G-Point</font>가 추가 적립</span> 됩니다.<br>
									* 추가 적립율은 프로모션에 따라 변경될 수 있습니다.
								</p>
							</div>
							<div class="col-4 text-right pl-0">
								<a href="gpay_charge.php" title="충전하기" class="btn btn-xs btn-info mt-1">충전하기</a>
								<!-- <a href="javascript:void(0)" onClick="alert('<?=$dic['Coming_soon']?>')" title="지불하기" class="btn btn-xs btn-info2 mt-1">지불하기</a> -->
								<a href="gpay_send.php" title="선물하기" class="btn btn-xs btn-info2 mt-1">전송/선물</a>
								<a href="gpay_history.php" title="이용내역" class="btn btn-xs btn-info4 mt-1">이용내역</a>
							</div>
						</div>
					</li>

					<li class="box-ver2 py-3">
						<div class="row  align-items-center justify-content-center m-0">
							<div class="col-3 text-center p-0">
								<img src="assets/images/logos/symbol_gen.png" width="50" />
								<h3 class="coin-name">G-Point</h3>
							</div>
							<div class="col-5 p-0">
								<span class="fs-0 fw-600"><?=number_format($rowMember['gpoint'])?> <small>Point</small></span>
								<p class="address fs--1 mt-2">
									<span class="fw-600">G-Point</span>는 클래스 및 쇼핑상품 <span class="fw-600">구매후 적립되는 포인트로, G-PAY(GP)로 전환(충전)하여 사용하거나 <font color="#ff0033">GEN 코인</font>으로 전환</span> 할 수 있습니다.
								</p>
							</div>
							<div class="col-4 text-right pl-0">
								<a href="gpay_charge.php" title="충전하기" class="btn btn-xs btn-info mt-1">G-PAY전환</a>
								<a href="gen_send.php" title="코인전환" class="btn btn-xs btn-info3 mt-1">코인전환</a>
								<a href="gen_history.php" title="이용내역" class="btn btn-xs btn-info4 mt-1">이용내역</a>
							</div>
						</div>
					</li>
					</ul>
				</div>
				<?/*
				$query = "select sum(금액) as 에이전시Airdrop from tbl_coin_gen where member_id = '{$rowMember['member_id']}' and 상세내용 = 'GEN-에이전시Airdrop'";
				$rowS  = db_select($query);
				$에이전시Airdrop = $rowS['에이전시Airdrop'];

				$query = "select sum(금액) as GENPOSAirdrop from tbl_coin_gen where member_id = '{$rowMember['member_id']}' and 상세내용 = 'GEN-POS지급'";
				$rowS  = db_select($query);
				$GENPOSAirdrop = $rowS['GENPOSAirdrop'];

				$GEN_Airdrop_Total = $에이전시Airdrop + $GENPOSAirdrop;
				?>				
				<div class="box-round mb-5">
					<!-- <div class="d-flex align-items-center">
						<h2 class="mr-auto mb-0">GEN-Point Airdrop</h2>
						<a href="block_my.php" title="자세히보기" class="color-6 fs-005">Total : <span class="coin-amount"><?=소수n자리까지표시($GEN_Airdrop_Total,4)?> GEN-Point</span> </a>
				 	</div> -->
					<div class="d-flex align-items-center">
						<h2 class="fs--1"><strong>G-PAY Airdrop</strong> : G-PAY를 보유하고 계시면 매일 보유금액의 0.1%씩 추가 지급됩니다.</h2>
				 	</div>
					<ul class="list list-wallet">
						
						<!-- <li class="d-flex align-items-center">
							<div class="list-icon purple">
								<i class="fas fa-user-friends"></i>
							</div>
							<div class="lh-3">
								<h3 class="coin-name">추천 Reward</h3>
								<span class="coin-amount"><?=소수n자리까지표시($에이전시Airdrop,4)?> GEN-Point</span>
							</div>
							<a href="block_recommend.php" class="btn btn-sm btn-gray ml-auto">내역</a>
						</li> -->
						<li class="d-flex align-items-center">
							<div class="list-icon purple">
								<i class="fas fa-user-friends"></i>
							</div>
							<div class="lh-3">
								<h3 class="coin-name fw-600">G-PAY Point Airdrop</h3>
								<span class="coin-amount">Airdrop 총수량 : <?=소수n자리까지표시($GENPOSAirdrop,4)?> GEN-Point</span>
							</div>
							<!-- <a href="block_daily.php" class="btn btn-sm btn-gray ml-auto">내역</a> -->
							<a href="gen_history.php" class="btn btn-sm btn-gray ml-auto">내역</a>
						</li>
					</ul>
				</div>
				*/?>