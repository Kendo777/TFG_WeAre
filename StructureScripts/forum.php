<?php

  $url= substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "index.php"));   

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

  if(isset($_POST["post"]))
  {
    $post = mysql_fix_string($mySqli_db,$_POST['post']);
    //*************************USER*****************************
    $user = "Marc";
    $sql= $mySqli_db->prepare("INSERT INTO `forum_posts`(`content`, `forum_id`, `user`) VALUES (?, ?, ?)");
    $sql->bind_param("sis",$post, $_GET["forum"], $user);
    $sql->execute();
  }
  if(isset($_POST["response"]))
  {
    $response = mysql_fix_string($mySqli_db,$_POST['response']);
    $post = $_POST["post_id"];
    //*************************USER*****************************
    $user = "Marc";
    $sql= $mySqli_db->prepare("INSERT INTO `forum_responses`(`content`, `forum_post_id`, `user`) VALUES (?, ?, ?)");
    $sql->bind_param("sis",$response, $post, $user);
    $sql->execute();
  }
  if(isset($_POST["forum_title"]) && isset($_POST["post_content"]))
  {
    $forum_title = mysql_fix_string($mySqli_db,$_POST['forum_title']);
    $post_content = mysql_fix_string($mySqli_db,$_POST['post_content']);
    //*************************USER*****************************
    $user = "Marc";
    $sql= $mySqli_db->prepare("INSERT INTO `forums`(`title`, `user`) VALUES (?, ?)");
    $sql->bind_param("ss",$forum_title, $user);
    $sql->execute();

    $forum_id = $mySqli_db->insert_id;
    var_dump($forum_id);
    $sql= $mySqli_db->prepare("INSERT INTO `forum_posts`(`content`, `forum_id`, `user`) VALUES (?, ?, ?)");
    $sql->bind_param("sis",$post_content, $forum_id, $user);
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
    echo '<a href="index.php?page=forum">
    <button type="submit" class="btn btn-primary">Back</button></a>';
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
            <a href="javascript:void(0)" class="card-link">';
      if(file_exists("images/profileImg/".$row["user"]))
      {
        echo '<img src="images/profileImg/' . $row["user"] . '" class="rounded-circle" width="50" alt="User">';
      }
      else
      {
        echo '<img src="../../StructureScripts/assets/img/default/userDefault.jpg" class="rounded-circle" width="50" alt="User">';
      }
      
      echo '</a>
            <div class="media-body ml-3"> 
              <a href="javascript:void(0)" class="text-secondary">' . $row["user"] . '</a> 
              <small class="text-muted ml-2">';

      echo time_ago($row['date']);


      echo '</small>';

      if($first)
      {
        echo '<h1 class="mt-1">' . $forum["title"] . '</h1>';
      }
      echo'<div class="mt-3 font-size-sm">
                <p>' . $row["content"] . '</p>
              </div>
              <button class="btn btn-xs text-muted has-icon"><i class="bi bi-heart" aria-hidden="true"></i> 1</button>';
      if($first)
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
      else
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
        echo '<small>' . $row_responses["content"] . ' - <span class="bg-info text-white">'. $row_responses["user"] .'</span> <span class="text-secondary">' . date_format($response_date, 'g:ia \o\n l jS F Y') . '</span></small><hr>';
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
            <a href="index.php?page=forum&forum=' . $row["id"] . '" class="text-primary">' . $row["title"] . '</a>
          </h5>
          <p class="text-sm"><span class="op-6">Posted</span>';
      echo ' ' . strtolower(time_ago($date)) . ' ';
      echo '<a class="text-black" href="#">by ' . $row["user"] . '</a>
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
              <span class="d-block text-sm">' . ($posts + $responses) . ' Interaction</span>
            </div>
          </div>
        </div>
      </div></div>
    </div></div>';
    }
    echo '<div class="row mt-4">
    <div data-aos="fade-up" data-aos-delay="200">
    <div class="text-center"><button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#post_create">Create Post</button></div>
        <div id="post_create" class="accordion-collapse collapse">
          <form action="' . $url . '" method="post" role="form">
            <div class="row">
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="forum_title" placeholder="Forum title" required>
              <textarea class="form-control" name="post_content" rows="5" placeholder="Write the post" required></textarea>
            </div>
            <div class="text-center"><button class="btn btn-primary" type="submit">Send Response</button></div>
          </form>
        </div>
        </div>
        </div>
        </div>';
  }

?>
