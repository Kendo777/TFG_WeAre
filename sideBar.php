<?php 
    require_once("mySqli.php");
?>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <a href="index.php"><h3>Reino de Terror de Gonzalo</h3>
                <strong>RTG</strong></a>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="index.php">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a>
                </li>
                <li>
                    <a href="index.php?page=info">
                        <i class="fas fa-info-circle"></i>
                        Info
                    </a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-users"></i>
                        Miembros
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li><a href="index.php?page=users">Inicio</a></li>
                        <?php
                            $sqlBar= $mySqli->prepare("SELECT * FROM members WHERE name != 'ElDictadorSecreto'");
                            $sqlBar->execute();
                            $resultBar=$sqlBar->get_result();
                            if(!$resultBar)
                            {
                                die($mySqli->error);
                            }
                            for($i=0; $i<$resultBar->num_rows; $i++)
                            {
                                $rowBar=$resultBar->fetch_assoc();
                                if(isset($rowBar['nickname']))
                                {
                                    echo'<li><a href="index.php?page=userInfo&user='.$rowBar['nickname'].'">'.$rowBar['nickname'].'</a></li>';
                                }
                                else
                                {
                                    echo'<li><a href="index.php?page=userInfo&user='.$rowBar['name'].'">'.$rowBar['name'].'</a></li>';
                                }
                            }
                        ?>

                    </ul>
                </li>
                <li>
                    <a href="index.php?page=user">
                        <i class="fas fa-edit"></i>
                        Posts
                    </a>
                </li>
                <li>
                    <a href="index.php?page=gallery">
                        <i class="fas fa-camera-retro"></i>
                        Galeria 
                    </a>
                </li>
                <li>
                    <a href="index.php?page=games">
                        <i class="fas fa-gamepad"></i>
                        Juegos 
                    </a>
                </li>
            </ul>
            <img src="css/Img/side.jpg" class="sideBar">
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="row justify-content-md-center">
                    <div class="col-md-auto">
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span></span>
                        </button>
                    </div>
                    <div class="col-md-auto">
                            <h3 style="color: white">EL REINO DEL TERROR DE GONZO</h3>
                    </div>
                    
                </div>
                <?php
                    if(!isset($_SESSION['user']))
                    {
                        echo'<div class="login">
                            <a href="index.php?page=login"><button class="btn btn-warning" type="button">Login</button></a>
                        </div>';
                    }
                    else if($_SESSION['user'] != "Invitado")
                    {
                        echo'<div class="login">
                        <button class="btn btn-warning" type="button"><i class="fas fa-user-circle"></i> '.$_SESSION['user'].'</button>
                        <ul class="list-group">
                          <li class="list-group-item"><a href="index.php?page=userInfo&user='.$_SESSION['user'].'">Profile</a></li>
                          <li class="list-group-item"><a href="index.php?page=userInfo&user='.$_SESSION['user'].'&edit"><i class="fas fa-wrench"></i> Edit Profile</a></li>
                          <li class="list-group-item"><a href="index.php?page=logeOut">Logout</a></li>
                        </ul>
                        </div>';
                    }
                    else
                    {
                        echo'<div class="login">
                        <button class="btn btn-warning" type="button"><i class="fas fa-user-circle"></i> '.$_SESSION['user'].'</button>
                        <ul class="list-group">
                          <li class="list-group-item"><a href="index.php?page=logeOut">Logout</a></li>
                        </ul>
                        </div>';
                    }
                ?>
            </nav>