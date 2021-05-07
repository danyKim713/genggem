<? 
include "./inc_program.php";

$strRecordNo = $_GET["txtRecordNo"];

// 주문정보
$query  = " SELECT A.*, B.cd_nm    \n";
$query .= " FROM   tbl_lecture_order A, sysT_CommonCode B    \n";
$query .= " WHERE  A.o_id = '{$strRecordNo}'   \n";
$query .= " AND    A.payment_flg = CONCAT(B.major_cd, B.minor_cd)   \n";
$rowOrder = db_select($query);   
?>

<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<body class="mb-5">

<? include "./inc_nav.php"; ?>
	<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg1.jpg);">
            <h2>Branch Information</h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

	<section id="m_bnr2">
		<div>
			<ul>
				<li class="wow fadeInDown">
					<a href="hanc_lecture.php">
						<div><i class="fa fa-list" aria-hidden="true"></i></div>
						<p class="txt_tit">강좌안내</p>
					</a>
				</li>
				<li class="wow fadeInUp">
					<a href="hanc_apply.php">
						<div><i class="fa fa-user" aria-hidden="true"></i></div>
						<p class="txt_tit">수강신청</p>
					</a>
				</li>
				<li class="wow fadeInDown">
					<!-- <a href="hanc_online.php"> -->
					<a href='javascript:void(0)' title='온라인강좌' onClick="alert('서비스 준비중입니다')">
						<div><i class="fas fa-edit" aria-hidden="true"></i></div>
						<p class="txt_tit">온라인강좌</p>
					</a>
				</li>
				<li class="wow fadeInUp">
					<a href="hanc_my.php">
						<div><i class="fas fa-desktop" aria-hidden="true"></i></div>
						<p class="txt_tit">내강좌관리</p>
					</a>
				</li>
			</ul>
		</div>
	</section>
	
	<section class="py-0 mb-5">
			<div class="container-fluid header-top-sub">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-4 p-3">
					<p class="fs-05 text-center color-primary">감사합니다.</p>					
					<div class="my-4">
						<ul class="ul-notice text-center">
							<li>강좌 수강신청이 정상적으로 완료되었습니다.</li>
							<li>담당자 확인 후 수강지역이 배정됩니다.</li>
							<li>(무통장 입금의 경우 입금확인 후 진행되며 주문 후 5일 안에 미입금시 자동 취소됩니다. )</li>
							<li>유익한 수강이 되시기 바랍니다.</li>
						</ul>
					</div>
					<p class="my-4 fs-05 text-center color-primary">주문번호: <?=$rowOrder["order_id"]?></p>
					
					<table class="table-info">
						<tbody>
							<tr>
								<th>결제수단</th>
								<td><?=$rowOrder["cd_nm"]?></td>
							</tr>

							<tr>
								<th>강좌비용</th>
								<td class="fw-600"><?=number_format($rowOrder["강좌비용"])?>원</td>
							</tr>
							<tr>
								<th>연회비</th>
								<td class="fw-600"><?=number_format($rowOrder["연회비"])?>원</td>
							</tr>
							<tr>
								<th>사용한 적립금</th>
								<td class="fw-600" style="color:red"><?=number_format($rowOrder["사용마일리지"])?>point</td>
							</tr>
							<tr>
								<th>할인쿠폰</th>
								<td class="fw-600" style="color:red"><?=number_format($rowOrder["할인쿠폰"])?>원</td>
							</tr>
							<tr>
								<th>결제금액</th>
								<td class="fw-600"><?=number_format($rowOrder["총결제금액"])?>원</td>
							</tr>
						</tbody>
					</table>

						<div class="mt-4">
							<a href="hanc_my.php" class="btn-block btn btn-dark mb-3 fs-0">나의 수강 목록</a>
						</div>
					</div>
					
				</div>
			</div>
		</section>
</body>


<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_hanc.php"; ?>

<script>
 $('.nav_bottom li[data-name="channelmade"]').addClass('active');
</script>
</html>