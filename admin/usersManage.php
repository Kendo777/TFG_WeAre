<?php
require_once("../mySqli.php");

if(!empty($_POST))
{
  if(isset($_POST['deleteId']))
  {
    if(isset($_POST['confirmation']))
    {
      $post = mysql_fix_string($mySqli,$_POST['deleteId']);
      $sql= $mySqli->prepare("DELETE FROM users WHERE user=?");
      $sql->bind_param("s",$post);
      $sql->execute();
    }
    else
    {
      $errorMsg='
          <form action="index.php?page=users" method="post">
          <div class="form-group">
          <p class="alert alert-danger">Are you sure that you want to delete the user '.$_POST['deleteId'].'?
          <input type="text" hidden class="form-control" name="confirmation">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$_POST['deleteId'].'">
          <button type="submit" class="btn btn-danger">Remove</button></p>
          </div>
          </form>';
    }
  }
}
if(isset($_POST["search"]))
{
  header( "Location: index.php?page=users&search=".$_POST["search"]);
}
if(isset($_GET["search"]))
{
    $post = mysql_fix_string($mySqli,$_GET['search']);
    $sql= $mySqli->prepare("SELECT * FROM users WHERE user!=? AND user LIKE ? ORDER BY user");
  $compare = "%".$post."%";
    $sql->bind_param("ss",$_SESSION['admin'],$compare);
}
else
{
  $sql= $mySqli->prepare("SELECT * FROM users WHERE user!=? ORDER BY user");
  $sql->bind_param("s",$_SESSION['admin']);
}
$sql->execute();
$result=$sql->get_result();

if(!$result)
{
  die($mySqli->error);
}
if(isset($errorMsg)) echo $errorMsg;
?>
<form class="form-inline my-2 my-lg-0" method="post" action="index.php?page=users">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
      </form>
<table class="table table-hover">
    <thead>
      <tr>
        <th>User</th>
          <th>Name</th>
          <th>Email</th>
          <th>Profile picture</th>
          <th></th>
          <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['user'].'</td>';
          echo '<td>'.$row['userName'].'</td>';
          echo '<td>'.$row['email'].'</td>';
          if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$row['user'].".png"))
            echo '<td><img src="..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'ProfileImg'.DIRECTORY_SEPARATOR.''.$row['user'].'.png" width="100" height="130"></td>';
          else
            echo '<td><img src="..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'Default'.DIRECTORY_SEPARATOR.'userDefault.jpg" width="100" height="130"></td>';

          echo '<td><a href="index.php?page=users&user='.$row['user'].'">
          <button type="submit" class="btn btn-primary">Show</button></a></td>';
          echo '<td><form action="index.php?page=users" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$row['user'].'">
          <button type="submit" class="btn btn-primary">Remove</button>
          </div>
          </form></td>';
          echo '</tr>';
        }
        //$conn->close(); //close the database connection, when it is not needed anymore in the script
      ?>
    </tbody>
</table>
<hr>