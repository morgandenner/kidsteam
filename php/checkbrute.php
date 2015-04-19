<?php
require_once 'php/config.php';
require_once 'php/connect.php';
require_once 'php/secsession.php';
require_once 'php/logincheck.php';
session_start();
?><!-- Copyright Morgan Denner
02.2015 made for Greg Walsh 
This is the online version of Kids Team group
in conjunction with independent study
Contact morgan at morgandenner@yahoo.com -->
<!--================LANDING PAGE===========================-->
<!DOCTYPE html>
<html lang="en">

<head>

<!--=========GOOGLE FONTS================================ -->
    <link href="http://fonts.googleapis.com/css?family=Pacifico" rel='stylesheet' type='text/css'>
    <link href="http://fonts.googleapis.com/css?family=Lora" rel='stylesheet' type='text/css'>

    <title>KIDS TEAM LANDING</title>

<!--=============VIEWPORT TAGS===============================-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!--===============CSS==========================-->
    <link rel="stylesheet" type="text/css" href="css/style.css" />

<!--==============Bootstrap=========================-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

    <div class="wrap">

<!--====================TOP MENU=============================-->
        <header class="main-header">

<!--======================BOOTSTRAP NAV BAR==================-->
<!--==================http://getbootstrap.com/components/===-->
            <nav class="navbar navbar-default">
                <div class="container-fluid">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>  
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>  
                        </button>
                        <a class="navbar-brand" href="#"><img src="img/logo.png" /></a>
                        
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">Snack Time</a></li>
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Discussion <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">This Week</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Previous Weeks</a></li>
                            </ul></li>
                            <li><a href="#">Design</a></li>
                            <li><a href="#">Gallery</a></li>
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                            <!--=========THIS SECTION IS HIDDEN IF THE USER IS LOGGED IN==-->
                                <li><a href="loginkt.php">Login</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Join</a></li>
                                <li class="divider"></li>
                            <!--========THIS SECTION IS HIDDEN IF THE USER IS LOGGED OUT==-->
                                <li><a href="#">My Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Sign Out</a></li>
                                <li class="divider"></li></ul></li>
                            <!--==========================================================-->
                        </ul><!--END OF RIGHT COLLAPSING NAV-->
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header><!--end of header --> 

<!--=======================LEFT CONTENT====================-->
        <div class="row">

            <div class="col-xs-12 col-md-2">
                <div class="row">
                    <div class="col-xs-6 col-md-12" id="online-status-left">
                        <h1>Online</h1>

                        <div id="student">
                     
                        </div><!-- end of student -->


                    </div><!-- end of #online-status-left -->
                    <div class="col-xs-6 col-md-12" id="feed-left">
                        <h1>Feed</h1>
                    </div><!-- end of #online-status-left -->
                </div><!-- end of .row -->
            </div><!-- end of #online-status-left-->


<!--=====================RIGHT CONTENT=======================-->
            <div class="col-xs-12 col-md-10" id="content-right">
                <div class="col-xs-12" id="announcement">
                    <h1>Announcements!</h1>
                    <p>hello grokdf dfikdjf df df pjeflmnsdflsjd dflkdgdfg ddfgdlfkgjdf dfglkdfgjdf dfg dgldkfgjdflgkjdfg ldkfjgd flkjdfglkdfjg ldfkgjdfl kjsldfksjdfdslkfjs lk jsdkfjdkfjk jwddhjgjdfg jdfkjdfgkd j kdfjdk j jdkfj kj k jdfj, dfkhdfk.</p></div>
            </div><!-- end of #content-right-->


        </div><!-- end of .row -->  

    </div><!--end of wrap div-->

<!--=====================FOOTER======================-->
    <footer class="site-footer footer">
        <div class="row">
            <div class="col-sm-4 col-xs-12">&copy; Copyright 2015</div>
            <div class="col-sm-4 col-xs-12"><a href="#">| About Kids Team |</a></div>
            <div class="col-sm-4 col-xs-12"><a href="#">| Contact Kids Team |</a></div>
        </div><!-- end of .row-->
    </footer>



<!--===========JQUERY AND JAVASCRIPT==================-->

<!-- jquery v1.11.2 cdn www.jquery.com -->    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<!-- javascript source file -->
<script type="text/javascript" src="js/script.js"></script>

<!-- bootstrap v3.3.2 cdn www.getboostrap.com -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>



</body>

</html>
