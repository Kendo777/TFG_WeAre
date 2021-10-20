<?php

require_once("mySqli.php");
header('Access-Control-Allow-Origin: *');
header('content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
function getProductsAsJson($mySqli){
	
	$sql = $mySqli->prepare("SELECT * FROM items ORDER BY itemName");
	if(!$sql)
	{
		echo "aqui";
		die($mySqli->error);
	}
	$sql->execute();
	$result = $sql->get_result();

	if(!$result){
		echo $mysqli->error;
	}else{
		$json = [];
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$aux = [];
            $aux["id"] = $row["itemId"];
            $aux["name"] = $row["itemName"];
            $aux["prize"] = $row["prize"];
            $aux["description"] = $row["description"];
            $aux["shippment"] = $row["extra"];
            $aux["stock"] = $row["stock"];
            if(file_exists("css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].".png"))
    			$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/ItemImg/".$row["itemId"].$row["itemName"].".png";
  			else //If the image doesnt exists we give a default one
			{
				$sqlAux= $mySqli->prepare("SELECT * FROM categories INNER JOIN classification ON categories.categoryId=classification.categoryId INNER JOIN items ON classification.itemId=items.itemId WHERE items.itemId=?");
				$sqlAux->bind_param("i",$row["itemId"]);
				$sqlAux->execute();
				$resultAux=$sqlAux->get_result();
				$rowAux=$resultAux->fetch_assoc();

				if(file_exists("css".DIRECTORY_SEPARATOR."Default".DIRECTORY_SEPARATOR.$rowAux['name']."Default.jpg"))
				{
				  $aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/".$rowAux['name']."Default.jpg";
				}
				else
				{
					$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/itemDefault.jpg";
				}
				$aux["category"] = $rowAux['name'];
			}
            array_push($json, $aux);
    	}
	return json_encode($json);
	}
}

function getSearchedProductsAsJson($mySqli,$search){
	
	$sql = $mySqli->prepare("SELECT * FROM items WHERE itemName LIKE ? ORDER BY itemName");
	$compare = "%".$search."%";
	$sql->bind_param("s",$compare);
	$sql->execute();
	$result = $sql->get_result();

	if(!$result){
		echo $mysqli->error;
	}else{
		$json = [];
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$aux = [];
            $aux["id"] = $row["itemId"];
            $aux["name"] = $row["itemName"];
            $aux["prize"] = $row["prize"];
            $aux["description"] = $row["description"];
            $aux["shippment"] = $row["extra"];
            $aux["stock"] = $row["stock"];
            if(file_exists("css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].".png"))
    			$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/ItemImg/".$row["itemId"].$row["itemName"].".png";
  			else //If the image doesnt exists we give a default one
			{
				$sqlAux= $mySqli->prepare("SELECT * FROM categories INNER JOIN classification ON categories.categoryId=classification.categoryId INNER JOIN items ON classification.itemId=items.itemId WHERE items.itemId=?");
				$sqlAux->bind_param("i",$row["itemId"]);
				$sqlAux->execute();
				$resultAux=$sqlAux->get_result();
				$rowAux=$resultAux->fetch_assoc();

				if(file_exists("css".DIRECTORY_SEPARATOR."Default".DIRECTORY_SEPARATOR.$rowAux['name']."Default.jpg"))
				{
				  $aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/".$rowAux['name']."Default.jpg";
				}
				else
				{
					$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/itemDefault.jpg";
				}
				$aux["category"] = $rowAux['name'];
			}
            array_push($json, $aux);
    	}
	return json_encode($json);
	}
}

function getProductsOrderByAsJson($mySqli, $orderBy){
	
	if($orderBy == "name")
		$sql = $mySqli->prepare("SELECT * FROM items ORDER BY itemName");
	else if($orderBy == "prize")
		$sql = $mySqli->prepare("SELECT * FROM items ORDER BY prize");
	$sql->execute();
	$result = $sql->get_result();

	if(!$result){
		echo $mysqli->error;
	}else{
		$json = [];
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$aux = [];
            $aux["id"] = $row["itemId"];
            $aux["name"] = $row["itemName"];
            $aux["prize"] = $row["prize"];
            $aux["description"] = $row["description"];
            $aux["shippment"] = $row["extra"];
            $aux["stock"] = $row["stock"];
            
            if(file_exists("css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].".png"))
    			$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/ItemImg/".$row["itemId"].$row["itemName"].".png";
  			else //If the image doesnt exists we give a default one
			{
				$sqlAux= $mySqli->prepare("SELECT * FROM categories INNER JOIN classification ON categories.categoryId=classification.categoryId INNER JOIN items ON classification.itemId=items.itemId WHERE items.itemId=?");
				$sqlAux->bind_param("i",$row["itemId"]);
				$sqlAux->execute();
				$resultAux=$sqlAux->get_result();
				$rowAux=$resultAux->fetch_assoc();

				if(file_exists("css".DIRECTORY_SEPARATOR."Default".DIRECTORY_SEPARATOR.$rowAux['name']."Default.jpg"))
				{
				  $aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/".$rowAux['name']."Default.jpg";
				}
				else
				{
					$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/itemDefault.jpg";
				}
				$aux["category"] = $rowAux['name'];
			}

            array_push($json, $aux);
    	}
	return json_encode($json);
	}
}

function getFiltredProductsAsJson($mySqli,$filter){
	
	$sql = $mySqli->prepare("SELECT * FROM items WHERE itemName LIKE ? ORDER BY itemName");
	$compare = "%".$search."%";
	$sql->bind_param("s",$compare);
	$sql->execute();
	$result = $sql->get_result();

	if(!$result){
		echo $mysqli->error;
	}else{
		$json = [];
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$aux = [];
            $aux["id"] = $row["itemId"];
            $aux["name"] = $row["itemName"];
            $aux["prize"] = $row["prize"];
            $aux["description"] = $row["description"];
            $aux["shippment"] = $row["extra"];
            $aux["stock"] = $row["stock"];
            if(file_exists("css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].".png"))
    			$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/ItemImg/".$row["itemId"].$row["itemName"].".png";
  			else //If the image doesnt exists we give a default one
			{
				$sqlAux= $mySqli->prepare("SELECT * FROM categories INNER JOIN classification ON categories.categoryId=classification.categoryId INNER JOIN items ON classification.itemId=items.itemId WHERE items.itemId=?");
				$sqlAux->bind_param("i",$row["itemId"]);
				$sqlAux->execute();
				$resultAux=$sqlAux->get_result();
				$rowAux=$resultAux->fetch_assoc();

				if(file_exists("css".DIRECTORY_SEPARATOR."Default".DIRECTORY_SEPARATOR.$rowAux['name']."Default.jpg"))
				{
				  $aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/".$rowAux['name']."Default.jpg";
				}
				else
				{
					$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/itemDefault.jpg";
				}
				$aux["category"] = $rowAux['name'];
			}
            array_push($json, $aux);
    	}
	return json_encode($json);
	}
}

function getCategoriesAsJson($mySqli){
	
	$sql = $mySqli->prepare("SELECT * FROM items WHERE itemName LIKE ?");
	$compare = "%".$search."%";
	$sql->bind_param("s",$compare);
	$sql->execute();
	$result = $sql->get_result();

	if(!$result){
		echo $mysqli->error;
	}else{
		$json = [];
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$aux = [];
            $aux["id"] = $row["itemId"];
            $aux["name"] = $row["itemName"];
            $aux["prize"] = $row["prize"];
            $aux["description"] = $row["description"];
            $aux["shippment"] = $row["extra"];
            $aux["stock"] = $row["stock"];
            if(file_exists("css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].".png"))
    			$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/ItemImg/".$row["itemId"].$row["itemName"].".png";
  			else //If the image doesnt exists we give a default one
			{
				$sqlAux= $mySqli->prepare("SELECT * FROM categories INNER JOIN classification ON categories.categoryId=classification.categoryId INNER JOIN items ON classification.itemId=items.itemId WHERE items.itemId=?");
				$sqlAux->bind_param("i",$row["itemId"]);
				$sqlAux->execute();
				$resultAux=$sqlAux->get_result();
				$rowAux=$resultAux->fetch_assoc();

				if(file_exists("css".DIRECTORY_SEPARATOR."Default".DIRECTORY_SEPARATOR.$rowAux['name']."Default.jpg"))
				{
				  $aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/".$rowAux['name']."Default.jpg";
				}
				else
				{
					$aux["img"] = "https://apimlozanoo20.000webhostapp.com/OnlineShop/css/Default/itemDefault.jpg";
				}
			}
            array_push($json, $aux);
    	}
	return json_encode($json);
	}
}

if(isset($_GET['search'])) {

	$get = mysql_fix_string($mySqli,$_GET['search']);

	$data = getSearchedProductsAsJson($mySqli,$get);
	//var_dump($data);
	header('Content-type: application/json');
	echo $data;
}
else if(isset($_GET['filter']))
{
	$get = mysql_fix_string($mySqli,$_GET['filter']);

	$data = getFiltredProductsAsJson($mySqli,$get);
	//var_dump($data);
	header('Content-type: application/json');
	echo $data;
}
else if(isset($_GET['orderBy']))
{
	$get = mysql_fix_string($mySqli,$_GET['orderBy']);

	$data = getProductsOrderByAsJson($mySqli,$get);
	//var_dump($data);
	header('Content-type: application/json');
	echo $data;
}
else
{
	$data = getProductsAsJson($mySqli);
	//var_dump($data);
	header('Content-type: application/json');
	echo $data;
}

?>