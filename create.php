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
      public $web_current_name;
      public $web_user;
      public $web_database;
      public $web_privacity;
      public $web_structure;

      function __construct(string $web_name, string $web_current_name, string $web_user, string $web_database, string $web_privacity, string $web_structure)
      {
          $this->web_name = $web_name;
          $this->web_current_name = $web_current_name;
          $this->web_user = $web_user;
          $this->web_database = $web_database;
          $this->web_privacity = $web_privacity;
          $this->web_structure = $web_structure;
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
  class WebUsers 
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
   * WebBlog
   *
   * 
   */
  class WebForum
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
   * WebBlog
   *
   * 
   */
  class WebCalendar
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
    $sql->bind_param("i",$_SESSION["weAre_user"]);
    $sql->execute();
    $result=$sql->get_result();
    $row=$result->fetch_assoc();

    $user = $row["user"];
    $email = $row["email"];
    $password = $row["password"];
    $rol = "admin";
    $valid = 0;
    $db_name_low = strtolower($db_name);
    $sql= $mySqli->prepare("INSERT INTO `web_pages`(`web_name`, `web_user`, `web_current_name`, `web_database`) VALUES (?, ?)");
    $sql->bind_param("ssss", $db_name, $_SESSION["weAre_user"], $db_name, $db_name_low);
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

    if(isset($_POST["users_enable"]) && isset($_POST["column_name"]))
    {
      foreach($_POST["column_name"] as $index => $column)
      {
        if(!empty($column))
        {
          $column_name = mysql_fix_string($mySqlidb, $column);
          $column_type = mysql_fix_string($mySqlidb, $_POST["column_type"][$index]);
          $sql= $mySqlidb->prepare("ALTER TABLE users ADD ". strtolower($column_name) . " " . strtoupper($column_type));
          $sql->execute();
        }
      }
    }

    $sql= $mySqlidb->prepare("INSERT INTO `users`(`user`, `email`, `user_name`, `password`, `rol`, `valid`) VALUES (?,?,?,?,?,?)");
    $sql->bind_param("ssssi", $user, $email, $user, $password, $rol, $valid);
    $sql->execute();
    
    $sql= $mySqlidb->prepare("INSERT INTO `users`(`user`, `email`, `password`, `rol`, `valid`) VALUES ('Guest','','','reader',0)");
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE blogs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(60) NOT NULL,
    description VARCHAR(2000) DEFAULT '',
    user VARCHAR(60) NOT NULL,
    CONSTRAINT fk_blog_user FOREIGN KEY (user) REFERENCES users(user) ON DELETE NO ACTION)");
    
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE blog_posts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    title VARCHAR(60) NOT NULL,
    content VARCHAR(2000) NOT NULL, 
    user VARCHAR(60) NOT NULL,
    blog_id INT(6) UNSIGNED NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP, 
    CONSTRAINT fk_blog_post_blog FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_blog_post_user FOREIGN KEY (user) REFERENCES users(user) ON DELETE SET NULL)");
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

    $sql= $mySqlidb->prepare("CREATE TABLE calendars (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(2000) NOT NULL)");
    $sql->execute();

    $sql= $mySqlidb->prepare("INSERT INTO `calendars`(`title`, `description`) VALUES ('Calendar Example', 'Description Example')");
    $sql->execute();
  
    $sql= $mySqlidb->prepare("CREATE TABLE calendar_events (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    calendar_id INT(6) UNSIGNED NOT NULL,
    title VARCHAR(60) NOT NULL,
    description VARCHAR(2000) DEFAULT '',
    color VARCHAR(20) NOT NULL,
    start DATETIME DEFAULT CURRENT_TIMESTAMP,
    end DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_event_calendar FOREIGN KEY (calendar_id) REFERENCES calendars(id) ON DELETE CASCADE ON UPDATE CASCADE)");
    $sql->execute();
  
    $sql= $mySqlidb->prepare("CREATE TABLE forums (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(60) NOT NULL,
    user VARCHAR(60) NOT NULL,
    CONSTRAINT fk_user_forum FOREIGN KEY (user) REFERENCES users(user) ON DELETE SET NULL)");
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE forum_categories (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL UNIQUE)");
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
    CONSTRAINT fk_user_forum_posts FOREIGN KEY (user) REFERENCES users(user) ON DELETE SET NULL,
    CONSTRAINT fk_id_forum_posts FOREIGN KEY (forum_id) REFERENCES forums(id) ON DELETE CASCADE ON UPDATE CASCADE)");
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

    
    $sql= $mySqlidb->prepare("CREATE TABLE galleries (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL,
    description VARCHAR(2000) DEFAULT '')");
    $sql->execute();

    $sql= $mySqlidb->prepare("INSERT INTO `galleries`(`name`, `description`) VALUES ('Example', 'Description Example')");
    $sql->execute();

    $sql= $mySqlidb->prepare("CREATE TABLE blank_pages (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content LONGTEXT DEFAULT '')");
    $sql->execute();

    $sql= $mySqlidb->prepare("INSERT INTO `blank_pages`(`content`) VALUES ('<h1>HOME EXAMPLE</h1><p>&nbsp;</p><p style=\"text-align:center;\"><u>Thank you for choosing</u><strong><u> WE ARE</u></strong></p><figure class=\"image image_resized image-style-side\" style=\"width:49.3%;\"><img src=\"https://blog.darwinbox.com/hubfs/MicrosoftTeams-image%20%2824%29-1.png\" alt=\"Our team\"></figure><p>We Are proposes generate a platform with which users can</p><p>&nbsp;create their own web page without programming knowledge. The platform will offer a series of components that can be added to the web. The resulting website will be highly customizable and can be modified by adding new information and sections, modifying them, deleting them and managing privacy.</p><p>We offer modern solutions to help you to make presence on the Internet</p><p>The main components are:</p><ul><li>Galleries</li><li>Blogs</li><li>Forums</li><li>Calendars</li><li>Blank pages</li><li>User administration</li></ul><h4>WE ARE has two plans for web pages</h4><figure class=\"table\" style=\"width:78.17%;\"><table><colgroup><col style=\"width:17.43%;\"><col style=\"width:13.11%;\"><col style=\"width:12.72%;\"><col style=\"width:11.3%;\"><col style=\"width:10.5%;\"><col style=\"width:23.07%;\"><col style=\"width:11.87%;\"></colgroup><thead><tr><th>Plan</th><th>Galleries</th><th>Blogs</th><th>Forums</th><th>Calendars</th><th>Blank pages</th><th>Users</th></tr></thead><tbody><tr><td><strong>Basic plan</strong></td><td>Only 1</td><td>Unlimited</td><td>Unlimited</td><td>Only 1</td><td>Only 1 (and Home page)</td><td>Unlimited</td></tr><tr><td><strong>Advanced plan</strong></td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td></tr></tbody></table></figure><p>For more information you can always read our <a href=\"http://localhost/TFG/blog.html\">blog </a>with all the necessary information&nbsp;</p>')");
    $sql->execute();

    $sql= $mySqlidb->prepare("INSERT INTO `blank_pages`(`content`) VALUES ('<h1>BLANK PAGE EXAMPLE</h1><p>&nbsp;</p><p style=\"text-align:center;\"><u>Thank you for choosing</u><strong><u> WE ARE</u></strong></p><figure class=\"image image_resized image-style-side\" style=\"width:49.3%;\"><img src=\"https://blog.darwinbox.com/hubfs/MicrosoftTeams-image%20%2824%29-1.png\" alt=\"Our team\"></figure><p>We Are proposes generate a platform with which users can</p><p>&nbsp;create their own web page without programming knowledge. The platform will offer a series of components that can be added to the web. The resulting website will be highly customizable and can be modified by adding new information and sections, modifying them, deleting them and managing privacy.</p><p>We offer modern solutions to help you to make presence on the Internet</p><p>The main components are:</p><ul><li>Galleries</li><li>Blogs</li><li>Forums</li><li>Calendars</li><li>Blank pages</li><li>User administration</li></ul><h4>WE ARE has two plans for web pages</h4><figure class=\"table\" style=\"width:78.17%;\"><table><colgroup><col style=\"width:17.43%;\"><col style=\"width:13.11%;\"><col style=\"width:12.72%;\"><col style=\"width:11.3%;\"><col style=\"width:10.5%;\"><col style=\"width:23.07%;\"><col style=\"width:11.87%;\"></colgroup><thead><tr><th>Plan</th><th>Galleries</th><th>Blogs</th><th>Forums</th><th>Calendars</th><th>Blank pages</th><th>Users</th></tr></thead><tbody><tr><td><strong>Basic plan</strong></td><td>Only 1</td><td>Unlimited</td><td>Unlimited</td><td>Only 1</td><td>Only 1 (and Home page)</td><td>Unlimited</td></tr><tr><td><strong>Advanced plan</strong></td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td></tr></tbody></table></figure><p>For more information you can always read our <a href=\"http://localhost/TFG/blog.html\">blog </a>with all the necessary information&nbsp;</p>')");
    $sql->execute();

  }
