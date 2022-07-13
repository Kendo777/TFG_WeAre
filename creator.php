<?php
    class WebData {
        public $WebName;
        public $WebUser;
        public $WebDataBase;
        public $WebPrivacity;

        function __construct(string $webName, string $webUser, string $webDataBase, string $webPrivacity)
        {
            $this->WebName = $webName;
            $this->WebUser = $webUser;
            $this->WebDataBase = $webDataBase;
            $this->WebPrivacity = $webPrivacity;
        }
    }

    class WebStyle {
        public $bck_Color;

        function __construct(string $bck_Color) {
          $this->bck_Color = $bck_Color;
      }
    }

    class WebGallery {
        public $enable;
        public $type;

        function __construct() {
            $this->enable = false;
        }
        function set(string $type) {
          $this->enable = true;
          $this->type = $type;
        }
    }

    function copy_folder($src, $dst) { 
  
    $dir = opendir($src);   
    while( $file = readdir($dir) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if (is_dir($src.DIRECTORY_SEPARATOR.$file) ) 
            { 
                mkdir($dst.DIRECTORY_SEPARATOR.$file, 0700);
                copy_folder($src.DIRECTORY_SEPARATOR.$file, $dst.DIRECTORY_SEPARATOR.$file);
            } 
            else
            {
                copy($src.DIRECTORY_SEPARATOR.$file, $dst.DIRECTORY_SEPARATOR.$file); 
            }
        } 
    } 
  
    closedir($dir);
}
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
  if(isset($_POST["webName"]) && !empty($_POST["webName"]) && !is_dir("WebPages".DIRECTORY_SEPARATOR.$_POST["webName"]))
  {
      mkdir("WebPages".DIRECTORY_SEPARATOR.$_POST["webName"], 0700);
      copy_folder("StructureScripts","WebPages".DIRECTORY_SEPARATOR.$_POST["webName"]);

      //IMPORT ALL BASICS SCRIPTS: PHP, CSS, JS,...

      $webData = new WebData($_POST["webName"], "Test", $_POST["webName"], "Public");
      $webStyle = new WebStyle($_POST["styleBckColor"]);
      $webGallery = new WebGallery();

      if(isset($_POST["galleryEnable"]))
      {
          $webGallery->set($_POST["galleryType"]);
      }
      if(isset($_POST["posts"]))
      {

      }


      $webConfig = (object) [
          'WebData' => $webData,
          'Style' => $webStyle,
          'Gallery' => $webGallery
      ];

      $webJSON = fopen("WebPages".DIRECTORY_SEPARATOR.$_POST["webName"].DIRECTORY_SEPARATOR."webConfig.txt", "w") or die("Unable to open file!");
      fwrite($webJSON, json_encode($webConfig));
      $errorMsg.='<p class="alert alert-success">Web page: '.$_POST["webName"].' is created correctly</p>';
  }
  else if(!empty($_POST))
  {
      if(!isset($_POST["webName"]) || empty($_POST["webName"]))
      {
          $errorMsg.='<p class="alert alert-danger">Web Name is not set</p>';
      }
      else if(is_dir("WebPages".DIRECTORY_SEPARATOR.$_POST["webName"]))
      {
          $errorMsg.='<p class="alert alert-danger">Web page already exists</p>';
      }
  }
?>

<section class="d-flex align-items-center">
  <div class="container" data-aos="fade-up">

    <div class="section-header mt-5">
      <h2 data-aos="fade-up" data-aos-delay="400">Create your own web page</h2>
      <?php
        if(isset($errorMsg)) echo '<div data-aos="fade-up" data-aos-delay="400">'.$errorMsg.'</div>';
      ?>
    </div>

    <div class="row justify-content-center">

      <form action='index.php?page=creator' method="post">
        <div class="form-row justify-content-center">
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

        <!-- <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="gallery">
          <label class="form-check-label" for="defaultCheck1">
            Gallery
          </label>
        </div> -->

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" name="posts">
          <label class="form-check-label" for="defaultCheck2">
            Posts
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck3" name="info">
          <label class="form-check-label" for="defaultCheck3">
            Info
          </label>
        </div>

        <section id="faq" class="faq">
          <div class="accordion accordion-flush px-xl-5" id="faqlist">

            <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-1">
                      <i class="bi bi-images question-icon"></i>
                        Style
                    </button>
                </h3>
                <div id="faq-content-1" class="accordion-collapse collapse"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <p>Web page style: colors,...</p>
                    <div class="form-group">
                      <label for="bckColor" class="mb-2"><b>1. Background Color picker</b></label>
                      <input type="color" class="form-control form-control-color" id="bckColor" name="styleBckColor" value="#563d7c" title="Choose your color">
                    </div>
                  </div>
                </div>
              </div><!-- End Component item-->

              <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                      <input type="checkbox" class="form-check-input" id="galleryEnable" name="galleryEnable" value="" data-bs-toggle="collapse" data-bs-target="#faq-content-2" style="position:absolute; left: 2%; !important">
                      <label class="form-check-label" for="galleryEnable">
                        <i class="bi bi-images question-icon"></i>
                          Gallery
                      </label>
                    </button>
                </h3>
                <div id="faq-content-2" class="accordion-collapse collapse"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <p>Upload your images to your web page</p>
                    <div class="form-group">
                      <div class="row">
                        <img src="assets/img/creator/gallery-1.png" style="width:25%; !important">
                        <img src="assets/img/creator/gallery-2.png" style="width:25%; !important">
                        <img src="assets/img/creator/gallery-3.png" style="width:25%; !important">
                        <img src="assets/img/creator/gallery-4.png" style="width:25%; !important">
                      </div>
                      <small class="form-text text-muted">All gallery types examples.<br><br></small>
                      <label for="galleryType" class="mb-2"><b>1. Gallery type</b></label>
                      <select class="form-control mb-2" id="galleryType" name="galleryType">
                        <option>Grid Gallery View</option>
                        <option>Zoom Gallery View</option>
                        <option>Basic Carousel View</option>
                        <option>Carousel View</option>
                      </select>
                      <small class="form-text text-muted">Choose type of gallery.</small>
                    </div>
                  </div>
                </div>
              </div><!-- End Component item-->

          </div>
        </section>

        <div class="form-group row">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</section>
