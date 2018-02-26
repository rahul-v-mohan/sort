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
        <!--    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />-->
        <!-- CSS Files -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="<?php echo base_url(); ?>assets/css/demo.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>CSS/jquery.datetimepicker.css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>CSS/jquery-ui.css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>CSS/jquery-confirm.min.css"/>
        <script src="<?php echo base_url(); ?>JS/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>JS/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>JS/jquery.datetimepicker.full.min.js"></script>
        <script src="<?php echo base_url(); ?>JS/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>JS/validate_common.js"></script>
        <script src="<?php echo base_url(); ?>JS/validation.js"></script>
        <script src="<?php echo base_url(); ?>JS/core.js"></script>
        <style>
            label.error{color:red};
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="sidebar"  data-image="<?php echo base_url(); ?>assets/img/sidebar-5.jpg" >
                <div class="sidebar-wrapper">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>" class="simple-text">
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
                        <a class="navbar-brand" href="#">You Can Save A Life </a>
                        <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-bar burger-lines"></span>
                            <span class="navbar-toggler-bar burger-lines"></span>
                            <span class="navbar-toggler-bar burger-lines"></span>
                        </button>
                        <?php 
                        if(!empty($top_menu)){ ?>
                        <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav ml-auto">
                            <?php foreach ($top_menu as $title => $url) {         ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url($url); ?>">
                                    <span class="no-icon"><?php echo $title; ?></span>
                                </a>
                            </li>
                            <?php   } ?>
                        </ul>
                    </div>
                        
                         <?php }  ?>
                    </div>
                </nav>