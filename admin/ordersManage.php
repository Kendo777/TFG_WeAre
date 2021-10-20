<?php
require_once("../mySqli.php");

if(!empty($_POST))
{
  if(isset($_POST['deleteId']))
  {
    if(isset($_POST['confirmation']))
    {
      $post = mysql_fix_string($mySqli,$_POST['deleteId']);

      $sql= $mySqli->prepare("SELECT * FROM orders WHERE orderId=?");
      $sql->bind_param("i",$post);
      $sql->execute();
      $result=$sql->get_result();
      $row=$result->fetch_assoc();

      if(!$row['send'])
      {
        $sql= $mySqli->prepare("UPDATE items SET stock=stock+? WHERE itemId=?");
        $sql->bind_param("ii",$row['cuantity'],$row['itemId']);
        $sql->execute();
      }
      $sql= $mySqli->prepare("DELETE FROM orders WHERE orderId=?");      
      $sql->bind_param("i",$post);
      $sql->execute();
    }
    else
    {
      $errorMsg='
          <form action="index.php?page=users" method="post">
          <div class="form-group">
          <p class="alert alert-danger">Are you sure that you want to delete the order '.$_POST['deleteId'].'?
          <input type="text" hidden class="form-control" name="confirmation">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$_POST['deleteId'].'">
          <button type="submit" class="btn btn-danger">Remove</button></p>
          </div>
          </form>';
    }
  }
  if(isset($_POST['send']))
  {
    $post = mysql_fix_string($mySqli,$_POST['send']);
    $sql= $mySqli->prepare("UPDATE orders SET send=1 WHERE orderId=?");
    $sql->bind_param("i",$post);
    $sql->execute();
  }
}

$sql= $mySqli->prepare("SELECT * FROM orders");
$sql->execute();
$result = $sql->get_result();

if(!$result)
{
  die($mySqli->error);
}
if(isset($errorMsg)) echo $errorMsg;
?>

<table class="table table-hover">
    <thead>
      <tr>
        <th>Order Id</th>
        <th>Item Id</th>
        <th>Name of Item</th>
        <th>Quantity</th>
        <th>Total Prize</th>
        <th>User</th>
        <th>Adress</th>
        <th>Date</th>
        <th>Sent</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        for($i=0; $i<$result->num_rows; $i++)
        {
          $row = $result->fetch_array();
          echo '<tr>';
          echo '<td>'.$row['orderId'].'</td>';
          echo '<td>'.$row['itemId'].'</td>';
          $sql= $mySqli->prepare("SELECT * FROM items WHERE itemId=?");
          $sql->bind_param("i",$row['itemId']);
          $sql->execute();
          $resultAux = $sql->get_result();
          $rowAux = $resultAux->fetch_array();

          echo '<td>'.$rowAux['itemName'].'</td>';
          echo '<td>'.$row['cuantity'].'</td>';
          echo '<td>'.$row['totalPrize'].'</td>';
          echo '<td>'.$row['user'].'</td>';

          $sql= $mySqli->prepare("SELECT * FROM addresses WHERE addressId=?");
          $sql->bind_param("i",$row['addressId']);
          $sql->execute();
          $resultAux = $sql->get_result();
          $rowAux = $resultAux->fetch_array();

          echo '<td>'.$rowAux['direction'].'</td>';

          echo '<td>'.$row['date'].'</td>';

          echo '<td><div class="custom-control custom-switch">';
        
          if(!$row['send'])
          {
            echo '<input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                      <label class="custom-control-label"></label></div></td>
            <td><form action="index.php?page=orders" method="post">
            <div class="form-group">
            <input type="text" hidden class="form-control" name="send" value="'.$row['orderId'].'">
            <button type="submit" class="btn btn-primary">Send</button>
            </div>
            </form></td>';
          }
          else
          {
            echo '<input type="checkbox" class="custom-control-input" id="customSwitch2" checked disabled>
                      <label class="custom-control-label"></label></div></td>';
          }
          echo '<td><form action="index.php?page=orders" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteId" value="'.$row['orderId'].'">
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