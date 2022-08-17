<?php

function copy_folder($src, $dst) { 
  if (! is_dir($src)) {
    throw new InvalidArgumentException("$src must be a directory");
  }
  $dir = opendir($src);   
  while( $file = readdir($dir) ) 
  { 
      if (( $file != '.' ) && ( $file != '..' ))
      { 
          if (is_dir($src.DIRECTORY_SEPARATOR.$file) ) 
          { 
              mkdir($dst.DIRECTORY_SEPARATOR.$file, 0700);
              copy_folder($src.DIRECTORY_SEPARATOR.$file, $dst.DIRECTORY_SEPARATOR.$file);
          } 
          else
          {
              copy($src.DIRECTORY_SEPARATOR.$file, $dst.DIRECTORY_SEPARATOR.$file); 
          }
      } 
  } 
  closedir($dir);
}
function deleteDir($dirPath) {
  if (! is_dir($dirPath)) {
      throw new InvalidArgumentException("$dirPath must be a directory");
  }
  $dir = opendir($dirPath);   
  while( $file = readdir($dir) ) 
  { 
      if (( $file != '.' ) && ( $file != '..' ))
      { 
          if (is_dir($dirPath.DIRECTORY_SEPARATOR.$file) ) 
          { 
              deleteDir($dirPath.DIRECTORY_SEPARATOR.$file);
          } 
          else
          {
              unlink($dirPath.DIRECTORY_SEPARATOR.$file); 
          }
      } 
  } 
  closedir($dir);
  rmdir($dirPath);
}

