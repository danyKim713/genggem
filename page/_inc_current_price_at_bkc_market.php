<?
$secret = $_SESSION['_api_secret'];
$access_token = $_SESSION['_api_access_token'];

$_SIGNATURE = hash_hmac('sha256', "GET api/v2/prices/bkc-{$coin}",  $secret);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "{$_EXCHANGE_SERVER_URL_PAY}/api/v2/prices/bkc-{$coin}?signature={$_SIGNATURE}",
  CURLOPT_USERAGENT => $_USER_AGENT,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
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

$json_current_price_at_bkc_market = json_decode($response, true);

if($json_current_price_at_bkc_market['message']!="success"){
	echo "FAIL";
	exit;
}