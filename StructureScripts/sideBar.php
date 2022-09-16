<div class="wrapper">
    <!-- Sidebar  -->
  <?php

if($json_data["navBar"]["type"] == "Side Collapser Bar")
{
  echo '<nav id="sidebar" class="active pt-2">
      <div class="sidebar-header">
          <a href="index.php"><h3>WE ARE ' . $json_data["web_data"]["web_current_name"] . '</h3>
          <strong>WE</strong></a>
      </div>
      <ul class="list-unstyled components px-2 sticky-top">';

      if($json_data["web_data"]["web_structure"] == "basic")
      {
        echo '<li>
              <a href="index.php">
                <i class="bi bi-house-fill"></i>
                  Home
              </a>
          </li>
          <li>
              <a href="index.php?page=blank">
                <i class="bi bi-journal-bookmark-fill"></i>
                  Blank
              </a>
          </li>';
        if($json_data["gallery"]["enable"])
        {
          echo '<li>
              <a href="index.php?page=gallery">
                <i class="bi bi-images"></i>
                  Gallery
              </a>
          </li>';
        }
        if($json_data["blog"]["enable"])
        {
          echo '<li>
            <a href="index.php?page=blog">
              <i class="bi bi-newspaper"></i>
                Blog 
            </a>
          </li>';
        }
        if($json_data["forum"]["enable"])
        {
          echo '<li>
              <a href="index.php?page=forum">
                <i class="bi bi-bar-chart-steps"></i>
                  Forum
              </a>
          </li>';
        }
        if($json_data["calendar"]["enable"])
        {
          echo '<li>
              <a href="index.php?page=calendar">
                <i class="bi bi-calendar-week"></i>
                  Calendar
              </a>
          </li>';
        }
      }
      else if($json_data["web_data"]["web_structure"] == "advanced")
      {
        foreach($json_data["navBar"]["tabs"] as $index => $value)
        {
          //var_dump($value);
          if($value["type"] == "Home")
          {
            echo '<li>
                <a href="index.php">
                  <i class="bi bi-house-fill"></i>
                    ' . $value["name"] . '
                </a>
            </li>';
          }
          else if($value["type"] == "Dropdown")
          {
            echo '<li>
            <a class="accordion-button collapsed dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#dropdown_' . $index . '" style="background: none; color: var(--color-links);">
              <i class="bi bi-globe2 question-icon"></i>
                ' . $value["name"] . '
          </a>
            <div id="dropdown_' . $index . '" class="accordion-collapse collapse">
            <ul class="list-unstyled">';
            foreach($value["tabs"] as $dropdown_value)
            {
              echo '<li>
                <a href="index.php?page=' . strtolower($dropdown_value["type"]) . '&id=' . $dropdown_value["index"] . '">';
              switch($dropdown_value["type"])
              {
                case "Gallery":
                  echo '<i class="bi bi-images"></i>';
                  break;
                case "Blog":
                  echo '<i class="bi bi-newspaper"></i>';
                  break;
                case "Forum":
                  echo '<i class="bi bi-bar-chart-steps"></i>';
                  break;
                case "Blank":
                  echo '<i class="bi bi-journal-bookmark-fill"></i>';
                  break;
                case "Calendar":
                  echo '<i class="bi bi-calendar-week"></i>';
                  break;

              }
              echo $dropdown_value["name"] . '
                </a>
            </li>';
            }
            echo '</ul>
                </div>
            </li>';

          }
          else
          {
            echo '<li>
                <a href="index.php?page=' . strtolower($value["type"]) . '&id=' . $value["index"] . '">';
            switch($value["type"])
            {
              case "Gallery":
                echo '<i class="bi bi-images"></i>';
                break;
              case "Blog":
                echo '<i class="bi bi-newspaper"></i>';
                break;
              case "Forum":
                echo '<i class="bi bi-bar-chart-steps"></i>';
                break;
              case "Blank":
                echo '<i class="bi bi-journal-bookmark-fill"></i>';
                break;
              case "Calendar":
                echo '<i class="bi bi-calendar-week"></i>';
                break;

            }
            echo $value["name"] . '
                </a>
            </li>';
          }
        }
      }
      echo '</ul>
      </nav>
      <div id="content">
      <nav class="navbar siddenavbar navbar-expand-lg navbar-dark bg-dark px-3 sticky-top">
            <div class="row justify-content-md-center">
                <div class="col-md-auto my-2">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="bi bi-list-ul"></i>
                    <span></span>
                    </button>
                </div> 
                <div class="col-md-auto">
                        <div class="row">  
                        <div class="col-md-auto mt-2">';

                echo '<h3 style="color: white">' . $json_data["web_data"]["web_current_name"] . '</h3>
                </div>';
                  if(isset($_GET["page"]))
                  {
                    if($_GET["page"] == "forum")
                    {
                        echo '<div class="col-md-auto my-2">
                        <form class="form-inline my-2 my-lg-0" method="post" action="index.php?page=forum">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                            </div>';
                    }
                    if($_GET["page"] == "blog")
                    {
                        echo '<div class="col-md-auto my-2">
                        <form class="form-inline my-2 my-lg-0" method="post" action="index.php?page=blog">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                            </div>';
                    }
                  }      
             echo '</div>
                      </div>         
              </div>';
                if(!isset($_SESSION['user']) && $json_data["user"]["enable"])
                {
                    echo'<div class="login ml-auto">
                        <a href="index.php?page=login"><button class="btn btn-warning" type="button">Login</button></a>
                    </div>';
                }
                else if($json_data["user"]["enable"])
                {
                    echo'<div class="login ml-auto">
                    <li class="dropdown" style="list-style-type: none;">';
                    if($_SESSION["user"] != "Guest")
                    {
                        echo '<a href="index.php?page=user"><button class="btn btn-warning" type="button"><i class="bi bi-person-circle"></i> '.$_SESSION['user'].'</button></a>
                        <ul>
                            <li><a href="index.php?page=user">Profile</a></li>
                            <li><a href="index.php?page=user&edit">Edit Profile</a></li>';
                        if($session_user["rol"] == "admin")
                        {
                            echo '<li><a href="index.php?page=user&admin">Admin users</a></li>';
                            echo '<li><a href="index.php?page=user&admin&web">Admin web</a></li>';
                        }
                    }
                    else
                    {
                        echo '<a href="#"><button class="btn btn-warning" type="button"><i class="bi bi-person-circle"></i> '.$_SESSION['user'].'<i class="bi bi-chevron-down"></i></button></a>
                        <ul>';
                    }
                    
                    echo '<li><a href="index.php?page=logout">Logout</a></li>
                    </ul>
                    </li>
                    </div>';
                }
        echo '</nav>';
}
?>

    <!-- Page Content  -->
    <div id="content">
      <?php
