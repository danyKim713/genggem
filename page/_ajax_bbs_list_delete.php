<?
@session_start();

$strRecordNo = $_POST['txtRecordNo']; 

include "include_save_header.php";



$query = "delete from  gf_channel_bbs where pk_channel_bbs = '{$strRecordNo}' ";

$result = db_query($query);

if ($result) {
    echo "SUCCESS";
}
?>