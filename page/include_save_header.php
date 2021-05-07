<?
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE); 
@session_start();
extract($_GET);
extract($_POST);

require_once $_SERVER["DOCUMENT_ROOT"]."/_PROGRAM_inc/include_default.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/page/lang/parse_dic.php";

require_once "inc_program.php";

$ck_login_member_pk = MyPassDecrypt($_COOKIE['ck_login_member_pk']);
$rowMember = db_select("select * from tbl_member where member_id='{$ck_login_member_pk}'");

//echo "select * from tbl_member where member_id='{$ck_login_member_pk}'";

$rowSiteConfig = db_select("select * from tbl_site_config");


if(!$NO_LOGIN && $rowMember['로그인허용여부'] == "N" && !$rowMember['pk_member']){
	msg_top_page($dic[login_denied],'/');
}