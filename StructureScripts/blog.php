<?php

$sql= $mySqli_db->prepare("SELECT * FROM blog_messages WHERE blog_id = 1");
$sql->execute();
$result=$sql->get_result();

for($i=0; $i<$result->num_rows; $i++)
{
  $row=$result->fetch_assoc();
  echo $row["content"];
}

?>