<?php 
    //require_once("mySqli.php");
?>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <a href="index.php"><h3>Steampunk Age of Steam</h3>
                <strong>SP</strong></a>
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
                    <a href="index.php?page=user">
                        <i class="fas fa-user"></i>
                        User
                    </a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-shopping-cart"></i>
                        Blog 
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
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
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="row justify-content-md-center">
                    <div class="col-md-auto">
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="bi bi-list-ul"></i>
                        <span></span>
                        </button>
                    </div>                    
                </div>
            </nav>