/******************************************************************************/
?>

<!DOCTYPE html>
<html>
<?php

if(isset($_GET["edit"]) && !isset($_SESSION["user"]) && !isset($_SESSION["weAre_user"]))
{
  header('location:index.php');
}
else if(isset($_GET["edit"]) && (isset($_SESSION["user"]) || isset($_SESSION["weAre_user"])))
{
  $web_page = mysql_fix_string($mySqli,$_GET["edit"]);
  $web_user = isset($_SESSION["weAre_user"]) ? $_SESSION["weAre_user"] : $_SESSION["user"];
  $sql= $mySqli->prepare("SELECT * FROM users INNER JOIN web_pages ON users.user = web_pages.web_user WHERE user= ? AND web_name = ?");
  $sql->bind_param("ss", $web_user , $web_page);
  $sql->execute();
  $result=$sql->get_result();
  $session_user=$result->fetch_assoc();

  if($session_user)
  {
    $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "WebPages" . DIRECTORY_SEPARATOR . $_GET["edit"] . DIRECTORY_SEPARATOR . "webConfig.json");
    $json_data = json_decode($json, true);
    $db_name = mysql_fix_string($mySqli, $_GET["edit"]);
    $mySqlidb = mysql_client_db($db_name);
  }
  else
  {
    header('location:index.php');
  }
  
}
/**
 * Web creation
 */
  $errorMsg="";
  $page="home";
  $url= substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "index.php"));   

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
  if(!isset($_GET["edit"]) && isset($_POST["web_name"]) && !empty($_POST["web_name"]) && !is_dir("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"]))
  {
    //NOT FOR THE MOMENT
    create_DB($mySqli, $_POST["web_name"]);
    // Create web page folder
    mkdir("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"], 0700);
    // Import all scripts: PHP, CSS, JS,... for the structure of the web page
    copy("StructureScripts/index.php", "WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."index.php"); 
    mkdir("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."images". DIRECTORY_SEPARATOR . "gallery", 0700, true);
    copy_folder("StructureScripts/assets/gallery", "WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."images". DIRECTORY_SEPARATOR . "gallery");
    mkdir("WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."images". DIRECTORY_SEPARATOR . "profile", 0700, true);
    //copy_folder("StructureScripts/assets/img","WebPages".DIRECTORY_SEPARATOR.$_POST["web_name"].DIRECTORY_SEPARATOR."images");

    $web_data = new WebData($_POST["web_name"], $_POST["web_name"], $_SESSION["weAre_user"], strtolower($_POST["web_name"]), $_POST["web_privacity"], $_GET["form"]);
    $web_style = new WebStyle($_POST["style_bck_color"], $_POST["style_primary_color"], $_POST["style_secundary_color"]);
    $web_users = new WebUsers();
    $web_gallery = new WebGallery();
    $web_blog = new WebBlog();
    $web_forum = new WebForum();
    $web_calendar = new WebCalendar();
       
    
    /**
     * Set the configuration of all the components of the result web page
     * If gallery is enabled, set the configuration selected
     * If...
     */
    if(isset($_POST["users_enable"]))
    {
        $web_users->set();
    }
    if(isset($_POST["gallery_enable"]))
    {
        $web_gallery->set($_POST["gallery_type"]);
    }
    if(isset($_POST["blog_enable"]))
    {
      $web_blog->set();
    }
    if(isset($_POST["forum_enable"]))
    {
      $web_forum->set();
    }
    if(isset($_POST["calendar_enable"]))
    {
      $web_calendar->set();
    }
    
    /**
     * JSON creation
     * Create the php object that will be encoded as JSON and insert all the nedded data 
     * Creates the JSON file and write the information
     */
    $webConfig = (object) [
        'web_data' => $web_data,
        'style' => $web_style,
        'user' => $web_users,
        'gallery' => $web_gallery,
        'blog' => $web_blog,
        'forum' => $web_forum,
        'calendar' => $web_calendar
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

  //EDIT WEB REGION
  if(isset($_GET["edit"]) && isset($_POST["save"]))
  {
    if(isset($_POST["users_enable"]) && isset($_POST["column_name"]))
    {
      foreach($_POST["column_name"] as $index => $column)
      {
        if(!empty($column))
        {
          $column_name = mysql_fix_string($mySqlidb, $column);
          $column_type = mysql_fix_string($mySqlidb, $_POST["column_type"][$index]);
          $sql= $mySqlidb->prepare("ALTER TABLE users ADD ". strtolower($column_name) . " " . strtoupper($column_type));
          $sql->execute();
        }
      }
    }
    $web_name = mysql_fix_string($mySqlidb, $_POST["web_name"]);
    $sql= $mySqli->prepare("UPDATE `web_pages` SET `web_current_name`= ? WHERE `web_name` = ? AND `web_user` = ?");
    $sql->bind_param("sss", $web_name , $_GET["edit"], $web_user);
    $sql->execute();
    $web_data = new WebData($_GET["edit"], $_POST["web_name"], $_SESSION["user"], strtolower($_GET["edit"]), $_POST["web_privacity"], $_GET["form"]);
    $web_style = new WebStyle($_POST["style_bck_color"], $_POST["style_primary_color"], $_POST["style_secundary_color"]);
    $web_users = new WebUsers();
    $web_gallery = new WebGallery();
    $web_blog = new WebBlog();
    $web_forum = new WebForum();
    $web_calendar = new WebCalendar();
       
    
    /**
     * Set the configuration of all the components of the result web page
     * If gallery is enabled, set the configuration selected
     * If...
     */
    if(isset($_POST["users_enable"]))
    {
        $web_users->set();
    }
    if(isset($_POST["gallery_enable"]))
    {
        $web_gallery->set($_POST["gallery_type"]);
    }
    if(isset($_POST["blog_enable"]))
    {
      $web_blog->set();
    }
    if(isset($_POST["forum_enable"]))
    {
      $web_forum->set();
    }
    if(isset($_POST["calendar_enable"]))
    {
      $web_calendar->set();
    }
    
    /**
     * JSON creation
     * Create the php object that will be encoded as JSON and insert all the nedded data 
     * Creates the JSON file and write the information
     */
    $webConfig = (object) [
        'web_data' => $web_data,
        'style' => $web_style,
        'user' => $web_users,
        'gallery' => $web_gallery,
        'blog' => $web_blog,
        'forum' => $web_forum,
        'calendar' => $web_calendar
    ];

    file_put_contents("WebPages".DIRECTORY_SEPARATOR.$_GET["edit"].DIRECTORY_SEPARATOR."webConfig.json", json_encode($webConfig));
    
    header('location:WebPages' . DIRECTORY_SEPARATOR . $_GET["edit"] . DIRECTORY_SEPARATOR . "index.php");

  }
  else if(isset($_GET["edit"]))
  {
    if(isset($_POST["delete_column"]))
    {
      $column = mysql_fix_string($mySqlidb, $_POST["delete_column"]);
  
      $sql= $mySqlidb->prepare("ALTER TABLE users DROP COLUMN " . $column);
      $sql->execute();
    }
  }

  /**********************************/
  else if(!empty($_POST) && !isset($_GET["edit"]))
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
if(isset($_GET["form"]) && $_GET["form"] == "basic")
{
  include_once("basicCreator.php");
}
if(isset($_GET["form"]) && $_GET["form"] == "advanced")
{
  include_once("advanceCreator.php");
}
else
{
  echo '    <!-- ======= Pricing Section ======= -->
  <section id="pricing" class="pricing mt-5">
    <div class="container" data-aos="fade-up">

      <div class="section-header">
        <h2>Our Services</h2>
        <p>Creating your first website is completely free</p>
      </div>

      <div class="row justify-content-center gy-4">

        <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
          <div class="pricing-item">

            <div class="pricing-header">
              <h3>Basic Web</h3>
              <h4><sup>$</sup>0<span> / month</span></h4>
              <h6 class="text-white mt-2">Recommended for those who want a complete page but easy to assemble<h6>
            </div>

            <ul>
              <li><i class="bi bi-dot"></i> <span>Users</span></li>
              <li><i class="bi bi-dot"></i> <span>Privacity</span></li>
              <li><i class="bi bi-dot"></i> <span>1 Gallery</span></li>
              <li><i class="bi bi-dot"></i> <span>1 Calendar</span></li>
              <li><i class="bi bi-dot"></i> <span>1 Blank page</span></li>
              <li><i class="bi bi-dot"></i> <span>Forum</span></li>
              <li><i class="bi bi-dot"></i> <span>Blog</span></li>
              <li class="na"><i class="bi bi-x"></i> <span>Nav Bar personalization</span></li>
            </ul>

            <div class="text-center mt-auto">
              <a href="index.php?page=create&form=basic" class="buy-btn">Start Now</a>
            </div>

          </div>
        </div><!-- End Pricing Item -->

        <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="400">
          <div class="pricing-item featured">

            <div class="pricing-header">
              <h3>Advanced Web</h3>
              <h4><sup>$</sup>19<span> / month</span></h4>
              <h6 class="text-white mt-2">Recommended for those who have already created a page before<h6>
            </div>
            <ul>
              <li><i class="bi bi-dot"></i> <span>Users</span></li>
              <li><i class="bi bi-dot"></i> <span>Privacity</span></li>
              <li><i class="bi bi-dot"></i> <span>Unlimited Galleries</span></li>
              <li><i class="bi bi-dot"></i> <span>Unlimited Calendars</span></li>
              <li><i class="bi bi-dot"></i> <span>Unlimited Blank pages</span></li>
              <li><i class="bi bi-dot"></i> <span>Forum</span></li>
              <li><i class="bi bi-dot"></i> <span>Blog</span></li>
              <li><i class="bi bi-dot"></i> <span>Nav Bar personalization</span></li>
            </ul>

            <div class="text-center mt-auto">
              <a href="index.php?page=create&form=advanced" class="buy-btn">Start Now</a>
            </div>

          </div>
        </div><!-- End Pricing Item -->

      </div>

    </div>
  </section><!-- End Pricing Section -->';
}

?>