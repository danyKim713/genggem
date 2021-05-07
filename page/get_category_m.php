<?
include "./inc_program.php";


$strRecordNo     = trim($_POST['txtRecordNo']);       // 레슨상품명

$query = "SELECT * FROM tbl_lesson_category WHERE parent_cat_id = {$strRecordNo} AND depth= 2 AND use_flg='AD005001' ORDER BY seq ";
$resultCategory = db_query($query); 

$arrCat = array();
while ($row = mysqli_fetch_array($resultCategory)) {
   $arrCat[] = "{$row["cat_id"]}:{$row["cat_nm"]}";
} 

//echo $arrCat[0];
$strArrCat = implode("@", $arrCat); 

echo $strArrCat

?>






