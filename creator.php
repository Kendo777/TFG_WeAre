<?php

/**
 * Web configuration classes and utils
 */

  /**
   * WebData
   *
   * 
   */
  class WebData 
  {
      public $web_name;
      public $web_user;
      public $web_database;
      public $web_privacity;

      function __construct(string $web_name, string $web_user, string $web_database, string $web_privacity)
      {
          $this->web_name = $web_name;
          $this->web_user = $web_user;
          $this->web_database = $web_database;
          $this->web_privacity = $web_privacity;
      }
  }
  /**
   * WebStyle
   *
   * 
   */
  class WebStyle 
  {
      public $bck_color;

      function __construct(string $bck_color) {
        $this->bck_color = $bck_color;
    }
  }
  /**
   * WebGallery
   *
   * 
   */
  class WebGallery 
  {
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

  /**
   * Copy all files from one folder to another
   * if is necessary it creates the remaining folders
   * 
   * @access public
   * @param string $src Folder path FROM which the files will be copied
   * @param string $dst Folder path WHERE the files will be copied
   * @return void
   */
  function copy_folder($src, $dst) { 
    $dir = opendir($src);   
    while( $file = readdir($dir) ) 
    { 
        if (( $file != '.' ) && ( $file != '..' ))
        { 
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
/******************************************************************************/
?>

<!DOCTYPE html>
<html>
<?php
/**
 * Web creation
 */
  session_start();
  $errorMsg="";
  $page="home";
  /*
   * For the moment is not needed 
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
  }*/

  /**
   * Creates the user page based on the selected configuration  checking that all the data entered is valid
   * If the web page name is correct and doesn't exist already, it creates it
   * Else it will show a error message
   */
  if(isset($_POST["web_name"]) && !empty($_POST["web_name"]) && !is_dir("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"]))
  {
    // Create web page folder
    mkdir("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"], 0700);
    // Import all scripts: PHP, CSS, JS,... for the structure of the web page
    copy_folder("StructureScripts","WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"]);

    $web_data = new WebData($_POST["web_name"], "Test", $_POST["web_name"], "Public");
    $web_style = new WebStyle($_POST["styleBckColor"]);
    $web_gallery = new WebGallery();
    
    /**
     * Set the configuration of all the components of the result web page
     * If gallery is enabled, set the configuration selected
     * If...
     */
    if(isset($_POST["galleryEnable"]))
    {
        $web_gallery->set($_POST["galleryType"]);
    }
    if(isset($_POST["posts"]))
    {

    }
    
    /**
     * JSON creation
     * Create the php object that will be encoded as JSON and insert all the nedded data 
     * Creates the JSON file and write the information
     */
    $webConfig = (object) [
        'web_data' => $web_data,
        'style' => $web_style,
        'gallery' => $web_gallery
    ];
    file_put_contents("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."webConfig.json", json_encode($webConfig));
    
    /**
     * Another possibility to generate the JSON 
     * $webJSON = fopen("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."webConfig.json", "w") or die("Unable to open file!");
     * fwrite($webJSON, json_encode($webConfig));
    */
    // If everything goes well, show a success message
    $errorMsg.='<p class="alert alert-success">Web page: '.$_POST["web_name"].' is created correctly</p>';
  }
  else if(!empty($_POST))
  {
      if(!isset($_POST["web_name"]) || empty($_POST["web_name"]))
      {
          $errorMsg.='<p class="alert alert-danger">Web Name is not set</p>';
      }
      else if(is_dir("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"]))
      {
          $errorMsg.='<p class="alert alert-danger">Web page already exists</p>';
      }
  }
/******************************************************************************/
?>

<section class="d-flex align-items-center">
  <div class="container" data-aos="fade-up">

    <div class="section-header mt-5">
      <h2 data-aos="fade-up" data-aos-delay="400">Create your own web page</h2>
      <?php if(isset($errorMsg)) echo '<div data-aos="fade-up" data-aos-delay="400">'.$errorMsg.'</div>'; ?>
    </div>

    <div class="row justify-content-center">

      <form action='index.php?page=creator' method="post">
        <div class="form-row justify-content-center">
          <div class="form-group col-md-6">
            <label>Web Name</label>
            <input type="text" class="form-control" name="web_name">
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Password</label>
            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
          </div>
        </div>

        <!-- ======= Configuration components ======= -->
        <section id="faq" class="faq">
          <div class="accordion accordion-flush px-xl-5" id="faqlist">

            <!-- Style Configuration -->
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
              
              <!-- Gallery Configuration -->
              <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                      <input type="checkbox" class="form-check-input" id="galleryEnable" name="galleryEnable" value="" data-bs-toggle="collapse" data-bs-target="#faq-content-2" style="position:absolute !important; left: 2% !important;">
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
                        <img src="assets/img/creator/gallery-1.png" style="width:25% !important;">
                        <img src="assets/img/creator/gallery-2.png" style="width:25% !important;">
                        <img src="assets/img/creator/gallery-3.png" style="width:25% !important;">
                        <img src="assets/img/creator/gallery-4.png" style="width:25% !important;">
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
        </section><!-- End Configuration components -->

        <div class="form-group row">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</section>
