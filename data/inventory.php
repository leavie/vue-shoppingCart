<?php
session_start();
?>
<!-- TODO: 預設一組連線資料庫資訊，假如失敗，便在瀏覽器詢問使用者，再重新連線
DO: /htdocs/switch_db_server.php -->
<?php
	$server = "127.0.0.1", $user = "root", $password = "Leavie45", $dbname = ""
	$link = new mysqli($sever, $user, $password, $dbname); // 沒有選擇資料庫
	if(!$link) die("無法連線");
	mysqli_query($link,"SET NAMES utf8");


	$insert = "INSERT INTO `inventory` (`Name` as name, `Price` as price) VALUES('', '120')";
	$select = "SELECT * FROM `inventory` WHERE 1";
	$update;
	$delete = "DELETE FROM `inventory` WHERE `name` = ''";

	// 查詢
	$result = $link->query($select);
	if(!$result) return;
//	echo  var_dump($result);

	// convert 查詢到的表格為 關聯陣列
    $row = $result->fetch_all(MYSQLI_ASSOC); // https://secure.php.net/manual/en/mysqli-result.fetch-all.php
    //echo var_dump($row); //test: 查看$row的類型

    // converts array to json
	$json = json_encode($row, JSON_NUMERIC_CHECK);

	// 將所有json的key轉換成小寫
	$lowercase_json = get_lowercase_json($json);

	// 輸出json， 目標為陣列notation
	echo "$lowercase_json";



function surrond_text() {

}

function get_lowercase_json($json) {
	// Source https://stackoverflow.com/questions/41377060/how-to-convert-json-key-in-lower-case-in-php
	// json_decode() converts json to array
	$array = json_decode($json, true);

	// key case changer. changes key recursively
	// Source php.net
	function array_change_key_case_recursive($arr)
	{
		return array_map(function($item){
			if(is_array($item))
				$item = array_change_key_case_recursive($item);
			return $item;
		},array_change_key_case($arr));
	}


	$new_array = array_change_key_case_recursive($array);

	// You expected json output
	$new_json = json_encode($new_array);

	return $new_json;
}

?>