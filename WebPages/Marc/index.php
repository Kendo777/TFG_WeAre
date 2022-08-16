<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>WE ARE</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/WeLogo.PNG" rel="icon">

  <!-- Vendor CSS Files -->
  <link href="../../StructureScripts/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../StructureScripts/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../StructureScripts/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../../StructureScripts/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../StructureScripts/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../StructureScripts/assets/css/calendar.css">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- SIDE BAR Custom CSS -->
    <link rel="stylesheet" href="../../StructureScripts/assets/sideBar/style4.css">

  <!-- Variables CSS Files. Uncomment your preferred color scheme -->
  <!-- <link href="assets/css/variables.css" rel="stylesheet"> -->
  <link href="../../StructureScripts/assets/css/variables-blue.css" rel="stylesheet">
  <!-- <link href="assets/css/variables-green.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-orange.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-purple.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-red.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-pink.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="../../StructureScripts/assets/css/main.css" rel="stylesheet">
  <link href="../../StructureScripts/assets/css/style.css" rel="stylesheet">


  <!-- Vendor JS Files -->
  <script src="../../StructureScripts/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../StructureScripts/assets/vendor/aos/aos.js"></script>
  <script src="../../StructureScripts/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../StructureScripts/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../../StructureScripts/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../StructureScripts/assets/vendor/php-email-form/validate.js"></script>

  <!-- jQuery CDN - Slim version (=without AJAX) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


  <script type="text/javascript">
      $(document).ready(function () {
          $('#sidebarCollapse').on('click', function () {
              $('#sidebar').toggleClass('active');
          });
      });
      function toggleFunc(div) {
          var x = document.getElementById(div);
          if (x.style.display === "none") {
          x.style.display = "block";
          } else {
          x.style.display = "none";
          }
      }
      function updateTextInput(val) {
          document.getElementById('textInput').innerHTML=val+"$"; 
      }
  </script>
  <!-- =======================================================
  * Template Name: HeroBiz - v2.1.0
  * Template URL: https://bootstrapmade.com/herobiz-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
<?php
  $url= substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "index.php"));   
  $json = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'webConfig.json');
  $json_data = json_decode($json, true);
?>
  <style>
    body {
        background-color: <?php echo $json_data["style"]["bck_color"] ?>;
        color: <?php echo $json_data["style"]["primary_color"] ?>;
    }
    #sidebar {
      background-color: <?php echo $json_data["style"]["secundary_color"] ?>;
    }
  </style>
</head>

<body>

<?php

    require_once("../../mySqli.php");
    session_start();
    $mySqli_db = mysql_client_db(strtolower(basename(__DIR__)));
    $sql= $mySqli_db->prepare("SELECT * FROM users WHERE user=?");
    $sql->bind_param("s", $_SESSION["user"]);
    $sql->execute();
    $result=$sql->get_result();
    $session_user=$result->fetch_assoc();
    $errorMsg='';
    ob_start();
    if(!isset($_SESSION["path"]))
    {
        $_SESSION["path"] = __DIR__;
    }
    $page="home";
    include_once("../../StructureScripts/sideBar.php");
    if(isset($_GET["page"]))
    {
        if($_GET['page']=="logout")
        {
            session_destroy();
            header('location:index.php');
        }
        else
        {
            $page = $_GET["page"];
        }
    }
    if(file_exists("../../StructureScripts/".$page.".php"))
    {
        include_once("../../StructureScripts/".$page.".php");
    }
    //include_once("../../StructureScripts/footer.php");
    ob_end_flush();

?>

  <!-- Template Main JS File -->
  <script src="../../StructureScripts/assets/js/main.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="../../StructureScripts/assets/js/dynamicForm.js"></script>
  <script src="../../StructureScripts/assets/js/calendar.js"></script>
  <?php
  /*if(isset($_GET["edit"]))
  {
    echo '<script src="../../StructureScripts/assets/CKEditor/build/ckeditor.js"></script>
    <script type="text/javascript">
    InlineEditor
            .create( document.querySelector( ".editor" ), {
              
              licenseKey: "",
              
              
              
            } )
            .then( editor => {
              window.editor = editor;
          
              
              
              
            } )
            .catch( error => {
              console.error( "Oops, something went wrong!" );
              console.error( "Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:" );
              console.warn( "Build id: ovla453mle2q-1qxbxw3xwq5" );
              console.error( error );
            } );
    
    function save_content(){
      document.getElementById("editor").contentEditable = "false";
      document.getElementById("blank_page_content").value = document.getElementById("editor_content").innerHTML;
    }
        </script>';
  }*/
  ?>
</body>

</html>