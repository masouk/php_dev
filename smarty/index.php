<?php
/**
 * Example Application
 *
 * @package Example-application
 */

require './_libs/smarty/libs/Smarty.class.php';
require './configs/config.php';

$conn = Mysql::connection();
//新增
/*
$count = $conn->exec("INSERT INTO `ad` SET name='GG'");
echo $count;
*/


//查詢 數組索引
//$rs = $conn->query("SELECT * FROM `ad`");
/*
//一行一行讀
while($row = $rs->fetch()){
	echo $row['name']."<br>";
}
//一次讀取全部
$result_arr = $rs->fetchAll();
foreach($result_arr as $key=>$val){
	echo $val['name']."<br>";
}
*/

//讀取資料形式
/*
 * PDO::CASE_LOWER 強制列名小寫
 * PDO::CASE_NATURAL 列名照原始大小
 * PDO::CASE_UPPER 強制列名大寫
 */
 $conn->setAttribute(PDO::ATTR_CASE,PDO::CASE_UPPER);
 $rs = $conn->query("SELECT * FROM `ad`");
 /*
  * PDO::FETCH_ASSOC 關連數組形式
  * PDO::FETCH_NUM 數字索引
  * PDO::FETCH_BOTH 以上兩者並存
  * PDO::FETCH_OBJ 物件形式
  */
 $rs->setFetchMode(PDO::FETCH_OBJ);
 $result_obj = $rs->fetchAll();
 foreach($result_obj as $key=>$val){
	//echo $val->NAME."<br>";
 }
 
 //獲取資料某一欄位
 /*
 $rs = $conn->prepare("SELECT COUNT(*) FROM `ad`");
 $rs->execute();
 $a = $rs->fetchColumn();
 print_r($a);
 */
 
 //取最後一筆ID
 /*
 $sql = "INSERT INTO `ad` (name) VALUES(?)";
 $rs = $conn->prepare($sql);
 $rs->execute(array("hello,world"));
 echo $conn->lastInsertId(); 
 */
 
 //新增綁定
 $sql = "INSERT INTO `ad` (name,vw) VALUES(:name,:vw)";
 $rs = $conn->prepare($sql);
 $a = "ddssd";
 //$c = "errr15ss";
 $b = $c;
 $rs->bindParam(":name",$a,PDO::PARAM_STR);
 $rs->bindParam(":vw",$b,PDO::PARAM_INT);
 $rs->execute();
 
 


$smarty = new Smarty;

//$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = true;
$smarty->cache_lifetime = 120;

$smarty->assign("Name", "Fred Irving Johnathan Bradley Peppergill", true);
$smarty->assign("FirstName", array("John", "Mary", "James", "Henry"));
$smarty->assign("LastName", array("Doe", "Smith", "Johnson", "Case"));
$smarty->assign("Class", array(array("A", "B", "C", "D"), array("E", "F", "G", "H"),
                               array("I", "J", "K", "L"), array("M", "N", "O", "P")));

$smarty->assign("contacts", array(array("phone" => "1", "fax" => "2", "cell" => "3"),
                                  array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234")));

$smarty->assign("option_values", array("NY", "NE", "KS", "IA", "OK", "TX"));
$smarty->assign("option_output", array("New York", "Nebraska", "Kansas", "Iowa", "Oklahoma", "Texas"));
$smarty->assign("option_selected", "NE");

$smarty->display('index.tpl');
