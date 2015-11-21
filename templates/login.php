<?php
if($_SESSION['access']){
	header("Location: http://localhost/health/index.php/home");
	die();
}
?>

<html>
	<head>
		<link rel="stylesheet" href="bootstrap.css" type="text/css">
		<link rel="stylesheet" href="my.css" type="text/css">
	</head>
	<body>
		<div class="main-container">
			<form class="form-horizontal">
			<fieldset>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="input_username">Username</label>  
			  <div class="col-md-4">
			  <input id="input_username" name="input_username" type="text" placeholder="johndoe" class="form-control input-md">
			  </div>
			</div>

			<!-- Password input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="input_password">Password</label>
			  <div class="col-md-4">
			    <input id="input_password" name="input_password" type="password" placeholder="ilikechow" class="form-control input-md">
			  </div>
			</div>

			<!-- Button (Double) -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="btn_login"></label>
			  <div class="col-md-8">
			    <button id="btn_login" type="button" name="btn_login" class="btn btn-primary">Login</button>
			    <button id="btn_guest" type="button" name="btn_guest" class="btn btn-default">Continue as guest</button>
			  </div>
			</div>

			<div class="form-group">
				<div class="col-md-4"></div>
				<div id ="wrong_pass"></div>
			</div>
			
			</fieldset>
			</form>

		</div>
		<script type="text/javascript" src="templates/jquery.min.js"></script>
		<script type="text/javascript" src="templates/bootstrap.js"></script>
		<script type="text/javascript" src="templates/login.js"></script>
	</body>
</html>
