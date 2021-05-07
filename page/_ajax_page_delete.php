<?
/**
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
**/
@session_start();

extract($_POST);

include $_SERVER["DOCUMENT_ROOT"] . "/_PROGRAM_inc/include_default.php";

$query = "delete from gf_page_article where pk_page_article = '{$pk_page_article}'";
db_query($query);

echo "SUCCESS";