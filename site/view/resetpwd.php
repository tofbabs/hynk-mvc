<?php global $host ?>
<!doctype html>
<html>


<!-- Mirrored from www.eakroko.de/flat/more-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 Jun 2015 16:07:17 GMT -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>Blacklist - Forgot Password</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo $host?>/site/css/bootstrap.min.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo $host?>/site/css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="<?php echo $host?>/site/css/themes.css">


	<!-- jQuery -->
	<script src="<?php echo $host?>/site/js/jquery.min.js"></script>

	<!-- Nice Scroll -->
	<script src="<?php echo $host?>/site/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo $host?>/site/js/bootstrap.min.js"></script>

	<!--[if lte IE 9]>
		<script src="<?php echo $host?>/site/js/plugins/placeholder/jquery.placeholder.min.js"></script>
		<script>
			$(document).ready(function() {
				$('input, textarea').placeholder();
			});
		</script>
	<![endif]-->


	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo $host?>/site/img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="<?php echo $host?>/site/img/apple-touch-icon-precomposed.png" />

</head>

<body class='login'>
	<div class="wrapper">
		<h1>
			<a href="#"><img src="<?php echo $host?>/site/img/logo-big.png" alt="" class='retina-ready' width="59">BLACKBOX</a>
		</h1>
		<?php include_once 'flash.php'; ?>
		<h2 class="text-center"><i class="fa fa-unlock"></i> Reset Password</h2>
		<div class="desc">Enter New Password Below</div>
		<form action="<?php echo $host?>/login/reset" class='form-horizontal' method="post">
			<div class="input-group">
				<input id="password" type="password" name="password" class='form-control'>
			</div>
			<hr>
			<div class="desc">Confirm Password</div>
			<div class="input-group">
				<input id="cpassword" type="password" name="cpassword" class='form-control'>
			</div>

			<input type="hidden" name="email" value="<?php echo isset($user_email) ? $user_email : ''?>">

			<div class="buttons">
				<div class="pull-left">
					<input type="submit" name="changePwdBtn" value="Change Password" class="btn btn-icon">
				</div>
			</div>

		</form>
		
	</div>

	<script type="text/javascript">

	pass1 = document.getElementById("password");
	pass2 = document.getElementById("cpassword");

	  window.onload = function () {
	    pass1.onchange = validatePassword;
	    pass2.onchange = validatePassword;
	  }

	  function validatePassword(){
	  var pass2=document.getElementById("password").value;
	  var pass1=document.getElementById("cpassword").value;
	  if(pass1!=pass2)
	    document.getElementById("cpassword").setCustomValidity("Passwords Don't Match");
	  else
	    document.getElementById("cpassword").setCustomValidity('');  
	  //empty string means no validation error
	  }

	</script>
</body>


</html>
