<?php
require_once("../mySqli.php");

if(!empty($_POST))
{
  if(isset($_POST['deleteId']))
  {
    $post = mysql_fix_string($mySqli,$_POST['deleteId']);
    if(isset($_POST['confirmation']))
    {
      
      $sql= $mySqli->prepare("DELETE FROM categories WHERE categoryId=?");
      $sql->bind_param("i",$post);
      $sql->execute();
    }
    else
    {
      $sql= $mySqli->prepare("SELECT * FROM categories WHERE categoryId=?");
      $sql->bind_param("i",$post);
      $sql->execute();
      $result=$sql->get_result();
      $row=$result->fetch_assoc();

      $errorMsg='
          <form action="index.php?page=categories" method="post">
          <div class="form-group">
          <p class="alert alert-danger">Are you sure that you want to delete the category '.$row['name'].'?
          <input type="text" hidden class="form-control" name="confirmation">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$row['categoryId'].'">
          <button type="submit" class="btn btn-danger">Remove</button></p>
          </div>
          </form>';
    }
  }
  if(isset($_POST['nameSubcategory']) && $_POST['nameSubcategory']!="")
  {
    $post = mysql_fix_string($mySqli,$_POST['nameSubcategory']);
    $sql= $mySqli->prepare("INSERT INTO subcategories(name) VALUES (?)");
    $sql->bind_param("s",$post);
    $sql->execute();
  }
  if(isset($_POST['nameCategory']) && $_POST['nameCategory']!="")
  {
    $post = mysql_fix_string($mySqli,$_POST['nameCategory']);
    $sql= $mySqli->prepare("INSERT INTO categories(name) VALUES (?)");
    $sql->bind_param("s",$post);
    $sql->execute();
  }
  if(isset($_POST['deleteSubId']))
  {
    $post = mysql_fix_string($mySqli,$_POST['deleteSubId']);
    $sql= $mySqli->prepare("DELETE FROM subcategories WHERE subCategoryId=?");
    $sql->bind_param("i",$post);
    $sql->execute();
  }
}

$sql= $mySqli->prepare("SELECT * FROM categories");
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
        <th>Category Name</th>
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
          echo '<td>'.$row['name'].'</td>';
      
          echo '<td><a href="index.php?page=categories&category='.$row['categoryId'].'">
          <button type="submit" class="btn btn-primary">Edit / Show Subcategories</button></a></td>';
          echo '<td><form action="index.php?page=categories" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$row['categoryId'].'">
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
<h2>Add Category</h2>
<form method='post' action="index.php?page=categories">
  <label>Name</label>
  <input type='text' name='nameCategory'><br>
  <input type='submit'>
</form>
    <hr>
<h2>Add Subcategories</h2>
<form method='post' action="index.php?page=categories">
  <label>Name</label>
  <input type='text' name='nameSubcategory'><br>
  <input type='submit'>
</form>
    <hr>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Subcategory Name non-affiliated</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql= $mySqli->prepare("SELECT subcategories.* FROM subcategories WHERE subcategories.name NOT IN (SELECT subcategories.name FROM subcategories INNER JOIN categoriesrelation ON subcategories.subCategoryId=categoriesrelation.subCategoryId)");
      $sql->execute();

      $result=$sql->get_result();
      
        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['name'].'</td>';
          echo '<td><form action="index.php?page=categories" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteSubId" value="'.$row['subCategoryId'].'">
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