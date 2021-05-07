<?
	function get_coordinate_by_address($address){
		$query = array(
			'address' => $address,
			'sensor' => 'true',
			'key' => 'AIzaSyBKbUkRI8Xj705A2EKtuKlzs-cpoh-0t_c'
		);
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?' . http_build_query($query);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

			CURLOPT_USERAGENT => 'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25'
		));

		$result = curl_exec($curl);
		curl_close($curl);

		return json_decode($result, true);
	}

	$query = "select * from tbl_store where lat='' and lng=''";
	$result = db_query($query);

	while($row = db_fetch($result)){
			// 주소가 없으면 패스
			if(empty($row['store_addr'])){
				continue;
			}
			$address = $row['store_addr'];
			$arr = get_coordinate_by_address($address);

			if($arr['status'] == "ZERO_RESULTS"){
				continue;
			}

			$lat = $arr['results'][0]['geometry']['location']['lat'];
			$lng = $arr['results'][0]['geometry']['location']['lng'];

			$query = "UPDATE tbl_store SET lat = '{$lat}', lng = '{$lng}' WHERE store_id = '{$row['store_id']}'";
			db_query($query);
	}