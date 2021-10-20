<?php
require_once("mySqli.php");
if(isset($_POST['deleteId']))
{
  $post = mysql_fix_string($mySqli,$_POST['deleteId']);

  $sql= $mySqli->prepare("SELECT * FROM orders WHERE orderId=?");
  $sql->bind_param("i",$post);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();

	$sql= $mySqli->prepare("UPDATE items SET stock=stock+1 WHERE itemId=?");
	$sql->bind_param("i",$row['itemId']);
	$sql->execute();

  if($row['cuantity']>1)
  {
  	$sql= $mySqli->prepare("UPDATE orders SET cuantity=cuantity-1 WHERE orderId=?");
  }
  else
  {
  	$sql= $mySqli->prepare("DELETE FROM orders WHERE orderId=?");
  }
	  
  $sql->bind_param("i",$post);
  $sql->execute();
}
if(isset($_POST['cardNumber']) && $_POST['cardNumber']!="" && isset($_POST['cardName']) && $_POST['cardName']!="" && isset($_POST['cardDate']) && $_POST['cardDate']!="")
{
  $cardName = mysql_fix_string($mySqli,$_POST['cardName']);
  $cardNumber = mysql_fix_string($mySqli,$_POST['cardNumber']);
  $cardDate = mysql_fix_string($mySqli,$_POST['cardDate']);

  $sql= $mySqli->prepare("INSERT INTO creditcard(user, number, name, date) VALUES (?,?,?,?)");
  $sql->bind_param("siss",$_SESSION['user'],$cardNumber,$cardName,$cardDate);
  $sql->execute();

}
if(isset($_POST['direction']) && $_POST['direction']!="" && isset($_POST['zipCode']) && $_POST['zipCode']!="" && isset($_POST['city']) && $_POST['city']!="" && isset($_POST['country']) && $_POST['country']!="")
{
  $direction = mysql_fix_string($mySqli,$_POST['direction']);
  $zipCode = mysql_fix_string($mySqli,$_POST['zipCode']);
  $city = mysql_fix_string($mySqli,$_POST['city']);
  $country = mysql_fix_string($mySqli,$_POST['country']);

  $sql= $mySqli->prepare("INSERT INTO addresses(user, direction, zipCode, city, country) VALUES (?,?,?,?,?)");
  $sql->bind_param("ssiss",$_SESSION['user'],$direction,$zipCode,$city,$country);
  $sql->execute();

}

if(isset($_POST['address']) && isset($_POST['creditCard']))
{
      $address = mysql_fix_string($mySqli,$_POST['address']);
      $creditCard = mysql_fix_string($mySqli,$_POST['creditCard']);

      $sql= $mySqli->prepare("SELECT * FROM orders WHERE user=? AND paid=0");
      $sql->bind_param("s",$_SESSION['user']);
      $sql->execute();
      $result=$sql->get_result();

      $date = date("Y-m-d H:i:s");
      
      for($i=0; $i<$result->num_rows ;$i++)
      {
        $row=$result->fetch_assoc();
        $sql= $mySqli->prepare("UPDATE orders SET addressId=?, creditCardId=?, date=?, paid=1 WHERE orderId=?");
        $sql->bind_param("iisi",$address,$creditCard,$date,$row['orderId']);
        $sql->execute();
      }
      header('location:index.php');
}

