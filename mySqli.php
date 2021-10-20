<?php

$hostname = "localhost";
$db = "reino_del_terror";
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
?>