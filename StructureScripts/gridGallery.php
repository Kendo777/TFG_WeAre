<?php

  $folder = "";
  if(isset($_GET["folder"]))
  {
    $folder = $_GET["folder"];
  }
?>
<section id="portfolio" class="portfolio" data-aos="fade-up">

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

  $path = __DIR__ . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "gallery";
  $columns = 0;

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

  $dir = scandir($path . DIRECTORY_SEPARATOR . $folder);
?>

<div class="container-fluid" data-aos="fade-up" data-aos-delay="200">

  <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">

    <ul class="portfolio-flters">
      <li data-filter="*" class="filter-active">All</li>
      <li data-filter=".filter-image">Images</li>
      <li data-filter=".filter-folder">Folders</li>
    </ul><!-- End Portfolio Filters -->

    <div class="row g-0 portfolio-container">

<?php

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
        <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-image" style="pointer-events: none !important;">
          <img src="assets/img/gallery' . DIRECTORY_SEPARATOR . $file . '" class="img-fluid" alt="">
        </div><!-- End Portfolio Item -->
        ';
      }
      else
      {
        echo '
        <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-folder border-warning" style="border-radius: 16px !important; border-width: 1px !important;">
          <img src="assets/img/folder.png" class="img-fluid glightbox preview-link" alt="">
          <div class="portfolio-info" style="top: 0 !important;">
          <a href="index.php?page=gallery&folder='.$file.'" data-gallery="portfolio-gallery" class="preview-link" style="left: 30% !important; text-align: center !important;"> 
            <h4 style="font-size: 1.5vw !important;"><i class="bi-zoom-in"> ' . $value . '</i></h4> 
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