$sql= $mySqli->prepare("SELECT * FROM orders WHERE user=? AND paid=0");
$sql->bind_param("s",$_SESSION['user']);
$sql->execute();
$result=$sql->get_result();
?>
<h2>Shopping Cart</h2>
<table class="table table-hover">
    <thead>
      <tr>
          <th>Name of product</th>
          <th>Prize</th>
          <th>Shippment</th>
          <th>Quantity</th>
          <th>Total Prize</th>
          <th></th>
          <?php 
          if(!isset($_GET["pay"]))
          {
            echo '<th></th>';
          }
          ?>
      </tr>
    </thead>
    <tbody>
      <?php
      	$totalPrize = 0;
      	for($i=0; $i<$result->num_rows; $i++)
      	{
      		$row=$result->fetch_assoc();
      		$sqlAux= $mySqli->prepare("SELECT * FROM items WHERE itemId=?");
			$sqlAux->bind_param("i",$row['itemId']);
			$sqlAux->execute();
			$resultAux=$sqlAux->get_result();
			$rowAux = $resultAux->fetch_assoc();
	          echo '<tr>';
	          echo '<td>'.$rowAux['itemName'].'</td>';
	          echo '<td>'.$rowAux['prize'].'$</td>';
	          echo '<td>'.$rowAux['extra'].'$</td>';
	          echo '<td>'.$row['cuantity'].'</td>';
	          $prize = $row['cuantity']*$rowAux['prize']+$rowAux['extra'];
	          echo '<td>'.$prize.'$</td>';
	          $totalPrize+=$prize;
	          if(file_exists("css".DIRECTORY_SEPARATOR."ItemImg".DIRECTORY_SEPARATOR.$row['itemId'].$rowAux['itemName'].".png"))
	            echo '<td><img src="css'.DIRECTORY_SEPARATOR.'ItemImg'.DIRECTORY_SEPARATOR.$row['itemId'].$rowAux['itemName'].'.png" width="100" height="130"></td>';
	          else
	            {
	            	$sqlAux= $mySqli->prepare("SELECT categories.* FROM categories INNER JOIN classification ON categories.categoryId=classification.categoryId WHERE classification.itemId=?");
                    $sqlAux->bind_param("i",$row['itemId']);
                    $sqlAux->execute();
                    $resultAux=$sqlAux->get_result();
                    $rowAux=$resultAux->fetch_assoc();
                    if(file_exists("css".DIRECTORY_SEPARATOR."Default".DIRECTORY_SEPARATOR.$rowAux['name']."Default.jpg"))
                    {
                      echo '<td><img src="css'.DIRECTORY_SEPARATOR.'Default'.DIRECTORY_SEPARATOR.$rowAux['name'].'Default.jpg" width="100" height="130"></td>';
                    }
                    else
                    {
                      echo '<td><img src="css'.DIRECTORY_SEPARATOR.'Default'.DIRECTORY_SEPARATOR.'itemDefault.jpg" width="100" height="130"></td>';
                    }
	            }
              if(!isset($_GET["pay"]))
              {
  	            echo '<td><form action="index.php?page=shoppingCart" method="post">
  					    <div class="form-group">
  					       <input type="text" hidden class="form-control" name="deleteId" value="'.$row['orderId'].'">
  					       <button type="submit" class="btn btn-primary">Take out</button>
  					    </div>
  					</form></td>';
            }
	          echo '</tr>';
      	}
      	echo '<tr><td></td><td></td><td></td><td><b>Total:<b></td><td><span class="prize">'.$totalPrize.'$</span></td>';
		if(!isset($_GET["pay"]) && $result->num_rows>0)
		{
			echo'<td><a href="index.php?page=shoppingCart&pay"><button type="submit" class="btn btn-warning">Finnish and buy <i class="fas fa-coins"></i></button><a></td>';
		}
      	echo '<td></td></tr>';
      ?>
    </tbody>
</table>
<?php

if(isset($_GET["pay"]))
{
	echo'<form action="index.php?page=shoppingCart&pay" method="post"> 
  <h4>Adress</h4>
  <select class="custom-select" name="address">';
      $sql= $mySqli->prepare("SELECT * FROM addresses WHERE user=?");
      $sql->bind_param("s",$_SESSION['user']);
      $sql->execute();
      $result=$sql->get_result();
      for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<option value="'.$row['addressId'].'">'.$row['direction'].' '.$row['zipCode'].' '.$row['city'].' '.$row['country'].'</option>';
        }
echo'</select><hr>
<h4>Credit Card</h4>
<select class="custom-select" name="creditCard">';
      $sql= $mySqli->prepare("SELECT * FROM creditcard WHERE user=?");
      $sql->bind_param("s",$_SESSION['user']);
      $sql->execute();
      $result=$sql->get_result();

      for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<option value="'.$row['creditCardId'].'">'.$row['name'].' nº: '.$row['number'].' '.$row['date'].'</option>';
        }
echo '</select><hr>
<button type="submit" class="btn btn-primary">Confirm</button>
</form>';
}