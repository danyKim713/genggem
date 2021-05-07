<?php 
$NO_LOGIN = true;
include "./inc_program.php";

include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();
$nOPrice         = trim($_POST['txtOPrice']);      // 결제금액
$nPrice          = trim($_POST['txtPrice']);        // 실결제금액
$strOrderID      = trim($_POST['txtOrderID']);      // 주문번호
$strPayment      = trim($_POST['rdoPayment']);      // 결제수단
$strReceiptIDTmp = trim($_POST['txtReceiptID']);    // 영수증ID
$strName         = trim($_POST['txtName']);         // 신청자이름
$strTel          = trim($_POST['txtTel']);          // 전화번호
$strLecture      = trim($_POST['txtLecture']);      // 강좌ID
$nSaveMileage    = trim($_POST['txtSaveMileage']);  // 적립될 적립금
$nLectureCost    = trim($_POST['txtLectureCost']);  // 강좌비용
$nDiscountCost   = trim($_POST['txtDiscountCost']); // 할인쿠폰
$nMileage        = trim($_POST['txtMileage']);      // 사용한 적립금
$nYearCost       = trim($_POST['txtYearCost']);     // 연회비
$strHancID       = trim($_POST['txtHancID']);       // 문화센터ID 
$strMemo         = trim($_POST['txtMemo']);         // 문의사항

$number_regex    = "/^[0-9]+$/";   // 숫자

if ($strPayment == "LOPAYGEN") {  // G-Pay 결제시
    if ($nPrice > $rowMember["gpay"]) {
        echo "보유한 G-PAY가 결제금액보다 적습니다. 충전 후 결제 해 주세요.";
        exit;
    }
}

if ($nMileage != "") {

    if (!preg_match($number_regex, $nMileage)) {
        echo "사용할 GPOINT는 숫자만 입력할 수 있습니다.";
        exit;
    } 

    if ($nMileage <= 0) {
        echo '사용할 GPOINT는 0보다 커야 합니다.';
        exit;
    }

    if ($nMileage > 50000) {
        echo 'GPOINT는 50,000point까지 사용 가능합니다.';
        exit;
    }

    if ($nMileage > $rowMember["gpoint"]) {
        echo '보유한 GPOINT보다 사용하는 GPOINT가 많습니다.';
        exit;
    }

    if (($nOPrice) < $nMileage) {
        echo '사용할 GPOINT가 결제할 금액보다 많습니다.';
        exit;
    }


}


/*
// 구매할 강좌내역 가져오기
$query  = " SELECT pk_lecture, 분류명, 강좌명, 마일리지, 사용유무, 카페코드, 강좌등급, 강좌비용     \n";
$query .= " FROM   tbl_lecture    \n";
$query .= " WHERE  pk_lecture = '{$strLecture}'   \n";
$rowLecture = db_select($query);   

$rowInfo = db_select($query); 
*/

$strDT = Date('Y-m-d H:i:s');

