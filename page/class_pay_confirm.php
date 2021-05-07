<? 
include "./inc_program.php";

$strRecordNo = $_GET["txtRecordNo"];

// 주문정보
$query  = " SELECT A.lo_id, A.l_id, A.coach_id, A.member_id, A.member_uid, A.payment_flg, A.original_price, A.order_price, A.사용마일리지, A.쿠폰금액, A.order_dt, A.status_flg, B.cd_nm    \n";
$query .= " FROM    tbl_lesson_order A, sysT_CommonCode B    \n";
$query .= " WHERE  A.lo_id = '{$strRecordNo}'   \n";
$query .= " AND      A.payment_flg = CONCAT(B.major_cd, B.minor_cd)   \n";
$rowOrder = db_select($query);   

?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<body>
	<header class="header top_fixed">
		<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
		<h2 class="header-title text-center">결제완료</h2>
	</header>
	<section class="py-0">
			<div class="container-fluid header-top-sub">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-6 p-3">
					<p class="my-4 fs-05 text-center color-primary">감사합니다.</p>					
					<div class="my-4">
						<ul class="ul-notice text-center">
							<li>클래스 신청이 정상적으로 완료되었습니다.</li>
							<li>신청하신 내역은 담당 아티스트에게 전달됩니다.</li>
							<li>(무통장 입금의 경우 입금확인 후 진행됩니다.)</li>
						</ul>
					</div>
					
					<table class="table-info">
						<tbody>
							<tr>
								<th>결제수단</th>
								<td><?=$rowOrder["cd_nm"]?></td>
							</tr>

							<tr>
								<th>클래스 상품 금액</th>
								<td class="fw-600"><?=number_format($rowOrder["original_price"])?> 원</td>
							</tr>
							<tr>
								<th>사용한 G-Point</th>
								<td class="fw-600" style="color:red">- <?=number_format($rowOrder["사용마일리지"])?> point</td>
							</tr>
<? if ($rowOrder["쿠폰금액"] > 0) { ?>
							<tr>
								<th>쿠폰금액</th>
								<td class="fw-600" style="color:red"><?=number_format($rowOrder["쿠폰금액"])?> 원</td>
							</tr>
<? } ?>
							<tr>
								<th>실결제금액</th>
								<td class="fw-600"><?=number_format($rowOrder["order_price"])?> 원</td>
							</tr>
						</tbody>
					</table>

						<div class="mt-4">
							<a href="class_my.php" class="btn-block btn btn-dark mb-3 fs-0">마이 클래스</a>
						</div>
					</div>
					<? include "./inc_Bottom_lesson.php"; ?>
				</div>
			</div>
		</section>
</body>

<? include "./inc_Bottom_class.php"; ?>

<script>
	$('.nav_bottom li[data-name="classlist"]').addClass('active');
</script>
</html>