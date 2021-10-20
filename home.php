<?php 
if(!isset($_SESSION['user']))
{
  header('location:index.php?page=login');
}
?>
<div class="products">
    <img src="css/Img/cover.png" class="cover">
    <h2>Welcome to Steampunk: Age of Steam</h2>
    <h3>Products</h3>

</div>
