<?php
require_once("../mySqli.php");

$id = mysql_fix_string($mySqli,$_GET['category']);
if(!empty($_POST))
{
  if(isset($_POST['name']) && $_POST['name']!="")
  {
    $post = mysql_fix_string($mySqli,$_POST['name']);
      $sqlAux= $mySqli->prepare("SELECT * FROM categories WHERE categoryId=?");
    $sqlAux->bind_param("i",$id);
    $sqlAux->execute();
    $resultAux = $sqlAux->get_result();
    $row = $resultAux->fetch_assoc();

    $sql= $mySqli->prepare("UPDATE categories SET name=? WHERE categoryId=?");
    $sql->bind_param("si",$post,$id);
    $sql->execute();
    rename("../css/Default/".$row['name']."Default.jpg", "../css/Default/".$post."Default.jpg");
  }
  if(isset($_POST['deleteId']))
  {
      $post = mysql_fix_string($mySqli,$_POST['deleteId']);
      $sql= $mySqli->prepare("DELETE FROM subclasification WHERE subCategoryId=?");
      $sql->bind_param("i",$post);
      $sql->execute();


      $sql= $mySqli->prepare("DELETE FROM categoriesrelation WHERE categoryId=? AND subCategoryId=?");
      $sql->bind_param("ii",$id,$post);
      $sql->execute();
  }
  if(isset($_POST['addSubcategory']))
  {
      $post = mysql_fix_string($mySqli,$_POST['addSubcategory']);
      $sql= $mySqli->prepare("INSERT INTO categoriesrelation(categoryId, subCategoryId) VALUES (?,?)");
      $sql->bind_param("ii",$id,$post);
      $sql->execute();
  }
  if(isset($_POST['subId']) && isset($_POST['subName']) && $_POST['subName']!="")
  {
    $name = mysql_fix_string($mySqli,$_POST['subName']);
    $subId = mysql_fix_string($mySqli,$_POST['subId']);
    $sql= $mySqli->prepare("UPDATE subcategories SET name=? WHERE subCategoryId=?");
    $sql->bind_param("si",$name,$subId);
    $sql->execute();
  }
  if(isset($_POST['newAttributeName']) && $_POST['newAttributeName']!="")
  {
      $post = mysql_fix_string($mySqli,$_POST['newAttributeName']);
      $sql= $mySqli->prepare("INSERT INTO attributes(categoryId, name) VALUES (?,?)");
      $sql->bind_param("is",$id,$post);
      $sql->execute();
  }
  if(isset($_POST['attributeName']) && $_POST['attributeName']!="")
  {
    $name = mysql_fix_string($mySqli,$_POST['attributeName']);
    $attId = mysql_fix_string($mySqli,$_POST['attributeId']);
    $sql= $mySqli->prepare("UPDATE attributes SET name=? WHERE attributeId=?");
    $sql->bind_param("si",$name,$attId);
    $sql->execute();
  }
  if(isset($_POST['deleteAttributeId']))
  {
    $post = mysql_fix_string($mySqli,$_POST['deleteAttributeId']);
    $sql= $mySqli->prepare("DELETE FROM attributes WHERE attributeId=?");
    $sql->bind_param("i",$post);
    $sql->execute();
  }
  

}

$sql= $mySqli->prepare("SELECT * FROM categories WHERE categories.categoryId=?");
$sql->bind_param("i",$id);
$sql->execute();
$result=$sql->get_result();


if(!$result)
{
  die($mySqli->error);
}

if(isset($errorMsg)) echo $errorMsg;
$row=$result->fetch_assoc();

echo '<h2>'.$row['name'].'</h2>'
?>
<hr>
<h3>Edit name of category</h3>
<form method='post' <?php echo 'action="index.php?page=categories&category='.$id.'"'?>>
  <label>Name of category</label>
  <input type='text' name='name'><br>
  <input type='submit'>
</form>
<hr>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Attributes of <?php echo $row['name'];?></th>
        <th>Change name</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql= $mySqli->prepare("SELECT attributes.* FROM attributes INNER JOIN categories ON attributes.categoryId=categories.categoryId WHERE categories.categoryId=?");
        $sql->bind_param("i",$id);
        $sql->execute();
        $result=$sql->get_result();
        
        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['name'].'</td>';
          echo '<td><form method="post" action="index.php?page=categories&category='.$id.'"
                <label>Name</label>
                <input type="text" hidden class="form-control" name="attributeId" value="'.$row['attributeId'].'">
                <input type="text" name="attributeName">
                <input type="submit">
              </form></td>';
          echo '<td><form action="index.php?page=categories&category='.$id.'" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteAttributeId" value="'.$row['attributeId'].'">
          <button type="submit" class="btn btn-primary">Delete</button>
          </div>
          </form></td>';
          echo '</tr>';
        }
        //$conn->close(); //close the database connection, when it is not needed anymore in the script
      ?>
    </tbody>
</table>
<hr>
<h3>Add attributes</h3>
<form method='post' <?php echo 'action="index.php?page=categories&category='.$id.'"'?>>
  <label>Name of attribute</label>
  <input type='text' name='newAttributeName'><br>
  <input type='submit'>
</form>
<hr>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Subcategory asociated</th>
        <th>Change name</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql= $mySqli->prepare("SELECT subcategories.* FROM subcategories INNER JOIN categoriesrelation ON subcategories.subCategoryId=categoriesrelation.subCategoryId INNER JOIN categories on categoriesrelation.categoryId=categories.categoryId WHERE categories.categoryId=?");
        $sql->bind_param("i",$id);
        $sql->execute();
        $result=$sql->get_result();
        
        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['name'].'</td>';
          echo '<td><form method="post" action="index.php?page=categories&category='.$id.'"
                <label>Name</label>
                <input type="text" hidden class="form-control" name="subId" value="'.$row['subCategoryId'].'">
                <input type="text" name="subName">
                <input type="submit">
              </form></td>';
          echo '<td><form action="index.php?page=categories&category='.$id.'" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$row['subCategoryId'].'">
          <button type="submit" class="btn btn-primary">Take Out</button>
          </div>
          </form></td>';
          echo '</tr>';
        }
        //$conn->close(); //close the database connection, when it is not needed anymore in the script
      ?>
    </tbody>
</table>
<hr>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Subcategory Name NON-Affiliated</th>
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
          echo '<td><form action="index.php?page=categories&category='.$_GET['category'].'" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="addSubcategory" value="'.$row['subCategoryId'].'">
          <button type="submit" class="btn btn-primary">Add</button>
          </div>
          </form></td>';
          echo '</tr>';
        }
        //$conn->close(); //close the database connection, when it is not needed anymore in the script
      ?>
    </tbody>
</table>
<hr>