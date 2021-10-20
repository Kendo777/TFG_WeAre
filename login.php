<?php
require_once("mySqli.php");
if(isset($_POST['user']) && isset($_POST['password']))
{
	$user = mysql_fix_string($mySqli,$_POST['user']);
	$password = mysql_fix_string($mySqli,$_POST['password']);


	$sql= $mySqli->prepare("SELECT * FROM members WHERE user=? OR email=?");
	$sql->bind_param("ss",$user,$user);
	$sql->execute();

	$result=$sql->get_result();

	if($result->num_rows>0)
	{
	    $row=$result->fetch_assoc(); //put the results into a row

	    if(password_verify($password,$row['password'])){
		    if($user == "ElDictadorSecreto")
		    {
		        //passwords match
		        session_start(); //login ok, start session and save session-variables
		        $_SESSION['admin']=$row['user'];
		        //$_SESSION['name']=$row['firstname'].' '.$row['lastname'];
		        //$_SESSION['starttime']=date('H:i:s');
		        header('location:admin/index.php'); //to index.php -> session isset now!
		    }
		    else
		    {
		    	//session_start();
		    	
		        $_SESSION['user']=$row['user'];
		        header('location:index.php');
		    }
		}
		else
		{
			$errorMsg.='<p class="alert alert-danger">User name, email or password not valid</p>';
		}
    
	}
	else
	{
		$errorMsg.='<p class="alert alert-danger">User name, email or password not valid</p>';
	}
}
else if(isset($_POST['guest']))
{
	if($_POST['guest'] == "Pleitesia al lider supremo")
	{
		$_SESSION['user']= "Invitado";
		header('location:index.php');
	}
	else
	{
		$errorMsg.='<p class="alert alert-danger">Invitacion no valida</p>';
	}
}


if(isset($errorMsg)) echo $errorMsg;
?>
<div class="row justify-content-md-center">
  <div class="col-md-auto">
<h3>Reino del terror - Login</h3>
<form method='post' action='index.php?page=login'>
	<div class="form-group">
		<label>User or Email</label>
		<input type='text' class="form-control" name='user'><br>
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type='password' class="form-control" name='password'>
	</div>
    <button type="submit" class="btn btn-primary">Login</button>
</form><br><br>

<p class="alert alert-info">Si no eres un miembro del Reino del terror <br>o te da pereza logearte, entra de forma rapida<br> con la <b><u>clave de invitado</u></b></p>

<form method='post' action='index.php?page=login'>
	<div class="form-group">
		<label>Usuario invitado</label>
		<input type='text' class="form-control" name='guest'><br>
	</div>
    <button type="submit" class="btn btn-primary">Entrar</button>
</form><br><br>



</div>
</div>