if(strlen($strReceiptIDTmp)>8){    // PG 이용한 결제일 경우

	//access Token 가져오기
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.bootpay.co.kr/request/token?application_id=5e0c57b902f57e00289c4216&private_key=afawDIXp8vYqPABY7IcsSXeg7RF8d2e6/HcWza/vnqY=",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
		"Postman-Token: 704a8821-4fe9-48de-a812-702a195dd8dc",
		"cache-control: no-cache"
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

	$json = json_decode($response, true);
	$token = $json['data']['token'];



	//정보 가져오기
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.bootpay.co.kr/receipt/".$strReceiptIDTmp,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"Authorization: ".$token,
		"Postman-Token: 7fadde43-5960-4fb6-b6e0-fca8dc3d7460",
		"cache-control: no-cache"
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

	$json = json_decode($response, true);

	$order_id = $json['data']['order_id'];
	$strReceiptID = $json['data']['receipt_id'];
	$tid = $json['data']['payment_data']['tid'];
	

	$nOrderPrice = $json['data']['price'];
	$strPaymentMethod = $json['data']['payment_data']['pm'];
	$strCardNm = $json['data']['payment_data']['card_name'];

    $query  = " SELECT MAX(o_id) AS id   \n";
    $query .= " FROM   tbl_lecture_order     \n";
    $rowID = db_select($query); 

    $strID = "";
    if ($rowID["id"] == "") {
        $strID = 1;
    } else {

        $strID = $rowID["id"] + 1;
    }

	if ($strPayment == "LOPAYVBN") { 
	    $strBigo = "문화센터클래스신청(가상계좌)";
	} else if ($strPayment == "LOPAYCAD") { 
	    $strBigo = "문화센터클래스신청(신용카드)";
	} else if ($strPayment == "LOPAYCEL") { 
	    $strBigo = "문화센터클래스신청(휴대폰소액결제)";
	}

	$query  = " INSERT INTO tbl_lecture_order SET    \n";
    $query .= "        o_id        = '{$strID}',  \n";
    $query .= "        order_id    = '{$strOrderID}',  \n";
	$query .= "        receipt_id  = '{$strReceiptID}',  \n";
	$query .= "        t_id        = '{$tid}',  \n";
	$query .= "        t_co        = '{$strCardNm}',  \n";
	$query .= "        member_id   = '{$rowMember["member_id"]}',  \n";
	$query .= "        member_uid  = '{$rowMember["UID"]}',  \n";
    $query .= "        payment_flg = '{$strPayment}',  \n";
	$query .= "        신청자이름     = '{$strName}',  \n";
	$query .= "        신청자전화번호  = '{$strTel}',  \n";
	$query .= "        강좌PK       = '{$strLecture}',  \n";
	$query .= "        적립될마일리지  = '{$nSaveMileage}',  \n";
	$query .= "        강좌비용      = '{$nLectureCost}',  \n";
	$query .= "        연회비       = '{$nYearCost}',  \n";
	$query .= "        사용마일리지   = '{$nMileage}',  \n";
	$query .= "        할인쿠폰     = '{$nDiscountCost}',  \n";
	$query .= "        총결제금액    = '{$nPrice}',  \n";
	$query .= "        신청문화센터PK = '{$strHancID}',  \n";
	$query .= "        남길메시지    = '{$strMemo}',  \n";
	$query .= "        주문상태     = 'HNCPACOM',   \n";
	$query .= "        정산상태     = 'HNCCLYET',   \n";
	$query .= "        상태내역     = CONCAT('>> ', '{$strDT}', ' {$strBigo}'),  \n";
	$query .= "        신청일      = '{$strDT}',  \n";
	$query .= "        수정자      = '{$rowMember["member_id"]}',  \n";
	$query .= "        수정일      = '{$strDT}'  \n";

    $result = db_query($query);

    if ($result) {        
		// 사용마일리지가 있으면
		if ($nMileage != "" && $nMileage > 0) {
			//$query = " SELECT * FROM sysT_MemberMileage WHERE member_uid = '{$rowMember["UID"]}' ORDER BY mm_id DESC LIMIT 1 ";
			//$rowM = db_select($query);

			// 잔액 = 마지막잔액 - 사용마일리지
			$nBlance = $rowMember["gpoint"] - $nMileage ;

			$query  = " INSERT INTO sysT_MemberMileage SET    \n";
			$query .= "        member_uid  = '{$rowMember["UID"]}',  \n";
			$query .= "        income      = '0',  \n";
			$query .= "        expenditure = '{$nMileage}',  \n";
			$query .= "        balance     = '{$nBlance}',  \n";  
			$query .= "        od_id       = '{$strID}',  \n";  // 강좌신청ID
			$query .= "        memo        = '문화센터클래스신청',  \n";
			$query .= "        isrt_user   = '{$rowMember["member_id"]}',  \n";
			$query .= "        isrt_dt     = '{$strDT}'  \n";

			$resultM = db_query($query);

            $query  = " UPDATE tbl_member SET  \n";
            $query .= "        gpoint  = '{$nBlance}'  \n";
            $query .= " WHERE  member_id   = '{$rowMember["member_id"]}'  \n";
            $resultMem = db_query($query);
		}



		echo "SUCCESS@{$strID}";
    } else {
        echo "문화센터클래스신청이 실패했습니다. 관리자에게 문의하세요.";
    } 

} else {   // PG 이용한 결제가 아닐 경우(무통장입금이거나 GENP일때)
    $query  = " SELECT MAX(o_id) AS id   \n";
    $query .= " FROM   tbl_lecture_order     \n";
    $rowID = db_select($query); 

    $strID = "";
    if ($rowID["id"] == "") {
        $strID = 1;
    } else {

        $strID = $rowID["id"] + 1;
    }

    if ($strPayment == "LOPAYBNK") { 
        $strBigo = "문화센터클래스신청(무통장입금)";

		$query  = " INSERT INTO tbl_lecture_order SET    \n";
        $query .= "        o_id        = '{$strID}',  \n";
        $query .= "        order_id    = '{$strOrderID}',  \n";
        $query .= "        member_id   = '{$rowMember["member_id"]}',  \n";
        $query .= "        member_uid  = '{$rowMember["UID"]}',  \n";
        $query .= "        payment_flg = '{$strPayment}',  \n";
        $query .= "        신청자이름    = '{$strName}',  \n";
        $query .= "        신청자전화번호 = '{$strTel}',  \n";
        $query .= "        강좌PK      = '{$strLecture}',  \n";
   	    $query .= "        적립될마일리지  = '{$nSaveMileage}',  \n";
        $query .= "        강좌비용      = '{$nLectureCost}',  \n";
        $query .= "        연회비       = '{$nYearCost}',  \n";
        $query .= "        사용마일리지   = '{$nMileage}',  \n";
        $query .= "        할인쿠폰     = '{$nDiscountCost}',  \n";
        $query .= "        총결제금액    = '{$nPrice}',  \n";
        $query .= "        신청문화센터PK = '{$strHancID}',  \n";
        $query .= "        남길메시지    = '{$strMemo}',  \n";
        $query .= "        주문상태      = 'HNCPAWAI',   \n";
        $query .= "        정산상태      = 'HNCCLYET',   \n";
        $query .= "        상태내역      = CONCAT('>> ', '{$strDT}', ' {$strBigo}'),  \n";
        $query .= "        신청일       = '{$strDT}',  \n";
        $query .= "        수정자       = '{$rowMember["member_id"]}',  \n";
        $query .= "        수정일       = '{$strDT}'  \n";

        $result = db_query($query);

        if ($result) {
			// 사용마일리지가 있으면
			if ($nMileage != "" && $nMileage > 0) {
				//$query = " SELECT * FROM sysT_MemberMileage WHERE member_uid = '{$rowMember["UID"]}' ORDER BY mm_id DESC LIMIT 1 ";
				//$rowM = db_select($query);

				// 잔액 = 마지막잔액 - 사용마일리지
				$nBlance = $rowMember["gpoint"] - $nMileage ;

				$query  = " INSERT INTO sysT_MemberMileage SET    \n";
				$query .= "        member_uid  = '{$rowMember["UID"]}',  \n";
				$query .= "        income      = '0',  \n";
				$query .= "        expenditure = '{$nMileage}',  \n";
				$query .= "        balance     = '{$nBlance}',  \n";  
				$query .= "        od_id       = '{$strID}',  \n";  // 강좌신청ID
				$query .= "        memo        = '문화센터클래스신청',  \n";
				$query .= "        isrt_user   = '{$rowMember["member_id"]}',  \n";
				$query .= "        isrt_dt     = '{$strDT}'  \n";

				$resultM = db_query($query);

                $query  = " UPDATE tbl_member SET  \n";
                $query .= "        gpoint  = '{$nBlance}'  \n";
                $query .= " WHERE  member_id   = '{$rowMember["member_id"]}'  \n";
                $resultMem = db_query($query);
			}

            echo "SUCCESS@{$strID}";
        } else {
            echo "문화센터클래스신청(결제)이 실패했습니다. 관리자에게 문의하세요.";
			//echo $query;

        }  
    } elseif ($strPayment == "LOPAYGEN") { 
        $strBigo = "문화센터클래스신청(GEP)";

        $strUID = make_uniq_id();

		$query  = " INSERT INTO tbl_lecture_order SET    \n";
        $query .= "        o_id        = '{$strID}',  \n";
        $query .= "        order_id    = '{$strOrderID}',  \n";
        $query .= "        member_id   = '{$rowMember["member_id"]}',  \n";
        $query .= "        member_uid  = '{$rowMember["UID"]}',  \n";
        $query .= "        payment_flg = '{$strPayment}',  \n";
        $query .= "        신청자이름    = '{$strName}',  \n";
        $query .= "        신청자전화번호 = '{$strTel}',  \n";
        $query .= "        강좌PK      = '{$strLecture}',  \n";
   	    $query .= "        적립될마일리지  = '{$nSaveMileage}',  \n";
        $query .= "        강좌비용      = '{$nLectureCost}',  \n";
        $query .= "        연회비       = '{$nYearCost}',  \n";
        $query .= "        사용마일리지   = '{$nMileage}',  \n";
        $query .= "        할인쿠폰     = '{$nDiscountCost}',  \n";
        $query .= "        총결제금액    = '{$nPrice}',  \n";
        $query .= "        신청문화센터PK = '{$strHancID}',  \n";
        $query .= "        남길메시지    = '{$strMemo}',  \n";
        $query .= "        주문상태      = 'HNCPACOM',   \n";
        $query .= "        정산상태      = 'HNCCLYET',   \n";
        $query .= "        상태내역      = CONCAT('>> ', '{$strDT}', ' {$strBigo}'),  \n";
        $query .= "        신청일       = '{$strDT}',  \n";
        $query .= "        수정자       = '{$rowMember["member_id"]}',  \n";
        $query .= "        수정일       = '{$strDT}'  \n";

        $result = db_query($query);

        if ($result) {
            $strGPointQuery = "";

			// 사용마일리지가 있으면
			if ($nMileage != "" && $nMileage > 0) {
				//$query = " SELECT * FROM sysT_MemberMileage WHERE member_uid = '{$rowMember["UID"]}' ORDER BY mm_id DESC LIMIT 1 ";
				//$rowM = db_select($query);

				// 잔액 = 마지막잔액 - 사용마일리지
				$nBlance = $rowMember["gpoint"] - $nMileage ;

				$query  = " INSERT INTO sysT_MemberMileage SET    \n";
				$query .= "        member_uid  = '{$rowMember["UID"]}',  \n";
				$query .= "        income      = '0',  \n";
				$query .= "        expenditure = '{$nMileage}',  \n";
				$query .= "        balance     = '{$nBlance}',  \n";  
				$query .= "        od_id       = '{$strID}',  \n";  // 강좌신청ID
				$query .= "        memo        = '문화센터클래스신청',  \n";
				$query .= "        isrt_user   = '{$rowMember["member_id"]}',  \n";
				$query .= "        isrt_dt     = '{$strDT}'  \n";

				$resultM = db_query($query);

                $strGPointQuery = "        ,gpoint  = '{$nBlance}'  \n";

			}

			$query  = " INSERT INTO tbl_coin_gep SET  \n";
            $query .= "        member_id    = '{$rowMember["member_id"]}',  \n";
            $query .= "        전송유니크값 = '{$strUID}',  \n";
            $query .= "        전송유형     = 'LECTURE',  \n";
            $query .= "        상세내용     = '문화센터클래스결제',  \n";
            $query .= "        금액         = '-{$nPrice}',  \n";
            $query .= "        참고1        = '{$strID}',   \n";
            $query .= "        처리일시     = '{$strDT}'  \n";

            $result2 = db_query($query);


            $query  = " UPDATE tbl_member SET  \n";
            $query .= "        gpay    = '".($rowMember["gpay"] - $nPrice)."'  \n";
            $query .= $strGPointQuery;
			$query .= " WHERE  member_id   = '{$rowMember["member_id"]}'  \n";
            $resultMem = db_query($query);

            echo "SUCCESS@{$strID}";
        } else {
            echo "문화센터클래스신청(결제)이 실패했습니다. 관리자에게 문의하세요.";
        }  
    } else {
        echo "잘못된 접근입니다.[LA037282.]";
        exit;
    }
}

?>