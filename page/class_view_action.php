<?php 
$NO_LOGIN = true;
include "./inc_program.php";


include "../common/include/incDeclaration.php";     // ��ü ���α׷� �������
include "../common/include/incDBAgent.php";     // ��ü ���α׷� �������
include "../common/include/incLib.php";     // ��ü ���α׷� �������

// �ܺ� ��ü ����
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strAction   = $_POST['txtAction']; 
$strRecordNo = $_POST['txtRecordNo'];  // ���Ǳ�ID





if (trim($strAction) == "COACHZZIM") {  // '��ġ��' ��ư Ŭ����


    // ��ġ���� �������� ��������
    $query  = " SELECT A.co_id, A.member_id, B.UID   \n";
    $query .= " FROM   tbl_coach A, tbl_member B \n";
    $query .= " WHERE  A.co_id = '{$strRecordNo}'   \n";    
    $query .= " AND    A.use_flg = 'AD005001'   \n";    //  ������� ��ġ��
    $query .= " AND    A.member_id = B.member_id   \n";

    $rowCoach = db_select($query); 

    // ������ ��������
    $query  = " SELECT COUNT(cz_id) AS cnt   \n";
    $query .= " FROM   tbl_coach_zzim   \n";
    $query .= " WHERE  co_id = '{$strRecordNo}'   \n";    // ��ġ���̵�
    $query .= " AND    co_member_id = '{$rowCoach["member_id"]}'   \n";    // ��ġ(ȸ��ID)
    $query .= " AND    isrt_user = '{$ck_login_member_pk}'   \n";     // ���ȸ�� ID

    $rowZZim = db_select($query); 



    if ($rowZZim["cnt"] > 0) {  // ���ƿ� �̸� ����
        $query  = " DELETE FROM tbl_coach_zzim   \n";
        $query .= " WHERE  co_id = '{$strRecordNo}'   \n";    
        $query .= " AND    co_member_id = '{$rowCoach["member_id"]}'   \n";    
        $query .= " AND    isrt_user = '{$ck_login_member_pk}'   \n";    

        $result = db_query($query);

        if ($result) {
            echo "SUCCESSD";
        } 
    } else  {  // ���ƿ� �ƴϸ� ���
        $query  = " INSERT INTO tbl_coach_zzim SET  \n";
        $query .= "        co_id     = '{$strRecordNo}',  \n";   // �������� ID
        $query .= "        co_member_id = '{$rowCoach["member_id"]}',  \n";  // ��ġ(ȸ�� ID)
        $query .= "        co_uid  = '{$rowCoach["UID"]}',  \n";  // ��ġ ID
        $query .= "        isrt_user = '{$ck_login_member_pk}',  \n";  // ���ȸ�� ID
        $query .= "        isrt_dt   = NOW()  \n";
        $result = db_query($query);

        if ($result) {
            echo "SUCCESSI";
        } 
    }

} else if (trim($strAction) == "QUESTIONDEL") {  // '���Ǳ� ����' ��ư Ŭ����
	$query  = " SELECT A.lq_id, A.coach_id, A.member_id, A.member_uid, A.q_memo, A.q_img, A.isrt_dt, A.updt_dt, B.co_id   \n";
	$query .= " FROM   tbl_lesson_question A, tbl_coach B    \n";
	$query .= " WHERE  A.lq_id = '{$strRecordNo}' ";
	$query .= " AND     A.member_id = B.member_id ";
	$resultInfo = db_query($query); 

	// ÷�ε� �̹��� ����
	if (trim($rowInfo['q_img']) != "" && is_file($uploadDirectory_ABS."/LessonQuestion/".trim($rowInfo['co_id'])."/".$rowInfo['q_img'])) { 
		@unlink($uploadDirectory_ABS."/LessonQuestion/".trim($rowInfo['co_id'])."/".$rowInfo['q_img']);     
	}

	// ���Ǳ� ����
	$query  = " DELETE FROM tbl_lesson_question   \n";
	$query .= " WHERE  lq_id = '{$strRecordNo}'   \n";    
	$result = db_query($query);

	// ���� �� �����Ǿ��ٸ�
	if ($result) {
		// ���� ���Ǳۿ� �ش��ϴ� �������������̺� ����
		$query  = " DELETE FROM tbl_lesson_question_appraisal   \n";
		$query .= " WHERE  lq_id = '{$strRecordNo}'   \n";    
		$result_A = db_query($query);


		// ���� ���Ǳۿ� �ش��ϴ� �������Ǵ�������̺� ����
		$query  = " DELETE FROM tbl_lesson_question_comment_appraisal   \n";
		$query .= " WHERE  lq_id = '{$strRecordNo}'   \n";    
		$result_CA = db_query($query);

		// ���� ���Ǳۿ� �ش��ϴ� �������Ǵ��(���)
		$query  = " DELETE FROM tbl_lesson_question_comment   \n";
		$query .= " WHERE  lq_id = '{$strRecordNo}'   \n";    
		$result_C = db_query($query);

         echo "SUCCESS";
	} else {
         echo "���Ǳ� ������ �����߽��ϴ�. �����ڿ��� �����ϼ���.";
	}
}

        


?>
