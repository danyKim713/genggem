<? include  "include_save_header.php"; ?>
<?
if (!$store_name) {
    msg_page("스토어/상호를 입력해 주세요");
 }

 if (!$store_area1_id) {
     msg_page("지역/도시를 선택해 주세요.");
 }
  if (!$store_area2_id) {
     msg_page("세부지역을 선택해 주세요.");
 }
  if (!$store_cate_id) {
     msg_page("업종을 선택해 주세요.");
 }
   if (!$store_tel) {
     msg_page("전화번호를 입력해 주세요.");
 }
  if (!$store_addr) {
     msg_page("스토어/사업장 주소를 입력해 주세요.");
 }

if (!$store_addr_detail) {
    msg_page($dic["Please_enter_address_details"]);
}

if (!$store_desc) {
    msg_page($dic["Please_enter_your_franchise_info"]);
}

$store_code ="S". rand(11111111,99999999);
$use_yn = "N";

$rand_id = rand(1111111,9999999);
$uid_duple_cnt =  db_count("tbl_store", "storeUID  ='$rand_id'  ", "storeUID");
if ($uid_duple_cnt > 0  ) {
    $rand_id = rand(1111111,9999999);
    $uid_duple_cnt =  db_count("tbl_store", "storeUID  ='$rand_id'  ", "storeUID");
    if ($uid_duple_cnt > 0  ) {
        $rand_id = rand(1111111,9999999);
        $uid_duple_cnt =  db_count("tbl_store", "storeUID  ='$rand_id'  ", "storeUID");
    }
}

$storeUID = $rand_id;

$query = "insert into tbl_store set ";
$query .= "storeUID='$storeUID',";
$query .= "store_name='$store_name',";
$query .= "국가코드='$국가코드',";
$query .= "store_cate_id='$store_cate_id',";
//$query .= "store_area0_id='$store_area0_id',";
$query .= "store_area1_id='$store_area1_id',";
$query .= "store_area2_id='$store_area2_id',";
$query .= "store_type	='',";
$query .= "store_code='$store_code',";
$query .= "store_addr='$store_addr',";
$query .= "store_addr_detail	='$store_addr_detail	',";
$query .= "store_tel='$store_tel',";
$query .= "store_desc='$store_desc',";
$query .= "store_saving_rate='$store_saving_rate',";
$query .= "use_yn='$use_yn',";
$query .= "reg_member_id	='{$rowMember['member_id']}',";
$query .= "regdate	=NOW(),";
$query .= "state	='가맹점 신규신청'";

//echo $query;


$result = db_query($query);

$rowMax = db_select("select max(store_id) as store_id from tbl_store");
$pk = $rowMax['store_id'];



foreach ($_FILES["file"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["file"]["tmp_name"][$key];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
        $name = basename($_FILES["file"]["name"][$key]);
        //move_uploaded_file($tmp_name, "data/$name");

		$filename = file_upload($tmp_name, $name, $_SERVER['DOCUMENT_ROOT']."/_UPLOAD/");

		db_query("insert into tbl_store_image set store_id='$pk', filename='$filename'");
    }
}

msg_top_page("수정되었습니다. 관리자 확인 후 게재됩니다.","store_set.php");