<?php
if(!isset($_SESSION['user']))
{
  header('location:index.php?page=login');
}
require_once("mySqli.php");
if(!isset($_SESSION['user']))
{
  header('location:index.php?page=login');
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
if(isset($_POST['directionEdit']) && $_POST['directionEdit']!="" && isset($_POST['zipCodeEdit']) && $_POST['zipCodeEdit']!="" && isset($_POST['cityEdit']) && $_POST['cityEdit']!="" && isset($_POST['countryEdit']) && $_POST['countryEdit']!="")
{
  $id=mysql_fix_string($mySqli,$_GET['address']);
  $direction = mysql_fix_string($mySqli,$_POST['directionEdit']);
  $zipCode = mysql_fix_string($mySqli,$_POST['zipCodeEdit']);
  $city = mysql_fix_string($mySqli,$_POST['cityEdit']);
  $country = mysql_fix_string($mySqli,$_POST['countryEdit']);

  $sql= $mySqli->prepare("UPDATE addresses SET direction=?,zipCode=?,city=?,country=? WHERE addressId=?");
  $sql->bind_param("sissi",$direction,$zipCode,$city,$country,$id);
  $sql->execute();

}
if(isset($_POST['cardNumberEdit']) && $_POST['cardNumberEdit']!="" && isset($_POST['cardNameEdit']) && $_POST['cardNameEdit']!="" && isset($_POST['cardDateEdit']) && $_POST['cardDateEdit']!="")
{
  $id=mysql_fix_string($mySqli,$_GET['creditCard']);
  $number = mysql_fix_string($mySqli,$_POST['cardNumberEdit']);
  $name = mysql_fix_string($mySqli,$_POST['cardNameEdit']);
  $date = mysql_fix_string($mySqli,$_POST['cardDateEdit']);

  $sql= $mySqli->prepare("UPDATE creditcard SET number=?,name=?,date=? WHERE creditCardId=?");
  $sql->bind_param("issi",$number,$name,$date,$id);
  $sql->execute();

}
if(isset($_POST['deleteAddress']))
{
  $post = mysql_fix_string($mySqli,$_POST['deleteAddress']);
    $sql= $mySqli->prepare("DELETE FROM addresses WHERE addressId=?");
    $sql->bind_param("i",$post);
    $sql->execute();
}
if(isset($_POST['deleteCard']))
{
  $post = mysql_fix_string($mySqli,$_POST['deleteCard']);
    $sql= $mySqli->prepare("DELETE FROM creditcard WHERE creditcard=?");
    $sql->bind_param("i",$post);
    $sql->execute();
}

if(isset($_POST['name']) && $_POST['name']!="")
{
  $post = mysql_fix_string($mySqli,$_POST['name']);
  $sql= $mySqli->prepare("UPDATE users SET userName=? WHERE user=?");
  $sql->bind_param("ss",$post,$_SESSION['user']);
  $sql->execute();
}
if(isset($_POST['phone']) && $_POST['phone']!="")
{
  $post = mysql_fix_string($mySqli,$_POST['phone']);
  $sql= $mySqli->prepare("UPDATE users SET phone=? WHERE user=?");
  $sql->bind_param("ss",$post,$_SESSION['user']);
  $sql->execute();
}
if(isset($_POST['email']) && $_POST['email']!="")
{
    $post = mysql_fix_string($mySqli,$_POST['email']);
    $sql= $mySqli->prepare("SELECT * FROM users WHERE user=? AND email=?");
    $sql->bind_param("ss",$_SESSION['user'],$post);
    $sql->execute();
     $result=$sql->get_result();

    if($result->num_rows>0)
    {
      $errorMsg.='<p class="alert alert-danger">Email is the same as the last one</p>';
    }
    else
    {
      $sql= $mySqli->prepare("UPDATE users SET email=? WHERE user=?");
      $sql->bind_param("ss",$post,$_SESSION['user']);
      $sql->execute();
      $result=$sql->get_result();

      if(!$result)
      {
        $errorMsg.='<p class="alert alert-danger">Email is already in the database</p>';
      }
      else
      {
        require_once("../mail/mail.php");
        sendEmail("steampunkshoopofsteam@gmail.com", $_SESSION['user'], "holi");
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
      $sql->bind_param("ss",$post,$_SESSION['user']);
      $sql->execute();
      $result=$sql->get_result();
      rename("css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$_SESSION['user'].".png", "css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$post.".png");
      $_SESSION['user'] = $post;
      header( "Location: index.php?page=user&edit");
    }
}
if(isset($_POST["password"]) && $_POST["password"]!="" && isset($_POST["password2"]) && $_POST["password2"]!="")
{
  $password = mysql_fix_string($mySqli,$_POST['password']);
  $password2 = mysql_fix_string($mySqli,$_POST['password2']);
  if($password==$password2)
    {
      $password = password_hash($password, PASSWORD_DEFAULT);
      $sql= $mySqli->prepare("UPDATE users SET password=? WHERE user=?");
      $sql->bind_param("ss",$password,$_SESSION['user']);
      $sql->execute();
      header('location:index.php?page=user&edit');
    }
    else
    {
      $errorMsg.='<p class="alert alert-danger">Password doesnt match</p>';
      $passwordChange=true;
    }
}
if(!empty($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error']==0)
{
  $sql= $mySqli->prepare("SELECT * FROM users WHERE user=?");
  $sql->bind_param("s",$id);
  $sql->execute();
  $result=$sql->get_result();
  $path = 'css'.DIRECTORY_SEPARATOR.'ProfileImg'.DIRECTORY_SEPARATOR;
  $row=$result->fetch_assoc();
  
  if(file_exists("css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$_SESSION['user'].".png")) unlink($path.$_SESSION['user'].".png");

  move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path.$_SESSION['user'].".png");
  
}
if(isset($_POST['deleteImage']))
{
  $sql= $mySqli->prepare("SELECT * FROM users WHERE user=?");
  $sql->bind_param("s",$id);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();
  $path = 'css'.DIRECTORY_SEPARATOR.'ProfileImg'.DIRECTORY_SEPARATOR;
  if(file_exists("css".DIRECTORY_SEPARATOR."ProfileImg".DIRECTORY_SEPARATOR.$_SESSION['user'].".png")) unlink($path.$_SESSION['user'].".png");
}

$sql= $mySqli->prepare("SELECT * FROM users WHERE user=?");
$sql->bind_param("s",$_SESSION['user']);
$sql->execute();
$result=$sql->get_result();
if(!$result)
{
  die($mySqli->error);
}
if(isset($errorMsg)) echo $errorMsg;
if(!isset($_GET['orders']))
{
  echo '
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
    <tbody>';
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['user'].'</td>';
          echo '<td>'.$row['userName'].'</td>';
          echo '<td>'.$row['email'].'</td>';
          echo '<td>'.$row['phone'].'</td>';
          if(file_exists("css/ProfileImg/".$row['user'].".png"))
            echo '<td><img src="css/ProfileImg/'.$row['user'].'.png" width="100" height="130"></td>';
          else
            echo '<td><img src="css/Default/userDefault.jpg" width="100" height="130"></td>';
          echo '</tr>';
        //$conn->close(); //close the database connection, when it is not needed anymore in the script
    echo '</tbody>
</table>';
}
if(isset($_GET['edit']))
{
  echo '<div class="row">
  <div class="col">
  <h2>Edit information</h2>
    <form method="post" action="index.php?page=user&edit">
      <label>User</label>
      <input type="text" name="user"><hr>
      <label>Name</label>
      <input type="text" name="name"><hr>
      <label>Email</label>
      <input type="email" name="email"><hr>
      <label>Phone</label>
      <input type="text" name="phone"><br><br>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
    </div>
    <div class="col">
    <div class="row">
      <form enctype="multipart/form-data" method="post" action="index.php?page=user&edit">
      <h2>Edit Image</h2>
      <input type="file"  name="uploaded_file" accept="image/*"><br><br>
      <input type="submit">
    </form>
    </div>
    <div class="row">
      <form method="post" action="index.php?page=user&edit">
      <h2>Change Password</h2>
      <label>Password</label><br>
      <input type="password" name="password"><br>
      <label>Repeat Password</label><br>
      <input type="password" name="password2"><br>
      <input type="submit">
    </form>
    </div>
    </div>
    </div><br>';
}
if(!isset($_GET['orders']))
{
  echo '
<h2>Addreses <i class="fas fa-sign"></i></h2>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Address</th>
        <th>Zip</th>
        <th>City</th>
        <th>Country</th>';
        if(isset($_GET["edit"]))
        {
          echo "<th></th><th></th>";
        }
echo '
      </tr>
    </thead>
    <tbody>';
      $sql= $mySqli->prepare("SELECT * FROM addresses WHERE user=?");
      $sql->bind_param("s",$_SESSION['user']);
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
          if(isset($_GET["edit"]) && (!isset($_GET["address"]) || $_GET["address"]!=$row['addressId']))
          {
            echo '<td><a href="index.php?page=user&edit&address='.$row['addressId'].'"><button class="btn btn-primary">Edit</button></a></td>
            <td><form action="index.php?page=user&edit" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteAddress" value="'.$row['addressId'].'">
          <button type="submit" class="btn btn-primary">Remove</button>
          </div>
          </form></td>';
          }
          echo '</tr>';
        }
echo '
</tbody>
</table>';
}
if(isset($_GET["edit"]))
{
  if(isset($_GET["address"]))
  {
    $get = mysql_fix_string($mySqli,$_GET['address']);
    $sql= $mySqli->prepare("SELECT * FROM addresses WHERE addressId=?");
      $sql->bind_param("i",$get);
      $sql->execute();
      $result=$sql->get_result();
      $row=$result->fetch_assoc();
    echo'<h4>Edir Address</h4>
            <form method="post" action="index.php?'.$_SERVER['QUERY_STRING'].'">
              <label>Address</label>
              <input type="text" name="directionEdit" value="'.$row['direction'].'"><hr>
              <label>Zip</label>
              <input type="number" name="zipCodeEdit" value="'.$row['zipCode'].'"><hr>
              <label>City</label>
              <input type="text" name="cityEdit" value="'.$row['city'].'"><hr>
              <label>Country</label>
              <input type="text" name="countryEdit" value="'.$row['country'].'"><br><br>
              <div class="form-group">
                <input type="text" hidden class="form-control">
                <button type="submit" class="btn btn-primary">Send</button>
              </div>
            </form>';
  }
  else
  {
    echo'<h4>Add Address</h4>
        <form method="post" action="index.php?page=user&edit">
          <label>Address</label>
          <input type="text" name="direction"><hr>
          <label>Zip</label>
          <input type="number" name="zipCode"><hr>
          <label>City</label>
          <input type="text" name="city"><hr>
          <label>Country</label>
          <input type="text" name="country"><br><br>
          <div class="form-group">
            <input type="text" hidden class="form-control">
            <button type="submit" class="btn btn-primary">Send</button>
          </div>
        </form>';
  }
}
if(!isset($_GET['orders']))
{
  echo '
<hr><h2>Credit card <i class="fas fa-credit-card"></i></h2>
<table class="table table-hover">
    <thead>
      <tr>
        <th>user name</th>
        <th>number</th>
        <th>expiration date</th>';
        if(isset($_GET["edit"]))
        {
          echo "<th></th><th></th>";
        }
echo '
      </tr>
    </thead>
    <tbody>';
      $sql= $mySqli->prepare("SELECT * FROM creditcard WHERE user=?");
      $sql->bind_param("s",$_SESSION['user']);
      $sql->execute();
      $result=$sql->get_result();

      for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '<tr>';
          echo '<td>'.$row['name'].'</td>';
          echo '<td>'.$row['number'].'</td>';
          echo '<td>'.$row['date'].'</td>';
            if(isset($_GET["edit"]) && (!isset($_GET["creditCard"]) || $_GET["creditCard"]!=$row['creditCardId']))
          {
            echo '<td><a href="index.php?page=user&edit&creditCard='.$row['creditCardId'].'"><button class="btn btn-primary">Edit</button></a></td>
            <td><form action="index.php?page=user&edit" method="post">
          <div class="form-group">
          <input type="text" hidden class="form-control" name="deleteCard" value="'.$row['creditCardId'].'">
          <button type="submit" class="btn btn-primary">Remove</button>
          </div>
          </form></td>';
          }
          echo '</tr>';
        }
echo '
</tbody>
</table>';
}
if(isset($_GET["edit"]))
{
  if(isset($_GET["creditCard"]))
  {
    $get = mysql_fix_string($mySqli,$_GET['creditCard']);
    $sql= $mySqli->prepare("SELECT * FROM creditcard WHERE creditCardId=?");
      $sql->bind_param("i",$get);
      $sql->execute();
      $result=$sql->get_result();
      $row=$result->fetch_assoc();
    echo'<h4>Edit Credit Card</h4>
      <form method="post" action="index.php?'.$_SERVER['QUERY_STRING'].'">
        <label>Number</label>
        <input type="number" name="cardNumberEdit" value="'.$row['number'].'"><hr>
        <label>Name</label>
        <input type="text" name="cardNameEdit" value="'.$row['name'].'"><hr>
        <label>Date</label>
        <input type="month" name="cardDateEdit" value="'.$row['date'].'"><br><br>
        <div class="form-group">
          <input type="text" hidden class="form-control">
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
      </form>';
  }
  else
  {
  echo'<h4>Add Credit Card</h4>
      <form method="post" action="index.php?page=user&edit">
        <label>Number</label>
        <input type="number" name="cardNumber"><hr>
        <label>Name</label>
        <input type="text" name="cardName"><hr>
        <label>Date</label>
        <input type="month" name="cardDate"><br><br>
        <div class="form-group">
          <input type="text" hidden class="form-control">
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
      </form>';
  }
}

if(isset($_GET['orders']))
{
  echo '
<h2>Your Orders <i class="fas fa-dolly"></i></h2>
<table class="table table-hover">
    <thead>
      <tr>
          <th>Name of product</th>
          <th>Quantity</th>
          <th>Total Prize</th>
          <th>Date</th>
          <th>Address</th>
          <th>Sent <i class="fas fa-truck"></i></th>
          <th></th>
      </tr>
    </thead>
    <tbody>';
        $sql= $mySqli->prepare("SELECT * FROM orders WHERE user=? AND paid=1");
        $sql->bind_param("s",$_SESSION['user']);
        $sql->execute();
        $result=$sql->get_result();
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
            echo '<td>'.$row['cuantity'].'</td>';
            $prize = $row['cuantity']*$rowAux['prize']+$rowAux['extra'];
            echo '<td>'.$prize.'$</td>';
            $date = new DateTime($row['date']);
            echo '<td>'.$date->format("F j, Y, g:i a").'</td>';

          $sqlAux= $mySqli->prepare("SELECT * FROM addresses WHERE addressId=?");
          $sqlAux->bind_param("i",$row['addressId']);
          $sqlAux->execute();
          $resultAux=$sqlAux->get_result();
          $rowDir = $resultAux->fetch_assoc();

          echo '<td>'.$rowDir['direction'].'</td>';
                      echo '<td><div class="custom-control custom-checkbox">';
            if($row['send'])
            {
                echo '<input type="checkbox" class="custom-control-input" checked disabled>
                      <label class="custom-control-label"></label>';
            }else{
                echo '<input type="checkbox" class="custom-control-input" disabled>
                      <label class="custom-control-label"></label>';
            }
          echo '</div></td>';

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
            echo '</tr>';
        }
echo '
    </tbody>
</table>';
}