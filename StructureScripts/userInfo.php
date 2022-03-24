<?php
if(!isset($_SESSION['user']))
{
  header('location:index.php?page=login');
}
$maxAdds=6;
$path = "usuarios".DIRECTORY_SEPARATOR.$_GET["user"];
$info = json_decode(file_get_contents($path.DIRECTORY_SEPARATOR."info.txt"),true);
if(isset($_GET["edit"]))
{
	echo '<div class="row">
  <div class="col">
  <h2>Editar informacion</h2>
    <form method="post" action="index.php?page=userInfo&user='.$_GET["user"].'&edit">
      <label>Nombre</label>
      <input type="text" name="name" value="'.$info["name"].'"><hr>
      <label>Apodo</label>
      <input type="text" name="nickname" value="'.$info["nickname"].'"><hr>
      <label>Posicion</label>
      <input type="text" name="job" value="'.$info["job"].'"><hr>
      <label>Cumleaños</label>
      <input type="date" name="date" value="'.$info["birthday"].'"><hr>
      <label>Descripcion</label><br>
      <textarea class="form-control" name="description" rows="10" col>'.$info["description"].'</textarea><hr>
      <br><br>
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
else
{
	echo '<div class="row" style="margin-left: 5%">
	  <div class="col-md-auto">
	  <img src="'.$path.DIRECTORY_SEPARATOR.'perfil.png">
	  </div>
	  <div class="col-md-auto">';
	if(!empty($info["nickname"]))
	{
		echo '<h2>'.$info["nickname"].'</h2>';
		echo '<h3>'.$info["name"].'</h3>';
	}
	else
	{
		echo '<h2>'.$info["name"].'</h2>';
	}
	echo '<h5>Posicion:</h5><p>'.$info['job'].'</p>
		  <h5>Cumleaños:</h5><p>'.$info['birthday'].'</p>
		  <h5>Discord</h5><p>'.$info['discord'].'</p>';
  echo '</div></div><div class="row" style="margin-left: 5%">
  <div class="col-md-auto">';
	echo '<h5>Descripcion</h5>';
	echo '<p style="max-width: 500px;">'.str_replace("\n","<br>",file_get_contents($path.DIRECTORY_SEPARATOR."descripcion.txt")).'</p>';
	echo '<a data-toggle="collapse" href="#collapseExample">
	<h5 style="display: inline;">Amigo Invisible</h5>  (Click aqui para ver)</a>';
	echo '<div class="card">
	<div class="collapse" id="collapseExample">
  <div class="card card-body" style="max-width: 500px;"><div class="card-body">
        '.str_replace("\n","<br>",file_get_contents($path.DIRECTORY_SEPARATOR."amigo invisible.txt")).'
      </div>
    </div>
  </div>';

	echo '</div>';
	echo '</div>';
}
?>