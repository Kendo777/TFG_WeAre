<?php
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
    header( "Location: index.php?page=forum&search=".$_POST["search"]);
  }
  if(isset($_POST["post"]))
  {
    $post = mysql_fix_string($mySqli_db,$_POST['post']);
    //*************************USER*****************************
    $user = $_SESSION["user"];
    $sql= $mySqli_db->prepare("INSERT INTO `forum_posts`(`content`, `forum_id`, `user`) VALUES (?, ?, ?)");
    $sql->bind_param("sis",$post, $_GET["forum"], $user);
    $sql->execute();
  }
  if(isset($_POST["response"]))
  {
    $response = mysql_fix_string($mySqli_db,$_POST['response']);
    $post = $_POST["post_id"];
    //*************************USER*****************************
    $user = $_SESSION["user"];
    $sql= $mySqli_db->prepare("INSERT INTO `forum_responses`(`content`, `forum_post_id`, `user`) VALUES (?, ?, ?)");
    $sql->bind_param("sis",$response, $post, $user);
    $sql->execute();
  }
  if(isset($_POST["forum_title"]) && isset($_POST["post_content"]))
  {
    $forum_title = mysql_fix_string($mySqli_db,$_POST['forum_title']);
    $post_content = str_replace("<script", "", $_POST["post_content"]);
    $post_content = str_replace("</script>", "", $post_content);
    $post_content = str_replace("<style", "", $post_content);
    $post_content = str_replace("</style>", "", $post_content);
    $post_content = str_replace("<?php", "", $post_content);
    $post_content = str_replace("?>", "", $post_content);
    $post_content = mysql_fix_string($mySqli_db, $post_content);
    //*************************USER*****************************
    $user = $_SESSION["user"];
    $sql= $mySqli_db->prepare("INSERT INTO `forums`(`title`, `user`) VALUES (?, ?)");
    $sql->bind_param("ss",$forum_title, $user);
    $sql->execute();

    $forum_id = $mySqli_db->insert_id;
    $sql= $mySqli_db->prepare("INSERT INTO `forum_posts`(`content`, `forum_id`, `user`) VALUES (?, ?, ?)");
    $sql->bind_param("sis",$post_content, $forum_id, $user);
    $sql->execute();

    if(isset($_POST["categorie_title"]))
    {
      foreach($_POST["categorie_title"] as $categorie_title)
      {
        if(!empty($categorie_title))
        {
          $categorie_title = mysql_fix_string($mySqli_db, ucfirst(strtolower($categorie_title)));
          $sql= $mySqli_db->prepare("INSERT INTO `forum_categories` (`name`) VALUES (?)");
          $sql->bind_param("s", $categorie_title);
          $sql->execute();

          $result=$sql->get_result();
          if($mySqli_db->errno==0)
          {
            $categorie_id = $mySqli_db->insert_id;
          }
          else
          {
            $sql= $mySqli_db->prepare("SELECT * FROM forum_categories WHERE name = ?");
            $sql->bind_param("s", $categorie_title);
            $sql->execute();
            $result=$sql->get_result();
            $categorie=$result->fetch_assoc();
            $categorie_id = $categorie["id"];
          }
          $sql= $mySqli_db->prepare("INSERT INTO `forum_categories_relation`(`forum_id`, `forum_category_id`) VALUES (?,?)");
          $sql->bind_param("ii", $forum_id, $categorie_id);
          $sql->execute();
        }
      }
    }
  }
  if(isset($_POST["delete_id"]))
  {
    $post_id = $_POST["delete_id"];
    $sql= $mySqli_db->prepare("DELETE FROM `forum_posts` WHERE id = ?");
    $sql->bind_param("i", $post_id);
    $sql->execute();
  }
  if(isset($_POST["delete_response_id"]))
  {
    $response_id = $_POST["delete_response_id"];
    $sql= $mySqli_db->prepare("DELETE FROM `forum_responses` WHERE id = ?");
    $sql->bind_param("i", $response_id);
    $sql->execute();
  }
  if(isset($_POST["delete_forum"]))
  {
    $forum_id = $_POST["delete_forum"];
    $sql= $mySqli_db->prepare("DELETE FROM `forums` WHERE id = ?");
    $sql->bind_param("i", $forum_id);
    $sql->execute();
  }



  if(isset($_GET["forum"]))
  {
    $sql= $mySqli_db->prepare("SELECT * FROM forums WHERE id = ?");
    $sql->bind_param("i",$_GET["forum"]);
    $sql->execute();
    $result=$sql->get_result();
    $forum=$result->fetch_assoc();


    $sql= $mySqli_db->prepare("SELECT * FROM forum_posts WHERE forum_id = ?");
    $sql->bind_param("i",$_GET["forum"]);
    $sql->execute();
    $result=$sql->get_result();
    $first = true;
    //echo '<a href="index.php?page=forum"><button type="submit" class="btn btn-primary">Back</button></a>';

    for($i=0; $i<$result->num_rows; $i++)
    {
      $row=$result->fetch_assoc();
      if($first)
      {
        echo '<div class="row mb-2 mt-3">';
      }
      else
      {
        echo '<div class="row mb-2" style="margin-left: 3%;">';
      }
      echo '<div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
      <div class="card mb-2">
        <div class="card-body">
          <div class="media forum-item"> 
            <a class="card-link">';
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
            <div class="media-body ml-3"> 
              <a class="text-secondary" ';
      if($row["user"] != "Guest")
      {
        echo 'href="index.php?page=user&user=' . $row["user"] . '"';
      }
      echo '>' . $row["user"] . '</a> 
              <small class="text-muted ml-2">';

      echo time_ago($row['date']);


      echo '</small>';
      if(isset($_SESSION["user"])  && ($_SESSION["user"] == $row["user"] || $session_user["rol"] == "admin"))
      {
        if($first)
        {
          echo '<form action="index.php?page=forum" method="post" role="form">
          <input type="hidden" name="delete_forum" value="' . $_GET["forum"] . '">
          <button type="submit" class="btn btn-danger btn-sm position-absolute end-0" onclick="return confirm(\'You are going to delete the current forum\nAre you sure?\')"><i class="bi bi-trash-fill"></i></button>
          </form>';
        }
        else
        {
          echo '<form action="index.php?page=forum&forum=' . $_GET["forum"] . '" method="post" role="form">
          <input type="hidden" name="delete_id" value="' . $row["id"] . '">
          <button type="submit" class="btn btn-danger btn-sm position-absolute end-0" onclick="return confirm(\'You are going to delete the current post\nAre you sure?\')"><i class="bi bi-trash-fill"></i></button>
          </form>';
        }
      }
      if($first)
      {
        echo '<h1 class="mt-1">' . str_replace("\'", "'",str_replace("\\\"", "\"", $forum["title"])) . '</h1>';
      }
      echo'<div class="mt-3 font-size-sm">
                <p>' . str_replace("\'", "'",str_replace("\\\"", "\"", $row["content"])) . '</p>
              </div>';
      if($first)
      {
        $sql= $mySqli_db->prepare("SELECT * FROM forum_categories fc INNER JOIN forum_categories_relation fcr ON fc.id = fcr.forum_category_id WHERE fcr.forum_id = ?");
        $sql->bind_param("i",$_GET["forum"]);
        $sql->execute();
        $result_categories=$sql->get_result();
        for($j=0; $j<$result_categories->num_rows; $j++)
        {
          $row_categories=$result_categories->fetch_assoc();
          echo '<a class="text-black mr-2 text-info" href="index.php?page=forum&filter=' . $row_categories["id"] . '">#' . $row_categories["name"] . '</a>';
        }
        echo '<br><br>';
        if(isset($_SESSION["user"])  && (isset($_SESSION["user"]) && $session_user["rol"] != "reader"))
        {
          echo '<a href="#" class="text-muted small" data-bs-toggle="collapse" data-bs-target="#post">Reply</a>
          <div id="post" class="accordion-collapse collapse">
            <form action="' . $url . '" method="post" role="form">
              <div class="row">
              <div class="form-group mt-3">
                <textarea class="form-control" name="post" rows="9" placeholder="Write the message of the post" required></textarea>
              </div>
              <div class="text-center"><button class="btn btn-primary" type="submit">Send Post</button></div>
            </form>
          </div>
          </div>';
        }
      }
      else if(isset($_SESSION["user"]) && $session_user["rol"] != "reader")
      {
        echo '<a href="#" class="text-muted small" data-bs-toggle="collapse" data-bs-target="#reply' . $row['id'] . '">Reply</a>
        <div id="reply' . $row['id'] . '" class="accordion-collapse collapse">
          <form action="' . $url . '" method="post" role="form">
            <div class="row">
            <div class="form-group mt-3">
              <textarea class="form-control" name="response" rows="5" placeholder="Write the reply for the post above" required></textarea>
              <input type="text" hidden class="form-control" name="post_id" value="' . $row['id'] . '">
            </div>
            <div class="text-center"><button class="btn btn-primary" type="submit">Send Response</button></div>
          </form>
        </div>
        </div>';
      }
      echo '<div class="responses">';
      $sql_responses= $mySqli_db->prepare("SELECT * FROM forum_responses WHERE forum_post_id = ?");
      $sql_responses->bind_param("i",$row["id"]);
      $sql_responses->execute();
      $result_responses=$sql_responses->get_result();
      $first_response = true;
      for($j=0; $j<$result_responses->num_rows; $j++)
      {
        $row_responses=$result_responses->fetch_assoc();
        if($first_response)
        {
          echo '<hr>';
          $first_response = false;
        }
        $response_date = new DateTime($row_responses['date']);
        echo '<div><small>' . str_replace("\'", "'",str_replace("\\\"", "\"", $row_responses["content"])) . ' - <span class="bg-info text-white">'. $row_responses["user"] .'</span> <span class="text-secondary">' . date_format($response_date, 'g:ia \o\n l jS F Y') . '</span></small>';
        if(isset($_SESSION["user"])  && ($_SESSION["user"] == $row["user"] || $session_user["rol"] == "admin"))
        {
          echo '<form action="index.php?page=forum&forum=' . $_GET["forum"] . '" method="post" role="form">
          <input type="hidden" name="delete_response_id" value="' . $row["id"] . '">
          <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
          </form>';
        }
        echo '</div><hr>';
      }
      echo '</div>
            </div>
          </div>
        </div>
      </div>
      </div>
      </div>';

      if($first)
      {
        $first = false;
      }
    }
  }
  else
  {
    if(isset($_GET["filter"]))
    {
      $sql= $mySqli_db->prepare("SELECT * FROM forums f INNER JOIN forum_categories_relation fcr ON f.id = fcr.forum_id WHERE fcr.forum_category_id = ?");
      $sql->bind_param("i",$_GET["filter"]);
    }
    else if(isset($_GET["search"]))
    {
      $key_word = mysql_fix_string($mySqli_db, $_GET["search"]);
      $sql= $mySqli_db->prepare("SELECT * FROM forums WHERE title LIKE '%" . $key_word . "%'");
    }
    else
    {
      $sql= $mySqli_db->prepare("SELECT * FROM forums");
    }
    $sql->execute();
    $result=$sql->get_result();
    for($i=0; $i<$result->num_rows; $i++)
    {
      $row=$result->fetch_assoc();

      $sql= $mySqli_db->prepare("SELECT COUNT(*) AS count FROM forum_posts WHERE forum_id = ?");
      $sql->bind_param("i",$row["id"]);
      $sql->execute();
      $result_count=$sql->get_result();
      $posts = $result_count->fetch_assoc()["count"];

      $sql= $mySqli_db->prepare("SELECT COUNT(*) AS count FROM forum_responses fr INNER JOIN forum_posts fp ON fr.forum_post_id = fp.id WHERE fp.forum_id = ?");
      $sql->bind_param("i",$row["id"]);
      $sql->execute();
      $result_count=$sql->get_result();
      $responses = $result_count->fetch_assoc()["count"];

      $sql= $mySqli_db->prepare("SELECT MIN(date) AS date FROM `forum_posts` WHERE forum_id = ?");
      $sql->bind_param("i",$row["id"]);
      $sql->execute();
      $result_date=$sql->get_result();
      $date = $result_date->fetch_assoc()["date"];

      $sql= $mySqli_db->prepare("SELECT MAX(date) AS date FROM `forum_posts` WHERE forum_id = ?");
      $sql->bind_param("i",$row["id"]);
      $sql->execute();
      $result_last_date=$sql->get_result();
      $last_date = $result_last_date->fetch_assoc()["date"];

      $sql= $mySqli_db->prepare("SELECT * FROM forum_categories fc INNER JOIN forum_categories_relation fcr ON fc.id = fcr.forum_category_id WHERE fcr.forum_id = ?");
      $sql->bind_param("i",$row["id"]);
      $sql->execute();
      $result_categories=$sql->get_result();

      echo '<div class="row mb-2">
      <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
      <div class="card py-3 px-3 rounded-0">
        <div class="row align-items-center">
        <div class="col-md-8 mb-3 mb-sm-0">
          <h5> 
            <a href="index.php?page=forum&forum=' . $row["id"] . '" class="text-primary">' . str_replace("\'", "'",str_replace("\\\"", "\"", $row["title"])) . '</a>
          </h5>
          <p class="text-sm"><span class="op-6">Posted</span>';
      echo ' ' . strtolower(time_ago($date)) . ' ';
      echo '<a class="text-black"';
      if($row["user"] != "Guest")
      {
        echo 'href="index.php?page=user&user=' . $row["user"] . '"';
      } 
      echo '>by ' . $row["user"] . '</a>
          </p>
          <div class="text-sm op-5">';
      for($j=0; $j<$result_categories->num_rows; $j++)
      {
        $row_categories=$result_categories->fetch_assoc();
        echo '<a class="text-black mr-2 text-info" href="index.php?page=forum&filter=' . $row_categories["id"] . '">#' . $row_categories["name"] . '</a>';
      }
      echo '</div>
        </div>
        <div class="col-md-4 op-7">
          <div class="row text-center op-7">
            <div class="col px-1"> 
              <i class="bi bi-bar-chart-line-fill"></i> 
              <span class="d-block text-sm">' . $posts . ' Posts</span>
            </div>
            <div class="col px-1"> 
              <i class="bi bi-chat-dots"></i> 
              <span class="d-block text-sm">' . $responses . ' Replys</span>
            </div>
            <div class="col px-1"> 
              <i class="bi bi-activity"></i> 
              <span class="d-block text-sm">last interaction: ' . strtolower(time_ago($last_date)) . '</span>
            </div>
          </div>
        </div>
      </div></div>
    </div></div>';
    }
    if(isset($_SESSION["user"]) && $session_user["rol"] != "reader")
    {
        echo '<div class="row mt-4">
        <div data-aos="fade-up" data-aos-delay="200">
        <div class="text-center"><button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#post_create">Create Post</button></div>
            <div id="post_create" class="accordion-collapse collapse">
              <form action="' . $url . '" method="post" role="form">
                <div class="row">
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="forum_title" placeholder="Forum title" required>
                  <hr>
                  <textarea class="form-control" name="post_content" rows="5" placeholder="Write the post" required></textarea>
                  <hr>
                  <div id="inputFormRow">
                      <div class="input-group mb-3">
                      <button class="btn btn-info disabled">#</button>
                      <input type="text" name="categorie_title[]" class="form-control m-input" placeholder="Categorie name" autocomplete="off">
                          <div class="input-group-append">
                              <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                          </div>
                      </div>
                  </div>
                  <div id="categorienewRow_1"></div>
                  <button onclick="addForumCategorieRow(1)" type="button" class="btn btn-info">Add Row</button>
                </div>
                <div class="text-center"><button class="btn btn-primary" type="submit">Send</button></div>
              </form>
            </div>
            </div>
            </div>
            </div>';
    }
  }

?>
