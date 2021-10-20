<?php
require_once("../mySqli.php");
$id = mysql_fix_string($mySqli,$_GET['user']);
if(isset($_POST['name']) && $_POST['name']!="")
{
  $post = mysql_fix_string($mySqli,$_POST['name']);
  $sql= $mySqli->prepare("UPDATE users SET userName=? WHERE user=?");
  $sql->bind_param("ss",$post,$id);
  $sql->execute();
}
if(isset($_POST['phone']) && $_POST['phone']!="")
{
  $post = mysql_fix_string($mySqli,$_POST['phone']);
  $sql= $mySqli->prepare("UPDATE users SET phone=? WHERE user=?");
  $sql->bind_param("ss",$post,$id);
  $sql->execute();
}
if(isset($_POST['email']) && $_POST['email']!="")
{
    $post = mysql_fix_string($mySqli,$_POST['email']);
    $sql= $mySqli->prepare("SELECT * FROM users WHERE user=? AND email=?");
    $sql->bind_param("ss",$id,$post);
    $sql->execute();
	   $result=$sql->get_result();

    if($result->num_rows>0)
    {
    	$errorMsg.='<p class="alert alert-danger">Email is the same as the last one</p>';
    }
    else
    {
      $sql= $mySqli->prepare("UPDATE users SET email=? WHERE user=?");
      $sql->bind_param("ss",$post,$id);
      $sql->execute();
      $result=$sql->get_result();

	    if(!$result)
	    {
	  		$errorMsg.='<p class="alert alert-danger">Email is already in the database</p>';
	  	}
	  	else
	  	{
	  		require_once("../mail/mail.php");
	  		sendEmail("steampunkshoopofsteam@gmail.com", $id, "holi");
	  	}
  	}
}
if(isset($_POST['user']) && $_POST['user']!="")
{
    $post = mysql_fix_string($mySqli,$_POST['user']);
    $sql= $mySqli->prepare("SELECT * FROM users WHERE user=?");
    $sql->bind_param("s",$post);
    $sql->execute();
    $result=$sql->get_result();

    if($result->num_rows>0)
    {
      $errorMsg.='<p class="alert alert-danger">User name is already taken</p>';
    }
    else
    {
      $sql= $mySqli->prepare("UPDATE users SET user=? WHERE user=?");
      $sql->bind_param("ss",$post,$id);
      $sql->execute();
      $result=$sql->get_result();
          rename("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$id.".png", "..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$post.".png");
          header( "Location: index.php?page=users&user=".$post);
    }
}
if(!empty($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error']==0)
{
  $sql= $mySqli->prepare("SELECT * FROM users WHERE user=?");
  $sql->bind_param("s",$id);
  $sql->execute();
  $result=$sql->get_result();
  $path = '..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'ProfileImg'.DIRECTORY_SEPARATOR;
  $row=$result->fetch_assoc();
  
  if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$row['user'].".png")) unlink($path.$row["user"].".png");

  move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path.$row["user"].".png");
  
}
if(isset($_POST['deleteImage']))
{
  $sql= $mySqli->prepare("SELECT * FROM users WHERE user=?");
  $sql->bind_param("s",$id);
  $sql->execute();
  $result=$sql->get_result();
	$row=$result->fetch_assoc();
	$path = '..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'ProfileImg'.DIRECTORY_SEPARATOR;
	if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$row['user'].".png")) unlink($path.$row["user"].".png");
}
  $sql= $mySqli->prepare("SELECT * FROM users WHERE user=?");
  $sql->bind_param("s",$id);
  $sql->execute();
  $result=$sql->get_result();
if(!$result)
{
  die($mySqli->error);
}
if(isset($errorMsg)) echo $errorMsg;
?>

<table class="table table-hover">
    <thead>
      <tr>
        <th>User</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Profile picture</th>
      </tr>
    </thead>
    <tbody>
      <?php
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['user'].'</td>';
          echo '<td>'.$row['userName'].'</td>';
          echo '<td>'.$row['email'].'</td>';
          echo '<td>'.$row['phone'].'</td>';
          if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$row['user'].".png"))
            echo '<td><img src="..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'ProfileImg'.DIRECTORY_SEPARATOR.$row['user'].'.png" width="100" height="130"></td>';
          else
            echo '<td><img src="..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'Default'.DIRECTORY_SEPARATOR.'userDefault.jpg" width="100" height="130"></td>';
          echo '</tr>';
        //$conn->close(); //close the database connection, when it is not needed anymore in the script
      ?>
    </tbody>
</table>

<div class="row">
  <div class="col-sm">
    <h2>Edit information</h2>
    <form method='post' <?php echo 'action="index.php?page=users&user='.$row['user'].'"'?>>
      <label>User</label>
      <input type='text' name='user'><hr>
      <label>Name</label>
      <input type='text' name='name'><hr>
      <label>Email</label>
      <input type='email' name='email'><br><br>
      <div class="form-group">
      	<input type="text" hidden class="form-control">
      	<button type="submit" class="btn btn-primary">Send</button>
      </div>
    </form>
  </div>

  <div class="col-sm">
    <h2>Add Image</h2>
    <form enctype="multipart/form-data" method='post' <?php echo 'action="index.php?page=users&user='.$row['user'].'"'?>>
      <label>Image</label><br>
      <input type="file"  name="uploaded_file" accept="image/*"><br><br>
      <input type='submit'>
    </form>
    <h2>Delete Image</h2>
    <form enctype="multipart/form-data" method='post' <?php echo 'action="index.php?page=users&user='.$row['user'].'"'?>>
      <div class="form-group">
      	<input type="text" hidden class="form-control" name="deleteImage">
      	<button type="submit" class="btn btn-primary">Remove</button>
      </div>
    </form>
  </div>
</div>
<hr>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Direction</th>
        <th>Zip</th>
        <th>City</th>
        <th>Country</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql= $mySqli->prepare("SELECT * FROM addresses WHERE user=?");
      $sql->bind_param("s",$id);
      $sql->execute();
      $result=$sql->get_result();
      for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['direction'].'</td>';
          echo '<td>'.$row['zipCode'].'</td>';
          echo '<td>'.$row['city'].'</td>';
          echo '<td>'.$row['country'].'</td>';
          echo '</tr>';
        }
        ?>
</tbody>
</table>
<hr>
<h2>Credit card</h2>
<table class="table table-hover">
    <thead>
      <tr>
        <th>user name</th>
        <th>number</th>
        <th>expiration date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql= $mySqli->prepare("SELECT * FROM creditcard WHERE user=?");
      $sql->bind_param("s",$id);
      $sql->execute();
      $result=$sql->get_result();

      for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['name'].'</td>';
          echo '<td>'.$row['number'].'</td>';
          echo '<td>'.$row['date'].'</td>';
          echo '</tr>';
        }
        ?>
</tbody>
</table>