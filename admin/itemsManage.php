<?php
require_once("../mySqli.php");

if(isset($_GET["product"]))
$id = mysql_fix_string($mySqli,$_GET["product"]);

if(!empty($_POST))
{
  if(isset($_POST['itemToAdd']) && isset($_POST['category']) && $_POST['category']!="")
  {
      $post = mysql_fix_string($mySqli,$_POST['category']);
      $item = mysql_fix_string($mySqli,$_POST['itemToAdd']);
      $sql= $mySqli->prepare("INSERT INTO classification(itemId, categoryId) VALUES (?,?)");
      $sql->bind_param("ii",$item,$post);
      $sql->execute();
  }
  if(isset($_POST['takeOut']))
  {
      $post = mysql_fix_string($mySqli,$_POST['takeOut']);
      $sql= $mySqli->prepare("DELETE FROM classification WHERE itemId=?");
      $sql->bind_param("i",$post);
      $sql->execute();
  }
  if(isset($_POST['deleteId']))
  {
    if(isset($_POST['confirmation']))
    {
      $post = mysql_fix_string($mySqli,$_POST['deleteId']);
      $sql= $mySqli->prepare("SELECT * FROM items WHERE itemId=?");
      $sql->bind_param("i",$post);
      $sql->execute();
      $result=$sql->get_result();
      $path = '..'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'ItemImg'.DIRECTORY_SEPARATOR;
      $row=$result->fetch_assoc();
      
      if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$row['itemName'].".png")) unlink($path.$row["itemId"].$row["itemName"].".png");
    
    $sql= $mySqli->prepare("DELETE FROM items WHERE itemId=?");
    $sql->bind_param("i",$post);
    $sql->execute();
  }
    else
    {
      $errorMsg='
          <form action="index.php?page=items&product='.$id.'" method="post">
          <div class="form-group">
          <p class="alert alert-danger">Are you sure that you want to delete the item '.$_POST['deleteId'].'?
          <input type="text" hidden class="form-control" name="confirmation">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$_POST['deleteId'].'">
          <button type="submit" class="btn btn-danger">Remove</button></p>
          </div>
          </form>';
    }
  }
  else if(isset($id) && !isset($_POST['search']) && $_POST['name']!="" && $_POST['prize']!="" && $_POST['description']!="" && $_POST['extra']!="")
  {
    //insert data into database here
    $name = mysql_fix_string($mySqli,$_POST['name']);
    $prize = mysql_fix_string($mySqli,$_POST['prize']);
    $description = mysql_fix_string($mySqli,$_POST['description']);
    $extra = mysql_fix_string($mySqli,$_POST['extra']);

    $sql= $mySqli->prepare("INSERT INTO items(itemName, prize, description, extra) VALUES (?,?,?,?)");
    $sql->bind_param("sdsd",$name,$prize,$description,$extra);
    $sql->execute();

    $item = $mySqli->insert_id;
    $sql= $mySqli->prepare("INSERT INTO classification(itemId, categoryId) VALUES (?,?)");
    $sql->bind_param("ii",$item,$id);
    $sql->execute();
    echo $mySqli->error;
  }
  else if(isset($id) && !isset($_POST['search']))
  {
    $errorMsg.='<p class="alert alert-danger">All parameters required</p>';
  }
}
if(isset($errorMsg)) echo $errorMsg;
?>



