<?php

ob_start();

require_once("../mySqli.php");
session_start();
$page="home";
$errorMsg="";
if(isset($_SESSION['admin']))
{
	$page="home";
    if(isset($_GET["user"]))
    {
        $page = "userInfo";
    }
    else if (isset($_GET["item"]))
    {
        $page="itemInfo";
    }
    else if (isset($_GET["category"]))
    {
        $page="categoriesInfo";
    }
    else if(isset($_GET["page"]))
    {
        if($_GET["page"]=="logout")
        {
            //setCookie(session_name(),'',time()-10000,'/');
            session_destroy();
            header('location:..'.DIRECTORY_SEPARATOR.'index.php');
        }
        else
        {
            $page=$_GET["page"];
        }
    }
}
else
{
    header('location:..'.DIRECTORY_SEPARATOR.'index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>University Admin</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
    <body>
    	<div class="nabvar">
    		<?php
    		if($page!="login")
    			include("session.php");
    		?>
    	</div>
    	<div class="container">
    		<?php
    		if($page!="login")
            {
                if(file_exists($page."Manage.php"))
    			 include($page."Manage.php");
                else
                    include("homeManage.php");
            }
    		else
            {
    			include("..".DIRECTORY_SEPARATOR.$page.".php");
            }
    		?>
    	</div>
    </body>
    <?php
ob_end_flush();
?>