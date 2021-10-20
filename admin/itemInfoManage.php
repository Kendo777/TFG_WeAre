<?php
require_once("../mySqli.php");
$id = mysql_fix_string($mySqli,$_GET['item']);
$categ = mysql_fix_string($mySqli,$_GET['product']);

if(!empty($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error']==0)
{
  $sql= $mySqli->prepare("SELECT * FROM items WHERE itemId=?");
  $sql->bind_param("s",$id);
  $sql->execute();
  $result=$sql->get_result();
  $path = '..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'ItemImg'.DIRECTORY_SEPARATOR;
  $row=$result->fetch_assoc();
  
  if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].".png")) unlink($path.$row["itemId"].$row["itemName"].".png");

  move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path.$row["itemId"].$row["itemName"].".png");
  
}
if(isset($_POST['deleteImage']))
{
  $sql= $mySqli->prepare("SELECT * FROM items WHERE itemId=?");
  $sql->bind_param("s",$id);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();
  $path = '..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'ItemImg'.DIRECTORY_SEPARATOR;
  if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].".png")) unlink($path.$row["itemId"].$row["itemName"].".png");

}

if(isset($_POST['name']) && $_POST['name']!="")
{
  $post = mysql_fix_string($mySqli,$_POST['name']);

  $sql= $mySqli->prepare("SELECT * FROM items WHERE itemId=?");
  $sql->bind_param("i",$id);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();

  $sql= $mySqli->prepare("UPDATE items SET itemName=? WHERE itemId=?");
  $sql->bind_param("si",$post,$id);
  $sql->execute();

  rename("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$id.$row['itemName'].".png", "..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$id.$post.".png");
  header( "Location: index.php?page=items&product=".$categ."&item=".$id);
}
if(isset($_POST['prize']) && $_POST['prize']!="")
{
  $post = mysql_fix_string($mySqli,$_POST['prize']);
  $sql= $mySqli->prepare("UPDATE items SET prize=? WHERE itemId=?");
  $sql->bind_param("di",$post,$id);
  $sql->execute();
}
if(isset($_POST['stock']) && $_POST['stock']!="")
{
  $sql= $mySqli->prepare("SELECT items.stock FROM items WHERE itemId=?");
  $sql->bind_param("i",$id);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();

  $post = mysql_fix_string($mySqli,$_POST['stock']);
  $post+=$row['stock'];
  $sql= $mySqli->prepare("UPDATE items SET stock=? WHERE itemId=?");
  $sql->bind_param("di",$post,$id);
  $sql->execute();
}
if(isset($_POST['description']) && $_POST['description']!="")
{
  $post = mysql_fix_string($mySqli,$_POST['description']);
  $sql= $mySqli->prepare("UPDATE items SET description=? WHERE itemId=?");
  $sql->bind_param("si",$post,$id);
  $sql->execute();
}
if(isset($_POST['extra']) && $_POST['extra']!="")
{
  $post = mysql_fix_string($mySqli,$_POST['extra']);
  $sql= $mySqli->prepare("UPDATE items SET extra=? WHERE itemId=?");
  $sql->bind_param("di",$post,$id);
  $sql->execute();
}
if(isset($_POST['deleteSubcategory']))
{
    $post = mysql_fix_string($mySqli,$_POST['deleteSubcategory']);
    $sql= $mySqli->prepare("DELETE FROM subclasification WHERE itemId=? AND subCategoryId=?");
    $sql->bind_param("ii",$id,$post);
    $sql->execute();
}
if(isset($_POST['addSubcategory']))
{
    $post = mysql_fix_string($mySqli,$_POST['addSubcategory']);
    $sql= $mySqli->prepare("INSERT INTO subclasification(itemId, subCategoryId) VALUES (?,?)");
    $sql->bind_param("ii",$id,$post);
    $sql->execute();
}
if(isset($_POST['addAttribute']))
{
    $post = mysql_fix_string($mySqli,$_POST['addAttribute']);
    $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId) VALUES (?,?)");
    $sql->bind_param("ii",$id,$post);
    $sql->execute();
}
if(isset($_POST['attributeId']) && isset($_POST['attributeValue']) && $_POST['attributeValue']!="")
{
    $value = mysql_fix_string($mySqli,$_POST['attributeValue']);
    $attId = mysql_fix_string($mySqli,$_POST['attributeId']);
    $sql= $mySqli->prepare("UPDATE itemattribute SET value=? WHERE attributeId=? AND itemId=?");
    $sql->bind_param("sii",$value,$attId,$id);
    $sql->execute();
}

