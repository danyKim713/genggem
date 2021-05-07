<? 
include "include_save_header.php";


$strUID  = trim($_POST["txtUID"]);
$nGPay   = trim($_POST["txtGPay"]);

$number_regex    = "/^[0-9]+$/";   // 숫자

// 신청정보
$query  = " SELECT UID, name FROM  tbl_member    \n";
$query .= " WHERE  UID = '{$strUID}'  \n";
$row_info = db_select($query);

if ($row_info["UID"] != "") {
    echo "SUCCESS@".$row_info["name"];
} else {
    echo "FAILED@존재하지 않는 UID입니다.";
}

?>