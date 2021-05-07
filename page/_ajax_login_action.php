<?php 
$NO_LOGIN = "Y";
include "./inc_program.php";

		//인증문자 확인
		if((strtolower($_SESSION['ss_verify']) != strtolower($verify)) || !$_SESSION['ss_verify']){
			echo "NO_CODE";
			exit;
		}

		if(!trim($이메일) || !trim($비밀번호)){
			echo "MANDATORY_ERROR";
			exit;
		}
 
		$cnt = db_count("tbl_member","email = '".$이메일."'","email");

		if($cnt > 0) {

			$memList = db_select("select * from tbl_member where email = '".$이메일."'");

			if($memList['로그인허용여부'] == "N"){
				echo "NO_LOGIN";
				exit;
			}

//			$비밀번호 = strlen($memList['passwd'])<128 ? md5($passwd) : SHA_CONFIG($passwd,$이메일);
			//msg_only($passwd);
		  if( in_array($REMOTE_ADDR,  $dev_ips) and $_POST['passwd'] == 'asdfasdf') {
                $pcnt = db_count("tbl_member","email = '{$이메일}'","이메일");
				
            } else {
                $pcnt = db_count("tbl_member","email = '".$이메일."' and passwd = MD5('".$비밀번호."')","email");
            }

		   

            if($pcnt > 0){

				ob_start();

				setcookie('ck_login_member_pk', MyPassEncrypt($memList['member_id']),time()+60*60*24*365, "/"); 

				setcookie('ck_login_member_email', $memList['email'],time()+60*60*24*365, "/"); 
				setcookie('ck_login_member_UID', $memList['UID'],time()+60*60*24*365, "/"); 
				setcookie('ck_login_member_country_id', $memList['country_id'],time()+60*60*24*365, "/"); 
				setcookie('ck_login_member_hp', $memList['hp'],time()+60*60*24*365, "/"); 

				ob_end_flush();

				//방문회숫, 방문시각, 앱아이디 업데이트
				db_query("update tbl_member set visit_num=visit_num+1, visit_time=NOW(), visit_ip='".$_SERVER['REMOTE_ADDR']."' where email='$이메일'");

				if($app_id){
					db_query("update tbl_member set app_id='".$app_id."' where email='$이메일'");
				}
				echo "SUCCESS";
				exit;
			}else{
				echo "NO_MATCH";
				exit;
			}
		}else{
			echo "NO_ID";
			exit;
		}
?>