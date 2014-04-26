<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Not Cooking Tonight</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-responsive.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/dt/DT_bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/dt/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/dt/TableTools_JUI.css" rel="stylesheet">

    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }
        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <!--<script src="../assets/js/html5shiv.js"></script>-->
    <![endif]-->

    <!-- Fav and touch icons -->
    <!--    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">-->
    <!--    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">-->
    <!--    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">-->
    <!--    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">-->
    <!--    <link rel="shortcut icon" href="../assets/ico/favicon.png">-->
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="<?php echo base_url();?>dash">Not Cooking Tonight</a>
            <div class="nav-collapse collapse">
                <p class="navbar-text pull-right">
                    Logged in as <?php echo $this->ion_auth->user()->row()->username; ?> <a href="<?php echo base_url(); ?>home/logout" class="navbar-link">Log out</a>
                </p>
                <ul class="nav">
                    <!--<li class="active"><a href="<?php echo base_url();?>dash">Dash</a></li>-->
                </ul>
            </div>
        </div>
    </div>
</div>