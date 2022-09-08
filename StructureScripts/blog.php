<?php
  /**
   * Calculate string format ago
   * 
   * @access public
   * @param date $date date to transform
   * @return int the last inserted id
   */
function time_ago($date)
{
    $orderDate = new DateTime($date);
    $currentTime = new DateTime(date("Y-m-d H:i:s"));
    $diff = $orderDate->diff($currentTime);
    $hours = $diff->days * 24;
    $hours += $diff->h;
    if($hours < 1)
    {
      return 'Less than a hour';
    }
    else if($hours < 24)
    {
      return $hours.' hour ago';
    }
    else if($diff->days < 31)
    {
      return $diff->days. ' days ago';
    }
    else if($diff->days < 365)
    {
      return ($diff->days / 31). ' months ago';
    }
    else
    {
      return $diff->format('%y').' year ago';
    }
}
if(isset($_POST["search"]))
{
  header( "Location: index.php?page=blog&search=".$_POST["search"]);
}
if(isset($_POST["post_title"]) && isset($_POST["post_content"]))
  {
    $post_title = mysql_fix_string($mySqli_db,$_POST['post_title']);
    $post_content = str_replace("<script", "", $_POST["post_content"]);
    $post_content = str_replace("</script>", "", $post_content);
    $post_content = str_replace("<style", "", $post_content);
    $post_content = str_replace("</style>", "", $post_content);
    $post_content = str_replace("<?php", "", $post_content);
    $post_content = str_replace("?>", "", $post_content);
    $post_content = mysql_fix_string($mySqli_db, $post_content);
    //*************************USER*****************************
    $user = $_SESSION["user"];
    $sql= $mySqli_db->prepare("INSERT INTO `blog_posts`(`title`, `content`, `blog_id`) VALUES (?, ?, ?)");
    $sql->bind_param("ssi",$post_title, $post_content, $_GET["id"]);
    $sql->execute();

  }

  if(isset($_POST["edit_post_title"]) && isset($_POST["edit_post_content"]))
  {
    $id = $_POST["edit_post_id"];
    $post_title = mysql_fix_string($mySqli_db,$_POST['edit_post_title']);
    $post_content = str_replace("<script", "", $_POST["edit_post_content"]);
    $post_content = str_replace("</script>", "", $post_content);
    $post_content = str_replace("<style", "", $post_content);
    $post_content = str_replace("</style>", "", $post_content);
    $post_content = str_replace("<?php", "", $post_content);
    $post_content = str_replace("?>", "", $post_content);
    $post_content = mysql_fix_string($mySqli_db, $post_content);

    $sql= $mySqli_db->prepare("UPDATE `blog_posts` SET `title`=?, `content`=? WHERE `id`=?");
    $sql->bind_param("ssi",$post_title, $post_content, $id);
    $sql->execute();

  }
  if(isset($_POST["edit_blog_title"]) && isset($_POST["edit_blog_description"]))
  {
    $id = $_GET["id"];
    $blog_title = mysql_fix_string($mySqli_db,$_POST['edit_blog_title']);
    $blog_description = str_replace("<script", "", $_POST["edit_blog_description"]);
    $blog_description = str_replace("</script>", "", $blog_description);
    $blog_description = str_replace("<style", "", $blog_description);
    $blog_description = str_replace("</style>", "", $blog_description);
    $blog_description = str_replace("<?php", "", $blog_description);
    $blog_description = str_replace("?>", "", $blog_description);
    $blog_description = mysql_fix_string($mySqli_db, $blog_description);

    $sql= $mySqli_db->prepare("UPDATE `blogs` SET `title`=?, `description`=? WHERE `id`=?");
    $sql->bind_param("ssi",$blog_title, $blog_description, $id);
    $sql->execute();

  }
  if(isset($_POST["blog_title"]) && isset($_POST["blog_description"]))
  {
    $blog_title = mysql_fix_string($mySqli_db,$_POST['blog_title']);
    $blog_description = str_replace("<script", "", $_POST["blog_description"]);
    $blog_description = str_replace("</script>", "", $blog_description);
    $blog_description = str_replace("<style", "", $blog_description);
    $blog_description = str_replace("</style>", "", $blog_description);
    $blog_description = str_replace("<?php", "", $blog_description);
    $blog_description = str_replace("?>", "", $blog_description);
    $blog_description = mysql_fix_string($mySqli_db, $blog_description);
    //*************************USER*****************************
    $user = $_SESSION["user"];
    $sql= $mySqli_db->prepare("INSERT INTO `blogs`(`title`, `description`, `user`) VALUES (?, ?, ?)");
    $sql->bind_param("sss",$blog_title, $blog_description, $user);
    $sql->execute();

  }

  if(isset($_POST["delete_post"]))
  {
    $post_id = $_POST["delete_post"];
    $sql= $mySqli_db->prepare("DELETE FROM `blog_posts` WHERE id = ?");
    $sql->bind_param("i", $post_id);
    $sql->execute();
  }
  if(isset($_POST["delete_blog"]))
  {
    $blog_id = $_POST["delete_blog"];
    $sql= $mySqli_db->prepare("DELETE FROM `blogs` WHERE id = ?");
    $sql->bind_param("i", $blog_id);
    $sql->execute();
  }

