<?php
require_once("mySqli.php");
$errorMsg="";

if(!empty($_POST))
{
	//Check if all inputs are set
	if(isset($_POST['user']) && $_POST['user']!="" && isset($_POST['password']) && $_POST['password']!="" && isset($_POST['password2']) && $_POST['password2']!="" && isset($_POST['name']) && $_POST['name']!="" && isset($_POST['email']) && $_POST['email']!="" && isset($_POST['phone']) && $_POST['phone']!="")
	{

		$validationCode = "";
		for($i=0; $i<4; $i++)
		{
			$validationCode.=random_int(0, 9);
		}
		$user = mysql_fix_string($mySqli,$_POST['user']);
		$password = mysql_fix_string($mySqli,$_POST['password']);
		$password2 = mysql_fix_string($mySqli,$_POST['password2']);
		$name = mysql_fix_string($mySqli,$_POST['name']);
		$email = mysql_fix_string($mySqli,$_POST['email']);
		$phone = mysql_fix_string($mySqli,$_POST['phone']);

		if($password==$password2)
		{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$validationCode = intval($validationCode);
			$sql= $mySqli->prepare("INSERT INTO users(user, email, password, userName, phone, valid) VALUES (?,?,?,?,?,?)");
			$sql->bind_param("sssssi",$user,$email,$password,$name,$phone,$validationCode);
			$sql->execute();

			$result=$sql->get_result();
			if($mySqli->errno==0)
			{
				require_once("mail/mail.php");
				sendEmail($_POST['email'],$_POST['user'],"registration",$validationCode);
				header('location:index.php?page=login');
			}
			else
			{
				$sql= $mySqli->prepare("SELECT * FROM users WHERE user=?");
				$sql->bind_param("s",$user);
				$sql->execute();
				$result=$sql->get_result();
				if($result->num_rows>0)
				{
					$errorMsg.='<p class="alert alert-danger">User name already exist in database</p>';
				}
				$sql="SELECT * FROM users WHERE email='".$_POST['email']."'";
				$sql= $mySqli->prepare("SELECT * FROM users WHERE email=?");
				$sql->bind_param("s",$email);
				$sql->execute();
				$result=$sql->get_result();
				if($result->num_rows>0)
				{
					$errorMsg.='<p class="alert alert-danger">Email already exist in database</p>';
				}
			}
		}
		else
		{
			$errorMsg.='<p class="alert alert-danger">Password doesnt match</p>';
		}
	}
	else
	{
		$errorMsg.='<p class="alert alert-danger">You must to full fill all parameters to register</p>';
	}
}
echo $errorMsg;

?>
<div class="row justify-content-md-center">
  <div class="col-md-auto">
<h3>Steampunk Shoop of Steam - Registration</h3>
<form method='post' action='index.php?page=register'>
	<div class="form-group">
		<label>User</label><br>
      <input type='text' class="form-control" name='user'><hr>
      <label>Name</label><br>
      <input type='text' class="form-control" name='name'><hr>
      <label>Email</label><br>
      <input type='email' class="form-control" name='email'><hr>
      <label>Password</label><br>
      <input type='password' class="form-control" name='password'><hr>
      <label>Repeat Password</label><br>
      <input type='password' class="form-control" name='password2'><hr>
      <label>Phone</label><br>
      <input type='text' class="form-control" name='phone'><br>
  </div>
      <input type='submit'>
</form>
</div>
</div>
