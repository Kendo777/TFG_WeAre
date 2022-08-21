<?php
if(isset($_SESSION["user"]))
{
	header('location:index.php');
}
if((isset($_POST['user']) && isset($_POST['password'])) || isset($_POST["guest"]))
{
  if(isset($_POST["guest"]))
  {
    $user = "guest";
    $password = mysql_fix_string($mySqli_db,$_POST['guest']);
  }
  else
  {
    $user = mysql_fix_string($mySqli_db,$_POST['user']);
    $password = mysql_fix_string($mySqli_db,$_POST['password']);
  }

	$sql= $mySqli_db->prepare("SELECT * FROM users WHERE user=? OR email=?");
	$sql->bind_param("ss",$user,$user);
	$sql->execute();

	$result=$sql->get_result();

	if($result->num_rows>0)
	{
	    $row=$result->fetch_assoc(); //put the results into a row

	    if(password_verify($password,$row['password'])){
		   
        if($row['valid']==0)
		    {
		        $_SESSION['user']=$row["user"];
		        header('location:index.php');
		    }
		    else
		    {
		    	$errorMsg.='<p class="alert alert-danger">Please verify the acount clicking in the link that we sended to your mail</p>';
		    	require_once("mail/mail.php");
				  sendEmail($row['email'], $row['user'], "registration", $row['valid']);
		    }
		}
		else if($_POST["guest"])
		{
			$errorMsg.='<p class="alert alert-danger">Guest key not valid</p>';
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
else if(isset($_POST['forgotPassword']) && $_POST['forgotPassword']!="")
{
	$post = mysql_fix_string($mySqli_db,$_POST['forgotPassword']);
	$sql= $mySqli_db->prepare("SELECT * FROM users WHERE email=?");
	$sql->bind_param("s",$post);
	$sql->execute();
	$result=$sql->get_result();

	if($result->num_rows>0)
	{
		$row=$result->fetch_assoc(); //put the results into a row
		$validationCode = "";
		for($i=0; $i<4; $i++)
		{
			$validationCode.=random_int(0, 9);
		}

		$sql= $mySqli_db->prepare("UPDATE users SET valid=? WHERE email=?");
		$sql->bind_param("ss",$validationCode,$post);
		$sql->execute();
		require_once("mail/mail.php");
		sendEmail($row['email'], $row['user'], "forgot", $validationCode);
	}
	else
	{
		$errorMsg.='<p class="alert alert-danger">Email not valid</p>';
	}
}
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
      <h2 data-aos="fade-up" data-aos-delay="400">Log in 
		<?php
			if(basename(dirname(getcwd())) != "WebPages")
			{
        echo 'and start your website';
			}
		?>
		</h2>
      <?php if(isset($errorMsg)) echo '<div data-aos="fade-up" data-aos-delay="400">'.$errorMsg.'</div>'; ?>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-auto">
      <form method='post' action='index.php?page=login'>
        <div class="form-group">
          <label>User or Email</label>
          <input type='text' class="form-control" name='user'><br>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type='password' class="form-control" name='password'>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
      <?php
        if($json_data["web_data"]["web_privacity"] == "Invitation")
        {
          echo '<p class="alert alert-info mt-5">If you are not a member of <b><u>' . $json_data["web_data"]["web_current_name"] . '</u></b> <br> and you have a guest key, quickly log in <br> with the <b><u>guest key</u></b></p>
          <form method="post" action="index.php?page=login">
            <div class="form-group">
              <label>Guest Key</label>
              <input type="text" class="form-control" name="guest"><br>
            </div>
            <button type="submit" class="btn btn-primary">Enter</button>
          </form>';
        }
      ?>
      <p class="alert alert-info mt-5">If you have not registered as user, you can do it
        <a href="index.php?page=register">here</a></p>

      <p class="alert alert-danger">Forgot the password? Change it <a href="index.php?page=verification">here</a></p>
	</div>
	</div>
	
</section>