<?php
include_once 'php/config.php';
include_once 'connect.php';
include_once 'php/secsession.php';
session_start();
?>
<!DOCTYPE html>
<html>
<title>Login</title>
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

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>

    <div class="wrap">
<!--====================TOP MENU=============================-->
<!--====================TOP MENU=============================-->
        <header class="main-header">

<!--======================BOOTSTRAP NAV BAR==================-->
<!--==================http://getbootstrap.com/components/===-->
            <nav class="navbar navbar-default">
                <div class="container-fluid">

                    <div class="navbar-header">
                        <a class="navbar-brand" href="#"><img src="img/logo.png" /></a>
                        
                    </div>

                </div><!-- /.container-fluid -->
            </nav>
        </header><!--end of header --> 


<!--========================CONTENT====================-->
<div class="row">
<div class="col-xs-12 col-sm-4 col"></div>
            <div class="col-xs-12 col-sm-4 text-center well well-lg" id="sign-in">
                    <div id='response'></div><!-- end of message div -->
<form name='myForm' data-ajax='false'>
    <div class="form-group-lg">
        <input type='text' id='email' class='form-group' placeholder='username'/>
    </div>
    <div class="form-group-lg">
        <input type='password' id='password' placeholder/>
    </div>
   
</form>
<button class="btn btn-default" type='button' onclick='signIn()'>Sign In</button>

<p><a href="register.html">Join Kid's Team</a></p>
<a href src="forgotpassword.html">Trouble Logging In?</a></p>
<div class="col-xs-12 col-sm-4 col"></div>
        </div><!-- end of well -->
    </div><!-- end of .row -->
</div>

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

<!-- crypto js for hasing algorithm -->
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha512.js"></script>
    
<!-- bootstrap v3.3.2 cdn www.getboostrap.com -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- ajax script to connect js with php -->
<script language="javascript" type="text/javascript">
function signIn(){
//check for browser
	var ajaxRequest;
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		//if the server is ready to respond, send the echo into the div
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('response');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;
    password = CryptoJS.SHA512(password);
	var queryString = "?email=" + email + "&password=" + password;
	ajaxRequest.open("GET", "php/testnewlogin2.php" + queryString, true);
	ajaxRequest.send(null); 
}
</script>
</body>
</html>