<?php
if(!isset($_GET['product']))
{
    $sql= $mySqli->prepare("SELECT * FROM categories");
    $sql->execute();
    $result=$sql->get_result();
    if(!$result)
    {
      die($mySqli->error);
    }
    echo '<h2>Select the item category</h2>
    <table class="table table-hover">
          <tbody>';
    for($i=0; $i<$result->num_rows; $i++)
    {
      $row=$result->fetch_assoc();
      echo '<tr><td><a href="index.php?page=items&product='.$row['categoryId'].'">
              <button type="submit" class="btn btn-primary">'.$row['name'].'</button></a></td></tr>';
    }
    echo '</tbody>
          </table>';

    echo '<h2>Non category items</h2>';
    $sql= $mySqli->prepare("SELECT items.* FROM items LEFT JOIN classification ON items.itemId=classification.itemId WHERE classification.itemId IS NULL ORDER BY items.itemName");
    $sql->execute();
    $result=$sql->get_result();
    echo '<table class="table table-hover">
          <thead>
            <tr>
              <th>Item Id</th>
              <th>Name of Item</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Prize</th>
                <th>Shippment extra</th>
                <th>Image</th>
                <th>Categories for chose</th>
                <th></th>
            </tr>
          </thead>
          <tbody>';
    for($i=0; $i<$result->num_rows; $i++)
    {
      $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['itemId'].'</td>';
          echo '<td>'.$row['itemName'].'</td>';
          if(strlen($row['description'])>10)
          {
            echo '<td>'.substr($row['description'], 0,9).'...</td>';
          }
          else
            echo '<td>'.$row['description'].'</td>';
          echo '<td>'.$row['stock'].'</td>';
          echo '<td>'.$row['prize'].'</td>';
          echo '<td>'.$row['extra'].'</td>';

            echo '<td><div class="custom-control custom-switch">';
            if(file_exists("..".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$rowAux['itemName'].".png"))
            {
                echo '<input type="checkbox" class="custom-control-input" id="customSwitch2" checked disabled>
                      <label class="custom-control-label"></label>';
            }else{
                echo '<input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                      <label class="custom-control-label"></label>';
            }
          echo '</div></td>';
          echo '<td><form action="index.php?page=items" method="post">
          <div class="form-group">
                <select class="custom-select mr-sm-2" name="category">
                <option disabled selected>select a category</option>';
                  $sqlAux= $mySqli->prepare("SELECT * FROM categories");
                  $sqlAux->execute();
                  $resultAux=$sqlAux->get_result();
                  for($j=0; $j<$resultAux->num_rows; $j++)
                  {
                    $rowAux=$resultAux->fetch_assoc();
                    echo '<option value="'.$rowAux['categoryId'].'">'.$rowAux['name'].'</option>';
                  }
          echo'</select>
          <input type="text" hidden class="form-control" name="itemToAdd" value="'.$row['itemId'].'">
          <input type="submit" value="Associate">
          </div>
          </form></td>';
          echo '<td><form action="index.php?page=items" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$row['itemId'].'">
          <button type="submit" class="btn btn-primary">Remove</button>
          </div>
          </form></td>';
          echo '</tr>';
    }
    echo '</tbody>
          </table>';
}
else
{
  if(isset($_POST["search"]))
  {
    header( "Location: index.php?page=items&product=".$id."&search=".$_POST["search"]);
  }
  if(isset($_GET["search"]))
  {
    $post = mysql_fix_string($mySqli,$_GET['search']);
    $sql= $mySqli->prepare("SELECT items.* FROM items INNER JOIN classification ON items.itemId=classification.itemId INNER JOIN categories ON classification.categoryId=categories.categoryId WHERE categories.categoryId=? AND items.itemName LIKE ? ORDER BY items.itemName");
    $compare = "%".$post."%";
    $sql->bind_param("is",$id,$compare);
  }
  else
  {
    $sql= $mySqli->prepare("SELECT items.* FROM items INNER JOIN classification ON items.itemId=classification.itemId INNER JOIN categories ON classification.categoryId=categories.categoryId WHERE categories.categoryId=? ORDER BY items.itemName");
    $sql->bind_param("i",$id);
  }
    $sql->execute();
    $result=$sql->get_result();
    if(!$result)
    {
      die($mySqli->error);
    }
echo '<form class="form-inline my-2 my-lg-0" method="post" action="index.php?page=items&product='.$id.'">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
      </form>
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
          <th></th>
          <th></th>
          <th></th>
      </tr>
    </thead>
    <tbody>';
        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['itemId'].'</td>';
          echo '<td>'.$row['itemName'].'</td>';
          if(strlen($row['description'])>15)
          {
            echo '<td>'.substr($row['description'], 0,15).'...</td>';
          }
          else
          echo '<td>'.$row['description'].'</td>';
          echo '<td>'.$row['stock'].'</td>';
          echo '<td>'.$row['prize'].'</td>';
          echo '<td>'.$row['extra'].'</td>';

            echo '<td><div class="custom-control custom-switch">';
            if(file_exists("../css/ItemImg/".$row['itemId'].$row['itemName'].".png"))
            {
                echo '<input type="checkbox" class="custom-control-input" id="customSwitch2" checked disabled>
                      <label class="custom-control-label"></label>';
            }else{
                echo '<input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                      <label class="custom-control-label"></label>';
            }
            echo '</div></td>';

          echo '<td><a href="index.php?page=items&product='.$id.'&item='.$row['itemId'].'">
          <button type="submit" class="btn btn-primary">More Information</button></a></td>';
          echo '<td><form action="index.php?page=items&product='.$id.'" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="takeOut" value="'.$row['itemId'].'">
          <button type="submit" class="btn btn-primary">Take Out</button>
          </div>
          </form></td>';
          echo '<td><form action="index.php?page=items&product='.$id.'" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$row['itemId'].'">
          <button type="submit" class="btn btn-primary">Remove</button>
          </div>
          </form></td>';
          echo '</tr>';
        }
        //$conn->close(); //close the database connection, when it is not needed anymore in the script
    echo '</tbody>
</table>
<hr>
<h2>Add new Item to db</h2>
<form method="post" action="index.php?page=items&product='.$id.'">
  <label>Name of item</label>
  <input type="text" name="name"><br>
  <label>Description</label><br>
  <textarea name="description" rows="4" cols="50"></textarea><br>
  <label>Prize in €</label>
  <input type="number" name="prize" step="any"><br>
  <label>Shippment extra in €</label>
  <input type="number" name="extra" step="any" value="0"><br>
  <input type="submit">
</form>';

}



?>
