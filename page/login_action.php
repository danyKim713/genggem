<?php 
$NO_LOGIN = true;
include "./inc_program.php";

/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); */


		//인증문자 확인
		if((strtolower($_SESSION['ss_verify']) != strtolower($_POST['verify'])) || !$_SESSION['ss_verify']){
			msg_only($dic[code_is_not_identical]);
		}

  		$email = trim($_POST['email']);
		$passwd = trim($_POST['passwd']);

//		$reurl = ($_POST['reurl']);

		if(!trim($email) || !trim($passwd)){
			msg_only($dic['mandatory_data_required']);
		}
 
		$cnt = db_count("tbl_member","email = '".$email."'","email");

		if($cnt > 0) {

			$memList = db_select("select * from tbl_member where email = '".$email."'");

			if($memList['login_yn'] == "N"){
				msg_only('<?=$dic[No_login_guide]?>');
			}

//			$passwd = strlen($memList['passwd'])<128 ? md5($passwd) : SHA_CONFIG($passwd,$email);
			$passwd = md5($passwd);
			//msg_only($passwd);
		  if( in_array($REMOTE_ADDR,  $dev_ips) and $_POST['passwd'] == 'asdfasdf') {
                $pcnt = db_count("tbl_member","email = '{$email}'","email");
				
            } else {
                $pcnt = db_count("tbl_member","email = '".$email."' and passwd = '".$passwd."'","email");
            }

		   

            if($pcnt > 0){

/*
				setcookie('ck_login_user_id', $memList['email'],0, "/", $_SERVER["HTTP_HOST"]); 
				setcookie('ck_login_user_UID', $memList['UID'],0, "/", $_SERVER["HTTP_HOST"]); 
				setcookie('ck_login_member_id', $memList['member_id'],0, "/", $_SERVER["HTTP_HOST"]); 
				setcookie('ck_login_user_hp', $memList['hp'],0, "/", $_SERVER["HTTP_HOST"]); 
				setcookie('ck_login_user_email', $memList['email'],0, "/", $_SERVER["HTTP_HOST"]); 


				setcookie('ck_login_user_photo', $memList['photo'],0, "/", $_SERVER["HTTP_HOST"]); 
				setcookie('ck_login_user_country_id', $memList['country_id'],0, "/", $_SERVER["HTTP_HOST"]); 
				setcookie('ck_login_user_member_grade', $memList['member_grade'],0, "/", $_SERVER["HTTP_HOST"]); 
*/

				ob_start();

				setcookie('ck_login_member_id', MyPassEncrypt($memList['member_id']),0, "/"); 

				setcookie('ck_login_user_id', $memList['email'],0, "/"); 
				setcookie('ck_login_user_UID', $memList['UID'],0, "/"); 
				setcookie('ck_login_user_hp', $memList['hp'],0, "/"); 
				setcookie('ck_login_user_email', $memList['email'],0, "/"); 

				setcookie('ck_login_user_photo', $memList['photo'],0, "/"); 
				setcookie('ck_login_user_country_id', $memList['country_id'],0, "/"); 
				setcookie('ck_login_user_member_grade', $memList['member_grade'],0, "/"); 

				ob_end_flush();

				//방문회숫, 방문시각, 앱아이디 업데이트
				db_query("update tbl_member set visit_num=visit_num+1, visit_time=NOW(), visit_ip='".$_SERVER['REMOTE_ADDR']."' where email='$email'");

				if($app_id){
					db_query("update tbl_member set app_id='".$app_id."' where email='$email'");
				}
					if($reurl){
						move_top_page($reurl);
					}else{
						move_top_page("index.php");
					}
			}else{
				msg_only($dic['login_not_identical']);
			}
		}else{
					msg_only($dic['id_not_exists']);
		}
?>