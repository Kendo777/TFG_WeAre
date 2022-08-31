<?php
  if($json_data["web_data"]["web_structure"] == "basic")
  {
    $blank_id = 2;
  }
  else if(isset($_GET["id"]))
  {
    $blank_id = $_GET["id"];
  }

  if(isset($_GET["edit"]) && (isset($_SESSION["user"]) && $session_user["rol"] == "reader"))
  {
    if(isset($_GET["edit"]))
    {
      header('location:index.php?page=blank&id=' . $blank_id);
    }
    else
    {
      header('location:index.php?page=blank');
    }
  }
  if(isset($_POST["blank_page_content"]))
  {
    $post = str_replace("<script", "", $_POST["blank_page_content"]);
    $post = str_replace("</script>", "", $post);
    $post = str_replace("<style", "", $post);
    $post = str_replace("</style>", "", $post);
    $post = str_replace("<?php", "", $post);
    $post = str_replace("?>", "", $post);

    $post = mysql_fix_string($mySqli_db, $post);
    //*************************USER*****************************
    $user = $_SESSION["user"];
    $sql= $mySqli_db->prepare("UPDATE `blank_pages` SET `content`=? WHERE `id`=?");
    $sql->bind_param("si", $post, $blank_id);
    $sql->execute();
  }
  
  $sql= $mySqli_db->prepare("SELECT * FROM blank_pages WHERE id = ?");
  $sql->bind_param("i", $blank_id);
  $sql->execute();
  $result=$sql->get_result();
  $blank=$result->fetch_assoc();
  if($blank)
  {
    if(isset($_SESSION["user"]) && $session_user["rol"] != "reader")
    {
      if(!isset($_GET["edit"]))
      {
        echo '<div class="position-absolute end-0 d-flex mr-5">
        <a type="button" class="btn btn-warning mb-5" href="index.php?page=blank';
        if(isset($_GET["id"]))
        {
          echo '&id='. $blank_id;
        }
        echo '&edit"><i class="bi bi-pencil-fill"></i></a>
        </div>';
      }
      else
      {
        echo '<a type="button" class="btn btn-warning mb-5" href="index.php?page=blank';
        if(isset($_GET["id"]))
        {
          echo '&id='. $blank_id;
        }
        echo '" onclick="return confirm(\'You are going to return without save\nAre you sure?\')"><i class="bi bi-arrow-return-left"></i></a>';
      }
    }
  }
  else
  {
    echo '<p class="alert alert-danger">Invalid component ID</p>';
  }
?>

<main id="editor_content">
  <div class="centered my-2">
    <div class="row row-editor">
      <div class="editor-container">
        <div class="editor" id="<?php if(!isset($_GET["edit"])) echo 'editor-off'; else echo 'editor'; ?>">
          <?php
            if($blank)
            {
              echo str_replace("\'", "'",str_replace("\\\"", "\"", $blank["content"]));
            }
          ?>
        </div>
      </div>
    </div></div>
</main>
<?php 
  if(isset($_GET["edit"]))
  {
    echo'<div class="position-absolute end-0 d-flex mr-4 mt-3 pb-5">
    <form action="index.php?page=blank';
    if(isset($_GET["id"]))
    {
      echo '&id='. $blank_id;
    }
    echo '" method="post" role="form">
      <input type="hidden" id="blank_page_content" name="blank_page_content">
      <button type="submit" class="btn btn-primary" onclick="save_content()">Save changes</button>
    </form>
    </div>';
  }
?>
<script src="../../StructureScripts/assets/CKEditor/build/ckeditor.js"></script>
<script type="text/javascript">
/*window.onload = function exampleFunction() {
  
  document.getElementById("editor").contentEditable = 'false';
}*/
InlineEditor
				.create( document.querySelector( '.editor' ), {
					
					licenseKey: '',
					
					
					
				} )
				.then( editor => {
					window.editor = editor;
          <?php
            if(!isset($_GET["edit"]))
            {
              echo "window.editor.enableReadOnlyMode( 'editor' );";
            }
          ?>
					
				} )
				.catch( error => {
					console.error( 'Oops, something went wrong!' );
					console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
					console.warn( 'Build id: ovla453mle2q-1qxbxw3xwq5' );
					console.error( error );
				} );

function save_content(){
  //document.getElementById("editor").contentEditable = 'false';
  document.getElementById("blank_page_content").value = window.editor.getData();
}

		</script>