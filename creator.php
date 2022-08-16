<?php
require_once("mySqli.php");
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
      public $primary_color;
      public $secundary_color;
      function __construct(string $bck_color, string $primary_color, string $secundary_color) {
        $this->bck_color = $bck_color;
        $this->primary_color = $primary_color;
        $this->secundary_color = $secundary_color;
    }
  }
  /**
   * WebNabBar
   *
   * 
   */
  class WebNavBar 
  {
      public $tabs;

      function __construct() {
        
    }
  }
  /**
   * WebBlog
   *
   * 
   */
  class WebBlog
  {
      public $enable;

      function __construct() {
          $this->enable = false;
      }
      function set() {
        $this->enable = true;
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
  function create_DB($mySqli, $db_name)
  {
    $sql= $mySqli->prepare("SELECT * FROM users WHERE user = ?");
    $sql->bind_param("i",$_SESSION["user"]);
    $sql->execute();
    $result=$sql->get_result();
    $row=$result->fetch_assoc();

    $user = $row["user"];
    $email = $row["email"];
    $password = $row["password"];
    $rol = "admin";
    $valid = 0;

    $sql= $mySqli->prepare("INSERT INTO `web_pages`(`web_name`, `web_user`) VALUES (?, ?)");
    $sql->bind_param("ss", $db_name, $_SESSION["user"]);
    $sql->execute();

    $db_name = mysql_fix_string($mySqli, $db_name);
    $sql= $mySqli->prepare("DROP DATABASE marc");
    $sql->execute();

    $sql= $mySqli->prepare("CREATE DATABASE " . $db_name);
    $sql->execute();

    //create tables
    $mySqlidb = mysql_client_db($db_name);
    
    // sql to create table
    $sql= $mySqlidb->prepare("CREATE TABLE users (
    user VARCHAR(60) NOT NULL UNIQUE PRIMARY KEY,
    email VARCHAR(60) NOT NULL UNIQUE,
    user_name VARCHAR(60) NOT NULL,
    password VARCHAR(60) NOT NULL,
    rol VARCHAR(60) DEFAULT 'reader',
    valid INT(4) NOT NULL)");
    $sql->execute();

    $sql= $mySqlidb->prepare("INSERT INTO `users`(`user`, `email`, `password`, `rol`, `valid`) VALUES (?,?,?,?,?)");
    $sql->bind_param("ssssi", $user, $email, $password, $rol, $valid);
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE blogs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL)");
    
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE blog_posts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    content VARCHAR(2000) NOT NULL, 
    blog_id INT(6) UNSIGNED NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP, 
    CONSTRAINT fk_id_blog FOREIGN KEY (blog_id) REFERENCES blogs(id))");
    $sql->execute();

    if(isset($_POST["blog_enable"]) && isset($_POST["blog_title"]))
    {
      foreach($_POST["blog_title"] as $blog_title)
      {
        if(!empty($blog_title))
        {
          $blog_title = mysql_fix_string($mySqlidb, $blog_title);
          $sql= $mySqlidb->prepare("INSERT INTO `blogs` (`name`) VALUES (?)");
          $sql->bind_param("s", $blog_title);
          $sql->execute();
        }
      }
    }
    $sql= $mySqlidb->prepare("CREATE TABLE forums (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    user VARCHAR(60) NOT NULL,
    CONSTRAINT fk_user_forum FOREIGN KEY (user) REFERENCES users(user) ON DELETE NO ACTION ON UPDATE CASCADE)");
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE forum_categories (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE)");
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE forum_categories_relation (
    forum_id INT(6) UNSIGNED NOT NULL,
    forum_category_id INT(6) UNSIGNED NOT NULL,
    CONSTRAINT fk_forum_id_category FOREIGN KEY (forum_id) REFERENCES forums(id) ON DELETE CASCADE,
    CONSTRAINT fk_forum_category_id FOREIGN KEY (forum_category_id) REFERENCES forum_categories(id) ON DELETE CASCADE)");
    $sql->execute();
  
    $sql= $mySqlidb->prepare("CREATE TABLE forum_posts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    content VARCHAR(2000) NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    forum_id INT(6) UNSIGNED NOT NULL, 
    user VARCHAR(60) NOT NULL,
    CONSTRAINT fk_user_forum_posts FOREIGN KEY (user) REFERENCES users(user) ON DELETE NO ACTION ON UPDATE CASCADE,
    CONSTRAINT fk_id_forum_posts FOREIGN KEY (forum_id) REFERENCES forums(id) ON DELETE CASCADE)");
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE forum_responses (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    content VARCHAR(2000) NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP, 
    forum_post_id INT(6) UNSIGNED NOT NULL, 
    user VARCHAR(60) NOT NULL,
    CONSTRAINT fk_user_forum_responses FOREIGN KEY (user) REFERENCES users(user) ON DELETE NO ACTION ON UPDATE CASCADE,
    CONSTRAINT fk_id_forum_posts_responses FOREIGN KEY (forum_post_id) REFERENCES forum_posts(id) ON DELETE CASCADE)");
    $sql->execute();

    if(isset($_POST["forum_enable"]) && isset($_POST["forum_title"]))
    {
      foreach($_POST["forum_title"] as $forum_title)
      {
        if(!empty($forum_title))
        {
          $forum_title = mysql_fix_string($mySqlidb, $forum_title);
          $sql= $mySqlidb->prepare("INSERT INTO `forums` (`name`, `user`) VALUES (?,?)");
          $sql->bind_param("si", $forum_title, $user);
          $sql->execute();
        }
      }
    }

    $sql= $mySqlidb->prepare("CREATE TABLE calendars (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL)");
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE calendar_events (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    calendar_id INT(6) UNSIGNED NOT NULL,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(500) DEFAULT '',
    color VARCHAR(15) NOT NULL,
    start DATETIME NOT NULL,
    end DATETIME DEFAULT NOT NULL,
    CONSTRAINT fk_event_calendar FOREIGN KEY (calendar_id) REFERENCES calendars(id) ON DELETE CASCADE ON UPDATE CASCADE)");
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE galleries (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(50) NOT NULL)");
      $sql->execute();
  
      $sql= $mySqlidb->prepare("CREATE TABLE gallery_tags (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
      name VARCHAR(50) NOT NULL, 
      gallery_id INT(6) UNSIGNED NOT NULL, 
      CONSTRAINT fk_id_gallery FOREIGN KEY (gallery_id) REFERENCES galleries(id))");
      $sql->execute();

      $sql= $mySqlidb->prepare("CREATE TABLE blank_pages (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        content VARCHAR(10000) DEFAULT '')");
        $sql->execute();
  }