$sql= $mySqli_db->prepare("SELECT * FROM galleries WHERE id = ?");
$sql->bind_param("i",$_GET["album"]);
$sql->execute();
$result=$sql->get_result();
$album=$result->fetch_assoc();

  if(isset($_GET["edit"]) && $session_user["rol"] == "reader")
  {
    header('location:index.php?page=gallery&album=' . $_GET["album"]);
  }
  if(isset($_POST['new_folder_name']))
  {
    if(!file_exists("images/gallery" . DIRECTORY_SEPARATOR . $_POST['new_folder_name']))
    {
      $title = mysql_fix_string($mySqli_db, $_POST['new_folder_name']);
      mkdir("images/gallery" . DIRECTORY_SEPARATOR . $_POST['new_folder_name'], 0700);
      copy_folder("images/gallery" . DIRECTORY_SEPARATOR . $album["name"], "images/gallery" . DIRECTORY_SEPARATOR . $_POST['new_folder_name']);
      deleteDir("images/gallery" . DIRECTORY_SEPARATOR . $album["name"]);

      $sql= $mySqli_db->prepare("UPDATE `galleries` SET `name`=? WHERE id = ?");
      $sql->bind_param("si", $title, $_GET["album"]);
      $sql->execute();

      header('location:index.php?page=gallery&album=' . $_GET["album"] . '&edit');
    }
    else if($_POST['new_folder_name'] != $album["name"])
    {
      $errorMsg.='<p class="alert alert-danger">Album name already exists!</p>';
    }
  }
  if(isset($_POST['album_description']))
  {
      $description = str_replace("<script", "", $_POST["album_description"]);
      $description = str_replace("</script>", "", $description);
      $description = str_replace("<style", "", $description);
      $description = str_replace("</style>", "", $description);
      $description = str_replace("<?php", "", $description);
      $description = str_replace("?>", "", $description);
      $description = mysql_fix_string($mySqli_db, $description);

      $sql= $mySqli_db->prepare("UPDATE `galleries` SET `description`=? WHERE id = ?");
      $sql->bind_param("si", $description, $_GET["album"]);
      $sql->execute();
  }

  if(isset($_FILES["upload"]) && isset($_POST["tag_new_images"]))
  {
    for( $i=0 ; $i < count($_FILES['upload']['name']) ; $i++ ) {
      move_uploaded_file($_FILES['upload']['tmp_name'][$i], "images/gallery" . DIRECTORY_SEPARATOR. $album["name"] . DIRECTORY_SEPARATOR . $_POST["tag_new_images"] . DIRECTORY_SEPARATOR . $_FILES['upload']['name'][$i]);
    }
  }
  if(isset($_POST['new_tag']))
  {
    if(!file_exists("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $_POST['new_tag']))
    {
      mkdir("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $_POST['new_tag'], 0700);
    }
    else
    {
      $errorMsg.='<p class="alert alert-danger">Tag already exists!</p>';
    }
  }
  if(isset($_POST['delete_img']))
  {
    unlink("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $_POST['delete_img']);
  }
  if(isset($_POST['delete_tag']))
  {
    copy_folder("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $_POST["delete_tag"], "images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . "No-category");
    deleteDir("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $_POST["delete_tag"]);
  }

  if(isset($_POST["image_tag"]))
  {
    $image_name = $_POST['image_name'];
    $count = 1;
    while(file_exists("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $_POST['image_tag'] . DIRECTORY_SEPARATOR . $image_name))
    {
      $image_name = substr($_POST["image_name"], 0, strrpos($_POST["image_name"], ".")) . "(" . $count . ")" . substr($_POST["image_name"], strrpos($_POST["image_name"], "."));
      $count++;
    }
    rename("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $_POST["current_tag"] . DIRECTORY_SEPARATOR . $_POST['image_name'], "images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $_POST['image_tag'] . DIRECTORY_SEPARATOR . $image_name);
  }

  echo $errorMsg;

$sql= $mySqli_db->prepare("SELECT * FROM galleries WHERE id = ?");
$sql->bind_param("i",$_GET["album"]);
$sql->execute();
$result=$sql->get_result();
$album=$result->fetch_assoc();

if(isset($_GET["edit"]))
{
  echo '<a href="index.php?page=gallery&album=' . $_GET["album"] . '">
  <button type="submit" class="btn btn-danger">Edit</button></a>';
}
else if($session_user["rol"] != "reader")
{
    echo '<a href="index.php?page=gallery&album=' . $_GET["album"] . '&edit">
  <button type="submit" class="btn btn-warning">Edit</button></a>';
}

if(isset($_GET["edit"]))
{
  $dir = scandir("images/gallery" . DIRECTORY_SEPARATOR . $album["name"]);
  echo '<br><br><h2>Editar carpeta</h2><hr>
    <div class="row">
    <div class="col mr-2">
		  <h2>Album info</h2>
		  <form method="post" action="index.php?page=gallery&album=' . $_GET["album"] . '&edit">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label class="input-group-text" for="album_name">Name</label>
          </div>
              <input type="text" class="form-control" id="album_name" name="new_folder_name" value="' . $album["name"] . '"><hr>
          </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label class="input-group-text" for="album_description">Descripcion</label>
          </div>
              <textarea class="form-control" id="album_description" row=5 name="album_description">' . $album["description"] . '</textarea><hr>
          </div>
            <button type="submit" class="btn btn-primary">Send</button>
          </form>
          <hr>
          <h5>Add new tag</h5>
        <form method="post" action="index.php?page=gallery&album=' . $_GET["album"] . '&edit">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="new_tag">Tag</label>
            </div>
                <input type="text" class="form-control" id="new_tag" name="new_tag" placeholder="New tag">
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
        <hr>
        <h5>Delete tag</h5>
        <form method="post" action="index.php?page=gallery&album=' . $_GET["album"] . '&edit">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="delete_tag">Tag</label>
            </div>
              <select class="custom-select" id="delete_tag" name="delete_tag">';
              foreach ($dir as $value) {
                if($value!="." && $value!=".." && $value!="No-category")
                {
                  if(is_dir("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $value))
                  {
                    echo '<option value="' . $value . '">' . ucfirst($value) . '</option>';
                  }
                }
              }
    echo'</select>            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>

				</div>';
		echo '<div class="col mr-4">
      <h2>Upload images</h2>
      <form method="post" enctype="multipart/form-data" action="index.php?page=gallery&album=' . $_GET["album"] . '&edit">
        <div class="input-group mb-3">
          <div class="custom-file">
          <input type="file" accept=".jpg, .png, .jpeg, .gif, .mp4, .mov, .avi, .mkv " name="upload[]" multiple class="custom-file-input" id="multiFile" onchange="updateList()">
            <label class="custom-file-label" for="multiFile">Choose file</label>
          </div>
          <div class="input-group my-2">
            <div class="input-group-prepend">
              <label class="input-group-text" for="tag_new_images">Tag</label>
            </div>
            <select class="custom-select" id="tag_new_images" name="tag_new_images">
              <option value="No-category" selected>No category</option>';
              foreach ($dir as $value) {
                if($value!="." && $value!=".." && $value!="No-category")
                {
                  if(is_dir("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $value))
                  {
                    echo '<option value="' . $value . '">' . ucfirst($value) . '</option>';
                  }
                }
              }
    echo'</select>
          </div>
          <small class="form-text text-muted">All the images that will be uploaded will be saved with the following tag</small>

        </div>
            <button type="submit" class="btn btn-primary">Send</button>
          </form>
          <hr>
		  <h4>Selected files:</h4>
		  <div id="fileList"></div>
		</div>
    </div><hr><br>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Media</th>
          <th>Name</th>
          <th>Tag</th>
          <th>Size</th>
          <th></th>
        </tr>
      </thead>
		  <tbody>';

    
		foreach ($dir as $tag) {
		if($tag!="." && $tag!="..")
		{
			if(is_dir("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $tag))
      {
        $album_folder = scandir("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $tag);
        foreach ($album_folder as $image) {
          if($image!="." && $image!="..")
          {
            echo '<tr>';
            if(strpos($image,'mp4'))
            {
              echo '
              <td>
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                  <div class="embed-responsive embed-responsive-4by3">
                    <iframe src="images/gallery' . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $tag . DIRECTORY_SEPARATOR . $image . '" sandbox></iframe>
                  </div>
                </div>
              </td>';
            }
            else if(!strpos($image, 'mp4'))
            {
              echo '<td><img src="images/gallery' . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $tag . DIRECTORY_SEPARATOR . $image . '" width="130" height="130"></td>';
            }

              echo '<td>' . $image . '</td>';
              echo '<td>
              <form action="index.php?page=gallery&album=' . $_GET["album"] . '&edit" method="post">
                <input type="text" hidden class="form-control" name="image_name" value="' . $image . '">
                <input type="text" hidden class="form-control" name="current_tag" value="' . $tag . '">
                <select class="form-control mb-2" name="image_tag">';
              foreach ($dir as $tag_select) {
                if($tag_select!="." && $tag_select!="..")
                {
                  echo '<option value="' . $tag_select . '"';
                  if($tag_select == $tag)
                  {
                    echo 'selected';
                  }
                  echo '>' . $tag_select . '</option>';
                }
              }
              echo '</select>
              <button type="submit" class="btn btn-warning">Change Tag</button>
              </form>
              </td>';

              echo '<td>'.number_format(filesize("images/gallery" . DIRECTORY_SEPARATOR . $album["name"] . DIRECTORY_SEPARATOR . $tag . DIRECTORY_SEPARATOR . $image)/1048576, 2).' MB</td>';
              echo '
              <td>
                <form action="index.php?page=gallery&album=' . $_GET["album"] . '&edit" method="post">
                  <div class="form-group">
                    <input type="text" hidden class="form-control" name="delete_img" value="' . $tag . DIRECTORY_SEPARATOR . $image . '">
                    <button type="submit" class="btn btn-danger">Remove</button>
                  </div>
                </form>
              </td>';
              echo '</tr>';
          }
        }
      }
			
			}
		}
		echo '</tbody>
			</table>
			</div>';
}
else
{
  if($json_data["gallery"]["type"] == "Zoom Gallery View")
  {
    require_once("zoomGallery.php");
	  echo create_zoom_gallery(0, $album);
  }
  else if($json_data["gallery"]["type"] == "Grid Gallery View")
  {
    require_once("gridGallery.php");
	  echo create_grid_gallery(0, $album);
  }
  else if($json_data["gallery"]["type"] == "Carousel View")
  {
    include_once("carouselGallery.php");
  }
  else if($json_data["gallery"]["type"] == "Basic Carousel View")
  {
    include_once("basicCarouselGallery_v2.php");
  }
}
/*
	if(!isset($_SESSION['user']))
	{
	  header('location:index.php?page=login');
	}
	$path = __DIR__.DIRECTORY_SEPARATOR."galeria";
	$folder = "";
	$columns = 0;
	$first = true;

	if(isset($_GET["folder"]))
	{
		$folder = $_GET["folder"];
		if(stripos($folder, DIRECTORY_SEPARATOR))
		{
			echo '<a href="index.php?page=gallery&folder='.substr($folder, 0, strrpos($folder,DIRECTORY_SEPARATOR)).'">
			<button type="submit" class="btn btn-primary">Back</button></a>';
		}
		else
		{
			echo '<a href="index.php?page=gallery">
			<button type="submit" class="btn btn-primary">Back</button></a>';
		}
	}

	$dir = scandir($path.DIRECTORY_SEPARATOR.$folder);

	if($_SESSION['user'] != "Invitado")
	{
		if(isset($_GET["edit"]))
		{
			echo '<a href="index.php?page=gallery&folder='.$folder.'">
			<button type="submit" class="btn btn-danger">Edit</button></a>';
		}
		else
		{
			if(isset($_GET["folder"]))
			{
				echo '<a href="index.php?page=gallery&folder='.$folder.'&edit">
			<button type="submit" class="btn btn-primary">Edit</button></a>';
			}
			else
			{
				echo '<a href="index.php?page=gallery&edit">
			<button type="submit" class="btn btn-primary">Edit</button></a>';
			}
		}
	}

	if(isset($_GET["edit"]))
	{
		if(isset($_POST['delete']))
		{
			if(is_dir('galeria'.DIRECTORY_SEPARATOR.$_POST['delete']))
			{
				rmdir('galeria'.DIRECTORY_SEPARATOR.$_POST['delete']);
			}
			else
			{
				unlink('galeria'.DIRECTORY_SEPARATOR.$_POST['delete']);
			}
			if(isset($_GET["folder"]))
      {
				header('location:index.php?page=gallery&folder='.$folder.'&edit');
      }
			else
      {
				header('location:index.php?page=gallery&edit');
      }
		}
		if(isset($_POST['newName']))
		{
			//rename(old, new)
			if(isset($_GET["folder"]))
			{
				mkdir('galeria'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$_POST['folder'],0777);
				if(isset($_POST['description']) && $_POST['description'] != "")
				{
					$myfile = fopen('galeria'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$_POST['folder'].DIRECTORY_SEPARATOR."comentario.txt", "w") or die("Unable to open file!");
					fwrite($myfile,$_POST['description']);
					fclose($myfile);
				}
				header('location:index.php?page=gallery&folder='.$folder.'&edit');
			}
			else
			{
				mkdir('galeria'.DIRECTORY_SEPARATOR.$_POST['folder'],0777);
				if(isset($_POST['description']) && $_POST['description'] != "")
				{
					$myfile = fopen('galeria'.DIRECTORY_SEPARATOR.$_POST['folder'].DIRECTORY_SEPARATOR."comentario.txt", "w") or die("Unable to open file!");
					fwrite($myfile,$_POST['description']);
					fclose($myfile);
				}
				header('location:index.php?page=gallery&edit');
			}
		}

		if(isset($_POST['folder']))
		{
			if(isset($_GET["folder"]))
			{
				mkdir('galeria'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$_POST['folder'],0777);
				if(isset($_POST['description']) && $_POST['description'] != "")
				{
					$myfile = fopen('galeria'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$_POST['folder'].DIRECTORY_SEPARATOR."comentario.txt", "w") or die("Unable to open file!");
					fwrite($myfile,$_POST['description']);
					fclose($myfile);
				}
				header('location:index.php?page=gallery&folder='.$folder.'&edit');
			}
			else
			{
				mkdir('galeria'.DIRECTORY_SEPARATOR.$_POST['folder'],0777);
				if(isset($_POST['description']) && $_POST['description'] != "")
				{
					$myfile = fopen('galeria'.DIRECTORY_SEPARATOR.$_POST['folder'].DIRECTORY_SEPARATOR."comentario.txt", "w") or die("Unable to open file!");
					fwrite($myfile,$_POST['description']);
					fclose($myfile);
				}
				header('location:index.php?page=gallery&edit');
			}
		}

		if(isset($_FILES['upload']))
		{
			for( $i=0 ; $i < count($_FILES['upload']['name']) ; $i++ ) {
				move_uploaded_file($_FILES['upload']['tmp_name'][$i], 'galeria'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$_FILES['upload']['name'][$i]);
			}

			header('location:index.php?page=gallery&folder='.$folder.'&edit');
		}
		echo '
    <script type="text/javascript">
      function updateList() {
        var input = document.getElementById(\'multiFile\');
        var output = document.getElementById(\'fileList\');
        var children = "";
        for (var i = 0; i < input.files.length; ++i) {
          children += \'<li>\' + input.files.item(i).name + \'</li>\';
        }
        output.innerHTML = \'<ul>\'+children+\'</ul>\';
      }
		</script>';

		echo '<br><br><h2>Editar carpeta</h2><hr>
    <div class="row">';

		echo '
    <div class="col-3 mr-2">
		  <h2>Cambiar info carpeta</h2>
		  <form method="post" action="index.php?page=gallery'; 
			if(isset($_GET["folder"]))
      {
				echo '&folder='.$folder;
      }
			echo '&edit">
            <label>Nuevo nombre</label><br>
            <input type="text" name="newName" value="'.$folder.'">
            <label>Descripcion carpeta</label><br>
            <input type="text" name="newDescription"><hr>
            <button type="submit" class="btn btn-primary">Send</button>
          </form>
				</div>';
		echo '
    <div class="col-3 mr-2">
      <h2>Nueva carpeta</h2>
      <form method="post" action="index.php?page=gallery'; 
			if(isset($_GET["folder"]))
      {
				echo '&folder='.$folder;
      }
			echo '&edit">
            <label>Nombre carpeta</label><br>
            <input type="text" name="folder">
            <label>Descripcion carpeta</label><br>
            <input type="text" name="description"><hr>
            <button type="submit" class="btn btn-primary">Send</button>
				  </form>
				</div>';
		echo '
    <div class="col-2 mr-4">
      <h2>Subir archivos</h2>
      <form method="post" enctype="multipart/form-data" action="index.php?page=gallery'; 
			if(isset($_GET["folder"]))
      {
				echo '&folder='.$folder;
      }
			echo '&edit">
            <label>Archivos</label><br>
            <input type="file" name="upload[]" multiple id="multiFile" onchange="updateList()"><hr>
            <button type="submit" class="btn btn-primary">Send</button>
          </form>
				</div>
    <div class="col-3">
		  <h4>Selected files:</h4>
		  <div id="fileList"></div>
		</div>
    </div><hr><br>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Media</th>
          <th>Name</th>
          <th>Size</th>
          <th></th>
        </tr>
      </thead>
		  <tbody>';

		foreach ($dir as $value) {
		if($value!="." && $value!="..")
		{
			if(!empty($folder))
			{
				$file = $folder.DIRECTORY_SEPARATOR.$value;
			}
			else
			{
				$file = $value;
			}

			if(is_dir($path.DIRECTORY_SEPARATOR.$file))
			{
				echo '<tr>';
				echo '<td><img src="css'.DIRECTORY_SEPARATOR.'Img'.DIRECTORY_SEPARATOR.'folder.png" width="100" height="130"></td>';
				echo '<td>'.$value.'</td>';
				echo '<td>'.number_format(sizeFolder('galeria'.DIRECTORY_SEPARATOR.$file)/1048576/1000, 2).' GB</td>';
        echo '
          <td>
            <form action="index.php?page=gallery&folder='.$folder.'&edit" method="post">
            <div class="form-group">
              <input type="text" hidden class="form-control" name="delete" value="'.$file.'">
              <button type="submit" class="btn btn-primary">Remove</button>
            </div>
            </form>
          </td>
        </tr>';
			}

			}
		}

		foreach ($dir as $value) {
		if($value!="." && $value!=".." && $value!="comentario.txt")
		{
			if(!empty($folder))
			{
				$file = $folder.DIRECTORY_SEPARATOR.$value;
			}
			else
			{
				$file = $value;
			}

			if(!is_dir($path.DIRECTORY_SEPARATOR.$file))
			{
				echo '<tr>';
				if(strpos($value,'mp4'))
				{
					echo '
          <td>
            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <div class="embed-responsive embed-responsive-4by3">
                <iframe src="galeria'.DIRECTORY_SEPARATOR.$file.'" sandbox></iframe>
              </div>
            </div>
          </td>';
				}
				else if(!strpos($value,'mp4'))
				{
					echo '<td><img src="galeria'.DIRECTORY_SEPARATOR.$file.'" width="100" height="130"></td>';
				}

					echo '<td>'.$value.'</td>';
					
					echo '<td>'.number_format(filesize('galeria'.DIRECTORY_SEPARATOR.$file)/1048576, 2).' MB</td>';
					echo '
          <td>
            <form action="index.php?page=gallery&folder='.$folder.'&edit" method="post">
              <div class="form-group">
                <input type="text" hidden class="form-control" name="delete" value="'.$file.'">
                <button type="submit" class="btn btn-primary">Remove</button>
              </div>
            </form>
          </td>';
					echo '</tr>';
			}
			
			}
		}
		echo '</tbody>
			</table>
			</div>';
	}
	else
	{
		echo '<script type="text/javascript">
				$(document).ready(function(){
				$(".fancybox").fancybox({
						openEffect: "none",
						closeEffect: "none"
					});
					
					$(".zoom").hover(function(){
						
						$(this).addClass(\'transition\');
					}, function(){
						
						$(this).removeClass(\'transition\');
					});
				});
				</script>
		<div class="container page-top">';

		foreach ($dir as $value) {
			if($value!="." && $value!="..")
			{
				if(!empty($folder))
				{
					$file = $folder.DIRECTORY_SEPARATOR.$value;
				}
				else
				{
					$file = $value;
				}
				if(is_dir($path.DIRECTORY_SEPARATOR.$file))
				{
					$imgUrl = 'galeria/'.str_replace(DIRECTORY_SEPARATOR, '/', $file).'/portada.jpg';
					if(!file_exists($imgUrl))
					{
						$imgUrl = 'css/Img/carpeta.png';
					}
					
					echo '
          <section class="content-section bg-light folder-img" style="background: url(\''.$imgUrl.'\'); margin-bottom: 20px;" >
            <div class="container text-center">
              <div class="row">
                <div class="col-lg-7 mx-auto bg-white-transparent">
                  <a href="index.php?page=gallery&folder='.$file.'"><h2>'.$value.'</h2></a>';
                  if(file_exists("galeria".DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR."comentario.txt"))
                  {
                      echo '<h4>'.file_get_contents("galeria".DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR."comentario.txt").'</h4>';
                  }			            
                echo'</div>
            </div>
					</div>
				</section>';
				}
				
			}
		}

		foreach ($dir as $value) {
			if($value!="." && $value!=".." && $value!="comentario.txt")
			{
				if(!empty($folder))
				{
					$file = $folder.DIRECTORY_SEPARATOR.$value;
				}
				else
				{
					$file = $value;
				}
				if(!is_dir($path.DIRECTORY_SEPARATOR.$file))
				{
					if ($columns == 0) {
						if($first)
						{
							echo '<div class="row">';
							$first = false;
						}
						else
							echo '</div><div class="row">';
						$columns = 4;
					}
					$columns-=1;
					if(strpos($value,'mp4'))
					{
						echo '
            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <div class="embed-responsive embed-responsive-4by3">
                <iframe src="galeria'.DIRECTORY_SEPARATOR.$file.'" sandbox></iframe>
              </div>
            </div>';
					}
					else
					{
						echo '
            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
							<a href="galeria'.DIRECTORY_SEPARATOR.$file.'" class="fancybox" rel="ligthbox">
							  <img  src="galeria'.DIRECTORY_SEPARATOR.$file.'" class="zoom img-fluid "  alt="">
							</a>
						</div>';
					}
				}
				
			}
		}
		echo '</div>';
	}

  /**
 * Calculate the total size of a folder
 * 
 * @access public
 * @param string $src Folder path whose size wants to be calculated
 * @return int folder size
 */
  function sizeFolder($path)
	{
		$dir = scandir($path);
		$contents;
		$size = 0;
		foreach ($dir as $value) {
			if($value!="." && $value!="..")
			{
				if(!is_dir($path.DIRECTORY_SEPARATOR.$value))
				{
					//echo $path."/".$value."<br>";
					$size += filesize($path.DIRECTORY_SEPARATOR.$value);
				}
			}
		}
		foreach ($dir as $value) {
			if($value!="." && $value!="..")
			{
				if(is_dir($path.DIRECTORY_SEPARATOR.$value))
				{
					$size += sizeFolder($path.DIRECTORY_SEPARATOR.$value);
				}
			}
		}
		return $size;
	}
?>