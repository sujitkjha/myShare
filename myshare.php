<?php
	session_start();

	date_default_timezone_set( 'Asia/Kathmandu' );

	require_once( __DIR__ . '/config.php' );

	require_once __DIR__ . '/libs/Facebook/autoload.php';

	require_once __DIR__ . '/function.php';

	$id = $_GET['u'];

	$filename = '';

	if( isset( $id ) ) {

		$filename =  $id . '.jpg';

	}else {

		$filename = 'default.jpg';

	}

	$imageLocation = "downloads/processed/$filename";

	$url = APP_BASE_URL . '/myshare.php?u=' . $id;
	$title = 'myShare for a cause';
	$description = 'show your support';
	$image = APP_BASE_URL . '/' . $imageLocation;
?>

<html>
<head>
	<title>myShare</title>
	<meta property="fb:app_id" 			content="<?= APP_ID ?>"/>
	<meta property="og:url" 			content="<?= $url ?>" />
	<meta property="og:type"        	content="article" />
	<meta property="og:title"       	content="<?= $title ?>" />
	<meta property="og:description" 	content="<?= $description ?>" />
	<meta property="og:image"       	content="<?= $image ?>" />
	<meta property="og:image:width" 	content="600"/>
	<meta property="og:image:height" 	content="315"/>
	<meta property="article:author" 	content="https://www.facebook.com/t.sudan">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
</head>
<body>

	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '<?= APP_ID ?>',
	      xfbml      : true,
	      version    : 'v2.8'
	    });
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>

	<div class="container" style="margin-top:30px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div>
					<div>
						<img src='<?= $imageLocation ?>' />
					</div>

					<div style="margin-top:10px;">
	
						<div id="shareBtn" class="btn btn-success clearfix">Share</div>
<?php
							$fb = getFacebook();
							
							$helper = $fb->getRedirectLoginHelper();  

							$callback = APP_BASE_URL . '/processor.php';

							$loginUrl = $helper->getLoginUrl( $callback );

							echo '<a href="' . $loginUrl . '" role="button" class="btn btn-info">Create mine too</a>';
							
?>
						</div>

						<script>
						document.getElementById('shareBtn').onclick = function() {
						  FB.ui({
						    method: 'share',
						    display: 'popup',
						    href: '<?= $url ?>',
						  }, function(response){});
						}
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>