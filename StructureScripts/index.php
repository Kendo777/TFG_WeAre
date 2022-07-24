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

  <!-- =======================================================
  * Template Name: HeroBiz - v2.1.0
  * Template URL: https://bootstrapmade.com/herobiz-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
<?php

  $json = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'webConfig.json');
  $json_data = json_decode($json, true);
?>
  <style>
    body {
        background-color: <?php echo $json_data["style"]["bck_color"] ?>;
    }
  </style>
</head>

<body>

<?php

    require_once("../../mySqli.php");
    session_start();
    $mySqli_db = mysql_client_db(strtolower(basename(__DIR__)));
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
    ob_end_flush();

?>

  <!-- Vendor JS Files -->
  <script src="../../StructureScripts/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../StructureScripts/assets/vendor/aos/aos.js"></script>
  <script src="../../StructureScripts/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../StructureScripts/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../../StructureScripts/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../StructureScripts/assets/vendor/php-email-form/validate.js"></script>
  <!-- Template Main JS File -->
  <script src="../../StructureScripts/assets/js/main.js"></script>
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
</body>

</html>