<?php
	
	session_start();

	date_default_timezone_set( 'Asia/Kathmandu' ); 

	use PHPImageWorkshop\ImageWorkshop;

	require_once __DIR__ . '/libs/Facebook/autoload.php';
	require_once __DIR__ . '/libs/PHPImageWorkshop/ImageWorkshop.php';
	require_once __DIR__ . '/config.php';
	require_once __DIR__ . '/function.php';
	
	$fb = getFacebook();
	$helper = $fb->getRedirectLoginHelper();  

	try {
	  	$accessToken = $helper->getAccessToken();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  	// When Graph returns an error
	  	echo 'Graph returned an error: ' . $e->getMessage();
	  	exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  	// When validation fails or other local issues
	  	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  	exit;
	}

	if (isset($accessToken)) {
	  	
	  	$response = $fb->get('/me?fields=id,name', $accessToken);

	  	$user = $response->getGraphUser();
		
		$profile_image = 'http://graph.facebook.com/' . $user['id'] . '/picture?type=large';

	  	$filename = saveImageFromUrl( $profile_image );

		$bannerImage = ImageWorkshop::initFromPath( __DIR__ . '/assets/banner.png' );
		$profileImage = ImageWorkshop::initFromPath( __DIR__ . '/downloads/' . $filename );

		$layer = ImageWorkshop::initVirginLayer( $bannerImage->getWidth(), $bannerImage->getHeight() );
		
		$profileImage->resizeInPixel( 200, null, true );

		$layer->addLayerOnTop( $profileImage, 100, 50, 'LT' );
		$layer->addLayerOnTop( $bannerImage, 0, 0, 'LT' );

		$dirPath = __DIR__ . '/downloads/processed';
		
		$createFolder = true;
		$backgroundColor = null;
		$imageQuality = 95;

		$layer->save( $dirPath, $filename, $createFolder, $backgroundColor, $imageQuality );

		$id = str_replace( '.jpg', '', $filename );
		
		//echo $filename . '<br />';
		//echo $id;
		
		header( 'Location: ' . APP_BASE_URL . "/myshare.php?u=$id" );
	}
?>