<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body>
<?
$_TITLE = $dic[Send_history];
$_BACK_LINK = "";
$sub = true
?>

<?
include "_inc_avalable_balance.php";
$json = json_decode($response, true);

//var_dump($response);

if($json['message']=="Unauthenticated."){
	?>
	<script>
		top.location.href = "wallet_login.php?go=chc_send_history.php";			
	</script>	
	<?
	exit;
}
?>

        <? include "./inc_Top.php"; ?>

          <form name="frm_page" id="frm_page" method="get">
            <input type="hidden" name="pageNo" id="pageNo" value="<?=$_GET['pageNo']?>">
          </form>

          <section class="wrap-wallet">
            <div class="container header-top">
              <div class="row align-items-center justify-content-center">
                <div class="col-sm-10 col-lg-6 col-xl-4 p-3">
                  <article class="box-ver2 mb-3">
                    <div class="p-3 text-center">
                      <label>CHC Amount</label>
                        <p class="fs-05 mb-0 font-2 fw-600">
                          <?= 소수n자리까지표시(get_코인_withdraw_available("chc", $json),6)?>
                        </p>
                    </div>
                  </article>
                  <article class="box-ver2">
                    <div class="con-list">
                      <ul class="send-list page no-style pl-0 mb-0" id="page1">
                        <?php
if(!$pageNo){
	$pageNo = 1;
}
 
$pageScale = 7;

$pageStartNo = ($pageNo -1)*$pageScale;

$orderBy = " ORDER BY A.regdate DESC ";


$start_from= $_GET['start_from'];
$end_to= $_GET['end_to'];
	
if ($start_from == "") {
    $start_from = date("Y-m-d", mktime(0,0,0,date("m")-10, date("d"), date("Y")));
}
if ($end_to == "") {
    $end_to = date("Y-m-d"); //진짜
}


$where = " where A.member_id = '".$member_id."'";
 
if ($start_from) {
    $where .= " and  left(A.regdate,10)  >= '$start_from'";
   }
if ($end_to) {
    $where .= " and  left(A.regdate,10)  <= '$end_to'";
}

$start = ($pageNo-1)*$pageScale;

$query = "select B.*, A.* from tbl_chc_send_history A 
				INNER JOIN tbl_member B
                	ON A.member_id = B.member_id
".$where. $orderBy;

$num = mysqli_num_rows(db_query($query));


$query .= " LIMIT ".$start.", ".$pageScale;

//echo $query;
//echo $where;
$result = db_query($query);


$display = $num - ($pageNo-1)*$pageScale;
?>

<?php
for ($i = 0; $i < mysqli_num_rows($result); $i++) {
	$row = mysqli_fetch_array($result);
?>

                            <li class="content">
                              <div class="info">
                                <label class="fs--2 color-5">Address</label>
                                <p class="p-history mb-1 fs--1">
                                  <?=$row['foreign_blockchain_address']?>
                                </p>
                                <p class="mb-0 fs--2 fw-500 color-7">
                                  <span><?php echo date("Y-m-d",strtotime($row['regdate']))?></span>
                                  <span><?php echo date("H:i:s",strtotime($row['regdate']))?></span>
                                </p>
                                <!--<p class="mb-0 fs--1 fw-500 color-7">
                                            <span><?php echo strtotime("Y-m-d",$row['transmit_date'])?></span>
                                            <span><?php echo strtotime("H:i:s",$row['transmit_date'])?></span>
                                        </p>-->
                              </div>

                              <div class="sum text-right">
                                <p class="fw-700 fs-005 m-0">
                                  <?=-($row['amount'])?><span class="fw-300 fs--1 color-6"> CHC</span></p>
                                <p class="fs--1 m-0 text-success <?php $row['success_yn'] =="N"? " text-danger " :" text-success "?>">
                                  <?php echo $dic[$row['success_yn']=="N"?"FAIL":"SUCCESS"]?>
                                </p>
                              </div>
                            </li>

                            <?}?>


                      </ul>


                      <?php
if (mysqli_num_rows($result) ==0) { ?>
                        <div class="none-info">
                          <?=$dic['You_have_no_history']?>
                        </div>
                        <? } ?>
                    </div>

                  </article>
                  <!--pagination-->
                  <div class="mt-3">
                    <? include ("_paging.php");?>
                      <!-- <ul class="pagination justify-content-center">
                            <li class="page-item"><a class="page-link" href="javascript:void(0)"><span class="icon ic-left-arrow"></span></a></li>
                            <li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0)">4</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0)">5</a></li>
                            <li class="page-item"><a class="page-link" href="#"><span class="icon ic-right-arrow"></span></a></li>
                        </ul> -->
                  </div>
                  <!--pagination-->
                </div>
              </div>
            </div>
          </section>
          <? include "./inc_Bottom.php"; ?>
    </body>

</html>
