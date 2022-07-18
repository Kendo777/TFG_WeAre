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
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-cogs"></i>
                        Products
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li><a href="#">1</a></li>
                    </ul>
                </li>
                <li>
                    <a href="index.php?page=user">
                        <i class="fas fa-user"></i>
                        User
                    </a>
                </li>
                <li>
                    <a href="index.php?page=shoppingCart">
                        <i class="fas fa-shopping-cart"></i>
                        Cart 
                    </a>
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