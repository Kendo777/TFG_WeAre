<?php
  if(!isset($_SESSION["weAre_user"]))
  {
    header('location:index.php');
  }

  function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    $dir = opendir($dirPath);   
    while( $file = readdir($dir) ) 
    { 
        if (( $file != '.' ) && ( $file != '..' ))
        { 
            if (is_dir($dirPath.DIRECTORY_SEPARATOR.$file) ) 
            { 
                deleteDir($dirPath.DIRECTORY_SEPARATOR.$file);
            } 
            else
            {
                unlink($dirPath.DIRECTORY_SEPARATOR.$file); 
            }
        } 
    } 
    closedir($dir);
    rmdir($dirPath);
  }

  if(isset($_POST["delete_web"]))
  {
    $web_id = $_POST["delete_web"];
    $sql= $mySqli->prepare("SELECT * FROM web_pages WHERE id = ?");
    $sql->bind_param("i", $web_id);
    $sql->execute();
    $result=$sql->get_result();
    $web=$result->fetch_assoc();

    $sql= $mySqli->prepare("DROP DATABASE " . $web["web_database"]);
    $sql->execute();

    deleteDir("WebPages" . DIRECTORY_SEPARATOR . $web["web_name"]);

    $sql= $mySqli->prepare("DELETE FROM `web_pages` WHERE id = ?");
    $sql->bind_param("i", $web_id);
    $sql->execute();
  }
?>
<section class="d-flex align-items-center">
  <div class="container" data-aos="fade-up">
  <div class="section-header mt-5">
      <h2 data-aos="fade-up" data-aos-delay="400">My Web Pages</h2>
      <?php if(isset($errorMsg)) echo '<div data-aos="fade-up" data-aos-delay="400">'.$errorMsg.'</div>'; ?>
    </div>
    <div class="row justify-content-center">
        <section id="faq" class="faq">
          <div class="accordion accordion-flush px-xl-5" id="faqlist">
<?php
    $sql= $mySqli->prepare("SELECT * FROM web_pages WHERE web_user = ?");
    $sql->bind_param("s", $_SESSION["weAre_user"]);
    $sql->execute();
    $result=$sql->get_result();
    for($i=0; $i<$result->num_rows; $i++)
    {
      $row=$result->fetch_assoc();
      $mySqlidb = mysql_client_db($row["web_database"]);
      
      $sql= $mySqlidb->prepare("SELECT COUNT(*) AS count FROM forums");
      $sql->execute();
      $result_count=$sql->get_result();
      $forums = $result_count->fetch_assoc()["count"];

      $sql= $mySqlidb->prepare("SELECT COUNT(*) AS count FROM blogs");
      $sql->execute();
      $result_count=$sql->get_result();
      $blogs = $result_count->fetch_assoc()["count"];

      $sql= $mySqlidb->prepare("SELECT COUNT(*) AS count FROM calendars");
      $sql->execute();
      $result_count=$sql->get_result();
      $calendars = $result_count->fetch_assoc()["count"];

      $sql= $mySqlidb->prepare("SELECT COUNT(*) AS count FROM galleries");
      $sql->execute();
      $result_count=$sql->get_result();
      $galleries = $result_count->fetch_assoc()["count"];

      $sql= $mySqlidb->prepare("SELECT COUNT(*) AS count FROM blank_pages");
      $sql->execute();
      $result_count=$sql->get_result();
      $blank = $result_count->fetch_assoc()["count"];

      $sql= $mySqlidb->prepare("SELECT COUNT(*) AS count FROM users");
      $sql->execute();
      $result_count=$sql->get_result();
      $users = $result_count->fetch_assoc()["count"];

      echo '<div class="row mb-2">
      <div class="accordion-item" data-aos="fade-up" data-aos-delay="200" style="border-radius: 5px; border: 1px solid rgba(0,0,0,.125) !important;">
      <div class="card py-3 px-3 rounded-0" style="border: none !important;">
        <div class="row align-items-center">
        <div class="col-md-4 mb-3 mb-sm-0">
          <h5> 
            <a href="WebPages' . DIRECTORY_SEPARATOR . $row["web_name"] . DIRECTORY_SEPARATOR . 'index.php?admin" class="text-primary">' . str_replace("\'", "'",str_replace("\\\"", "\"", $row["web_current_name"])) . '</a>
          </h5>
          <p class="text-sm"><span class="op-6">Created the </span>';
      echo ' ' . $row["date_creation"] . '
            </p>
          <div class="text-sm op-5">';

      echo '</div>
        </div>
        <div class="col-md-8">
          <div class="row text-center">
            <div class="col px-1"> 
              <i class="bi bi-person-circle"></i> 
              <span class="d-block text-sm">' . $users . ' Users</span>
            </div>
            <div class="col px-1"> 
              <i class="bi bi-images"></i>
              <span class="d-block text-sm">' . $galleries . ' Galleries</span>
            </div>
            <div class="col px-1"> 
              <i class="bi bi-newspaper"></i> 
              <span class="d-block text-sm">' . $blogs . ' Blogs</span>
            </div>
            <div class="col px-1"> 
              <i class="bi bi-bar-chart-steps"></i>
              <span class="d-block text-sm">' . $forums . ' Forums</span>
            </div>
            <div class="col px-1"> 
              <i class="bi bi-calendar-week"></i> 
              <span class="d-block text-sm">' . $calendars . ' Calendars</span>
            </div>
            <div class="col px-1"> 
              <i class="bi bi-journal-bookmark-fill"></i>
              <span class="d-block text-sm">' . $blank . ' Blanks</span>
            </div>
            <div class="col px-1"> 
              <a href="index.php?page=create&edit='. $row["web_name"] . '">
              <button type="submit" class="btn btn-warning">Admin</button></a>
            </div>
            <div class="col px-1"> 
              <form action="index.php?page=myWebs" method="post" role="form">
                <input type="hidden" name="delete_web" value="' . $row["id"] . '">
                <button type="submit" class="btn btn-danger" onclick="return confirm(\'You are going to delete the ' . $row["web_current_name"] . ' web page\nOnce deleted it cannot be recovered. Are you sure?\')"><i class="bi bi-trash-fill"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div></div>
    </div></div>';
    }
    ?>
              </div>
        </section><!-- End Configuration components -->
    </div>
  </div>
</section>