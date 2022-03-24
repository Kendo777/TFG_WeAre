<?php
    ob_start();
?>

<!DOCTYPE html>
<html>
<?php
session_start();
$errorMsg="";
$page="home";
if(isset($_GET["page"]))
{
    if($_GET['page']=="logeOut")
    {
        session_destroy();
        header('location:index.php');
    }
    else
    {
        $page = $_GET["page"];
    }
}
if(isset($_POST["webName"]) && !is_dir("WebPages".DIRECTORY_SEPARATOR.$_POST["webName"]))
{
    mkdir("WebPages".DIRECTORY_SEPARATOR.$_POST["webName"], 0700);
    //IMPORT ALL BASICS SCRIPTS: PHP, CSS, JS,...
    $webData["webName"] = $_POST["webName"];
    $webData["webComponents"] = array();
    //user
    if(isset($_POST["gallery"]))
    {
        copy("StructureScripts".DIRECTORY_SEPARATOR."gallery.php", "WebPages".DIRECTORY_SEPARATOR.$_POST["webName"].DIRECTORY_SEPARATOR."gallery.php");
        array_push($webData["webComponents"],"gallery");
    }
    if(isset($_POST["posts"]))
    {
        //copy("StructureScripts".DIRECTORY_SEPARATOR."gallery.php", "WebPages".DIRECTORY_SEPARATOR.$_POST["webName"].DIRECTORY_SEPARATOR."gallery.php");
        array_push($webData["webComponents"],"posts");
    }
    if(isset($_POST["info"]))
    {
        copy("StructureScripts".DIRECTORY_SEPARATOR."userInfo.php", "WebPages".DIRECTORY_SEPARATOR.$_POST["webName"].DIRECTORY_SEPARATOR."userInfo.php");
        array_push($webData["webComponents"],"info");
    }
    $webJSON = fopen("WebPages".DIRECTORY_SEPARATOR.$_POST["webName"].DIRECTORY_SEPARATOR."webData.txt", "w") or die("Unable to open file!");
    fwrite($webJSON, json_encode($webData));
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>WE ARE</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style4.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</head>

<body>
    <form action='creator.php' method="post">
     <div class="form-row">
    <div class="form-group col-md-6">
      <label>Web Name</label>
      <input type="text" class="form-control" name="webName">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>
  </div>
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
      <div class="col-sm-10">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
          <label class="form-check-label" for="gridRadios1">
            First radio
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
          <label class="form-check-label" for="gridRadios2">
            Second radio
          </label>
        </div>
        <div class="form-check disabled">
          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
          <label class="form-check-label" for="gridRadios3">
            Third disabled radio
          </label>
        </div>
      </div>
    </div>
  </fieldset>
  <div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="gallery">
  <label class="form-check-label" for="defaultCheck1">
    Gallery
  </label>
</div>
  <div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="posts">
  <label class="form-check-label" for="defaultCheck1">
    Posts
  </label>
</div>
  <div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="info">
  <label class="form-check-label" for="defaultCheck1">
    Info
  </label>
</div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
  </div>
</form>
</body>

</html>
<?php
ob_end_flush();
?>