/******************************************************************************/
?>

<!DOCTYPE html>
<html>
<?php
/**
 * Web creation
 */
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
    //NOT FOR THE MOMENT
    create_DB($mySqli, $_POST["web_name"]);
    // Create web page folder
    mkdir("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"], 0700);
    // Import all scripts: PHP, CSS, JS,... for the structure of the web page
    copy("StructureScripts/index.php", "WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."index.php"); 
    mkdir("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."images". DIRECTORY_SEPARATOR . "gallery", 0700, true);
    //copy_folder("StructureScripts/assets/img","WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."images");

    $web_data = new WebData($_POST["web_name"], $_SESSION["user"], strtolower($_POST["web_name"]), $_POST["web_privacity"]);
    $web_style = new WebStyle($_POST["style_bck_color"], $_POST["style_primary_color"], $_POST["style_secundary_color"]);
    $web_gallery = new WebGallery();
    $web_blog = new WebBlog();
       
    
    /**
     * Set the configuration of all the components of the result web page
     * If gallery is enabled, set the configuration selected
     * If...
     */
    if(isset($_POST["gallery_enable"]))
    {
        $web_gallery->set($_POST["gallery_type"]);
    }
    if(isset($_POST["blog_enable"]))
    {
      $web_blog->set();
    }
    
    /**
     * JSON creation
     * Create the php object that will be encoded as JSON and insert all the nedded data 
     * Creates the JSON file and write the information
     */
    $webConfig = (object) [
        'web_data' => $web_data,
        'style' => $web_style,
        'gallery' => $web_gallery,
        'blog' => $web_blog,
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

<header>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="StructureScripts\assets\js\dynamicForm.js"></script>

</header>

<section class="d-flex align-items-center">
  <div class="container" data-aos="fade-up">

    <div class="section-header mt-5">
      <h2 data-aos="fade-up" data-aos-delay="400">Create your own web page</h2>
      <?php if(isset($errorMsg)) echo '<div data-aos="fade-up" data-aos-delay="400">'.$errorMsg.'</div>'; ?>
    </div>

    <div class="row justify-content-center">

      <form action='index.php?page=creator' method="post">
        <!-- ======= Configuration components ======= -->
        <section id="faq" class="faq">
          <div class="accordion accordion-flush px-xl-5" id="faqlist">

          <!-- General Configuration -->
          <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#general">
                      <i class="bi bi-images question-icon"></i>
                        General
                    </button>
                </h3>
                <div id="general" class="accordion-collapse collapse show"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <label><b>1. Web Name<b></label>
                    <input type="text" class="form-control" name="web_name" required>
                    <br>
                    <label for="web_privacity" class="mb-2"><b>2. Privacity</b></label>
                      <select class="form-control mb-2" id="web_privacity" name="web_privacity">
                        <option>Public</option>
                        <option>Private</option>
                        <option>Invitation</option>
                      </select>
                  </div>
                </div>
              </div><!-- End Component item-->

            <!-- Style Configuration -->
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#style">
                      <i class="bi bi-images question-icon"></i>
                        Style
                    </button>
                </h3>
                <div id="style" class="accordion-collapse collapse show"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <p>Web page style: colors,...</p>
                    <div class="form-group">
                      <label for="style_bck_color" class="mb-2"><b>1. Background Color picker</b></label>
                      <input type="color" class="form-control form-control-color" id="style_bck_color" name="style_bck_color" value="#FFFFFF" title="Choose your color">
                      <label for="style_bck_color" class="mb-2"><b>1. Primary Color picker</b><small>Text color</small></label>
                      <input type="color" class="form-control form-control-color" id="style_primary_color" name="style_primary_color" value="#000000" title="Choose your color">
                      <label for="style_bck_color" class="mb-2"><b>1. Secundary Color picker</b><small>Borders color,...</small></label>
                      <input type="color" class="form-control form-control-color" id="style_secundary_color" name="style_secundary_color" value="#000000" title="Choose your color">
                    </div>
                  </div>
                </div>
              </div><!-- End Component item-->

              <!-- Navbar Configuration -->
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navBar">
                      <i class="bi bi-images question-icon"></i>
                        Navigation Bar
                    </button>
                </h3>
                <div id="navBar" class="accordion-collapse collapse"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <label for="navBar_type" class="mb-2"><b>1. Navigation bar type</b></label>
                    <select class="form-control mb-2" id="navBar_type" name="navBar_type">
                      <option>Clasic Navigation Bar</option>
                      <option>Side Collapsed Bar</option>
                    </select>
                    <div id="inputFormRow">
                        <div class="input-group mb-3">
                          <div class="col-sm-2">
                            <select class="form-control" id="navBar_tab_type" name="navBar_tab_type">
                              <option>Blog</option>
                              <option>Gallery</option>
                            </select>
                          </div>
                          <div class="col-sm-2">
                            <input type="number" name="navBar_tab_target[]" class="form-control m-input" placeholder="Tab target">
                          </div>
                          <input type="text" name="navBar_tab[]" class="form-control m-input" placeholder="Tab name" autocomplete="off">
                          <div class="input-group-append">
                              <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                          </div>
                        </div>
                    </div>
                    <div id="nabBarnewRow"></div>
                    <button onclick="addNavBarRow()" type="button" class="btn btn-info">Add Row</button>
                  </div>
                </div>
              </div><!-- End Component item-->
              
              <!-- Gallery Configuration -->
              <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#gallery">
                      <input type="checkbox" class="form-check-input" id="gallery_enable" name="gallery_enable" value="" data-bs-toggle="collapse" data-bs-target="#gallery" style="position:absolute !important; left: 2% !important;">
                      <label class="form-check-label" for="gallery_enable">
                        <i class="bi bi-images question-icon"></i>
                          Gallery
                      </label>
                    </button>
                </h3>
                <div id="gallery" class="accordion-collapse collapse"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <p>Upload your images to your web page</p>
                    <div class="form-group">
                    <div class="row">
                      <section id="portfolio" class="portfolio">
                          <div class="container">
                            <div class="section-header">
                            <h2>Grid Gallery</h2>
                            <p>Non hic nulla eum consequatur maxime ut vero memo vero totam officiis pariatur eos dolorum sed fug dolorem est possimus esse quae repudiandae. Dolorem id enim officiis sunt deserunt esse soluta consequatur quaerat</p>
                          </div>
                        </div>
                        <div class="container-fluid" style="width: 50%;">
                          <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">
                            <div class="row g-0">
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/app-1.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/product-1.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/branding-1.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/books-1.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/app-2.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/product-2.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/branding-2.jpg" class="img-fluid glightbox" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/books-2.jpg" class="img-fluid glightbox" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/app-3.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/product-3.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/branding-3.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/books-3.jpg" class="img-fluid glightbox preview-link" alt="">
                            </div><!-- End Portfolio Item -->
                            
                          </div><!-- End Portfolio Container -->
                        </div>
                      </div>
                      </section><!-- End Portfolio Section -->
                      </div>
                      <div class="row">
                      <section id="portfolio" class="portfolio">
                          <div class="container">
                            <div class="section-header">
                            <h2>Zoom Gallery</h2>
                            <p>Non hic nulla eum consequatur maxime ut vero memo vero totam officiis pariatur eos dolorum sed fug dolorem est possimus esse quae repudiandae. Dolorem id enim officiis sunt deserunt esse soluta consequatur quaerat</p>
                          </div>

                        </div>
                        <div class="container-fluid"  style="width: 50%;">
                          <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">
                            <div class="row g-0">
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/app-1.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/app-1.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/product-1.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/product-1.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/branding-1.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/branding-1.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/books-1.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/books-1.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/app-2.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/app-2.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/product-2.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/product-2.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/branding-2.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/branding-2.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/books-2.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/books-2.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/app-3.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/app-3.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/product-3.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/product-3.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/branding-3.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/branding-3.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/books-3.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/books-3.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            
                          </div><!-- End Portfolio Container -->
                        </div>
                      </div>
                      </section><!-- End Portfolio Section -->
                      </div>
                      <small class="form-text text-muted">All gallery types examples.<br><br></small>
                      <label for="gallery_type" class="mb-2"><b>1. Gallery type</b></label>
                      <select class="form-control mb-2" id="gallery_type" name="gallery_type">
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

              <!-- Blog Configuration -->
              <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#blog">
                      <input type="checkbox" class="form-check-input" id="blog_enable" name="blog_enable" value="" data-bs-toggle="collapse" data-bs-target="#blog" style="position:absolute !important; left: 2% !important;">
                      <label class="form-check-label" for="blog_enable">
                        <i class="bi bi-images question-icon"></i>
                          Blog
                      </label>
                    </button>
                </h3>
                <div id="blog" class="accordion-collapse collapse"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <div class="row">
                      <div class="col-lg-12">
                        <div id="inputFormRow">
                            <div class="input-group mb-3">
                            <button name="$blog_id[]" class="btn btn-info disabled">0</button>                                
                            <input type="text" name="blog_title[]" class="form-control m-input" placeholder="blog title" autocomplete="off">
                                <div class="input-group-append">
                                    <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div id="blognewRow"></div>
                        <button onclick="addBlogRow()" type="button" class="btn btn-info">Add Row</button>
                      </div>
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




