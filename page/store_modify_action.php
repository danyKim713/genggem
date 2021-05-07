<? include  "include_save_header.php"; ?>
<?
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); 

if (!$store_name) {
	msg_only("상호/스토어명을 입력해 주세요");
 }

 if (!$store_addr) {
	msg_only("주소를 입력해 주세요.");
 }

if (!$store_addr_detail) {
	msg_only("상세 주소를 입력해 주세요.");
}

if (!$store_desc) {
	msg_only("스토어 정보/안내를 입력해 주세요.");
}

$store_code ="S". rand(11111111,99999999);
$use_yn = "Y";

$resultImage = db_query("select * from tbl_store_image where store_id='".$store_id."'");

while($rowImage = db_fetch($resultImage)){

	if($_FILES['file_'.$rowImage['store_image_id']]['tmp_name'] != ""){
		$filename = file_upload($_FILES['file_'.$rowImage['store_image_id']]['tmp_name'], $name, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

		$use_yn = "N";

		db_query("update tbl_store_image set filename='$filename' where store_id='".$store_id."' and store_image_id='".$rowImage['store_image_id']."'");
	}
}

foreach ($_FILES["file"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {

		$use_yn = "N";

        $tmp_name = $_FILES["file"]["tmp_name"][$key];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
        $name = basename($_FILES["file"]["name"][$key]);
        //move_uploaded_file($tmp_name, "data/$name");

		$filename = file_upload($tmp_name, $name, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

		db_query("insert into tbl_store_image set store_id='$store_id', filename='$filename'");
    }
}

//메뉴판도 동일한 로직으로 처리

$resultMenu = db_query("select * from tbl_store_menu where store_id='".$store_id."'");

while($rowMenu = db_fetch($resultMenu)){

	if($_FILES['file_'.$rowMenu['store_menu_id']]['tmp_name'] != ""){
		$filename = file_upload($_FILES['file_'.$rowMenu['store_menu_id']]['tmp_name'], $name, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

		$use_yn = "N";

	}else{
		$filename = "";
	}

	db_query("update tbl_store_menu set ".($filename ? "store_menu_image='$filename', ":"")."store_menu_name='".${"store_menu_name_".$rowMenu['store_menu_id']}."', 
		store_menu_price ='".${"store_menu_price_".$rowMenu['store_menu_id']}."', 화폐단위 ='".${"화폐단위_".$rowMenu['store_menu_id']}."' where store_id='".$store_id."' and store_menu_id='".$rowMenu['store_menu_id']."'");
}

foreach ($_FILES["store_menu_image"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {

		$use_yn = "N";

        $tmp_name = $_FILES["store_menu_image"]["tmp_name"][$key];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
        $name = basename($_FILES["store_menu_image"]["name"][$key]);
        //move_uploaded_file($tmp_name, "data/$name");

		$filename = file_upload($tmp_name, $name, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

		db_query("insert into tbl_store_menu set store_id='$store_id', store_menu_image='$filename', store_menu_name='".$store_menu_name[$key]."', store_menu_price='".$store_menu_price[$key]."',화폐단위='{$화폐단위[$key]}'");
    }
}

$query = "update tbl_store set ";
$query .= "store_name='$store_name',";
$query .= "국가코드='$국가코드',";
$query .= "store_cate_id='$store_cate_id',";
//$query .= "store_area0_id='$store_area0_id',";
$query .= "store_area1_id='$store_area1_id',";
$query .= "store_area2_id='$store_area2_id',";
$query .= "store_addr='$store_addr',";
$query .= "store_addr_detail	='$store_addr_detail	',";
$query .= "store_tel='$store_tel',";

$query .= "store_saving_rate='$store_saving_rate',";

$query .= "ceo_name='$ceo_name',";
$query .= "business_hour='$business_hour',";
$query .= "offday_info='$offday_info',";
$query .= "parking_info='$parking_info',";

if($use_yn == "N"){
	$query .= "state='가맹점 정보수정요청',";
}
$query .= "store_desc='$store_desc'";

$query .= " where store_id='".$store_id."' and reg_member_id = '".$rowMember['member_id']."'";

$result = db_query($query);


msg_top_page("수정되었습니다. 관리자 확인 후 게재됩니다.","store_set.php");