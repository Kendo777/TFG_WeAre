<?php

echo '<h3>Shop Administration</h3>';
echo '<p>You are logged in as: <b>'.$_SESSION['admin'].'</b>. ';
?>
<ul class="nav">
        <li class="nav-item">
    <a class="nav-link" href="index.php">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=items">Item Manage</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=categories">Categories Manager</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=orders">Orders Manage</a>
  </li>
<li class="nav-item">
    <a class="nav-link" href="index.php?page=users">Users Manager</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=logout">Logout</a>
  </li>
</ul>
<hr>