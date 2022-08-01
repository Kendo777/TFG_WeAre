<?php
require_once("mySqli.php");

$passwordChange=false;

if(isset($_GET["code"]) && isset($_GET["user"])) //verification
{
	$code = mysql_fix_string($mySqli,$_GET['code']);
	$user = mysql_fix_string($mySqli,$_GET['user']);

	$sql= $mySqli->prepare("SELECT * FROM users WHERE user=?");
	$sql->bind_param("s",$user);
	$sql->execute();
	$result=$sql->get_result();

	if($result->num_rows>0) // if exist
	{
	    $row=$result->fetch_assoc();
	    if($row['valid']==$code)
	    {
	    	$sql= $mySqli->prepare("UPDATE users SET valid=0 WHERE user=?");
    		$sql->bind_param("s",$user);
    		$sql->execute();
    		$passwordChange=true;
	    }
	    else if($row['valid']==0)
	    {
	    	$errorMsg.='<p class="alert alert-danger">User already valid</p>';
	    }
	    else
	    {
	    	$errorMsg.='<p class="alert alert-danger">Wrong validation code</p>';
	    }

	    if(isset($_GET["validation"])) // if the email is verification
	    {
	    	header('location:index.php?page=login');
	    }
	}
}
if(isset($_GET["user"]) && isset($_POST["password"]) && $_POST["password"]!="" && isset($_POST["password2"]) && $_POST["password2"]!="") // change password
{
	$user = mysql_fix_string($mySqli,$_GET['user']);
	$password = mysql_fix_string($mySqli,$_POST['password']);
	$password2 = mysql_fix_string($mySqli,$_POST['password2']);
	if($password==$password2)
		{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$sql= $mySqli->prepare("UPDATE users SET password=? WHERE user=?");
			$sql->bind_param("ss",$password,$user);
			$sql->execute();
			header('location:index.php?page=login');
		}
		else
		{
			$errorMsg.='<p class="alert alert-danger">Password doesnt match</p>';
			$passwordChange=true;
		}
}
if(isset($errorMsg)) echo $errorMsg;

echo '<div class="row justify-content-md-center">
  <div class="col-md-auto">';
if(!$passwordChange)
{
echo '<h3>Steampunk Age of Steam - Validation</h3>
<p class="alert alert-danger">Forgot the password? Get it back:</p>
<form method="post" action="index.php?page=login">
	<div class="form-group">
		<label>Email</label>
		<input type="text" class="form-control" name="forgotPassword"><br>
	</div>
    <button type="submit" class="btn">Send</button>
</form>';
}
else
{
	if(isset($_GET["forgot"]))
	{
		echo '<h3>Steampunk Age of Steam - Validation</h3>
		<p class="alert alert-danger">Forgot the password? Get it back:</p>
		<form method="post" action="index.php?page=verification&user='.$_GET["user"].'">
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" name="password"><br>
				<label>Repeat Password</label>
				<input type="password" class="form-control" name="password2"><br>
			</div>
		    <button type="submit" class="btn">Send</button>
		</form>';
	}
}
echo'</div>
</div>';