<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/favicon.ico">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>SORT</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
        <!-- CSS Files -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="<?php echo base_url(); ?>assets/css/demo.css" rel="stylesheet" />
    </head>

    <body>
        <div class="wrapper">
            <div class="sidebar" data-image="<?php echo base_url(); ?>assets/img/sidebar-5.jpg" >
                <div class="sidebar-wrapper">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>index" class="simple-text">
                            SORT
                        </a>
                    </div>
                    <ul class="nav">
                        <?php
                        if (!empty($menu)) {
                            foreach ($menu as $title => $temp) {
                                ?>
                                <li>
                                    <a class="nav-link" href="<?php echo base_url().$temp['url']; ?> ">
                                        <i class="nc-icon <?php echo $temp['class']; ?>"></i>
                                        <p><?php echo $title; ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>   
                    </ul>
                </div>
            </div>
            <div class="main-panel">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                    <div class=" container-fluid  ">
                        <a class="navbar-brand" href="#"> <?php echo 'name here'; ?></a>
                        <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-bar burger-lines"></span>
                            <span class="navbar-toggler-bar burger-lines"></span>
                            <span class="navbar-toggler-bar burger-lines"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navigation">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="change_password.php">
                                        <span class="no-icon">Change Password</span>
                                    </a>
                                </li>
                                <!--                            <li class="nav-item dropdown">
                                                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span class="no-icon">Dropdown</span>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                                    <a class="dropdown-item" href="#">Action</a>
                                                                    <a class="dropdown-item" href="#">Another action</a>
                                                                    <a class="dropdown-item" href="#">Something</a>
                                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                                    <div class="divider"></div>
                                                                    <a class="dropdown-item" href="#">Separated link</a>
                                                                </div>
                                                            </li>-->
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url(); ?>home/logout">
                                        <span class="no-icon">Log out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>