<?php
require_once("mySqli.php");
$errorMsg="";

if(!empty($_POST))
{
	//Check if all inputs are set
	if(isset($_POST['user']) && !empty($_POST['user']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['password2']) && !empty($_POST['password2']) &&  isset($_POST['email']) && !empty($_POST['email']))
	{

		$validationCode = "";
		for($i=0; $i<4; $i++)
		{
			$validationCode.=random_int(0, 9);
		}
		$user = mysql_fix_string($mySqli,$_POST['user']);
		$password = mysql_fix_string($mySqli,$_POST['password']);
		$password2 = mysql_fix_string($mySqli,$_POST['password2']);
		$email = mysql_fix_string($mySqli,$_POST['email']);

		if($password==$password2)
		{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$validationCode = intval($validationCode);
			$sql= $mySqli->prepare("INSERT INTO users(user, email, password, valid) VALUES (?,?,?,?)");
			$sql->bind_param("sssi",$user,$email,$password,$validationCode);
			$sql->execute();

			$result=$sql->get_result();
			if($mySqli->errno==0)
			{
				/*require_once("mail/mail.php");
				sendEmail($_POST['email'],$_POST['user'],"registration",$validationCode);*/
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
<section class="d-flex align-items-center">
  <div class="container" data-aos="fade-up">
    <div class="section-header mt-5">
      <h2 data-aos="fade-up" data-aos-delay="400">Register and start your first website</h2>
      <?php if(isset($errorMsg)) echo '<div data-aos="fade-up" data-aos-delay="400">'.$errorMsg.'</div>'; ?>
    </div>
	<div class="row justify-content-md-center">
    <div class="col-lg-5">
      <form method='post' action='index.php?page=register'>
        <div class="form-group">
          <label>User</label><br>
        <input type='text' class="form-control" name='user'><hr>
        <label>Email</label><br>
        <input type='email' class="form-control" name='email'><hr>
        <label>Password</label><br>
        <input type='password' class="form-control" name='password'>
        <label>Repeat Password</label><br>
        <input type='password' class="form-control" name='password2'><hr>
      </div>
        <input type='submit'>
      </form>
    </div>
	</div>
</div>
</section>