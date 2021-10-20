<?php 
if(!isset($_SESSION['user']))
{
  header('location:index.php?page=login');
}
require_once("timeline.php");
 ?>