$sql= $mySqli->prepare("SELECT * FROM items WHERE itemId=?");
$sql->bind_param("i",$id);
$sql->execute();
$result=$sql->get_result();

if(!$result)
{
  die($mySqli->error);
}
?>

<table class="table table-hover">
    <thead>
      <tr>
        <th>Item Id</th>
        <th>Name of Item</th>
          <th>Description</th>
          <th>Stock</th>
          <th>Prize</th>
          <th>Shippment extra</th>
          <th>Image</th>
      </tr>
    </thead>
    <tbody>
      <?php
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['itemId'].'</td>';
          echo '<td>'.$row['itemName'].'</td>';
          echo '<td>'.$row['description'].'</td>';
          echo '<td>'.$row['stock'].'</td>';
          echo '<td>'.$row['prize'].'</td>';
          echo '<td>'.$row['extra'].'</td>';
          if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].".png"))
            echo '<td><img src="..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'ItemImg'.DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].'.png" width="100" height="130"></td>';
          else
          {
            $sql= $mySqli->prepare("SELECT * FROM categories WHERE categoryId=?");
            $sql->bind_param("i",$categ);
            $sql->execute();
            $result=$sql->get_result();
            $row=$result->fetch_assoc();
            if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."Default".DIRECTORY_SEPARATOR.$row['name']."Default.jpg"))
              echo '<td><img src="..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'Default'.DIRECTORY_SEPARATOR.$row['name'].'Default.jpg" width="100" height="130"></td>';
            else
              echo '<td><img src="..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'Default'.DIRECTORY_SEPARATOR.'itemDefault.jpg" width="100" height="130"></td>';
          }
          echo '</tr>';
        //$conn->close(); //close the database connection, when it is not needed anymore in the script
      ?>
    </tbody>
</table>
<hr>
<div class="row">
  <div class="col-sm">
    <h2>Edit information of the product</h2>
    <form method='post' <?php echo 'action="index.php?page=items&product='.$categ.'&item='.$id.'"'?>>
      <label>Name of item</label>
      <input type='text' name='name'><hr>
      <label>Description</label><br>
      <textarea name='description' rows="4" cols="50"></textarea><hr>
      <label>Prize in €</label>
      <input type='number' name='prize' step="any"><hr>
      <label>Shippment extra in €</label>
      <input type='number' name='extra' step="any"><br>
      <input type='submit'>
    </form>
<hr>
    <h2>Add stock</h2>
    <form method='post' <?php echo 'action="index.php?page=items&product='.$categ.'&item='.$id.'"'?>>
      <label>New Stock</label>
      <input type='number' name='stock' min="0">
      <input type='submit'>
    </form>
    <hr>
    <h2>Edit attributes of the product</h2><hr>
      <?php
        $sql= $mySqli->prepare("SELECT attributes.* FROM attributes INNER JOIN categories ON attributes.categoryId=categories.categoryId INNER JOIN itemattribute ON attributes.attributeId=itemattribute.attributeId WHERE categories.categoryId=? AND itemattribute.itemId=?");
        $sql->bind_param("ii",$categ,$id);
        $sql->execute();
        $result=$sql->get_result();
        
        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();


          $sqlAux= $mySqli->prepare("SELECT itemattribute.* FROM itemattribute WHERE itemattribute.itemId=? AND itemattribute.attributeId=?");
          $attId = $row['attributeId'];
          $sqlAux->bind_param("ii",$id,$attId);
          $sqlAux->execute();
          $resultAux=$sqlAux->get_result();
          $rowAux =$resultAux->fetch_assoc();

          echo '<form method="post" action="index.php?page=items&product='.$categ.'&item='.$id.'">
          <h4>'.$row['name'].': '.$rowAux['value'].'</h4>
                <label>Value:</label>
                <input type="text" hidden class="form-control" name="attributeId" value="'.$row['attributeId'].'">
                <input type="text" name="attributeValue" value="'.$rowAux['value'].'">
                <input type="submit">
                </form>
                <hr>';
        }

        $sql= $mySqli->prepare("SELECT attributes.* FROM attributes INNER JOIN categories ON attributes.categoryId=categories.categoryId WHERE categories.categoryId=? AND attributes.attributeId NOT IN (SELECT attributes.attributeId FROM attributes INNER JOIN categories ON attributes.categoryId=categories.categoryId INNER JOIN itemattribute ON attributes.attributeId=itemattribute.attributeId WHERE categories.categoryId=? AND itemattribute.itemId=?)");
        $sql->bind_param("iii",$categ,$categ,$id);
        $sql->execute();
        $result=$sql->get_result();
        echo '<table style="width:auto;" class="table table-hover">
          <tbody>';
        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr><td><h4>'.$row['name'].'</h4></td>
          <td><form enctype="multipart/form-data" method="post" action="index.php?page=items&product='.$categ.'&item='.$id.'"
                <div class="form-group">
                  <input type="text" hidden class="form-control" name="addAttribute" value="'.$row['attributeId'].'">
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form></td></tr>';
        }
        echo '</tbody></table>';

      ?>
