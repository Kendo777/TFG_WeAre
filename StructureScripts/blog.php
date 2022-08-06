<?php

if(isset($_GET["blog"]))
{
  $sql= $mySqli_db->prepare("SELECT * FROM blog_posts WHERE blog_id = ?");
  $sql->bind_param("i",$_GET["blog"]);
  $sql->execute();
  $result=$sql->get_result();
  
  for($i=0; $i<$result->num_rows; $i++)
  {
    $row=$result->fetch_assoc();
    echo "<p>" . $row["content"] . "</p><br>";
  }
}
else
{
  $sql= $mySqli_db->prepare("SELECT * FROM blogs");
  $sql->execute();
  $result=$sql->get_result();
  
  for($i=0; $i<$result->num_rows; $i++)
  {
    $row=$result->fetch_assoc();
    echo '<a href="index.php?page=blog&blog=' . $row["id"] . '">' . $row["title"] . '</a><br>';
  }
}

?>