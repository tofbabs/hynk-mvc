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

	<title>	BLACKLIST - Forgot Password</title>

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
		<div class="login-body">

			<h2>ACCOUNT RESET</h2>
			<form action="<?php echo $host ?>/login/reset" method='post' class='form-validate' id="test">
				<div class="form-group">
					<div class="email controls">
						<input type="text" name='email' placeholder="Email address" class='form-control' data-rule-required="true" data-rule-email="true">
					</div>
				</div>
				<div class="submit pull-lefet">
					<input type="submit" name="resetBtn" value="Reset" class='btn btn-primary'>
				</div>
			</form>
		</div>
	</div>
</body>


</html>
