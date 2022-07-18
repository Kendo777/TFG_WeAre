<?php

function create_grid_gallery($path, $columns)
{
  $grid_gallery_code = "";

  $folder = "";
  if(isset($_GET["folder"]))
  {
    $folder = $_GET["folder"];
  }
  $grid_gallery_code.= '<section id="portfolio" class="portfolio" data-aos="fade-up">
    <div class="container">
      <div class="section-header">';
  if(isset($_GET["folder"]))
  {
    if(strrpos($folder, DIRECTORY_SEPARATOR))
    {
      $grid_gallery_code.= '<h2>' . substr($folder, strrpos($folder, DIRECTORY_SEPARATOR) + 1) . '</h2>';
    }
    else
    {
      $grid_gallery_code.= '<h2>' . $folder . '</h2>';
    }
    $grid_gallery_code.= '<p>Description</p>';
  }
  else
  {
    $grid_gallery_code.= '<h2>Gallery</h2>';
    $grid_gallery_code.= '<p>Description</p>';
  }
  $grid_gallery_code.= '</div>
    </div>';

  $dir = scandir($path . DIRECTORY_SEPARATOR . "images/gallery" . DIRECTORY_SEPARATOR . $folder);

  $grid_gallery_code.= '<div class="container-fluid" data-aos="fade-up" data-aos-delay="200">
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
        $grid_gallery_code.= '
        <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-image" style="pointer-events: none !important;">
          <img src="images/gallery' . DIRECTORY_SEPARATOR . $file . '" class="img-fluid" alt="">
        </div><!-- End Portfolio Item -->
        ';
      }
    }
  }
  $grid_gallery_code.= '</div><!-- End Portfolio Container -->
    </div>
  </div>
  </section><!-- End Portfolio Section -->';

  return $grid_gallery_code;
}