//BLOG POST LIST
/******************************************************************************/
if(isset($_GET["id"]))
  {
    $sql= $mySqli_db->prepare("SELECT * FROM blogs WHERE id = ?");
    $sql->bind_param("i",$_GET["id"]);
    $sql->execute();
    $result=$sql->get_result();
    $blog=$result->fetch_assoc();

    if($blog)
    {
      $sql= $mySqli_db->prepare("SELECT * FROM blog_posts WHERE blog_id = ?");
      $sql->bind_param("i",$_GET["id"]);
      $sql->execute();
      $result=$sql->get_result();
      echo '<div class="row mt-4">
      <div data-aos="fade-up" data-aos-delay="200">
      <div class="section-header">';
      if(isset($_POST["edit_blog"]))
      {
        echo '<form action="index.php?page=blog&id=' . $_GET["id"] . '" method="post" role="form">
                <div class="row">
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="edit_blog_title" placeholder="Blog title" value="' . str_replace("\'", "'",str_replace("\\\"", "\"", $blog["title"])) . '" required>
                  <hr>
                  <textarea class="form-control" name="edit_blog_description" rows="5" placeholder="Write the description" required>' . str_replace("\'", "'",str_replace("\\\"", "\"", $blog["description"])) . '</textarea>
                  <br>
                <div class="text-center"><button class="btn btn-primary" type="submit">Send</button></div>
              </form>';
      }
      else
      {
        if(isset($_SESSION["user"])  && ($_SESSION["user"] == $blog["user"] || $session_user["rol"] == "admin"))
        {
          echo '<div class="position-absolute end-0 d-flex">
            <form action="index.php?page=blog&id=' . $_GET["id"] . '" method="post" role="form">
            <input type="hidden" name="edit_blog" value="' . $blog["id"] . '">
            <button type="submit" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></button>
            </form>';
          echo '<form action="index.php?page=blog" method="post" role="form">
              <input type="hidden" name="delete_blog" value="' . $blog["id"] . '">
              <button type="submit" class="btn btn-danger btn-sm mx-2"><i class="bi bi-trash-fill" onclick="return confirm(\'You are going to delete the current blog\nAre you sure?\')"></i></button>
              </form>
          </div>';
        }
        echo '<h2><i>' . str_replace("\'", "'",str_replace("\\\"", "\"", $blog["title"])) . '</i></h2>
          <p>' . str_replace("\'", "'",str_replace("\\\"", "\"", $blog["description"])) . '</p>';
      }
      echo '</div>';
      //echo '<a href="index.php?page=blog"><button type="submit" class="btn btn-primary">Back</button></a>';
      if(isset($_SESSION["user"])  && ($_SESSION["user"] == $blog["user"] || $session_user["rol"] == "admin"))
      {
        echo '
        <div class="text-right">
        <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#post_create">Create Post</button></div>
            <div id="post_create" class="accordion-collapse collapse">
              <form action="index.php?page=blog&id=' . $_GET["id"] . '" method="post" role="form">
                <div class="row">
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="post_title" placeholder="Post title" required>
                  <hr>
                  <textarea class="form-control" name="post_content" rows="5" placeholder="Write the post" required></textarea>
                </div>
                <div class="text-center"><button class="btn btn-primary" type="submit">Send</button></div>
              </form>
            </div>
            </div>
            <hr>
            </div>
            </div>';
      }
      for($i=0; $i<$result->num_rows; $i++)
      {
        $row=$result->fetch_assoc();

        if(isset($_POST["edit_post"]) && $_POST["edit_post"] == $row["id"])
        {
          echo '<div class="row mb-2 mt-3">
          <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
          <div class="card mb-2">
            <div class="card-body">
            <div class="media forum-item my-2"> 
                <a class="card-link">';
          //Insert image of the user, if it has no one then put a default
          if(file_exists("images/profile/". $blog["user"] . ".png"))
          {
            echo '<img src="images/profile/' . $blog["user"] . '.png" class="rounded-circle" width="50" alt="User">';
          }
          else
          {
            echo '<img src="../../StructureScripts/assets/defaultImg/userDefault.jpg" class="rounded-circle" width="50" alt="User">';
          }
          echo '</a>
                <div class="media-body ml-3"> 
                  <a>' . $blog["user"] . '</a><br>
                  <small class="text-muted">' . substr($row['date'], 0, strpos($row["date"], " ")) . '</small>
                  <form action="index.php?page=blog&id=' . $_GET["id"] . '" method="post" role="form">
                    <div class="row">
                    <div class="form-group mt-3">
                    <input type="hidden" name="edit_post_id" value="' . $row["id"] . '">
                      <input type="text" class="form-control" name="edit_post_title" placeholder="Post title" value="' . str_replace("\'", "'",str_replace("\\\"", "\"", $row["title"])) . '" required>
                      <hr>
                      <textarea class="form-control" name="edit_post_content" rows="5" placeholder="Write the post" required>' . str_replace("\'", "'",str_replace("\\\"", "\"", $row["content"])) . '</textarea>
                    </div>
                    <div class="text-center"><button class="btn btn-primary" type="submit">Send</button></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>';
        }
        else
        {
          echo '<div class="row mb-2 mt-3">
          <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
          <div class="card mb-2">
            <div class="card-body">';
            if(isset($_SESSION["user"])  && ($_SESSION["user"] == $blog["user"] || $session_user["rol"] == "admin"))
            {
              echo '<div class="position-absolute end-0 d-flex">
                <form action="index.php?page=blog&id=' . $_GET["id"] . '" method="post" role="form">
                <input type="hidden" name="edit_post" value="' . $row["id"] . '">
                <button type="submit" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></button>
                </form>';
              echo '<form action="index.php?page=blog&id=' . $_GET["id"] . '" method="post" role="form">
                  <input type="hidden" name="delete_post" value="' . $row["id"] . '">
                  <button type="submit" class="btn btn-danger btn-sm mx-2" onclick="return confirm(\'You are going to delete the current post\nAre you sure?\')"><i class="bi bi-trash-fill"></i></button>
                  </form>
              </div>';
            }
            echo '<h1 class="mt-1">' . str_replace("\'", "'",str_replace("\\\"", "\"", $row["title"])) . '</h1>
              <div class="media forum-item my-2"> 
                <a class="card-link">';
          //Insert image of the user, if it has no one then put a default
          if(file_exists("images/profile/". $blog["user"] . ".png"))
          {
            echo '<a href="index.php?page=user&user=' . $blog["user"] . '">
            <img src="images/profile/' . $blog["user"] . '.png" class="rounded-circle" width="50" alt="User">
            </a>';
          }
          else
          {
            echo '<a href="index.php?page=user&user=' . $blog["user"] . '">
            <img src="../../StructureScripts/assets/defaultImg/userDefault.jpg" class="rounded-circle" width="50" alt="User">
            </a>';
          }
          
          echo '</a>
                <div class="media-body ml-3"> 
                  <a href="index.php?page=user&user=' . $blog["user"] . '">' . $blog["user"] . '</a><br>
                  <small class="text-muted">' . substr($row['date'], 0, strpos($row["date"], " ")) . '</small>';
          echo '<div class="mt-4 font-size-sm">
                <p>' . str_replace("\'", "'",str_replace("\\\"", "\"", $row["content"])) . '</p>
              </div>';
          
          echo '</div>
                </div>
              </div>
            </div>
          </div></div>';
      }
    }
  }
  else
  {
    echo '<p class="alert alert-danger">Invalid component ID</p>';
  }
  }//BLOG LIST/******************************************************************************/
  else
  {
    if(isset($_GET["filter"]))
    {
      $sql= $mySqli_db->prepare("SELECT * FROM forums f INNER JOIN forum_categories_relation fcr ON f.id = fcr.blog_id WHERE fcr.forum_category_id = ?");
      $sql->bind_param("i",$_GET["filter"]);
    }
    else if(isset($_GET["search"]))
    {
      $key_word = mysql_fix_string($mySqli_db, $_GET["search"]);
      $sql= $mySqli_db->prepare("SELECT * FROM blogs  WHERE title LIKE '%" . $key_word . "%'");
    }
    else
    {
      $sql= $mySqli_db->prepare("SELECT * FROM blogs");
    }
    $sql->execute();
    $result=$sql->get_result();
    echo '<div class="row mb-2">';
    for($i=0; $i<$result->num_rows; $i++)
    {
      $row=$result->fetch_assoc();

      $sql= $mySqli_db->prepare("SELECT COUNT(*) AS count FROM blog_posts WHERE blog_id = ?");
      $sql->bind_param("i",$row["id"]);
      $sql->execute();
      $result_count=$sql->get_result();
      $posts = $result_count->fetch_assoc()["count"];

      $sql= $mySqli_db->prepare("SELECT MIN(date) AS date FROM `blog_posts` WHERE blog_id = ?");
      $sql->bind_param("i",$row["id"]);
      $sql->execute();
      $result_date=$sql->get_result();
      $date = $result_date->fetch_assoc()["date"];

      $sql= $mySqli_db->prepare("SELECT MAX(date) AS date FROM `blog_posts` WHERE blog_id = ?");
      $sql->bind_param("i",$row["id"]);
      $sql->execute();
      $result_last_date=$sql->get_result();
      $last_date = $result_last_date->fetch_assoc()["date"];

      echo '<div class="col-md-6 mb-3">
      <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
      <div class="card flex-md-row mb-4 box-shadow h-md-250">
        <div class="card-body d-flex flex-column align-items-start">';
          //<strong class="d-inline-block mb-2 text-primary">World</strong>
      echo '<h2 class="mb-3"><strong>
            <a class="text-dark" href="index.php?page=blog&id=' . $row["id"] . '">' . str_replace("\'", "'",str_replace("\\\"", "\"", $row["title"])) . '</a>
          </strong></h2>
          <div class="mb-1 text-muted">
          <a class="card-link mr-2">';
        //Insert image of the user, if it has no one then put a default
        if(file_exists("images/profile/". $row["user"] . ".png"))
        {
          echo '<a href="index.php?page=user&user=' . $row["user"] . '">
          <img src="images/profile/' . $row["user"] . '.png" class="rounded-circle" width="50" alt="User">
          </a>';
        }
        else if($row["user"] == "Guest")
        {
          echo '<img src="../../StructureScripts/assets/defaultImg/Guest.png" class="rounded-circle" width="50" alt="User">';
        }
        else
        {
          echo '<a href="index.php?page=user&user=' . $row["user"] . '">
          <img src="../../StructureScripts/assets/defaultImg/userDefault.jpg" class="rounded-circle" width="50" alt="User">
          </a>';
        }
        
        echo '</a>

                <a ';
        if($row["user"] != "Guest")
        {
          echo 'href="index.php?page=user&user=' . $row["user"] . '"';
        }
        echo '>' . $row["user"] . '</a>
                <small class="text-muted">' . substr($date, 0, strpos($date, " ")) . '</small>
          </div>
          <p class="card-text my-3">' . str_replace("\'", "'",str_replace("\\\"", "\"", $row["description"])) . '</p>
          <a href="index.php?page=blog&id=' . $row["id"] . '">Continue reading</a>
        </div>
        <div class="col-md-4 op-7 my-auto">
        <div class="row text-center op-7">
          <div class="col px-1"> 
            <i class="bi bi-bar-chart-line-fill"></i> 
            <span class="d-block text-sm">' . $posts . ' Posts</span>
          </div>
          <div class="col px-1"> 
            <i class="bi bi-activity"></i> 
            <span class="d-block text-sm">last interaction: ' . strtolower(time_ago($last_date)) . '</span>
          </div>
        </div>
      </div>
      </div>
      </div>
      </div>';
    }
    echo '</div>';
    if(isset($_SESSION["user"]) && $session_user["rol"] != "reader")
    {
        echo '<div class="row mt-4">
        <div data-aos="fade-up" data-aos-delay="200">
        <div class="text-center"><button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#blog_create">Create Blog</button></div>
            <div id="blog_create" class="accordion-collapse collapse">
              <form action="index.php?page=blog" method="post" role="form">
                <div class="row">
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="blog_title" placeholder="Blog title" required>
                  <hr>
                  <textarea class="form-control" name="blog_description" rows="5" placeholder="Write the description" required></textarea>
                  <br>
                <div class="text-center"><button class="btn btn-primary" type="submit">Send</button></div>
              </form>
            </div>
            </div>
            </div>
            </div>';
    }
  }

?>