<nav class="navbar navbar-dark bg-dark navbar-expand-sm fixed-top">

    <img class="logo container-fluid" src="<?php if (isset($loginPage)){ echo './images/logoring_.png';}else{echo './../images/logoring_.png';} ?>"  alt="Logo" style="max-width: 6rem">

    <div class="container font">
        <a href="#" class="navbar-brand"><!-- Imagine Dragons --></a>

            <button class="navbar-toggler collapsed" type="button"
                data-toggle="collapse" data-target="#myTogglerNav"
                aria-controls="myTogglerNav"
                aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="myTogglerNav">
            <div class="navbar-nav ml-auto"><!-- ml-auto .. to shift to the right -->
                <a class="nav-item nav-link ml-auto link" href="http://localhost/phprevamp/admin.php"><?php

                    if (session_status() == PHP_SESSION_NONE) {
                            echo 'LOGIN';
                        } else {
                            echo 'LOGOUT';
                        }
                ?>

                </a>
                <a class="nav-item nav-link ml-auto" href="http://localhost/phprevamp/admin/album_list.php">ALBUMS</a>
                <a class="nav-item nav-link ml-auto" href="http://localhost/phprevamp/admin/fan_list.php">FANS</a>
            </div><!-- navbar -->
        </div>  <!-- collapse -->
    </div><!-- container -->
  </nav><!-- nav -->
  <p class="space" style="margin-bottom: 5rem; color: rgba(255,255,255,.0)">margin</p>
