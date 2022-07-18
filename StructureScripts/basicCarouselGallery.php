<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  
<?php

  $folder = "";
  if(isset($_GET["folder"]))
  {
    $folder = $_GET["folder"];
  }
?>
<section id="portfolio" class="portfolio" data-aos="fade-up" style="padding-bottom: 0 !important;">

<div class="container">

<div class="section-header">
<?php

  if(isset($_GET["folder"]))
  {
    if(strrpos($folder, DIRECTORY_SEPARATOR))
    {
      echo '<h2>' . substr($folder, strrpos($folder, DIRECTORY_SEPARATOR) + 1) . '</h2>';
    }
    else
    {
      echo '<h2>' . $folder . '</h2>';
    }
    echo '<p>Description</p>';
  }
  else
  {
    echo '<h2>Gallery</h2>';
    echo '<p>Description</p>';
  }
?>
  </div>

</div>

<?php
  $path = __DIR__ . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "gallery";

  if(isset($_GET["folder"]))
  {
    if(stripos($folder, DIRECTORY_SEPARATOR))
    {
      echo '<a href="index.php?page=gallery&folder=' . substr($folder, 0, strrpos($folder,DIRECTORY_SEPARATOR)) . '">
      <button type="submit" class="btn btn-primary">Back</button></a>';
    }
    else
    {
      echo '<a href="index.php?page=gallery">
      <button type="submit" class="btn btn-primary">Back</button></a>';
    }
  }
?>
<div class="container-fluid" data-aos="fade-up" data-aos-delay="200">

<div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">
  <div class="row g-0 portfolio-container">

<?php

  $dir = scandir($path . DIRECTORY_SEPARATOR . $folder);

  foreach ($dir as $value) {
    if($value!="." && $value!=".." && $value!="comentario.txt")
    {
      if(!empty($folder))
      {
        $file = $folder . DIRECTORY_SEPARATOR . $value;
      }
      else
      {
        $file = $value;
      }

      if(is_dir($path . DIRECTORY_SEPARATOR . $file))
      {
        echo '
        <div class="col-md-2 portfolio-item filter-folder">
          <img src="images/folder.png" class="img-fluid glightbox preview-link" alt="">
          <div class="portfolio-info" style="top: 0 !important;">
          <a href="index.php?page=gallery&folder='.$file.'" data-gallery="portfolio-gallery" class="preview-link" style="left: 0 !important;"> 
            <h4><i class="bi-zoom-in"> ' . $value . '</i></h4> 
          </a>
        </div>
        </div><!-- End Portfolio Item -->
        ';
      }
    }
  }
?>
    </div><!-- End Portfolio Container -->

</div>

</div>
</section><!-- End Portfolio Section -->


<div class="container">
  <div class="col-md-12">
      <div id="slideCarousel" class="carousel slide">

        <!-- Carousel items -->
        <div class="carousel-inner">
<?php
$first=true;
  foreach ($dir as $value) {
    if($value!="." && $value!=".." && $value!="comentario.txt")
    {
      if(!empty($folder))
      {
        $file = $folder . DIRECTORY_SEPARATOR . $value;
      }
      else
      {
        $file = $value;
      }

      if(!is_dir($path . DIRECTORY_SEPARATOR . $file))
      {
          echo '
          <div class="item ';
          if($first)
          {
            echo 'active';
            $first = false;
          }
          echo '">
            <img src="images/gallery' . DIRECTORY_SEPARATOR . $file . '">
          </div>
          <!--/item-->';
      }
    }
  }

?>
          </div>
          <!--/item-->
        </div>
        <!--/carousel-inner-->
        <a class="left carousel-control" href="#slideCarousel" data-slide="prev"><p>‹</p></a>

        <a class="right carousel-control" href="#slideCarousel" data-slide="next"><p>›</p></a>
      </div>
      <!--/myCarousel-->
  </div>
</div>
