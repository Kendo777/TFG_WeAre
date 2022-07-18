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

<section id="testimonials" class="testimonials" style="background: none !important; padding-top: 3% !important;">
  <div class="container" data-aos="fade-up">
    <div class="testimonials-slider swiper">
      <div class="swiper-wrapper" >

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
          <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="images/gallery' . DIRECTORY_SEPARATOR . $file . '">
              </div>
          </div><!-- End testimonial item -->
          ';
      }
    }
  }

?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
      </div>
    </section><!-- End Testimonials Section -->