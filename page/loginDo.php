<?
ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
ini_set("url_rewriter.tags","");        // 링크에 PHPSESSID가 따라다니는것을 무력화함
session_cache_limiter("no-cache");
session_start();


//  파일 Include
include "../common/include/incLang.php";
include "../common/include/incDBAgent.php";         // Database
include "../common/include/incLib.php";             // 라이브러리

//  외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();


//  Class 정의
class CMemberLoginDo {
    // 변수 선언
    private $strMemberID;  // 관리자 아이디
    private $strMemberPwd; // 관리자 비밀번호

    function __construct() {
    }

    function __destruct() {
    }

    function __set($pName, $pValue) {
        $this->$pName = trim($pValue);
    }

    function __get($pName) {
        return $this->$pName;
    }

    // 사용자 정의함수
    // 회원 로그인 처리
    public function fnLoginDo() {
        global $clsDBAgent;
        global $clsLib;
        global $biko_login;

        // 변수선언 및 초기화
        $strSQL = "";
        // 입력한 정보(아이디, 비밀번호)와 일치하고 현재 계정정보를 사용하고 있는 회원 검색
        $strSQL  = " SELECT mb_id, mb_level, bikopay_code \n";
        $strSQL .= " FROM   sysT_Member \n";
        $strSQL .= " WHERE  mb_id = '{$this->strMemberID}' \n";
        $strSQL .= " AND    mb_pwd = MD5('{$this->strMemberPwd}') \n";
        $clsDBAgent->strSQL = $strSQL;
        $oRs_Member = $clsDBAgent->fnQuery();

        $nMemberCnt = mysql_num_rows($oRs_Member);

        if ($nMemberCnt == 0) {
            $clsLib->fnAlertMsg($biko_login[5]);
            unset($clsLib);
            exit;
        }

        $RS_Member = mysql_fetch_array($oRs_Member);

        $_SESSION["S_MEMBERID"]   = $RS_Member["mb_id"];
        $_SESSION["S_MEMBERAUTH"] = $RS_Member["mb_level"];
        if ($RS_Member["bikopay_code"] != "") {
            $_SESSION["S_BIKOPAY"] = "BIKOMEMBER";
        } else { 
            $_SESSION["S_BIKOPAY"] = "";
        }

        // 최종접속일, 접속IP 수정
        $strSQL  = " UPDATE sysT_Member SET \n";
        $strSQL .= "        last_logindt    = NOW(), \n";
        $strSQL .= "        login_ip        = '{$_SERVER["REMOTE_ADDR"]}', \n";
        $strSQL .= "        updt_dt         = NOW() \n";
        $strSQL .= " WHERE  mb_email = '{$this->strMemberID}' \n";

        $clsDBAgent->strSQL = $strSQL;
        $oRs = $clsDBAgent->fnQuery();

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <script src="/common/script/jquery-1.8.3.min.js"></script>
</head>
<body>
    <script>
        $("#frmTmp", parent.document).attr("action", "/z_bikopay/main.php");
        $("#frmTmp", parent.document).attr("target", "");
        $("#frmTmp", parent.document).submit();
    </script>
</body>
</html>

<?
    }

    // 회원 로그아웃 처리
    public function fnLogOutDo() {
		global $clsLib;

        $_SESSION["S_MEMBERID"]   = "";
        $_SESSION["S_MEMBERAUTH"] = "";
        $_SESSION["S_BIKOPAY"]    = "";
        session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <script src="/common/script/jquery-1.8.3.min.js"></script>
</head>
<body>
    <script>
        $("#frmLogout", parent.document).attr("action", "/z_bikopay/login.php");
        $("#frmLogout", parent.document).attr("target", "");
        $("#frmLogout", parent.document).submit();
    </script>
</body>
</html>

<?
    }
}

// 객체생성
$clsMemberLoginDo = new CMemberLoginDo();

// 변수설정
$clsMemberLoginDo->strAction     = $_REQUEST["txtAction"];

if ($clsMemberLoginDo->strAction == "MBLOGIN") {
    $clsMemberLoginDo->strMemberID   = $_POST["txtMBID"];
    $clsMemberLoginDo->strMemberPwd  = $_POST["txtMBPWD"];
    $clsMemberLoginDo->fnLoginDo();
}
else if ($clsMemberLoginDo->strAction == "MBLOGOUT") {
    $clsMemberLoginDo->fnLogOutDo();
}

// 객체소멸
unset($clsMemberLoginDo);
?>
