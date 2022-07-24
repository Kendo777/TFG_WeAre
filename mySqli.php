<?php

$hostname = "localhost";
$db = "we_are";
$user = "root";
$pwd = "";

$mySqli = new mysqli($hostname,$user,$pwd,$db);

function mysql_fix_string($mysqli,$string)
{
	if(get_magic_quotes_gpc())
	{
		$string = stripslashes($string);
	}
	return $mysqli->real_escape_string($string);
}
function mysql_client_db($db)
{
	return new mysqli($GLOBALS['hostname'],$GLOBALS['user'],$GLOBALS['pwd'],$db);
}
?>