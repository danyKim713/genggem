<?
@session_start();
extract($_POST);

include "../_PROGRAM_inc/function.inc";

$secret = $_SESSION['_api_secret'];
$access_token = $_SESSION['_api_access_token'];
/**
echo $secret;
echo PHP_EOL;
echo $access_token;
**/
$_SIGNATURE = hash_hmac('sha256', "PUT api/v2/deposit-address?currency=".strtoupper($currency),  $secret);

//echo $_SIGNATURE;

$post = array(
	"currency" => strtoupper($currency)
);
$json_encoded = json_encode($post);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "{$_EXCHANGE_SERVER_URL_PAY}/api/v2/deposit-address?signature={$_SIGNATURE}",
  CURLOPT_USERAGENT => $_USER_AGENT,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS => http_build_query($post),
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: Bearer {$access_token}",
    "cache-control: no-cache",
	"User-Agent: {$_USER_AGENT}"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

error_debug($response);
error_debug($err);

curl_close($curl);

if ($err) {
//  echo "cURL Error #:" . $err;
} else {
//  echo $response;
}

$json = json_decode($response, true);

if($json['message']=="success"){
	echo "SUCCESS|".$json['data']['blockchain_address'];
}else{
	echo "FAIL";
}