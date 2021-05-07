<?
include "include_save_header.php";


$개인율 = array(0.25, 0.25, 0.25, 0.25);
$공유보상율 = array(0.03, 0.04, 0.07, 0.10);
$추천율 = array(0.03, 0.04, 0.07, 0.10);

function 레벨구하기($참여구좌수){

    $참여CHC = $참여구좌수 * 200;

    if($참여CHC >=200 && $참여CHC < 2000){
        return 0; //1레벨
    }else if($참여CHC >= 2000 && $참여CHC < 20000){
        return 1; //2레벨
    }else if($참여CHC >= 20000 && $참여CHC < 40000){
        return 2; //3레벨
    }else if($참여CHC >= 40000){
        return 3; //VIP
    }
}


$query = "select M.*, A.* from tbl_cloud_history A, tbl_member M,  where A.member_id = M.member_id and A.참여상태 = '참여승인' and M.email = 'dongman@bitkoex.com'";
$result = db_query($query);

$idx = 0;
while($row = db_fetch($result)){
    echo $idx.PHP_EOL;

    //레벨 구하기
    $레벨인덱스 = 레벨구하기($row['참여구좌수']);
    echo $레벨인덱스.PHP_EOL;

    $기준CHC = $row['참여구좌수'] * 200 * 6;

    $계산용개인율 = $개인율[$레벨인덱스];
    $계산용공유보상율 = $공유보상율[$레벨인덱스];

    $개인보상금액 = $기준CHC * ($계산용개인율 + $계산용공유보상율) / 100;
    echo $개인보상금액.PHP_EOL;

    $유저수수료 = $개인보상금액 * 2 / 100;

    //admin_to_user API진행


}