<?php
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
		$user = mysql_fix_string($mySqli_db,$_POST['user']);
		$password = mysql_fix_string($mySqli_db,$_POST['password']);
		$password2 = mysql_fix_string($mySqli_db,$_POST['password2']);
		$email = mysql_fix_string($mySqli_db,$_POST['email']);

		if($password==$password2)
		{
			$password = password_hash($password, PASSWORD_DEFAULT);
			//No funciona mail de google
			$validationCode = 0; //intval($validationCode);
			$sql= $mySqli_db->prepare("INSERT INTO users(user, email, password, valid) VALUES (?,?,?,?)");
			$sql->bind_param("sssi",$user,$email,$password,$validationCode);
			$sql->execute();

			$result=$sql->get_result();
			if($mySqli_db->errno==0)
			{
				/*require_once("mail/mail.php");
				sendEmail($_POST['email'],$_POST['user'],"registration",$validationCode);*/
				header('location:index.php?page=user&edit');
			}
			else
			{
				$sql= $mySqli_db->prepare("SELECT * FROM users WHERE user=?");
				$sql->bind_param("s",$user);
				$sql->execute();
				$result=$sql->get_result();
				if($result->num_rows>0)
				{
					$errorMsg.='<p class="alert alert-danger">User name already exist in database</p>';
				}
				$sql="SELECT * FROM users WHERE email='".$_POST['email']."'";
				$sql= $mySqli_db->prepare("SELECT * FROM users WHERE email=?");
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
<section class="d-flex align-items-center"
<?php 
  if(basename(dirname(getcwd())) == "WebPages")
  {
    echo 'style="padding: 0px;"';
  }
?>
>
  <div class="container" data-aos="fade-up">
    <div class="section-header mt-5">
      <h2 data-aos="fade-up" data-aos-delay="400">Sign in
      <?php
        if(basename(dirname(getcwd())) != "WebPages")
        {
          echo 'and start your first website';
        }
		  ?>
      </h2>
      <?php if(isset($errorMsg)) echo '<div data-aos="fade-up" data-aos-delay="400">'.$errorMsg.'</div>'; ?>
    </div>
	<div class="row justify-content-md-center">
    <div class="col-lg-5">
      <form method='post' action='index.php?page=register'>
        <div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">User</span>
            </div>
            <input type="text" class="form-control" name="user" placeholder="Enter your user name" aria-label="Username" aria-describedby="basic-addon1" required>
          </div>
        <hr>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">Email</span>
            </div>
            <input type="email" class="form-control" name="email" placeholder="Enter your email" aria-label="Email" aria-describedby="basic-addon1" required>
        </div>
        <hr>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Password</span>
          </div>
          <input type="password" class="form-control" name="password" placeholder="Enter the password" aria-label="Password" aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Password</span>
          </div>
          <input type="password" class="form-control" name="password2" placeholder="Confirm the password" aria-label="Password" aria-describedby="basic-addon1" required>
        </div>
        <hr>
      </div>
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
	</div>
</div>
</section>