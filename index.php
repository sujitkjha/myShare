<?php
	
	session_start();

	date_default_timezone_set( 'Asia/Kathmandu' ); 

	require_once __DIR__ . '/libs/Facebook/autoload.php';
	
	require_once __DIR__ . '/config.php';

	require_once __DIR__ . '/function.php';
?>
<html>
<head>
	<title>myShare</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
</head>
<body>

	<div class="container" style="margin-top:20px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div>
					<img src="default.png" alt="default-image-banner" style="display:block;margin-bottom:5px;" />
	
<?php
					$fb = getFacebook();
					
					$helper = $fb->getRedirectLoginHelper();  

					$callback = APP_BASE_URL . '/processor.php';

					$loginUrl = $helper->getLoginUrl( $callback );

					echo '<a href="' . $loginUrl . '" role="button" class="btn btn-info">Create your\'s now</a>';
?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>