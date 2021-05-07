<?
/**
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
**/
@session_start();

include "include_save_header.php";

$query = "update tbl_store_payment set ";
$query .= "결제상태 = '취소요청' where pk_store_payment = '$pk_store_payment'";

db_query($query);

echo "SUCCESS";