<?php
require_once "include_save_header.php";

extract($_POST);
/**
			reg_member_id: '<?=$rowStore['reg_member_id']?>',
			coin: 지불코인,
			원화결제금액: 원화결제금액,
			지불화폐총금액: 지불화폐총금액,
			적립포인트: 적립포인트
**/

$query = "select * from tbl_store where reg_member_id = '$reg_member_id'";
$rowStore = db_select($query);

if($coin == "bkp"){
	//db처리
	//amoutn-보유량 이상
	if(bkp_now($rowMember['email'])<$지불화폐총금액){
		echo "NOT_ENOUGH_BALANCE";
		exit;
	}
	//amoutn-금일 한도 이내
	$query = "select sum(send_amount) as sum from sysT_CoinSend where isrt_user='{$rowMember['email']}' and isrt_dt like '".date("Y-m-d")."%'";
	$rowS= db_select($query);
	if($rows['sum']+$지불화폐총금액 > 20000000){
		echo "EXCEED_TODAY";
		exit;
	}
	//amoutn-1회 천만원
	if($지불화폐총금액 > 10000000){
		echo "OVER_ONCE";
		exit;
	}

	$recipient_flg = "AD205003";

	$recipient = "decomix@naver.com";

	$status_flg = "AD716005";

	$전송방식 = "UID";
	$수신자 = $rowUID['UID'];

	$balance = $rowMember['bkpoint'] - $지불화폐총금액;

	$query = "insert into  sysT_CoinSend set ";
	$query .= "send_amount = '{$지불화폐총금액}',";
	$query .= "recipient_flg = '$recipient_flg',";
	$query .= "recipient = '{$recipient}',";
	$query .= "status_flg  = '{$status_flg }',";
	$query .= "mgr_memo  = NULL,";
	$query .= "recipient_id  = '{$recipient}',";
	$query .= "isrt_user  = '{$rowMember['email']}',";
	$query .= "isrt_dt  = NOW(),";
	$query .= "updt_user = 'admin',";
	$query .= "updt_dt = NOW()";

	db_query($query);

	$query = "select max(cs_id) as cs_id from sysT_CoinSend";
	$rowS = db_select($query);
	$s_id = $rowS['cs_id'];

	//보내는 사람
	$query = "insert into  sysT_CoinHistory set ";
	$query .= "mb_id = '{$rowMember['email']}',";
	$query .= "recipient_id = '$recipient',";
	$query .= "charge  = '0',";
	$query .= "spending  = '{$지불화폐총금액}',";
	$query .= "fee  = NULL,";
	$query .= "balance  = '{$balance}',";
	$query .= "cc_id  = NULL,";
	$query .= "charge_dt  = NULL,";
	$query .= "s_id  = '{$s_id}',";
	$query .= "cw_id  = NULL,";
	$query .= "spanding_dt  = NOW(),";
	$query .= "use_type  = 'AD458005',";
	$query .= "mgr_memo  = NULL,";
	$query .= "isrt_user  = 'admin',";
	$query .= "isrt_dt = NOW()";

	db_query($query);

	$query = "update tbl_member set bkpoint = '{$balance}' where member_id='{$rowMember['member_id']}'";
	db_query($query);

	$balance = bkp_now($recipient) + $지불화폐총금액;

	//받는 사람
	$query = "insert into  sysT_CoinHistory set ";
	$query .= "mb_id = '{$recipient}',";
	$query .= "recipient_id = '$recipient',";
	$query .= "charge  =  '{$지불화폐총금액}',";
	$query .= "spending  = '0',";
	$query .= "fee  = NULL,";
	$query .= "balance  = '{$balance}',";
	$query .= "cc_id  = NULL,";
	$query .= "charge_dt  = NOW(),";
	$query .= "s_id  = '{$s_id}',";
	$query .= "cw_id  = NULL,";
	$query .= "spanding_dt  = NULL,";
	$query .= "use_type  = 'AD458006',";
	$query .= "mgr_memo  = NULL,";
	$query .= "isrt_user  = '{$rowMember['email']}',";
	$query .= "isrt_dt = NOW()";

	db_query($query);

	$query = "update tbl_member set bkpoint = '{$balance}' where email='{$recipient}'";
	db_query($query);

	//결제내역에 기록하기

	$success_yn = "Y";
	

}else{
	//실제 전송 : user to admin
	//has_otp:N,has_fee:N

	$secret = $_SESSION['_api_secret'];
	$access_token = $_SESSION['_api_access_token'];

	$from_email = $_SESSION['_api_username'];
	$receiver_email = $_EXCHANGE_DEAL_EMAIL_PAY;
	$receiver_address = null;
	$amount = $지불화폐총금액;
	$admin_fee = 0;
	$admin_email = $_EXCHANGE_DEAL_EMAIL_PAY;
//	$otp = $otp;
//	$destination_tag = "";

	$post = array(
		"currency" => $coin,
		"from_email" => $from_email,
		"receiver_email" => $receiver_email,
		"receiver_address" => $receiver_address,
		"amount" => $amount,
		"admin_fee" => 0,
		"admin_email" => $admin_email,
		"otp" =>  null,
		"has_otp" => "N",
		"has_fee" => "N",
		"destination_tag" => $destination_tag
	);


	error_debug($post);

	$payload = "POST api/v2/send-coin-with-fee?".(urldecode(http_build_query($post)));

	$_SIGNATURE = hash_hmac('sha256', $payload,  $secret);

	error_debug("payload:".$payload);
	error_debug("secret:".$secret);
	error_debug("_SIGNATURE :".$_SIGNATURE );

	//echo $_SIGNATURE;
	//echo PHP_EOL;
	//echo $access_token;

	$json_encoded = json_encode($post);

	error_debug($json_encoded);

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "{$_EXCHANGE_SERVER_URL_PAY}/api/v2/send-coin-with-fee?signature={$_SIGNATURE}",
	  CURLOPT_USERAGENT => $_USER_AGENT,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,

		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_POST => true,

	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => $json_encoded,
	  CURLOPT_HTTPHEADER => array(
		"accept: application/json",
		"content-type: application/json",
		"authorization: Bearer {$access_token}",
		"cache-control: no-cache",
		"User-Agent: {$_USER_AGENT}"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	//  echo "cURL Error #:" . $err;
	} else {
	//  echo $response;
	}

	error_debug($response);


	$json = json_decode($response, true);

	//var_dump($response);

	if($json['message'] == "success"){
		$success_yn = "Y";
	}else{
		$success_yn = "N";
		echo "FAIL";
		exit;
	}
}

if($success_yn == "Y"){
	$query = "insert into tbl_store_payment set ";
	$query .= "member_id = '{$rowMember['member_id']}',";
	$query .= "store_id = '{$rowStore['store_id']}',";
	$query .= "결제상태 = '결제완료',";
	$query .= "결제일시 = NOW(),";
	$query .= "결제코인 = '{$coin}',";
	$query .= "원화결제금액 = '{$원화결제금액}',";
	$query .= "코인결제금액 = '{$코인결제금액}',";
	$query .= "적립포인트 = '{$적립포인트}'";

	$result = db_query($query);
	
	if($result){
		$query = "select max(pk_store_payment) as m from tbl_store_payment";
		$rowM = db_select($query);
		$_SESSION['pk_store_payment'] = $rowM['m'];

		echo "SUCCESS";
	}
}