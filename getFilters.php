<?php
require_once("db.php");
header('Access-Control-Allow-Origin: *');
header('content-type: application/json; charset=utf-8');

function getFiltersAsJson($mySqli){
	
	$sql = $mySqli->prepare("SELECT * FROM categories ORDER by name");
	$sql->execute();
	$result = $sql->get_result();

	if(!$result){
		echo $mysqli->error;
	}else{
		$json = [];
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$aux = [];
            $aux["name"] = $row["name"];
            array_push($json, $aux);
    	}
	return json_encode($json);
	}
}

$data = getFiltersAsJson($mySqli);
//var_dump($data);
header('Content-type: application/json');
echo $data;

?>