<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="./assets/css/sub.css?20190930">

<body class="mb-5">
<? 
include "./inc_nav.php"; 


?>

<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg4.jpg);">
		<h2>Help Desk</h2>
	</div>
</div>
<? include "./inc_help_nav.php"; ?>
<script>



</script>
<section class="new-arrivals-products-area">
	<div class="container">
		<div class="category-area2 mt-2">
			<article class="p-1">
				<!--tab-->
				<div id="tab-menu" class="tab-sub clearfix">
					<ul class="row align-items-center justify-content-center text-center">
						<li class="col p-0 active"><a href="gpay_charge_history.php" title="충전내역">G-PAY 충전내역</a></li>
						<li class="col p-0"><a href="gpay_history.php" title="전송/사용내역">전송/이용내역</a></li>
					</ul>
				</div>
				<!--tab-->
				

					<!--보유금액-->
					<div class="box-round mx-3 mt-3 mb-2">
						<div class="align-items-center justify-content-center text-center">
							<h2 class="mr-auto mb-0 fw-600">G-PAY 보유금액 : <?=number_format($rowMember['gpay'])?> <small>GP</small></h2>
						</div>
					</div>	
					<!--//-->

					
					<!--date-->
					<form name="frm_page" id="frm_page" method="get" action="./gpay_charge_history.php">
					<input type="hidden" name="pageNo" id="pageNo" value="<?=$pageNo?>"/>
					<div class="con-datepicker clearfix">
						<label>기간 검색</label>
						<div class="d-flex align-items-center">
							<div class="input-daterange input-group" id="datepicker">
								<input type="text" class="input-sm form-control datepicker background-10" name="sdate" value="<?=$sdate?>">
								<span class="input-group-addon color-8">-</span>
								<input type="text" class="input-sm form-control datepicker background-10" name="edate" value="<?=$edate?>">
							</div>
							<div class="ml-auto">
								<button type="submit" class="btn btn-primary btn-search"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</div>
					</form>
					<!--//date-->

					<div class="p-3 mt-3">
						<div class="list-history">
							<ul>

						<!-- 충전 내역이 없을때
						<div class="m-5 text-center">
							<span class="fs-005 color-7">충전 내역이 없습니다. </span>
						</div> -->

<?
    if(!$pageNo){
        $pageNo = 1;
    }
     
    $pageScale = 10;

    $pageStartNo = ($pageNo -1)*$pageScale;



    $arrWhere = array(); 
    if ($sdate) {
        $arrWhere[] = "  left(isrt_dt,10)  >= '$sdate'";
    }
    if ($edate) {
        $arrWhere[] .= "  left(isrt_dt,10)  <= '$edate'";
    }

    
    $strWhere = implode(" AND ", $arrWhere);

    if (trim($strWhere) != "")  $strWhere = " AND " . $strWhere;

    $start = ($pageNo-1)*$pageScale;


    $query  = " SELECT ga_id, member_id, ga_method, ga_amount, ga_amount_original, erate, etc, status_flg, isrt_dt  \n";
    $query .= " FROM   tbl_gpaycharge_apply  \n";
    $query .= " WHERE  member_id = '{$rowMember["member_id"]}'  \n";
    $query .= $strWhere;
    $query .= " ORDER BY ga_id DESC  \n";
    $query .= " LIMIT ".$start.", ".$pageScale;
    $result = db_query($query);


    $query  = " SELECT COUNT(*)  \n";
    $query .= " FROM   tbl_gpaycharge_apply  \n";
    $query .= " WHERE  member_id = '{$rowMember["member_id"]}'  \n";
    $query .= $strWhere;

    $num=db_result($query);

    $display = $num - ($pageNo-1)*$pageScale;

    while($row = db_fetch($result)){
        if ($row["status_flg"] == "CA519RET") {
            $strColor = "<font color='#ff0033'>".showNameCommonCode($row["status_flg"])."</font>";
        } else {
            $strColor = showNameCommonCode($row["status_flg"]);
        }
        

?>




								<li>
									<div class="list-info d-flex">
										<div>
											<h5 class="fs-005 mb-0 fw-400"><?=showNameCommonCode($row["ga_method"])?></h5>
											<span class="fs--1 color-7"><?=$row['isrt_dt']?> <span class="bar"></span><?=$strColor?></span>
										</div>
									    <div class="ml-auto">
									    	<p class="mb-0 color-4"><strong><?=number_format($row['ga_amount'])?></strong> <small></small></p>
									    </div>
									</div>
								</li>


<?
    }
?>

								
							</ul>
						</div>
						<div class="mt-3">
							<? include ("_paging.php");?>
						</div>
						<? include "./gpay_status.php"; ?>
					</div>
				</div>


			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_main.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="wallet"]').addClass('active');
</script>
</html>