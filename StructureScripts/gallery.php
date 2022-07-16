<?php

  $json = file_get_contents('webConfig.json');
  $json_data = json_decode($json, true);
  
  if($json_data["gallery"]["type"] == "Zoom Gallery View")
  {
    include_once("zoomGallery.php");
  }
  else if($json_data["gallery"]["type"] == "Grid Gallery View")
  {
    include_once("gridGallery.php");
  }
  else if($json_data["gallery"]["type"] == "Carousel View")
  {
    include_once("carouselGallery.php");
  }
  else if($json_data["gallery"]["type"] == "Basic Carousel View")
  {
    include_once("basicCarouselGallery.php");
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