</div>
  <div class="col-sm">
    <div class="row">
    <h2>Add Image to the product</h2>
    <form enctype="multipart/form-data" method='post' <?php echo 'action="index.php?page=items&product='.$categ.'&item='.$id.'"'?>>
      <input type="file"  name="uploaded_file" accept="image/*"><br><br>
      <input type='submit'>
    </form>
  </div>
  <hr>
    <h2>Delete Image</h2>
    <form enctype="multipart/form-data" method='post' <?php echo 'action="index.php?page=items&product='.$categ.'&item='.$id.'"'?>>
      <div class="form-group">
        <input type="text" hidden class="form-control" name="deleteImage">
        <button type="submit" class="btn btn-primary">Remove</button>
      </div>
    </form><hr>
  <div class="row">
    <div class="col-sm">
    <h4>Sub Categories</h4>
    <table class="table table-hover">
      <tbody>
        <?php
        $sql= $mySqli->prepare("SELECT subcategories.subCategoryId, subcategories.name FROM subcategories INNER JOIN subclasification ON subcategories.subCategoryId=subclasification.subCategoryId INNER JOIN items ON subclasification.itemId=items.itemId WHERE items.itemId=?");
        $sql->bind_param("i",$id);
        $sql->execute();
        $result=$sql->get_result();

        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr><td><form action="index.php?page=items&product='.$categ.'&item='.$id.'" method="post">
            <div class="form-group">
            <input type="text" hidden class="form-control" name="deleteSubcategory" value="'.$row['subCategoryId'].'">
            <button type="submit" class="btn btn-primary">'.$row['name'].'</button>
            </div>
            </form></td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
      <div class="col-sm">
    <h4>NON Sub Categories</h4>
    <table class="table table-hover">
      <tbody>
        <?php

        $sql= $mySqli->prepare("SELECT subcategories.subCategoryId, subcategories.name FROM subcategories INNER JOIN categoriesrelation ON subcategories.subCategoryId=categoriesrelation.subCategoryId INNER JOIN categories ON categoriesrelation.categoryId=categories.categoryId WHERE subcategories.name NOT IN (SELECT subcategories.name FROM subcategories INNER JOIN subclasification ON subcategories.subCategoryId=subclasification.subCategoryId INNER JOIN items ON subclasification.itemId=items.itemId WHERE items.itemId=?) AND categories.categoryId=?");
        $sql->bind_param("is",$id,$categ);
        $sql->execute();
        $result=$sql->get_result();

        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr><td><form action="index.php?page=items&product='.$categ.'&item='.$id.'" method="post">
            <div class="form-group">
            <input type="text" hidden class="form-control" name="addSubcategory" value="'.$row['subCategoryId'].'">
            <button type="submit" class="btn btn-primary">'.$row['name'].'</button>
            </div>
            </form></td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>
</div>