<?php

function create_zoom_gallery($columns, $album)
{
  $zoom_gallery_code = "";

  $folder = $album["name"];

  $zoom_gallery_code.= '<section id="portfolio" class="portfolio" data-aos="fade-up">
    <div class="container">
      <div class="section-header">';

  $zoom_gallery_code.= '<h2>' . $folder . '</h2>
  <p>' . $album["description"] . '</p>
  </div>
    </div>';

  $dir = scandir("images/gallery" . DIRECTORY_SEPARATOR . $folder);

  $zoom_gallery_code.= '
  <div class="container-fluid" data-aos="fade-up" data-aos-delay="200">

    <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">

      <ul class="portfolio-flters">
        <li data-filter="*" class="filter-active">All</li>';
    foreach ($dir as $value) {
      if($value!="." && $value!=".." && $value!="No-category")
      {
        if(is_dir("images/gallery" . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $value))
        {
          $zoom_gallery_code.= '<li data-filter=".filter-' . $value . '">' . ucfirst($value) . '</li>';
        }
      }
    }
  $zoom_gallery_code.= '</ul><!-- End Portfolio Filters -->

      <div class="row g-0 portfolio-container">';
  foreach ($dir as $tag) {
    if($tag!="." && $tag!="..")
    {
      if(is_dir("images/gallery" . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $tag))
      {
        $album = scandir("images/gallery" . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $tag);
        foreach ($album as $image) {
          if($image!="." && $image!="..")
          {
            $zoom_gallery_code.= '
            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-' . $tag .'" style="padding-left: 2px; padding-right: 0px; padding-bottom: 2px;">
              <img src="images/gallery' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $tag . DIRECTORY_SEPARATOR . $image . '" class="img-fluid glightbox preview-link" alt="">
              <div class="portfolio-info" style="top: 0 !important;">
                <a href="images/gallery' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $tag . DIRECTORY_SEPARATOR . $image . '" data-gallery="portfolio-gallery" class="glightbox preview-link" style="left: 45% !important;">
                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                </a>
              </div>
            </div><!-- End Portfolio Item -->
            ';
          }
        }
        
      }
    }
  }

  $zoom_gallery_code.= '</div><!-- End Portfolio Container -->
    </div>
  </div>
  </section><!-- End Portfolio Section -->';

  return $zoom_gallery_code;
}