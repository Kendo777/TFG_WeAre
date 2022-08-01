<?php

function create_zoom_gallery($path, $columns)
{
  $zoom_gallery_code = "";

  $folder = "";
  if(isset($_GET["folder"]))
  {
    $folder = $_GET["folder"];
  }

  $zoom_gallery_code.= '<section id="portfolio" class="portfolio" data-aos="fade-up">
    <div class="container">
      <div class="section-header">';

  if(isset($_GET["folder"]))
  {
    if(strrpos($folder, DIRECTORY_SEPARATOR))
    {
      $zoom_gallery_code.= '<h2>' . substr($folder, strrpos($folder, DIRECTORY_SEPARATOR) + 1) . '</h2>';
    }
    else
    {
      $zoom_gallery_code.= '<h2>' . $folder . '</h2>';
    }
    $zoom_gallery_code.= '<p>Description</p>';
  }
  else
  {
    $zoom_gallery_code.= '<h2>Gallery</h2>';
    $zoom_gallery_code.= '<p>Description</p>';
  }

  $zoom_gallery_code.= '</div>
    </div>';

  if(isset($_GET["folder"]))
  {
    if(stripos($folder, DIRECTORY_SEPARATOR))
    {
      $zoom_gallery_code.= '<a href="index.php?page=gallery&folder=' . substr($folder, 0, strrpos($folder,DIRECTORY_SEPARATOR)) . '">
      <button type="submit" class="btn btn-primary">Back</button></a>';
    }
    else
    {
      $zoom_gallery_code.= '<a href="index.php?page=gallery">
      <button type="submit" class="btn btn-primary">Back</button></a>';
    }
  }

  $dir = scandir($path . DIRECTORY_SEPARATOR . "images/gallery" . DIRECTORY_SEPARATOR . $folder);

  $zoom_gallery_code.= '
  <div class="container-fluid" data-aos="fade-up" data-aos-delay="200">

    <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">

      <ul class="portfolio-flters">
        <li data-filter="*" class="filter-active">All</li>
        <li data-filter=".filter-image">Images</li>
        <li data-filter=".filter-folder">Folders</li>
      </ul><!-- End Portfolio Filters -->

      <div class="row g-0 portfolio-container">';

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

      if(!is_dir($path . DIRECTORY_SEPARATOR . "images/gallery" . DIRECTORY_SEPARATOR . $file))
      {
        $zoom_gallery_code.= '
        <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-image" style="padding-left: 2px; padding-right: 0px; padding-bottom: 2px;">
          <img src="images/gallery' . DIRECTORY_SEPARATOR . $file . '" class="img-fluid glightbox preview-link" alt="">
          <div class="portfolio-info" style="top: 0 !important;">
            <a href="images/gallery' . DIRECTORY_SEPARATOR . $file . '" data-gallery="portfolio-gallery" class="glightbox preview-link" style="left: 45% !important;">
              <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
            </a>
          </div>
        </div><!-- End Portfolio Item -->
        ';
      }
    }
  }

  $zoom_gallery_code.= '</div><!-- End Portfolio Container -->
    </div>
  </div>
  </section><!-- End Portfolio Section -->';

  return $zoom_gallery_code;
}