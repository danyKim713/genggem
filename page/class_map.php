<!DOCTYPE HTML>
<html lang="en">
<?
	include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<body class="">

<header class="header top_fixed">
	<h2 class="header-title text-center fw-500"><img src="./assets/img/core-img/favicon.png" width="25px" class="mb-1"> 지도보기</h2>
</header>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div id="daum_map" class="col-sm-10 col-lg-6 col-xl-4 p-2 text-center" style="height:600px">
					지도
				</div>
			</div>
		</div>
		<div class="remodal-footer text-center">
			<button class="btn btn-info btn-sm fs-0" onClick="parent.close();">닫기</button>
		</div>
	</section>
</body>

<? 

$rowS['store_addr'] = $address;
$rowS['store_name'] = $name;
include "_kakao_map.php"; 

?>

</html>