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

if($json_data["web_data"]["web_structure"] == "basic")
{
  $album_id = 1;
}
else if(isset($_GET["id"]))
{
  $album_id = $_GET["id"];
}

$sql= $mySqli_db->prepare("SELECT * FROM galleries WHERE id = ?");
$sql->bind_param("i",$album_id);
$sql->execute();
$result=$sql->get_result();
$album=$result->fetch_assoc();

  if(isset($_GET["edit"]) && (!isset($_SESSION["user"]) || $session_user["rol"] == "reader"))
  {
    header('location:index.php?page=gallery&id=' . $album_id);
  }
  if(isset($_POST['new_folder_name']))
  {
    if(!file_exists("images/gallery" . DIRECTORY_SEPARATOR . $_POST['new_folder_name']))
    {
      $title = mysql_fix_string($mySqli_db, $_POST['new_folder_name']);
      mkdir("images/gallery" . DIRECTORY_SEPARATOR . $_POST['new_folder_name'], 0700);
      copy_folder("images/gallery" . DIRECTORY_SEPARATOR . $album["title"], "images/gallery" . DIRECTORY_SEPARATOR . $_POST['new_folder_name']);
      deleteDir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"]);

      $sql= $mySqli_db->prepare("UPDATE `galleries` SET `name`=? WHERE id = ?");
      $sql->bind_param("si", $title, $album_id);
      $sql->execute();

      header('location:index.php?page=gallery&id=' . $album_id . '&edit');
    }
    else if($_POST['new_folder_name'] != $album["title"])
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
      $sql->bind_param("si", $description, $album_id);
      $sql->execute();
  }

  if(isset($_FILES["upload"]) && isset($_POST["tag_new_images"]))
  {
    for( $i=0 ; $i < count($_FILES['upload']['name']) ; $i++ ) {
      move_uploaded_file($_FILES['upload']['tmp_name'][$i], "images/gallery" . DIRECTORY_SEPARATOR. $album["title"] . DIRECTORY_SEPARATOR . $_POST["tag_new_images"] . DIRECTORY_SEPARATOR . $_FILES['upload']['name'][$i]);
    }
  }
  if(isset($_POST['new_tag']))
  {
    if(!file_exists("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $_POST['new_tag']))
    {
      mkdir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $_POST['new_tag'], 0700);
    }
    else
    {
      $errorMsg.='<p class="alert alert-danger">Tag already exists!</p>';
    }
  }
  if(isset($_POST['delete_img']))
  {
    unlink("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $_POST['delete_img']);
  }
  if(isset($_POST["delete_all_images"]))
  {
    $dir = scandir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"]);
    foreach ($dir as $value) {
      if($value!="." && $value!="..")
      {
        if(is_dir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $value))
        {
          deleteDir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $value);
        }
      }
    }
    mkdir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . "No-category", 0700);

  }
  if(isset($_POST['delete_tag']))
  {
    copy_folder("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $_POST["delete_tag"], "images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . "No-category");
    deleteDir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $_POST["delete_tag"]);
  }

  if(isset($_POST["image_tag"]))
  {
    $image_name = $_POST['image_name'];
    $count = 1;
    while(file_exists("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $_POST['image_tag'] . DIRECTORY_SEPARATOR . $image_name))
    {
      $image_name = substr($_POST["image_name"], 0, strrpos($_POST["image_name"], ".")) . "(" . $count . ")" . substr($_POST["image_name"], strrpos($_POST["image_name"], "."));
      $count++;
    }
    rename("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $_POST["current_tag"] . DIRECTORY_SEPARATOR . $_POST['image_name'], "images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $_POST['image_tag'] . DIRECTORY_SEPARATOR . $image_name);
  }

  echo $errorMsg;

$sql= $mySqli_db->prepare("SELECT * FROM galleries WHERE id = ?");
$sql->bind_param("i",$album_id);
$sql->execute();
$result=$sql->get_result();
$album=$result->fetch_assoc();

if($album)
{
  if(isset($_GET["edit"]))
  {
    echo '<a href="index.php?page=gallery&id=' . $album_id . '">
    <button type="submit" class="btn btn-warning">Edit</button></a>';
  }
  else if(isset($_SESSION["user"])  && $session_user["rol"] != "reader")
  {
      echo '<a href="index.php?page=gallery&id=' . $album_id . '&edit">
    <button type="submit" class="btn btn-warning">Edit</button></a>';
  }

  if(isset($_GET["edit"]))
  {
    $dir = scandir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"]);
    echo '<br><br><h2>Editar carpeta</h2><hr>
      <div class="row">
      <div class="col mr-2">
        <h2>Album info</h2>
        <form method="post" action="index.php?page=gallery&id=' . $album_id . '&edit">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="album_name">Name</label>
            </div>
                <input type="text" class="form-control" id="album_name" name="new_folder_name" value="' . $album["title"] . '"><hr>
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
          <form method="post" action="index.php?page=gallery&id=' . $album_id . '&edit">
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
          <form method="post" action="index.php?page=gallery&id=' . $album_id . '&edit">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="delete_tag">Tag</label>
              </div>
                <select class="custom-select" id="delete_tag" name="delete_tag">';
                foreach ($dir as $value) {
                  if($value!="." && $value!=".." && $value!="No-category")
                  {
                    if(is_dir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $value))
                    {
                      echo '<option value="' . $value . '">' . ucfirst($value) . '</option>';
                    }
                  }
                }
      echo'</select>            </div>
              <button type="submit" class="btn btn-primary">Send</button>
          </form>
          <hr>
          <h5>Delete all images</h5>
          <form method="post" action="index.php?page=gallery&id=' . $album_id . '&edit">
          <input type="hidden" name="delete_all_images">
          <button type="submit" class="btn btn-danger" onclick="return confirm(\'You are going to delete all the images and tags in the gallery\nAre you sure?\')">Send</button>
          </form>
          </div>';
      echo '<div class="col mr-4">
        <h2>Upload images</h2>
        <form method="post" enctype="multipart/form-data" action="index.php?page=gallery&id=' . $album_id . '&edit">
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
                    if(is_dir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $value))
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
        if(is_dir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $tag))
        {
          $album_folder = scandir("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $tag);
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
                      <iframe src="images/gallery' . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $tag . DIRECTORY_SEPARATOR . $image . '" sandbox></iframe>
                    </div>
                  </div>
                </td>';
              }
              else if(!strpos($image, 'mp4'))
              {
                echo '<td><img src="images/gallery' . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $tag . DIRECTORY_SEPARATOR . $image . '" width="130" height="130"></td>';
              }

                echo '<td>' . $image . '</td>';
                echo '<td>
                <form action="index.php?page=gallery&id=' . $album_id . '&edit" method="post">
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

                echo '<td>'.number_format(filesize("images/gallery" . DIRECTORY_SEPARATOR . $album["title"] . DIRECTORY_SEPARATOR . $tag . DIRECTORY_SEPARATOR . $image)/1048576, 2).' MB</td>';
                echo '
                <td>
                  <form action="index.php?page=gallery&id=' . $album_id . '&edit" method="post">
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
    if($album["type"] == "Zoom Gallery View")
    {
      require_once("zoomGallery.php");
      echo create_zoom_gallery(0, $album);
    }
    else if($album["type"] == "Grid Gallery View")
    {
      require_once("gridGallery.php");
      echo create_grid_gallery(0, $album);
    }
    else if($album["type"] == "Carousel View")
    {
      include_once("carouselGallery.php");
    }
    else if($album["type"] == "Basic Carousel View")
    {
      include_once("basicCarouselGallery_v2.php");
    }
  }
}
else
{
  echo '<p class="alert alert-danger">Invalid component ID</p>';
}

?>