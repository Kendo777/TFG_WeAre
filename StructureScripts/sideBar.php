<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar" class="active">
        <div class="sidebar-header">
            <a href="index.php"><h3>WE ARE <?php echo $json_data["web_data"]["web_name"] ?></h3>
            <strong>WE</strong></a>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="index.php?page=gallery">
                    <i class="fas fa-cogs"></i>
                    Gallery
                </a>
            </li>
            <li>
                <a href="index.php?page=forum">
                    <i class="fas fa-user"></i>
                    Forum
                </a>
            </li>
            <li>
                <a href="index.php?page=calendar&calendar=1">
                    <i class="fas fa-user"></i>
                    Calendar
                </a>
            </li>
            <li>
                <a href="index.php?page=blank&blank=1">
                    <i class="fas fa-user"></i>
                    Editor
                </a>
            </li>
            <li>
                <a href="index.php?page=user">
                    <i class="fas fa-user"></i>
                    User
                </a>
            </li>
            <li>
              <a href="index.php?page=blog">
                  Blog 
              </a>
              <div id="blog" class="accordion-collapse collapse">
                <ul>
                    <?php
                        $sqlBar= $mySqli_db->prepare("SELECT * FROM blogs");
                        $sqlBar->execute();
                        $resultBar=$sqlBar->get_result();
                        if(!$resultBar)
                        {
                            die($mySqli->error);
                        }
                        for($i=0; $i<$resultBar->num_rows; $i++)
                        {
                            $rowBar=$resultBar->fetch_assoc();
                            echo'<li><a href="index.php?page=blog&blog='.$rowBar['name'].'">'.$rowBar['name'].'</a></li>';
                        }
                    ?>
                </ul>
              </div>
            </li>
        </ul>
    </nav>

    <!-- Page Content  -->
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
            <div class="row justify-content-md-center">
                <div class="col-md-auto">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="bi bi-list-ul"></i>
                    <span></span>
                    </button>
                </div> 
                <?php
                  if(isset($_GET["page"]))
                  {
                    if($_GET["page"] == "forum")
                    {
                        echo '<div class="col-md-auto">
                        <div class="row">
                            <form class="form-inline my-2 my-lg-0" method="post" action="index.php?page=forum">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                      </div> ';
                    }
                  }   
                ?>            
              </div>
            <?php
                if(!isset($_SESSION['user']))
                {
                    echo'<div class="login ml-auto">
                        <a href="index.php?page=login"><button class="btn btn-warning" type="button">Login</button></a>
                    </div>';
                }
                else
                {
                    echo'<div class="login ml-auto">
                    <li class="dropdown" style="list-style-type: none;">
                    <a href="index.php?page=user"><button class="btn btn-warning" type="button"><i class="bi bi-person-circle"></i> '.$_SESSION['user'].'</button></a>
                    <ul>
                        <li><a href="index.php?page=user">Profile</a></li>
                        <li><a href="index.php?page=user&edit">Edit Profile</a></li>
                        <li><a href="index.php?page=logout">Logout</a></li>
                    </ul>
                    </li>
                    </div>';
                }
            ?>

        </nav>