if($json_data["navBar"]["type"] == "Clasic Navigation Bar")
{
  echo '
  <header id="navbar" class="header fixed-top header-scrolled">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
    <a href="index.php" class="logo d-flex align-items-center">
        <img src="../../StructureScripts/assets/img/WeArelogo.png" alt="">
        <span style="line-height: normal;">ARE ' . $json_data["web_data"]["web_current_name"] . '</span>
      </a>';

  echo '<nav class="navbar">
  <ul>';
  if($json_data["web_data"]["web_structure"] == "basic")
  {
    echo '<li>
          <a class="nav-link scrollto active" href="index.php">
            <i class="bi bi-house-fill"></i>
              Home
          </a>
        </li>
        <li>
        <a class="nav-link scrollto active" href="index.php?page=blank">
          <i class="bi bi-journal-bookmark-fill"></i>
            Blank
        </a>
      </li>
        <li>
        <a class="nav-link scrollto active" href="index.php?page=gallery">
          <i class="bi bi-images"></i>
            Gallery
        </a>
      </li>
        <li>
        <a class="nav-link scrollto active" href="index.php?page=blog">
          <i class="bi bi-newspaper"></i>
            Blog
        </a>
      </li>
        <li>
        <a class="nav-link scrollto active" href="index.php?page=forum">
          <i class="bi bi-bar-chart-steps"></i>
            Forum
        </a>
      </li>
        <li>
        <a class="nav-link scrollto active" href="index.php?page=calendar">
          <i class="bi bi-calendar-week"></i>
            Calendar
        </a>
      </li>
      </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
    </nav>
    <nav class="navbar">';
  }
  else if($json_data["web_data"]["web_structure"] == "advanced")
  {
    foreach($json_data["navBar"]["tabs"] as $index => $value)
    {
      //var_dump($value);
      if($value["type"] == "Home")
      {
        echo '<li>
        <a class="nav-link scrollto active" href="index.php">
          <i class="bi bi-house-fill"></i>
          ' . $value["name"] . '
        </a>
      </li>';
      }
      else if($value["type"] == "Dropdown")
      {
        echo '<li class="dropdown"><a href="#">
        <i class="bi bi-globe2 question-icon"></i>
        <span>' . $value["name"] . '</span>
         <i class="bi bi-chevron-down"></i></a>
        <ul>';
        foreach($value["tabs"] as $dropdown_value)
        {
          echo '<li>
            <a href="index.php?page=' . strtolower($dropdown_value["type"]) . '&id=' . $dropdown_value["index"] . '">';
          switch($dropdown_value["type"])
          {
            case "Gallery":
              echo '<i class="bi bi-images"></i>';
              break;
            case "Blog":
              echo '<i class="bi bi-newspaper"></i>';
              break;
            case "Forum":
              echo '<i class="bi bi-bar-chart-steps"></i>';
              break;
            case "Blank":
              echo '<i class="bi bi-journal-bookmark-fill"></i>';
              break;
            case "Calendar":
              echo '<i class="bi bi-calendar-week"></i>';
              break;

          }
          echo $dropdown_value["name"] . '
            </a>
        </li>';
        }
        echo '</ul>
        </li>';

      }
      else
      {
        echo '        
        <li>
            <a class="nav-link scrollto active" href="index.php?page=' . strtolower($value["type"]) . '&id=' . $value["index"] . '">';
        switch($value["type"])
        {
          case "Gallery":
            echo '<i class="bi bi-images"></i>';
            break;
          case "Blog":
            echo '<i class="bi bi-newspaper"></i>';
            break;
          case "Forum":
            echo '<i class="bi bi-bar-chart-steps"></i>';
            break;
          case "Blank":
            echo '<i class="bi bi-journal-bookmark-fill"></i>';
            break;
          case "Calendar":
            echo '<i class="bi bi-calendar-week"></i>';
            break;

        }
        echo $value["name"] . '
            </a>
        </li>';
      }
    }
  }
  if(!isset($_SESSION['user']) && $json_data["user"]["enable"])
  {
      echo'<div class="login ml-auto">
          <a href="index.php?page=login"><button class="btn btn-primary" type="button">Login</button></a>
      </div>';
  }
  else if($json_data["user"]["enable"])
  {
      if($_SESSION["user"] != "Guest")
      {
          echo '<ul>
          <li class="dropdown"><a href="index.php?page=user"><button class="btn btn-primary" type="button"><i class="bi bi-person-circle"></i> ' . $_SESSION['user'] . '<i class="bi bi-chevron-down"></i></button></a>
                    <ul>
                      <li><a href="index.php?page=user">Profile</a></li>
                      <li><a href="index.php?page=user&edit">Edit Profile</a></li>';
              
          if($session_user["rol"] == "admin")
          {
              echo '<li><a href="index.php?page=user&admin">Admin users</a></li>';
              echo '<li><a href="index.php?page=user&admin&web">Admin web</a></li>';
          }
      }
      else
      {
          echo '<ul>
          <li class="dropdown"><a><i class="bi bi-person-circle"></i>' . $_SESSION['user'] . '</a>
          <ul>';
      }
      
      echo '<li><a href="index.php?page=logout">Logout</a></li>
      </li></ul>
      <ul>';
  }
  echo '</nav><!-- .navbar -->';
  echo '  </div>
  </header><!-- End Header -->
  <section id="portfolio" class="portfolio mt-5" data-aos="fade-up">';
  if(isset($_GET["page"]))
  {
    if($_GET["page"] == "forum")
    {
        echo '<div class="col-md-auto my-2">
        <form class="form-inline my-2 my-lg-0" method="post" action="index.php?page=forum">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            </div>';
    }
    if($_GET["page"] == "blog")
    {
        echo '<div class="col-md-auto my-2">
        <form class="form-inline my-2 my-lg-0" method="post" action="index.php?page=blog">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            </div>';
    }
  }  
}
?>