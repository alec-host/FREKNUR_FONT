<?php
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");	
		
global $username,$pass,$err_a,$err_b,$msg,$checksum,$wb_name;

$wb_name = "freknur";

#-username.
if(isset($_POST['username']) && trim($_POST['username']) != ''){
	$username = strtolower($_POST['username']);
	$err_a = 0;
}else{
	$err_a = 1;
}
#-password.
if(isset($_POST['paswd']) && trim($_POST['paswd']) != ''){
	$pass = $_POST['paswd'];
	$err_b = 0;
}else{
	$err_b = 1;
}

$checksum = ($err_a*$err_b);

if($checksum==0){
	require_once('function/functions.php');
	$url = 'http://localhost/freknur/dashboard/gateway/index.php';
	$obj = array();
	
	$obj['username'] = $username;
	$obj['pasword']  = $pass;
	$obj['head']     = 'authentication';
	
	$output  = _curlPostToApi($url,$obj); 
	$obj_res = json_decode($output);
	if(trim($output) != ""){
		$msg = "";
		$_SESSION['user'] = $obj_res->name;
		$_SESSION['type'] = $obj_res->type;
		
		exit(header("Location:http://localhost/freknur/dashboard/index.php"));	

    }else{
		$msg = "Invalid mobile number/password";
	}
}else{	
}
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
    <title>freknur</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 80px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */       
    }
    .nh{
	background-image:url('img/welcomeimg.jpg');
	background-repeat:no-repeat;
	background-size:contain;
	background-position:center;    
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--a class="navbar-brand" href="../index.php"><img src='../img/_small_hello_teacher.png'></a-->
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <!--li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Bottom -->
	<center>
    <nav class="navbar navbar-fixed-bottom" role="navigation" style="width:20%">
        <div class="container" style="width:20%">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <a href="#"></a>
            </div>
        </div>
    </nav>
	</center>
	<!-- /Bottom -->
	<center>
    <!-- Page Content -->
    <div class="container" width="100%">

        <div class="row">
            <div class="col-lg-12 text-left">
				<form method="post" class="form-horizontal" action="<?=$_SERVER['PHP_SELF']?>">
				<fieldset>
					<div align="">
					<!--img src='../img/povo-logo.png'-->
					<p align="center"><img src='img/izislip_sm.png'/></p>
                		</div>	
				
                		<hr class="featurette-divider">	
               			<br>
				
				<!-- Notification-->
				<?php if($msg != ""){ ?>
				<div class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Info!</strong> <?=$msg?>
				</div>		
				<?php } ?>
				
				
				<div class="form-group">
				  <label class="col-md-4 control-label" for="username"></label>
				  <div class="col-md-4">
					<select id="username" name="username" class="form-control" required="">
					  <option value=""></option>
					  <option value="Admin">Admin</option>
					  <option value="User">User</option>
					</select>
				  </div>
				</div>				

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="paswd"></label>  
				  <div class="col-md-4">
				  <input id="paswd" name="paswd" placeholder="Password" class="form-control input-md" required="" type="password">
					
				  </div>
				</div>
				
				<br/>
				
				<!-- Button -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="btnsignup"></label>
				  <div class="col-md-4">
					<button id="btnsignup" name="btnsignup" class="btn btn-primary btn-block active"><b>SIGN IN</b></button>
				  </div>
				</div>
				</fieldset>
				</form>
				<!--div align="center">
					<em>Already have an account?</em>
					<button id="b" name="b" class="btn btn-success"><b>SIGN IN</b></button>
                                </div-->	
            </div>
        </div>
        <!-- /.row -->
	<br>
        <hr class="featurette-divider">
	
    </div>
    	<!-- /.container -->
	</center>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<!-- Footer -->
	
    <!-- jQuery Version 1.11.1 -->
    <script src="../js/jquery.js"></script>

    <script src="../js/jquery.placeholder.js"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

	<script>
	$(function() {
		// Invoke the plugin
		$('input, textarea').placeholder({customClass:'my-placeholder'});
		// That’s it, really.
		/*
		var html;

		if ($.fn.placeholder.input && $.fn.placeholder.textarea) {
		       html = '<strong>Your current browser natively supports <code>placeholder</code> for <code>input</code> and <code>textarea</code> elements.
		               </strong> The plugin won’t run in this case, since its not needed. If you want to test the plugin, use an older browser.';   
		} else if ($.fn.placeholder.input) {
			html = '<strong>Your current browser natively supports <code>placeholder</code> for <code>input</code> elements, but not for
			        <code>textarea</code> elements.</strong> The plugin will only do its thang on the <code>textarea</code>s.';
		}

		if (html) {
			$('<p class="note">' + html + '</p>').insertBefore('form');
		}
		*/
	});	
	</script>	
</body>

</html>