<?php
if(!isset($_SESSION['user']))
{
  header('location:index.php?page=login');
}

if(isset($_POST['name']) && !empty($_POST['name']))
{
  $post = mysql_fix_string($mySqli_db, $_POST['name']);
  $sql= $mySqli_db->prepare("UPDATE `users` SET `user_name`=? WHERE user=?");
  $sql->bind_param("ss", $post, $_SESSION['user']);
  $sql->execute();
}

if(isset($_POST['email']) && !empty($_POST['email']))
{
    $post = mysql_fix_string($mySqli_db, $_POST['email']);
    $sql= $mySqli_db->prepare("SELECT * FROM users WHERE user=? AND email=?");
    $sql->bind_param("ss", $_SESSION['user'], $post);
    $sql->execute();
     $result=$sql->get_result();

    if($result->num_rows>0)
    {
      $errorMsg.='<p class="alert alert-danger">Email is the same as the last one</p>';
    }
    else
    {
      $sql= $mySqli_db->prepare("UPDATE users SET email=? WHERE user=?");
      $sql->bind_param("ss", $post, $_SESSION['user']);
      $sql->execute();
      $result=$sql->get_result();

      if(!empty($mySqli_db->error))
      {
        $errorMsg.='<p class="alert alert-danger">Email is already in the database</p>';
      }
      else
      {/*
        require_once("../mail/mail.php");
        sendEmail("steampunkshoopofsteam@gmail.com", $_SESSION['user'], "holi");*/
      }
    }
}
if(isset($_POST['user']) && !empty($_POST['user']))
{
    $post = mysql_fix_string($mySqli_db, $_POST['user']);
    $sql= $mySqli_db->prepare("SELECT * FROM users WHERE user=?");
    $sql->bind_param("s", $post);
    $sql->execute();
    $result=$sql->get_result();

    if(!empty($mySqli_db->error))
    {
      $errorMsg.='<p class="alert alert-danger">User name is already taken</p>';
    }
    else
    {
      $sql= $mySqli_db->prepare("UPDATE users SET user=? WHERE user=?");
      $sql->bind_param("ss", $post, $_SESSION['user']);
      $sql->execute();
      $result=$sql->get_result();
      rename("images".DIRECTORY_SEPARATOR."profile".DIRECTORY_SEPARATOR.$_SESSION['user'].".png", "images".DIRECTORY_SEPARATOR."profile".DIRECTORY_SEPARATOR.$post.".png");
      $_SESSION['user'] = $post;
      header( "Location: index.php?page=user&edit");
    }
}
if(isset($_POST["password"]) && !empty($_POST["password"]) && isset($_POST["password2"]) && !empty($_POST["password2"]))
{
  $password = mysql_fix_string($mySqli_db, $_POST['password']);
  $password2 = mysql_fix_string($mySqli_db, $_POST['password2']);
  if($password==$password2)
    {
      $password = password_hash($password, PASSWORD_DEFAULT);
      $sql= $mySqli_db->prepare("UPDATE users SET password=? WHERE user=?");
      $sql->bind_param("ss", $password, $_SESSION['user']);
      $sql->execute();
      header('location:index.php?page=user&edit');
    }
    else
    {
      $errorMsg.='<p class="alert alert-danger">Password doesnt match</p>';
      $passwordChange=true;
    }
}
if(isset($_POST["user_edit"]))
{
  foreach($_POST as $key => $value) {
    if($key != "user_edit")
    {
      $column_name = mysql_fix_string($mySqli_db, $key);
      $column_value = mysql_fix_string($mySqli_db, $value);

      $sql= $mySqli_db->prepare("UPDATE users SET " . $column_name . "=? WHERE user=?");
      $sql->bind_param("ss", $column_value, $_SESSION['user']);
      $sql->execute();
      header('location:index.php?page=user&edit');
    }
    echo "POST parameter '$key' has '$value'";
  }
}
if(!empty($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error']==0)
{
  $sql= $mySqli_db->prepare("SELECT * FROM users WHERE user=?");
  $sql->bind_param("s", $id);
  $sql->execute();
  $result=$sql->get_result();
  $path = 'images'.DIRECTORY_SEPARATOR.'profile'.DIRECTORY_SEPARATOR;
  $row=$result->fetch_assoc();
  
  if(file_exists("images".DIRECTORY_SEPARATOR."profile".DIRECTORY_SEPARATOR.$_SESSION['user'].".png")) unlink($path.$_SESSION['user'].".png");

  move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path.$_SESSION['user'].".png");
}
if(isset($_POST['deleteImage']))
{
  $sql= $mySqli_db->prepare("SELECT * FROM users WHERE user=?");
  $sql->bind_param("s", $id);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();
  $path = 'images'.DIRECTORY_SEPARATOR.'profile'.DIRECTORY_SEPARATOR;
  if(file_exists("images".DIRECTORY_SEPARATOR."profile".DIRECTORY_SEPARATOR.$_SESSION['user'].".png")) unlink($path.$_SESSION['user'].".png");
}

$sql= $mySqli_db->prepare("SELECT * FROM users WHERE user=?");
$sql->bind_param("s", $_SESSION['user']);
$sql->execute();
$result=$sql->get_result();

$sql= $mySqli_db->prepare("SHOW COLUMNS FROM " . mysql_fix_string($mySqli_db, $json_data["web_data"]["web_database"]) . ".users");
$sql->execute();
$result_columns=$sql->get_result();
if(!$result)
{
  die($mySqli_db->error);
}
if(isset($errorMsg)) echo $errorMsg;

  echo '
<table class="table table-hover">
    <thead>
      <tr>
        <th>User</th>
          <th>Name</th>
          <th>Email</th>
          <th>Profile picture</th>
      </tr>
    </thead>
    <tbody>';
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['user'].'</td>';
          echo '<td>'.$row['user_name'].'</td>';
          echo '<td>'.$row['email'].'</td>';
          if(file_exists("images/profile/".$row['user'].".png"))
          {
            echo '<td><img src="images/profile/'.$row['user'].'.png" class="profile_picture rounded-circle"></td>';
          }
          else
          {
            echo '<td><img src="../../StructureScripts/assets/defaultImg/userDefault.jpg" class="profile_picture rounded-circle"></td>';
          }
          echo '</tr>';

        //$conn->close(); //close the database connection, when it is not needed anymore in the script
    echo '</tbody>
</table>';

for($i=0; $i<$result_columns->num_rows; $i++)
{
  $column=$result_columns->fetch_assoc();
  if($column["Field"] != "user" && $column["Field"] != "email" && $column["Field"] != "user_name" && $column["Field"] != "password" && $column["Field"] != "valid")
  {
    echo '<b>' . ucfirst($column["Field"]) . ': </b>' . $row[$column["Field"]] . '<br>';
  }
}


if(isset($_GET['edit']))
{
  echo '<div class="row justify-content-center">
  <div class="col col-lg-5">
  <div class="row">
  <h2><u>Edit main information</u></h2>
    <form method="post" action="index.php?page=user&edit">
      <div class="input-group mb-3 mt-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">User</span>
        </div>
        <input type="text" class="form-control" placeholder="Enter your new Username" aria-label="Username" aria-describedby="basic-addon1" name="user">
      </div>
      <hr>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">Name</span>
        </div>
        <input type="text" class="form-control" placeholder="Enter your new Name" aria-label="Name" aria-describedby="basic-addon1" name="name">
      </div>
      <hr>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">Email</span>
        </div>
        <input type="text" class="form-control" placeholder="Enter your new Email" aria-label="Email" aria-describedby="basic-addon1" name="email">
      </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
    </div>
    <br>
    <div class="row">
    <h2><u>Edit user information</u></h2>
      <form method="post" action="index.php?page=user&edit">
      <input type="text" hidden class="form-control" name="user_edit">';
      
    mysqli_data_seek($result_columns, 0);
    for($i=0; $i<$result_columns->num_rows; $i++)
    {
      $column=$result_columns->fetch_assoc();
      if($column["Field"] != "user" && $column["Field"] != "email" && $column["Field"] != "user_name" && $column["Field"] != "password" && $column["Field"] != "valid" && $column["Field"] != "rol")
      {
        echo'<div class="input-group mb-3 mt-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">' . ucfirst($column["Field"]) . '</span>
          </div>';
        if($column["Type"] != "varchar(2000)")
        {
          if($column["Type"] == "varchar(60)")
          {
            echo '<input type="text" class="form-control" value="' . $row[$column["Field"]] . '" aria-label="' . ucfirst($column["Field"]) . '" aria-describedby="basic-addon1" name="' . $column["Field"] . '">';
          }
          else if(strpos($column["Type"], "int") !== false)
          {
            echo '<input type="number" class="form-control" value="' . $row[$column["Field"]] . '" aria-label="' . ucfirst($column["Field"]) . '" aria-describedby="basic-addon1" name="' . $column["Field"] . '">';
          }
          else if($column["Type"] == "date")
          {
            echo '<input type="date" value="' . $row[$column["Field"]] . '" name="' . $column["Field"] . '">';
          }
        }
        else
        {
          echo '<textarea class="form-control" name="' . $column["Field"] . '" rows="5">' . $row[$column["Field"]] . '</textarea>';
        }
        echo '</div>
        <hr>';
      }
    }        
        
 echo'<button type="submit" class="btn btn-primary">Send</button>
      </form>
      </div>
    </div>
    <div class="col col-lg-5">
    <div class="row">
      <form enctype="multipart/form-data" method="post" action="index.php?page=user&edit">
      <h2><u>Edit Image</u></h2>
      <div class="input-group mb-3 mt-3">
        <div class="input-group-prepend">
          <span class="input-group-text">Upload</span>
        </div>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="inputGroupFile01" name="uploaded_file" accept="image/*">
          <label class="custom-file-label" for="inputGroupFile01">Choose the new Profile Picture</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Send</button>
    </form>
    </div>
    <br>
    <div class="row">
      <form method="post" action="index.php?page=user&edit">
      <h2><u>Change Password</u></h2>
      <div class="input-group mb-3 mt-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">Password</span>
        </div>
        <input type="text" class="form-control" placeholder="Password" aria-label="New Password" aria-describedby="basic-addon1" name="password">
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">Repeat Password</span>
        </div>
        <input type="text" class="form-control" placeholder="Repeat Password" aria-label="Repeat Password" aria-describedby="basic-addon1" name="password2">
      </div>
      <button type="submit" class="btn btn-primary">Send</button>
    </form>
    </div>
    </div>
    </div><br>';
}
?>